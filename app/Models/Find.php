<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Find extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'name', 'code', 'user_id','audit_id', 'status','end_date','description','recommendation','responsible','responsible_comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id','id');
    }
}
