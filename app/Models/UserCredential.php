<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'email_provider',
        'full_email_provider',
        'group_name',
        'group_id',
        'user_id',
    ];
}
