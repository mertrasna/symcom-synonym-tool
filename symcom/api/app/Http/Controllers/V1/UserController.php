<?php

namespace App\Http\Controllers\V1;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Routing\Helpers;
use App\Libraries\Helpers as CustomHelper;

class UserController extends Controller
{
	use Helpers;

    public function __construct(\App\User $user, \App\Admin $admin, \App\ResetPassword $resetPassword, \App\OauthAccessToken $oauthAccessToken){
        $this->user = $user;
        $this->admin = $admin;
        $this->resetPassword = $resetPassword;
        $this->oauthAccessToken = $oauthAccessToken;
    }

    /**
    * User signup Method 
    * Return : user access token and basic info 
    **/
    public function signUp(Request $request){
    	$returnArr=config('constants.return_array');
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());

    	try{
    		// DB::beginTransaction();
    		$adminUsernames=[];
	    	$systemAdmins=config('constants.system_admin');
	    	if(!empty($systemAdmins)){
	    		foreach ($systemAdmins as $adminKey => $adminValue) {
	    			$adminUsernames[]=strtolower($systemAdmins[$adminKey]['username']);
	    		}
	    	}

    		$validationRules=[
	            'username' => 'required|min:3|unique:users',
	            'user_type' => 'required|integer|between:2,3',
	            'email' => 'required|email|unique:users',
	            'password' => 'required|confirmed|min:6',
	            'first_name' => 'required',
	            'last_name' => 'required'
 	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        if(in_array(strtolower($input['username']), $adminUsernames)){
	        	$validationMsg['username']="The username has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        $chechAdminEmails=$this->admin->where('email', $input['email'])->first();
	        if($chechAdminEmails === null){

	        	$rowPassword=$input['password'];
	        	$input['password']=Hash::make($input['password']);
	        	$input['ip_address']=$request->ip();
	        	$input['created_at']=\Carbon\Carbon::now()->toDateTimeString();

	          	$user=$this->user->create($input);
	          	
	          	if($user){

                    try {
                    	$updateLoginTimeData['last_login_at']=\Carbon\Carbon::now()->toDateTimeString();
                    	$updateLoginTimeData['current_login_at']=\Carbon\Carbon::now()->toDateTimeString();
                    	$lastLoginData=$this->user->where('id', $user->id)->update($updateLoginTimeData);
                    }
                    catch(\Exception $e){
			        	$this->user->where('id', $user->id)->delete();
                    	$returnArr['status']=5;
		                $returnArr['content']=$e;
		                $returnArr['message']="Operation failed, could not update the users current login time";
		                return $returnArr;
			        }

			        if($lastLoginData){

	                	$client = new \GuzzleHttp\Client();
			            try {
			            	$apiUrl=config('constants.api_base_path')."v1/oauth/token";
			                $response = $client->request('POST', $apiUrl, [
			                    'headers' => [
			                        'user-agent' => $_SERVER['HTTP_USER_AGENT'],
			                    ],
			                    'form_params' => [
			                        'grant_type' => 'password', 
			                        'client_id'=> 2, 
			                        'client_secret' => 'ki9mw70DmV3U4QRA0wsaIJ0DMWpra0uRjZJRQI92', 
			                        'username'=>$input['email'],
			                        'password'=>$rowPassword,
			                        'scope'=>'*',
			                        'provider'=>'api'
			                    ]
			                ]);

			                $contents = json_decode($response->getBody(), true);  

			                $createdUserData=$this->user->where('id', $user->id)->first();
	        
			                $uaerInfoArr['id']=$createdUserData->id;
			                $uaerInfoArr['username']=$createdUserData->username;
			                $uaerInfoArr['first_name']=$createdUserData->first_name;
			                $uaerInfoArr['last_name']=$createdUserData->last_name;
			                $uaerInfoArr['full_name']=$createdUserData->full_name;
			                $uaerInfoArr['slug']=$createdUserData->slug;
			                $uaerInfoArr['user_type']=$createdUserData->user_type;
			                $uaerInfoArr['email']=$createdUserData->email;
			                $uaerInfoArr['initials']=$createdUserData->initials;
			                $uaerInfoArr['current_login_at']=$createdUserData->current_login_at;
			                $uaerInfoArr['last_login_at']=$createdUserData->last_login_at;

			                $returnArr['status']=2;
			                $returnArr['content']=array_merge($contents, $uaerInfoArr);
			                $returnArr['message']="User created and access token generated successfully";
		                    
			            }
			            catch (\GuzzleHttp\Exception\ClientException $e) {
			            	$this->user->where('id', $user->id)->delete();
			                $responsePre = $e->getResponse();
			                $response = json_decode($responsePre->getBody(), true);

			                $returnArr['status']=5;
			                $returnArr['content']=$response;
			                $returnArr['message']="Operation failed, could not generate the access token";
			            }
	                	
	                }else{
	                	$this->user->where('id', $user->id)->delete();
	                	$returnArr['status']=5;
		                $returnArr['content']="";
		                $returnArr['message']="Operation failed, could not update the users current login time";
	                }
                    
                    
	          	}else{
	          		$returnArr['status']=5;
		            $returnArr['content']=$user;
		            $returnArr['message']="Operation failed, could not add user in DB";
	          	}
	            
	        }else{
	            $validationMsg['email']="The email has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            //return $returnArr;
	        }
	        // DB::commit();
    	}
        catch(\Exception $e){
        	// DB::rollback();
        	if(isset($user)){
        		$this->user->where('id', $user->id)->delete();
        	}
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
    }


    /**
    * User logout Method
    * Deleting all tokens of current user 
    * Return : blank
    **/
    public function logout()
	{ 
		$returnArr=config('constants.return_array');
		try{
			$guard=CustomHelper::getGuard();
			if($guard == ''){
				$returnArr['status']=0;
	            $returnArr['content']='Unauthorized.';
	            $returnArr['message']="User not found"; 
			}else{
				\Auth::guard($guard)->user()->AauthAcessToken()->delete();
		       	
		       	$returnArr['status']=2;
		        $returnArr['content']="";
		        $returnArr['message']="User access token destoried successfully";
			}
	    }
        catch(\Exception $e){
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}


	/**
    * User login Method
    * Return : user access token and basic info
    **/
    public function login(Request $request){
    	$returnArr=config('constants.return_array');
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());

    	try{
    		DB::beginTransaction();

    		$provider='api';
    		$adminUsernames=[];
	    	$systemAdmins=config('constants.system_admin');
	    	if(!empty($systemAdmins)){
	    		foreach ($systemAdmins as $adminKey => $adminValue) {
	    			$adminUsernames[$adminKey]=strtolower($systemAdmins[$adminKey]['username']);
	    		}
	    	}
    		
    		$validationRules=[
	            'username' => 'required',
	            'password' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

	        $getUserData = null;
	        if(in_array(strtolower($input['username']), $adminUsernames)){
	        	$provider='admin';
	        	$adminId=array_search(strtolower($input['username']), $adminUsernames);
	        	$getUserData=$this->admin->where('id', $adminId)->first();
	        }else{
	        	$getUserData=$this->admin->where('email', $input['username'])->first();
	        	$provider='admin';
	        	if($getUserData === null){
	        		$getUserData=$this->user->where('username', $input['username'])->orWhere('email', $input['username'])->first();
	        		$provider='api';
	        	}
	        }
		    if($getUserData === null){
		    	$returnArr['status']=4;
	            $returnArr['content']=$getUserData;
	            $returnArr['message']="No user found with this Username";
		    }else{
		    	
		    	if (Hash::check($input['password'], $getUserData->password))
                {
                	$userEmail=trim($getUserData->email);
                	$client = new \GuzzleHttp\Client();
			        try {
			        	$apiUrl=config('constants.api_base_path')."v1/oauth/token";
			            $responsePre = $client->request('POST', $apiUrl, [
			                'headers' => [
			                    'user-agent' => $_SERVER['HTTP_USER_AGENT'],
			                ],
			                'form_params' => [
			                    'grant_type' => 'password', 
			                    'client_id'=> 2, 
			                    'client_secret' => 'ki9mw70DmV3U4QRA0wsaIJ0DMWpra0uRjZJRQI92', 
			                    'username'=>$userEmail,
			                    'password'=>$input['password'],
			                    'scope'=>'*',
			                    'provider'=>$provider
			                ]
			            ]); 
			            $response=json_decode($responsePre->getBody(), true);  

			            $updateLoginTimeData['last_login_at']=(isset($getUserData->current_login_at) and $getUserData->current_login_at != null and $getUserData->current_login_at != "0000-00-00 00:00:00") ? \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $getUserData->current_login_at)->format('Y-m-d H:i:s') : \Carbon\Carbon::now()->toDateTimeString();
	                    $updateLoginTimeData['current_login_at']=\Carbon\Carbon::now()->toDateTimeString();
	                    $updateLoginTimeData['ip_address']=$request->ip();

	                    if($provider == 'admin')
	                    	$lastLoginData=$this->admin->where('id', $getUserData->id)->update($updateLoginTimeData);
	                    else
	                    	$lastLoginData=$this->user->where('id', $getUserData->id)->update($updateLoginTimeData);

	                    if($lastLoginData){

	                    	if($provider == 'admin')
	                    		$logedInUserData=$this->admin->where('id', $getUserData->id)->first();
	                    	else
	                    		$logedInUserData=$this->user->where('id', $getUserData->id)->first();
	        
			                $uaerInfoArr['id']=$logedInUserData->id;
			                $uaerInfoArr['username']=$logedInUserData->username;
			                $uaerInfoArr['first_name']=$logedInUserData->first_name;
			                $uaerInfoArr['last_name']=$logedInUserData->last_name;
			                $uaerInfoArr['full_name']=$logedInUserData->full_name;
			                $uaerInfoArr['slug']=$logedInUserData->slug;
			                $uaerInfoArr['user_type']=$logedInUserData->user_type;
			                $uaerInfoArr['email']=$logedInUserData->email;
			                $uaerInfoArr['initials']=$logedInUserData->initials;
							if($provider == 'admin'){
								$uaerInfoArr['initials']="ADMIN";
							}
			                $uaerInfoArr['current_login_at']=$logedInUserData->current_login_at;
			                $uaerInfoArr['last_login_at']=$logedInUserData->last_login_at;

	                    	$returnArr['status']=2;
				            $returnArr['content']=array_merge($response, $uaerInfoArr);
				            $returnArr['message']="User access token generated successfully";
	                    }else{
	                    	$returnArr['status']=5;
			                $returnArr['content']="";
			                $returnArr['message']="Operation failed, could not update the last login time.";
	                    }
			        }
			        catch (\GuzzleHttp\Exception\ClientException $e) {
			            $responsePre = $e->getResponse();
			            $response = json_decode($responsePre->getBody(), true);

			            $returnArr['status']=5;
		                $returnArr['content']=$response;
		                $returnArr['message']="Operation failed, could not generate the access token";
			        }
                }else{
                	$returnArr['status']=4;
		            $returnArr['content']="";
		            $returnArr['message']="User password does not match";
                }
		    }
		    DB::commit();
    	}
    	catch(\Exception $e){
    		DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }
        
        return $returnArr;
    }

    /**
    * User change password Method
    * Return : nothing(blank)
    **/
    public function changePassword(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		//$input=$request->all();
		$input=array_map('trim', $request->all());
		try{
			DB::beginTransaction();
			$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;

			$validationRules=[
	            'current_password' => 'required',
            	'password' => 'required|confirmed|min:6'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

	        if (!Hash::check($input['current_password'], $currentUser->password)){
	            $createMessage['current_password']="The current password does not match.";
	            $returnArr['status']=3;
	            $returnArr['content']=$createMessage;
	            $returnArr['message']="Validation failed.";
	        }else{
	        	$updateData['password']=Hash::make($input['password']);
	        	$updateData['ip_address']=$request->ip();
	        	$updateData['updated_at']=\Carbon\Carbon::now()->toDateTimeString();
	        	if(CustomHelper::isAdminId($logedInUser) === true)
            		$updateRes=$this->admin->where('id', $logedInUser)->update($updateData);
            	else
            		$updateRes=$this->user->where('id', $logedInUser)->update($updateData);

            	if($updateRes==true){
            		$mailData['user_full_name']=$currentUser->full_name;
            		$mailData['password']=$input['password'];
            		/*Mail::send('emails.password-change-mail', $mailData, function($message) use($currentUser) {
		            	$receiverEmail=trim($currentUser->email);
					    $message->to($receiverEmail, $currentUser->full_name)
					            ->subject('Symcom password changed');
					    $message->from('symcom@noreply.com','Symcom');
					});*/

            		$returnArr['status']=2;
	                $returnArr['content']="";
	                $returnArr['message']="Password is updated successfully";
            	}else{
            		$returnArr['status']=5;
	                $returnArr['content']="";
	                $returnArr['message']="Operation failed, could not update the password";
            	}
	        }

	        DB::commit();
	    }
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}


	/**
    * User Send Reset Password Link Method
    * Return : nothing(blank)
    **/
    public function sendResetPasswordLink(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		//$input=$request->all();
		$input=array_map('trim', $request->all());
		try{
			DB::beginTransaction();
			$canProceed=0;
			$validationRules=[
	            'email' => 'required|email',
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

	        $userData=$this->user->where('email', $input['email'])->first();
	        if($userData == null){
	        	$userData=$this->admin->where('email', $input['email'])->first();
	        	if($userData == null)
	        		$canProceed=0;
	        	else
	        		$canProceed=1;
	        }
	        else
	        	$canProceed=1;

	        if($canProceed == 1){

	        	$deleteExistingTokens=$this->resetPassword->where('email', $input['email'])->delete();

	        	$microTime=preg_replace('/(0)\.(\d+) (\d+)/', '$3$1$2', microtime());
		        $length=rand(20,30);
		        $tokenPre = bin2hex(random_bytes($length));
		        $token = $tokenPre.$microTime;
		        $resetPasswordData['user_id']=isset($userData->id) ? $userData->id : NULL;
		        $resetPasswordData['email']=$input['email'];
		        $resetPasswordData['token']=$token;
		        $resetPasswordData['ip_address']=$request->ip();
		        $resetPasswordData['expire_at']=\Carbon\Carbon::now()->addMinutes(60);
		        $resetPasswordData['created_at']=\Carbon\Carbon::now()->toDateTimeString();
		        $createUserToken=$this->resetPassword->create($resetPasswordData);  

		        if($createUserToken){
		            $passwordResetLink="https://www.alegralabs.com/mukesh/symcom/zurücksetzen-passwort.php?token=".$token;

		            $data['receiver_name']=$userData->full_name;
		            $data['password_reset_link']=$passwordResetLink;
		            $data['created_at']=$resetPasswordData['created_at'];

		            /*Mail::send('emails.reset-password-mail', $data, function($message) use($userData) {
		            	$receiverEmail=trim($userData->email);
					    $message->to($receiverEmail, $userData->full_name)
					            ->subject('Symcom password reset link');
					    $message->from('symcom@noreply.com','Symcom');
					});*/

		            $returnArr['status']=2;
		            $returnArr['content']="";
		            $returnArr['message']="Reset password link sent successfully.";

		        }else{
		            $returnArr['status']=5;
		            $returnArr['content']="";
		            $returnArr['message']="Operation failed, could not generate and send the reset password link.";
		        }
	        }else{
	        	$returnArr['status']=4;
		        $returnArr['content']="";
		        $returnArr['message']="No user found with the provided email";
	        }

	        DB::commit();
	    }
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}


	/**
    * User reset password Method
    * Return : nothing(blank)
    **/
    public function resetPassword(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		//$input=$request->all();
		$input=array_map('trim', $request->all());
		try{
			DB::beginTransaction();
			$validationRules=[
	            'password' => 'required|confirmed|min:6',
	            'token' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

	        $tokenData=$this->resetPassword->where('token', $input['token'])->first();
	        if($tokenData === null){
                $returnArr['status']=4;
                $returnArr['content']="";
                $returnArr['message']="The link you are using is invalid. Please request a new reset password link.";
            }else{
		        
		        $expirationTime=$tokenData->expire_at;
		        if (\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($expirationTime))){
		        	$updateData['password']=Hash::make($input['password']);
		        	$updateData['ip_address']=$request->ip();
		        	$updateData['updated_at']=\Carbon\Carbon::now()->toDateTimeString();
		        	if(CustomHelper::isAdminId($tokenData->user_id) === true)
	            		$updateRes=$this->admin->where('id', $tokenData->user_id)->update($updateData);
	            	else
	            		$updateRes=$this->user->where('id', $tokenData->user_id)->update($updateData);
		        	if($updateRes==true){
		        		$deleteExistingTokens=$this->resetPassword->where('token', $input['token'])->delete();
	            		$returnArr['status']=2;
		                $returnArr['content']="";
		                $returnArr['message']="Password is reset successfully";
	            	}else{
	            		$returnArr['status']=5;
		                $returnArr['content']="";
		                $returnArr['message']="Operation failed, could not update the password";
	            	}
		        }else{
		        	//$deleteExistingTokens=$this->resetPassword->where('token', $input['token'])->delete();
		        	$returnArr['status']=5;
		            $returnArr['content']="";
		            $returnArr['message']="Operation failed, the link you are using is expired.";
		        }
            }

	        DB::commit();
	    }
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}


	/**
    * User add user Method 
    * Creates user
    * Return : user informations 
    **/
    public function addUser(Request $request){
    	$returnArr=config('constants.return_array');
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());

    	try{
    		DB::beginTransaction();
    		$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;

    		$adminUsernames=[];
	    	$systemAdmins=config('constants.system_admin');
	    	if(!empty($systemAdmins)){
	    		foreach ($systemAdmins as $adminKey => $adminValue) {
	    			$adminUsernames[]=strtolower($systemAdmins[$adminKey]['username']);
	    		}
	    	}

    		$validationRules=[
	            'username' => 'required|min:3|unique:users',
	            'user_type' => 'required|integer|between:2,3',
	            'email' => 'required|email|unique:users',
	            'password' => 'required|confirmed|min:6',
	            'first_name' => 'required',
	            'last_name' => 'required'
 	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        if(in_array(strtolower($input['username']), $adminUsernames)){
	        	$validationMsg['username']="The username has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        $chechAdminEmails=$this->admin->where('email', $input['email'])->first();
	        if($chechAdminEmails === null){

	        	$rowPassword=$input['password'];
	        	$insertData['username']= (isset($input['username']) and $input['username'] != "") ? $input['username'] : NULL;
	        	$insertData['user_type']= (isset($input['user_type']) and $input['user_type'] != "") ? $input['user_type'] : NULL;
	        	$insertData['email']= (isset($input['email']) and $input['email'] != "") ? $input['email'] : NULL;
	        	$insertData['first_name']= (isset($input['first_name']) and $input['first_name'] != "") ? $input['first_name'] : NULL;
	        	$insertData['last_name']= (isset($input['last_name']) and $input['last_name'] != "") ? $input['last_name'] : NULL;
	        	$insertData['initials']= (isset($input['initials']) and $input['initials'] != "") ? $input['initials'] : NULL;
	        	$insertData['salutation']= (isset($input['salutation']) and $input['salutation'] != "") ? $input['salutation'] : NULL;
	        	$insertData['phone']= (isset($input['phone']) and $input['phone'] != "") ? $input['phone'] : NULL;
	        	$insertData['active']= (isset($input['active']) and $input['active'] !="" ) ? $input['active'] : 0;
	        	$insertData['company']= (isset($input['company']) and $input['company'] !="" ) ? $input['company'] : NULL;
	        	$insertData['password']=Hash::make($input['password']);
	        	$insertData['ip_address']=$request->ip();
	        	$insertData['created_at']=\Carbon\Carbon::now()->toDateTimeString();

	          	$user=$this->user->create($insertData);
	          	
	          	if($user){

	          		$createdUserData=$this->user->where('id', $user->id)->first();
	          		$userType=CustomHelper::getConstantsValue('user_type', $createdUserData->user_type);

	          		$mailData['admin_full_name']=$currentUser->full_name;
		            $mailData['user_full_name']=$createdUserData->full_name;
		            $mailData['user_type']=$userType;
		            $mailData['username']=$createdUserData->username;
		            $mailData['password']=$rowPassword;
		            $mailData['user_email']=$createdUserData->email;
		            $mailData['login_link']='https://www.alegralabs.com/mukesh/symcom/login.php';
		            $mailData['site_url']='https://www.alegralabs.com/mukesh/symcom';

		            /*Mail::send('emails.user-add-mail-to-admin', $mailData, function($message) use($currentUser) {
		            	$receiverEmail=trim($currentUser->email);
					    $message->to($receiverEmail, $currentUser->full_name)
					            ->subject('Symcom user login details');
					    $message->from('symcom@noreply.com','Symcom');
					});

					Mail::send('emails.user-add-mail-to-user', $mailData, function($message) use($createdUserData) {
		            	$receiverEmail=trim($createdUserData->email);
					    $message->to($receiverEmail, $createdUserData->full_name)
					            ->subject('Symcom login details');
					    $message->from('symcom@noreply.com','Symcom');
					});*/

	          		
			        $returnArr['status']=2;
	                $returnArr['content']=$createdUserData;
	                $returnArr['message']="User created successfully";
                    
	          	}else{
	          		$returnArr['status']=5;
		            $returnArr['content']=$user;
		            $returnArr['message']="Operation failed, could not add user in DB";
	          	}
	            
	        }else{
	            $validationMsg['email']="The email has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            //return $returnArr;
	        }
	        DB::commit();
    	}
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
    }

    /**
    * User update user Method 
    * Updates user
    * Return : user informations 
    **/
    public function updateUser(Request $request){
    	$returnArr=config('constants.return_array');
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());

    	try{
    		DB::beginTransaction();
    		$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;

    		$adminUsernames=[];
	    	$systemAdmins=config('constants.system_admin');
	    	if(!empty($systemAdmins)){
	    		foreach ($systemAdmins as $adminKey => $adminValue) {
	    			$adminUsernames[]=strtolower($systemAdmins[$adminKey]['username']);
	    		}
	    	}

	    	if(!isset($input['id']) or $input['id'] == ""){
	    		$validationMsg['id']="The id field is required.";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	    	}

    		$validationRules=[
	            'id' => 'required',
	            'username' => 'required|min:3|unique:users,username,'.$input['id'],
	            'user_type' => 'required|integer|between:2,3',
	            'email' => 'required|email|unique:users,email,'.$input['id'],
	            'first_name' => 'required',
	            'last_name' => 'required'
 	        ];
 	        if(isset($input['password']) && $input['password']!=""){
	        	$passwordValidationRule=[
		            'password' => 'required|confirmed|min:6'
		        ];
		        $validationRules=array_merge($validationRules, $passwordValidationRule);
	        }
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        if(in_array(strtolower($input['username']), $adminUsernames)){
	        	$validationMsg['username']="The username has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        $chechAdminEmails=$this->admin->where('email', $input['email'])->first();
	        if($chechAdminEmails === null){

	        	$chechUserExistance=$this->user->where('id', $input['id'])->first();
	        	if($chechUserExistance === null){
	        		$returnArr['status']=4;
		            $returnArr['content']="";
		            $returnArr['message']="No user found with the provided id";
	        	}else{
	        		$rowPassword="";
		        	$updateData['username']= (isset($input['username']) and $input['username'] != "") ? $input['username'] : NULL;
		        	$updateData['user_type']= (isset($input['user_type']) and $input['user_type'] != "") ? $input['user_type'] : NULL;
		        	$updateData['email']= (isset($input['email']) and $input['email'] != "") ? $input['email'] : NULL;
		        	$updateData['first_name']= (isset($input['first_name']) and $input['first_name'] != "") ? $input['first_name'] : NULL;
		        	$updateData['last_name']= (isset($input['last_name']) and $input['last_name'] != "") ? $input['last_name'] : NULL;
		        	$updateData['initials']= (isset($input['initials']) and $input['initials'] != "") ? $input['initials'] : NULL;
		        	$updateData['salutation']= (isset($input['salutation']) and $input['salutation'] != "") ? $input['salutation'] : NULL;
		        	$updateData['phone']= (isset($input['phone']) and $input['phone'] != "") ? $input['phone'] : NULL;
		        	$updateData['active']= (isset($input['active']) and $input['active'] !="" ) ? $input['active'] : 0;
		        	$updateData['company']= (isset($input['company']) and $input['company'] !="" ) ? $input['company'] : NULL;
		        	if(isset($input['password']) and $input['password'] != ""){
		        		$updateData['password']=Hash::make($input['password']);
		        		$rowPassword=$input['password'];
		        	}
		        	$updateData['ip_address']=$request->ip();
		        	$updateData['updated_at']=\Carbon\Carbon::now()->toDateTimeString();

		          	$updateResult=$this->user->where('id', $input['id'])->update($updateData);
					if($updateResult){
						$this->oauthAccessToken->where('user_id', $input['id'])->delete();
		          		$createdUserData=$this->user->where('id', $input['id'])->first();
		          		$userType=CustomHelper::getConstantsValue('user_type', $createdUserData->user_type);

		          		$mailData['admin_full_name']=$currentUser->full_name;
			            $mailData['user_full_name']=$createdUserData->full_name;
			            $mailData['user_type']=$userType;
			            $mailData['username']=$createdUserData->username;
			            $mailData['password']= ($rowPassword != "") ? $rowPassword : 'Not changed (use your current password to login)';
			            $mailData['user_email']=$createdUserData->email;
			            $mailData['login_link']='https://www.alegralabs.com/mukesh/symcom/login.php';
			            $mailData['site_url']='https://www.alegralabs.com/mukesh/symcom';

			            /*Mail::send('emails.user-update-mail-to-admin', $mailData, function($message) use($currentUser) {
			            	$receiverEmail=trim($currentUser->email);
						    $message->to($receiverEmail, $currentUser->full_name)
						            ->subject('Symcom user profile update details');
						    $message->from('symcom@noreply.com','Symcom');
						});

						Mail::send('emails.user-update-mail-to-user', $mailData, function($message) use($createdUserData) {
			            	$receiverEmail=trim($createdUserData->email);
						    $message->to($receiverEmail, $createdUserData->full_name)
						            ->subject('Symcom profile update details');
						    $message->from('symcom@noreply.com','Symcom');
						});*/

		          		
				        $returnArr['status']=2;
		                $returnArr['content']=$createdUserData;
		                $returnArr['message']="User informations updated successfully";
	                    
		          	}else{
		          		$returnArr['status']=5;
			            $returnArr['content']="";
			            $returnArr['message']="Operation failed, could not update the data";
		          	}
	        	}
	            
	        }else{
	            $validationMsg['email']="The email has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            //return $returnArr;
	        }
	        DB::commit();
    	}
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
    }

    /**
    * User view user Method
    * view user information by it's ID
    * Return : a user's informations
    **/
    public function viewUser(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		//$input=$request->all();
		$input=array_map('trim', $request->all());
		try{
			$validationRules=[
	            'id' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed, id not provided";
	            return $returnArr;
	        }

		    $userData=$this->user->where('id', $input['id'])->first();
	        if($userData === null){
	        	$returnArr['status']=4;
		        $returnArr['content']="";
		        $returnArr['message']="No user found with provided id";
	        }else{

	        	$result['data']=$userData;
	        	$returnArr['status']=2;
                $returnArr['content']=$result;
                $returnArr['message']="User information fetched successfully";
	        }
	    }
        catch(\Exception $e){
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}

	/**
    * Fetching all user Method 
    * Return : all user 
    **/
    public function allUser(Request $request){
    	$returnArr=config('constants.return_array');
    	$dataPerPage=config('constants.data_per_page');
    	$is_paginate=config('constants.is_paginate');
    	$order_by_column='created_at';
    	$listing_order='desc';
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());
    	try{
    		if(isset($input['is_paginate']) && $input['is_paginate'] == 0){
	            $is_paginate=$input['is_paginate'];
	        }
	        if(isset($input['data_per_page']) && $input['data_per_page']!=""){
	            $dataPerPage=$input['data_per_page'];
	        }

	        if($is_paginate == 0){
	        	$userData=$this->user
	    					->orderBy('users.'.$order_by_column, $listing_order)
	    					->get();
	    		$dataArray['data']=$userData->toArray();
	        }else{
	        	$userData=$this->user
	    					->orderBy('users.'.$order_by_column, $listing_order)
	    					->paginate($dataPerPage);
	    		$dataArray=$userData->toArray();
	        }
	        
	    	if(isset($dataArray['data']) && !empty($dataArray['data'])){

	    		if($is_paginate == 0)
	    			$response=$dataArray;
	    		else{
	    			$response=[
		                'data' => $dataArray['data'],
		                'total' => $dataArray['total'],
		                'limit' => $dataArray['per_page'],
		                'pagination' => [
		                    'next_page' => $dataArray['next_page_url'],
		                    'prev_page' => $dataArray['prev_page_url'],
		                    'current_page' => $dataArray['current_page'],
		                    'first_page' => $dataArray['first_page_url'],
		                    'last_page' => $dataArray['last_page_url']
		                ]
		            ];
	    		}

	            $returnArr['status']=2;
	            $returnArr['content']=$response;
	            $returnArr['message']="Data fetched successfully";
	        }else{
	        	$returnArr['status']=4;
		        $returnArr['content']="";
		        $returnArr['message']="No data found";
	        }
    	}
        catch(\Exception $e){
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
    }

    /**
    * User delete user Method
    * delete a user by it's ID or delete multiple user with id array
    * Return : nothing(blank)
    **/
    public function deleteUser(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		$input=$request->all();
		//$input=array_map('trim', $request->all());
		try{
			DB::beginTransaction();
			$validationRules=[
	            'id' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed, id not provided";
	            return $returnArr;
	        }

	        if (is_array($input['id'])) 
    		{
    			$resultData=$this->user->whereIn('id', $input['id'])->delete();
    			$this->oauthAccessToken->whereIn('user_id', $input['id'])->delete();
	    		if($resultData){
		        	$returnArr['status']=2;
			        $returnArr['content']="";
			        $returnArr['message']="Users deleted successfully";
		        }else{
			    	$returnArr['status']=5;
	                $returnArr['content']="";
	                $returnArr['message']="Operation failed, could not delete the users. Please check the provided id(s)";
		        }
    		}else{
    			$userData=$this->user->where('id', $input['id'])->first();
		        if($userData === null){
		        	$returnArr['status']=4;
			        $returnArr['content']="";
			        $returnArr['message']="No user found with provided id";
		        }else{
		        	$resultData=$this->user->where('id', $input['id'])->delete();
		        	$this->oauthAccessToken->where('user_id', $input['id'])->delete();
			        if($resultData){
			        	$returnArr['status']=2;
				        $returnArr['content']="";
				        $returnArr['message']="User deleted successfully";
			        }else{
				    	$returnArr['status']=5;
		                $returnArr['content']="";
		                $returnArr['message']="Operation failed, could not delete the user";
			        }
		        }
    		}
	        DB::commit();
	    }
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
	}

	/**
    * User update user email Method 
    * Updates user email
    * Return : user informations 
    **/
    public function updateUserEmail(Request $request){
    	$returnArr=config('constants.return_array');
    	//$input=$request->all();
    	$input=array_map('trim', $request->all());

    	try{
    		DB::beginTransaction();
    		$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;

    		$validationRules=[
	            'email' => 'required|email|unique:users,email,'.$logedInUser
 	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }
	        $chechAdminEmails=$this->admin->where('email', $input['email'])->first();
	        if($chechAdminEmails === null){

	        	if(CustomHelper::isAdminId($logedInUser) === true)
	        		$chechUserExistance=$this->admin->where('id', $logedInUser)->first();
	        	else
	        		$chechUserExistance=$this->user->where('id', $logedInUser)->first();

	        	if($chechUserExistance === null){
	        		$returnArr['status']=4;
		            $returnArr['content']="";
		            $returnArr['message']="No user found with the provided id";
	        	}else{
		        	$updateData['email']= (isset($input['email']) and $input['email'] != "") ? $input['email'] : NULL;
		        	$updateData['ip_address']=$request->ip();
		        	$updateData['updated_at']=\Carbon\Carbon::now()->toDateTimeString();

		        	if(CustomHelper::isAdminId($logedInUser) === true)
		          		$updateResult=$this->admin->where('id', $logedInUser)->update($updateData);
		          	else
		          		$updateResult=$this->user->where('id', $logedInUser)->update($updateData);

					if($updateResult){
						if(CustomHelper::isAdminId($logedInUser) === true)
		          			$updatedUserData=$this->admin->where('id', $logedInUser)->first();
		          		else{
		          			$updatedUserData=$this->user->where('id', $logedInUser)->first();
		          			$adminInfo=$this->admin->where('id', 1)->first();
		          			$userType=CustomHelper::getConstantsValue('user_type', $updatedUserData->user_type);
				            $mailData['admin_full_name']=$adminInfo->full_name;
				            $mailData['user_full_name']=$updatedUserData->full_name;
				            $mailData['user_type']=$userType;
				            $mailData['user_email']=$updatedUserData->email;
				            $mailData['site_url']='https://www.alegralabs.com/mukesh/symcom';

				            if($chechUserExistance->email != $updatedUserData->email){
				            	/*Mail::send('emails.user-email-change-mail-to-admin', $mailData, function($message) use($adminInfo) {
					            	$receiverEmail=trim($adminInfo->email);
								    $message->to($receiverEmail, $adminInfo->full_name)
								            ->subject('Symcom user email change notification');
								    $message->from('symcom@noreply.com','Symcom');
								});*/
				            }
		          		}

				        $returnArr['status']=2;
		                $returnArr['content']=$updatedUserData;
		                $returnArr['message']="User informations updated successfully";
	                    
		          	}else{
		          		$returnArr['status']=5;
			            $returnArr['content']="";
			            $returnArr['message']="Operation failed, could not update the data";
		          	}
	        	}
	            
	        }else{
	            $validationMsg['email']="The email has already been taken";
	            $returnArr['status']=3;
	            $returnArr['content']=$validationMsg;
	            $returnArr['message']="Validation failed";
	            //return $returnArr;
	        }
	        DB::commit();
    	}
        catch(\Exception $e){
        	DB::rollback();
        	$returnArr['status']=6;
	        $returnArr['content']=$e;
	        $returnArr['message']="Something went wrong";
        }

        return $returnArr; 
    }


	public function testEmail(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		//$input=$request->all();
		$input=array_map('trim', $request->all());

		$data = array('name'=>"Hemanta Saikia", "body" => "Test mail");
    
		Mail::send('emails.resetpassword', $data, function($message) {
		    $message->to('hemantapro@gmail.com', 'Hemanta Saikia')
		            ->subject('Symcom Testing Mail');
		    $message->from('symcom@noreply.com','Symcom');
		});

	}

}
