<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Models;

use Playground\Models\Model;
use Playground\Models\Scopes\ScopeIsPublished;

/**
 * \Tests\Unit\Playground\Models\TestModel
 */
class TestModel extends Model
{
    use ScopeIsPublished;
}
