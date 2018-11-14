<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $fillable = ['email', 'token', 'created_at'];
    protected $hidden = ['token'];
    public $timestamps = false;
    public $primaryKey = 'email';
    public $incrementing = false;
}
