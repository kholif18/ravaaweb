<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'name',
        'email',
        'phone',
        'company',
        'message',
        'budget',
        'timeline',
        'status',
        'notes'
    ];

    protected $casts = [
        'budget' => 'decimal:2'
    ];

    // Relationship dengan service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Relationship dengan user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Accessors
    public function getFormattedBudgetAttribute()
    {
        if ($this->budget === null) {
            return 'Not specified';
        }
        
        return 'Rp ' . number_format($this->budget, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800'
        ];
        
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
