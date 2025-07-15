<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'bdsp_id',
        'name',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'is_approved',
    ];

    public function bdsp()
    {
        return $this->belongsTo(User::class, 'bdsp_id');
    }
}