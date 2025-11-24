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
 * @property int $brand_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Brand $brand
 */
class CarModel extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        "name",
        "brand_id",
    ];

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }
}
