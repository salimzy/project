<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerProfile extends Model
{
    use HasFactory;

    protected $fillable = ['headline', 'bio', 'skills', 'location'];

    protected function casts(): array
    {
        return ['skills' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
