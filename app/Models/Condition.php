<?php

declare(strict_types=1);

namespace Otoszroto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Otoszroto\Enums\ConditionName;

/**
 * @property int $id
 * @property ConditionName $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Condition extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "name",
    ];
    protected $casts = [
        "name" => ConditionName::class,
    ];
}
