<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Tambahkan 'description' dan 'image' di sini
    protected $fillable = ['name', 'slug', 'description', 'image'];
}
