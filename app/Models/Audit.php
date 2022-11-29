<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Audit extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'name', 'code', 'user_id', 'status','expiration_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function find()
    {
        return $this->hasMany(Find::class);
    }
}
