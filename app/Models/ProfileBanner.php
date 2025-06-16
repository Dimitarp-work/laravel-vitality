<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileBanner extends Model
{
    protected $fillable = ['name', 'image_url'];
}
