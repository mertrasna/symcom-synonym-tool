<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\Helpers as CustomHelper;

class SynonymEnController extends Controller
{

    public function __construct(\App\User $user, \App\Admin $admin, \App\QuelleImportMaster $quelleImportMaster, \App\SynonymEn $synonymEn, \App\SynonymReference $synonymReference){
        $this->user = $user;
        $this->admin = $admin;
        $this->quelleImportMaster = $quelleImportMaster;
        $this->synonymEn = $synonymEn;
		$this->synonymReference = $synonymReference;
        $this->dateFormat=config('constants.date_format');
        $this->dateTimeFormat=config('constants.date_time_format');
    }

    /**
    * Fetching all SynonymEn Method 
    * Return : all SynonymEn 
    **/
    public function allSynonymEn(Request $request){
    	$returnArr=config('constants.return_array');
    	$dataPerPage=config('constants.data_per_page');
    	$is_paginate=config('constants.is_paginate');
    	$input=$request->all();

    	try{
    		if(isset($input['is_paginate']) && $input['is_paginate'] == 0){
	            $is_paginate=$input['is_paginate'];
	        }
    		if(isset($input['data_per_page']) && $input['data_per_page']!=""){
	            $dataPerPage=$input['data_per_page'];
	        }

	        if($is_paginate == 0){
	        	$synonymEnData=$this->synonymEn
							->with('synonymreference')
	    					->orderBy('synonym_en.ersteller_datum', 'desc')
	    					->get();
	    		$dataArray['data']=$synonymEnData->toArray();
	        }else{
	        	$synonymEnData=$this->synonymEn
							->with('synonymreference')
	    					->orderBy('synonym_en.ersteller_datum', 'desc')
	    					->paginate($dataPerPage);
	    		$dataArray=$synonymEnData->toArray();
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
    * adding Synonym Method
    * Adding a Synonym
    * Return : added Synonym informations
    **/
    public function addSynonymEn(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		$input=$request->all();
		try{
			DB::beginTransaction();
			$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;

			$validationRules=[
	            'word' => 'required',
	            'strict_synonym' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

		    $insertData['word']= (isset($input['word']) and $input['word'] != "") ? $input['word'] : NULL;
		    $insertData['strict_synonym']= (isset($input['strict_synonym']) and $input['strict_synonym'] != "") ? $input['strict_synonym'] : NULL;
		    $insertData['synonym_partial_1']= (isset($input['synonym_partial_1']) and $input['synonym_partial_1'] != "") ? $input['synonym_partial_1'] : NULL;
		    $insertData['synonym_partial_2']= (isset($input['synonym_partial_2']) and $input['synonym_partial_2'] != "") ? $input['synonym_partial_2'] : NULL;
		    $insertData['synonym_general']= (isset($input['synonym_general']) and $input['synonym_general'] != "") ? $input['synonym_general'] : NULL;
		    $insertData['synonym_minor']= (isset($input['synonym_minor']) and $input['synonym_minor'] != "") ? $input['synonym_minor'] : NULL;
		    $insertData['synonym_nn']= (isset($input['synonym_nn']) and $input['synonym_nn'] != "") ? $input['synonym_nn'] : NULL;
			$insertData['synonym_reference_id']= (isset($input['synonym_reference_id']) and $input['synonym_reference_id'] != "") ? $input['synonym_reference_id'] : NULL;
			$insertData['synonym_ns']= (isset($input['synonym_ns']) and $input['synonym_ns'] != "") ? $input['synonym_ns'] : "0";
			$insertData['source_reference_ns']= (isset($input['source_reference_ns']) and $input['source_reference_ns'] != "") ? $input['source_reference_ns'] : "0";
			$insertData['synonym_comment']= (isset($input['synonym_comment']) and $input['synonym_comment'] != "") ? $input['synonym_comment'] : NULL;
		    $insertData['active']= (isset($input['active']) and $input['active'] != "") ? $input['active'] : 1;
		    $insertData['ip_address']=$request->ip();
		    $insertData['ersteller_datum']=\Carbon\Carbon::now()->toDateTimeString();
		    $insertData['ersteller_id']=$logedInUser;

		    $synonymDeResult=$this->synonymEn->create($insertData);
		    if($synonymDeResult){
				$canProceed = 1;
				if(isset($insertData['synonym_reference_id']) AND !empty($insertData['synonym_reference_id'])){
					$synonymReferenceData = [];
					foreach ($insertData['synonym_reference_id'] as $synonymRefKey => $synonymRefVal) {
						$synonymReferenceData[] = [
							'synonym_id'  => $synonymDeResult->id,
							'synonym_reference_id' => $synonymRefVal,
							'ersteller_datum' => \Carbon\Carbon::now()->toDateTimeString(),
							'ersteller_id' => $logedInUser,
						];
					}

					$synonymReferenceInsertRes=DB::table('synonym_en_synonym_reference')->insert($synonymReferenceData);
					if($synonymReferenceInsertRes == true)
						$canProceed = 1;
					else
						$canProceed = 0;
				}
		    	$updateData['is_synonyms_up_to_date']= 0;
		    	$updateData['ip_address']=$request->ip();
			    $updateData['stand']=\Carbon\Carbon::now()->toDateTimeString();
			    $updateData['bearbeiter_id']=$logedInUser;
			    $updateResult=$this->quelleImportMaster->where('is_synonyms_up_to_date', 1)->update($updateData);
				if($canProceed == 1){
					$insertedData=$this->synonymEn->where('synonym_id', $synonymDeResult->id)->first();
					$result['data']=$insertedData;
					$returnArr['status']=2;
					$returnArr['content']=$result;
					$returnArr['message']="Synonym created successfully";
				}else{
					$returnArr['status']=5;
					$returnArr['content']="";
					$returnArr['message']="Operation failed, could not assign the synonym reference";
				}
					
		    }else{
		    	$returnArr['status']=5;
                $returnArr['content']="";
                $returnArr['message']="Operation failed, could not create the synonym";
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
    * view SynonymEn Method
    * view SynonymEn information by it's ID
    * Return : a SynonymEn's informations
    **/
    public function viewSynonymEn(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		$input=$request->all();
		try{
			$validationRules=[
	            'synonym_id' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed, synonym_id not provided";
	            return $returnArr;
	        }

		    $synonymEnData=$this->synonymEn->with('synonymreference')->where('synonym_id', $input['synonym_id'])->first();
	        if($synonymEnData === null){
	        	$returnArr['status']=4;
		        $returnArr['content']="";
		        $returnArr['message']="No synonym found with provided synonym_id";
	        }else{
	        	$result['data']=$synonymEnData;
	        	$returnArr['status']=2;
                $returnArr['content']=$result;
                $returnArr['message']="Synonym information fetched successfully";
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
    * User update Synonym Method
    * update Synonym information by it's ID
    * Return : updated Synonym's informations
    **/
    public function updateSynonymEn(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		$input=$request->all();
		try{
			DB::beginTransaction();
			$guard=CustomHelper::getGuard();
			$currentUser = \Auth::guard($guard)->user();
    		$logedInUser=isset($currentUser->id) ? $currentUser->id : NULL;
    		
			$validationRules=[
	            'synonym_id' => 'required',
	            'word' => 'required',
	            'strict_synonym' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed";
	            return $returnArr;
	        }

	        $synonymData=$this->synonymEn->where('synonym_id', $input['synonym_id'])->first();
	        if($synonymData === null){
	        	$returnArr['status']=4;
		        $returnArr['content']="";
		        $returnArr['message']="No synonym found with provided synonym_id";
	        }else{
	        	$updateData['word']= (isset($input['word']) and $input['word'] != "") ? $input['word'] : NULL;
		    	$updateData['strict_synonym']= (isset($input['strict_synonym']) and $input['strict_synonym'] != "") ? $input['strict_synonym'] : NULL;
		    	$updateData['synonym_partial_1']= (isset($input['synonym_partial_1']) and $input['synonym_partial_1'] != "") ? $input['synonym_partial_1'] : NULL;
		    	$updateData['synonym_partial_2']= (isset($input['synonym_partial_2']) and $input['synonym_partial_2'] != "") ? $input['synonym_partial_2'] : NULL;
		    	$updateData['synonym_general']= (isset($input['synonym_general']) and $input['synonym_general'] != "") ? $input['synonym_general'] : NULL;
		    	$updateData['synonym_minor']= (isset($input['synonym_minor']) and $input['synonym_minor'] != "") ? $input['synonym_minor'] : NULL;
		    	$updateData['synonym_nn']= (isset($input['synonym_nn']) and $input['synonym_nn'] != "") ? $input['synonym_nn'] : NULL;
		    	$updateData['synonym_comment']= (isset($input['synonym_comment']) and $input['synonym_comment'] != "") ? $input['synonym_comment'] : NULL;
				$updateData['synonym_ns']= (isset($input['synonym_ns']) and $input['synonym_ns'] != "") ? $input['synonym_ns'] : "0";
		    	$updateData['source_reference_ns']= (isset($input['source_reference_ns']) and $input['source_reference_ns'] != "") ? $input['source_reference_ns'] : "0";
		    	$updateData['active']= (isset($input['active']) and $input['active'] != "") ? $input['active'] : 1;
		    	$updateData['ip_address']=$request->ip();
			    $updateData['stand']=\Carbon\Carbon::now()->toDateTimeString();
			    $updateData['bearbeiter_id']=$logedInUser;

			    $updateResult=$this->synonymEn->where('synonym_id', $input['synonym_id'])->update($updateData);
			    if($updateResult){
					$deleteExistingSynonymReference=DB::table('synonym_en_synonym_reference')->where('synonym_id', $input['synonym_id'])->delete();
					$canProceed = 1;
					
					if(isset($input['synonym_reference_id']) and !empty($input['synonym_reference_id'])){
						$synonymReferenceData = [];
						foreach ($input['synonym_reference_id'] as $synonymRefKey => $synonymRefVal) {
							$synonymReferenceData[] = [
								'synonym_id'  => $input['synonym_id'],
								'synonym_reference_id' => $synonymRefVal,
								'ersteller_datum' => \Carbon\Carbon::now()->toDateTimeString(),
								'ersteller_id' => $logedInUser,
							];
						}

						$synonymReferenceInsertRes=DB::table('synonym_en_synonym_reference')->insert($synonymReferenceData);
						if($synonymReferenceInsertRes == true)
							$canProceed = 1;
						else
							$canProceed = 0;
					}

			    	$updateQIMData['is_synonyms_up_to_date']= 0;
			    	$updateQIMData['ip_address']=$request->ip();
				    $updateQIMData['stand']=\Carbon\Carbon::now()->toDateTimeString();
				    $updateQIMData['bearbeiter_id']=$logedInUser;
				    $updateQIMResult=$this->quelleImportMaster->where('is_synonyms_up_to_date', 1)->update($updateQIMData);
			    	if($canProceed == 1){
						$fetchData=$this->synonymEn->where('synonym_id', $input['synonym_id'])->first();	
						$returnArr['status']=2;
						$returnArr['content']=$fetchData;
						$returnArr['message']="Synonym information updated successfully";
					}else{
						$returnArr['status']=5;
						$returnArr['content']="";
						$returnArr['message']="Operation failed, could not assign the synonym reference";
					}		
			    }else{
			    	$returnArr['status']=5;
	                $returnArr['content']="";
	                $returnArr['message']="Operation failed, could not update the synonym";
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
    * User delete Synonym Method
    * delete a Synonym by it's ID
    * Return : nothing(blank)
    **/
    public function deleteSynonymEn(Request $request)
	{ 
		$returnArr=config('constants.return_array');
		$input=$request->all();
		try{
			DB::beginTransaction();
			$validationRules=[
	            'synonym_id' => 'required'
	        ];
	        $validator= \Validator::make($input, $validationRules);
	        if($validator->fails()){
	            $returnArr['status']=3;
	            $returnArr['content']=$validator->errors();
	            $returnArr['message']="Validation failed, synonym_id not provided";
	            return $returnArr;
	        }

	        if (is_array($input['synonym_id'])) 
    		{
				DB::table('synonym_en_synonym_reference')->whereIn('synonym_id', $input['synonym_id'])->delete();
    			$resultData=$this->synonymEn->whereIn('synonym_id', $input['synonym_id'])->delete();
	    		if($resultData){
		        	$returnArr['status']=2;
			        $returnArr['content']="";
			        $returnArr['message']="Synonym deleted successfully";
		        }else{
			    	$returnArr['status']=5;
	                $returnArr['content']="";
	                $returnArr['message']="Operation failed, could not delete the synonym. Please check the provided synonym_id(s)";
		        }
    		}
    		else{
    			$synonymData=$this->synonymEn->where('synonym_id', $input['synonym_id'])->first();
		        if($synonymData === null){
		        	$returnArr['status']=4;
			        $returnArr['content']="";
			        $returnArr['message']="No synonym found with provided synonym_id";
		        }else{
					DB::table('synonym_en_synonym_reference')->whereIn('synonym_id', $input['synonym_id'])->delete();
		        	$resultData=$this->synonymEn->where('synonym_id', $input['synonym_id'])->delete();
			        if($resultData){
			        	$returnArr['status']=2;
				        $returnArr['content']="";
				        $returnArr['message']="Synonym deleted successfully";
			        }else{
				    	$returnArr['status']=5;
		                $returnArr['content']="";
		                $returnArr['message']="Operation failed, could not delete the herkunft";
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
}
