<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $photo_url
 * @property float $price
 * @property int $owner_id
 * @property int $model_id
 * @property int $category_id
 * @property int $condition_id
 * @property int $auction_state_id
 */
class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "photo_url",
        "price",
        "owner_id",
        "model_id",
        "category_id",
        "condition_id",
        "auction_state_id",
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner_id");
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, "model_id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class, "condition_id");
    }

    public function auctionState(): BelongsTo
    {
        return $this->belongsTo(AuctionState::class, "auction_state_id");
    }

    public $timestamps = false;
}
