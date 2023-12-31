<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * \GammaMatrix\Playground\Models\UuidModel
 *
 * Models that extend this class use a UUID for a primary key.
 *
 */
abstract class UuidModel extends Model
{
    use HasUuids;

    /**
     * Disable auto-incrementing primary when using a UUID column.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var boolean
     */
    public static $snakeAttributes = true;
}
