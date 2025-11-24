<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
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
 * @property string $auction_state
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $owner
 * @property CarModel $model
 * @property Category $category
 * @property Condition $condition
 * @property AuctionState $auctionState
 */
class Auction extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        "name",
        "description",
        "photo_url",
        "price",
        "owner_id",
        "model_id",
        "category_id",
        "condition_id",
        "auction_state",
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner_id");
    }

    /**
     * @return BelongsTo<CarModel, $this>
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, "model_id");
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    /**
     * @return BelongsTo<Condition, $this>
     */
    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class, "condition_id");
    }

    /**
     * @return BelongsTo<AuctionState, $this>
     */
    public function auctionState(): BelongsTo
    {
        return $this->belongsTo(AuctionState::class, "auction_state", "name");
    }
}
