<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    protected $title;
    protected $attributes = [
        'title',
        'first_cover',
        'publication_date',
        'description',
        'author',
        'genre'
    ];

    protected $dates = [
        'publication_date'
    ];

    /**
     * Get the user that owns the Book
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
