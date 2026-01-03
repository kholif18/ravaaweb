<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'benefits',
        'cta_text',
        'whatsapp_number',
        'phone_number',
        'color',
        'image_url',
        'start_date',
        'expiry_date',
        'status'
    ];

    protected $casts = [
        'benefits' => 'array',
        'start_date' => 'date',
        'expiry_date' => 'date',
        'status' => 'boolean'
    ];
}
