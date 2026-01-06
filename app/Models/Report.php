<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $reporter_id
 * @property int $auction_id
 * @property string|null $reason
 * @property Carbon|null $resolved_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $reporter
 * @property Auction $auction
 */
class Report extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        "reporter_id",
        "auction_id",
        "reason",
        "resolved_at",
    ];
    protected $casts = [
        "resolved_at" => "datetime",
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, "reporter_id");
    }

    /**
     * @return BelongsTo<Auction, $this>
     */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, "auction_id");
    }
}
