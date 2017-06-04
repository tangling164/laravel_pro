<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,AuthorizableContract, CanResetPasswordContract

{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'users';
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remeber_token'];

    //�����û�����
    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    /**
     * @return mixed
     */
    public function feed()
    {
        return $this->statuses()
                    ->orderBy('created_at','desc');
    }
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
