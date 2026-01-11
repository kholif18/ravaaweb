<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaUsage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media_usages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'media_id',
        'model_type',
        'model_id',
        'field_name',
        'purpose',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'media_id' => 'integer',
        'model_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the media associated with this usage
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Get the model that uses this media
     */
    public function model()
    {
        return $this->morphTo();
    }
}