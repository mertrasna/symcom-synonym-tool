<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Helpers as CustomHelper;

class ResetPassword extends Model
{
    protected $table = 'reset_password';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'token', 'ip_address', 'expire_at', 'created_at', 'updated_at'
    ];

    public $timestamps = false;
}
