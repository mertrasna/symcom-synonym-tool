<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;
use App\Libraries\Helpers as CustomHelper;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    protected $table='admins';

    protected $fillable = [
        'email', 'password', 'ip_address', 'last_login_at', 'current_login_at'
    ];

    public $timestamps = false;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Appending creator name and editor name in the return array
     */
    protected $appends = ['username', 'slug', 'user_type', 'salutation', 'first_name', 'last_name', 'full_name', 'phone', 'active', 'company'];


    /**
     * For geting each users access tokens
     */
    public function AauthAcessToken()
    {
        return $this->hasMany('App\OauthAccessToken', 'user_id', 'id');
    }

    /**
     * Geting Last login date time in project format
     */
    public function getLastLoginAtAttribute($value)
    {
        $datetimeFormat=config('constants.date_time_format');
        return ($value != "" and $value != NULL and $value != '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($value)->format($datetimeFormat) : NULL;
    }

    /**
     * Geting Current login date time in project format
     */
    public function getCurrentLoginAtAttribute($value)
    {
        $datetimeFormat=config('constants.date_time_format');
        return ($value != "" and $value != NULL and $value != '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($value)->format($datetimeFormat) : NULL;
    }

    /**
     * Geting Created at date time in project format
     */
    public function getCreatedAtAttribute($value)
    {
        $datetimeFormat=config('constants.date_time_format');
        return ($value != "" and $value != NULL and $value != '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($value)->format($datetimeFormat) : NULL;
    }

    /**
     * Geting Updated at date time in project format
     */
    public function getUpdatedAtAttribute($value)
    {
        $datetimeFormat=config('constants.date_time_format');
        return ($value != "" and $value != NULL and $value != '0000-00-00 00:00:00') ? \Carbon\Carbon::parse($value)->format($datetimeFormat) : NULL;
    }

     /**
     * Geting Admin username from the constants
     */
    public function getUsernameAttribute()
    {
        $username=CustomHelper::getAdminConstants($this->id, 'username');
        return ($username != "") ? $username : NULL;
    }

    /**
     * Geting Admin slug from the constants
     */
    public function getSlugAttribute()
    {
        $slug=CustomHelper::getAdminConstants($this->id, 'slug');
        return ($slug != "") ? $slug : NULL;
    }

    /**
     * Geting Admin user_type from the constants
     */
    public function getUserTypeAttribute()
    {
        $userType=CustomHelper::getAdminConstants($this->id, 'user_type');
        return ($userType != "") ? $userType : NULL;
    }

    /**
     * Geting Admin salutation from the constants
     */
    public function getSalutationAttribute()
    {
        $salutation=CustomHelper::getAdminConstants($this->id, 'salutation');
        return ($salutation != "") ? $salutation : NULL;
    }

    /**
     * Geting Admin first_name from the constants
     */
    public function getFirstNameAttribute()
    {
        $firstName=CustomHelper::getAdminConstants($this->id, 'first_name');
        return ($firstName != "") ? $firstName : NULL;
    }

    /**
     * Geting Admin last_name from the constants
     */
    public function getLastNameAttribute()
    {
        $lastName=CustomHelper::getAdminConstants($this->id, 'last_name');
        return ($lastName != "") ? $lastName : NULL;
    }

    /**
     * Geting Admin full_name from the constants
     */
    public function getFullNameAttribute()
    {
        $fullName=CustomHelper::getAdminConstants($this->id, 'full_name');
        return ($fullName != "") ? $fullName : NULL;
    }

    /**
     * Geting Admin phone from the constants
     */
    public function getPhoneAttribute()
    {
        $phone=CustomHelper::getAdminConstants($this->id, 'phone');
        return ($phone != "") ? $phone : NULL;
    }

    /**
     * Geting Admin active from the constants
     */
    public function getActiveAttribute()
    {
        $active=CustomHelper::getAdminConstants($this->id, 'active');
        return ($active != "") ? $active : NULL;
    }

    /**
     * Geting Admin company from the constants
     */
    public function getCompanyAttribute()
    {
        $company=CustomHelper::getAdminConstants($this->id, 'company');
        return ($company != "") ? $company : NULL;
    }
}
