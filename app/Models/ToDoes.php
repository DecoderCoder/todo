<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoes extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'parent', 'completed'];

    protected $nullable = [
        'parent'
    ];

    protected $attributes = [
        'description' => '',
        'parent' => null,
        'completed' => false,
    ];
}
