<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Helpers\IdenticonHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Metrics\Chartable;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $photo
 * @property string $city
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
    use Chartable;

    public $timestamps = true;
    protected $fillable = [
        "name",
        "description",
        "price",
        "city",
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

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    protected function photo(): Attribute
    {
        return Attribute::get(fn(): string => IdenticonHelper::url($this->id));
    }
}
