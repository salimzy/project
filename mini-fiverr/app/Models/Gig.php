<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'packages', 'delivery_days', 'status', 'cover_image',
    ];

    protected function casts(): array
    {
        return ['packages' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(function (Gig $gig): void {
            $gig->slug = Str::slug($gig->title).'-'.Str::lower(Str::random(6));
        });
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
