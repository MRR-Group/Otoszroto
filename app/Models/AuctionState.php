<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Otoszroto\Enums\AuctionStateName;

/**
 * @property int $id
 * @property ActionStateName $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AuctionState extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "name",
    ];
    protected $casts = [
        "name" => AuctionStateName::class,
    ];
}
