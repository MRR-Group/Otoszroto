<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $brand_id
 */
class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "brand_id",
    ];

    public $timestamps = false;
}
