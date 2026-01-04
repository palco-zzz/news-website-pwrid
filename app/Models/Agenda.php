<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'date',
        'time',
        'end_time',
        'location',
        'description',
        'category',
        'image',
        'status',
        'created_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'time' => 'datetime:H:i',
        ];
    }

    /**
     * Get the user who created this agenda.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include published agendas.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include upcoming agendas.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->startOfDay());
    }

    /**
     * Scope a query to only include past agendas.
     */
    public function scopePast($query)
    {
        return $query->where('date', '<', now()->startOfDay());
    }

    /**
     * Scope a query to order by date ascending.
     */
    public function scopeOrderByDate($query)
    {
        return $query->orderBy('date', 'asc');
    }
}
