<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderSubmission extends Model
{
    protected $fillable = [
        'type',
        'customer_name',
        'whatsapp',
        'email',
        'data',
        'file_path',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'data' => 'array',
        'file_path' => 'array',
    ];

    /**
     * Type label mapping
     */
    public const TYPE_LABELS = [
        'wedding' => 'Pernikahan',
        'khitan' => 'Khitan',
        'baby_name' => 'Nama Bayi',
        'birthday' => 'Ulang Tahun',
    ];

    /**
     * Status label mapping
     */
    public const STATUS_LABELS = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    /**
     * Type accessor
     */
    protected function typeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::TYPE_LABELS[$this->type] ?? $this->type,
        );
    }

    /**
     * Status accessor
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::STATUS_LABELS[$this->status] ?? $this->status,
        );
    }

    /**
     * Get specific data field
     */
    public function getDataField(string $key, mixed $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }

    /**
     * Scope: filter by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: filter by status
     */
    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: search by name or whatsapp
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
              ->orWhere('whatsapp', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
