<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'docs';

    protected $fillable = [
        'title',
        'generated_name',
        'file_path',
        'content',
        'classification',
        'file_type',
        'size',
        'uploaded_at',
        'user_id',
        'description',
    ];

    protected $dates = [
        'uploaded_at',
        'created_at',
        'updated_at',
    ];

 
}
