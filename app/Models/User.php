<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
    ];

    /**
     * Relasi: 1 User memiliki banyak Hobby
     */
    public function hobbies()
    {
        return $this->hasMany(Hobby::class);
    }
}