<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];
}
