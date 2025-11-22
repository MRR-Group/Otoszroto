<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $brand_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CarModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "name",
        "brand_id",
    ];
}
