<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_hobi',
        'user_id',
    ];

    /**
     * Relasi: Hobby dimiliki oleh 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}