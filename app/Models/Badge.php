<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Badge extends Model
{
    protected $fillable = ['name', 'description', 'image_url', 'style'];

    protected $casts = [
        'style' => 'array',
    ];

    public function users()
{
    return $this->belongsToMany(\App\Models\User::class)->withTimestamps();
}

public static function createForChallenge(array $data)
{
    $service = new ItemCreationService();
    return $service->createBadge($data, $data['price'] ?? 0);
}

}
