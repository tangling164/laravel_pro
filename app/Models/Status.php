<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Status extends Model
{
    use Authorizable;
    protected $fillable = ['content'];
    protected $table = 'statuses';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
