<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class user extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'member_code',
        // その他の会員情報
    ];

    public function member()
{
    return $this->hasOne(Member::class, 'user_id', 'id');
}
}