<?php
/**
 * Playground
 */
namespace Playground\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\UuidModel
 *
 * Models that extend this class use a UUID for a primary key.
 */
abstract class UuidModel extends Model
{
    use HasUuids;

    /**
     * Disable auto-incrementing primary when using a UUID column.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = true;
}
