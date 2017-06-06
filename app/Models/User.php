<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;
class User extends Model implements AuthenticatableContract,AuthorizableContract, CanResetPasswordContract

{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'users';
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remeber_token'];

    //生成用户令牌
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
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
                                        ->with('user')
                                        ->orderBy('created_at','desc');
    }
    //生成一对多的关系
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

   public function followers()
    {
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    public function follow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }

    public function unfollow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
