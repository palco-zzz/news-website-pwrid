<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CitizenReport extends Model
{
    use HasFactory;

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = ['status_color'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category',
        'location',
        'latitude',
        'longitude',
        'reporter_id',
        'reporter_name',
        'reporter_phone',
        'status',
        'is_anonymous',
        'is_published',
        'published_at',
        'upvotes_count',
        'admin_note',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_anonymous' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the reporter (user) that submitted this report.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Scope a query to only include published reports.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    /**
     * Scope a query to only include verified reports.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope a query to only include pending reports.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to order by latest published.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to order by most upvoted.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('upvotes_count', 'desc');
    }

    /**
     * Get the status color attribute for Tailwind classes.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
            'verified' => 'bg-blue-100 text-blue-700 border-blue-200',
            'in_progress' => 'bg-purple-100 text-purple-700 border-purple-200',
            'resolved' => 'bg-green-100 text-green-700 border-green-200',
            'rejected' => 'bg-red-100 text-red-700 border-red-200',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }
}
