<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'type', 'total', 'user_id', 'status', 'wallet_type',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
