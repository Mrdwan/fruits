<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $genus
 * @property string $order
 * @property float $carbohydrates
 * @property float $protein
 * @property float $fat
 * @property float $calories
 * @property float $sugar
 * @property bool $is_favorited
 * @property FruitFamily $family
 */
class Fruit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'genus',
        'order',
        'carbohydrates',
        'protein',
        'fat',
        'calories',
        'sugar',
        'fruit_family_id'
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(FruitFamily::class, 'fruit_family_id');
    }

    public function scopeFavorited($query): Builder
    {
        return $query->where('is_favorited', true);
    }

    public function scopeUnfavorited($query): Builder
    {
        return $query->where('is_favorited', false);
    }

    public function toggleFavorite()
    {
        $this->is_favorited = ! $this->is_favorited;

        return $this->save();
    }
}
