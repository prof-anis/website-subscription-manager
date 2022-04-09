<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'description'
    ];

    protected $casts = [
        'notifications_sent_at' => 'datetime'
    ];

    public function websites(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'website_id', 'id');
    }

    public function isSent(): bool
    {
        return (bool) $this->notifications_sent_at;
    }
}
