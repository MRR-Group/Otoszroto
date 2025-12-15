<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Otoszroto\Enums\AuctionState;
use Otoszroto\Enums\Condition;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $photo_url
 * @property float $price
 * @property int $owner_id
 * @property int $model_id
 * @property int $category_id
 * @property Condition $condition
 * @property AuctionState $auction_state
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $owner
 * @property CarModel $model
 * @property Category $category
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
        "condition",
        "auction_state",
    ];    
    protected $casts = [
        "condition" => Condition::class,
        "auction_state" => AuctionState::class,
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
        return $this->belongsTo(Category::class);
    }
}
