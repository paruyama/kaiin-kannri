<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Modelを継承

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'user_id', // usersテーブルのIDと紐づける
        'name',
        'phone',
        'member_code',
        // その他の会員情報
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // membersテーブルのidとusersテーブルのidを紐づける
    }
}
