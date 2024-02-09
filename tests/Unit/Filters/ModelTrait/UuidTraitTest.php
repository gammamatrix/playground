<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\UuidTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterUuid()
 */
class UuidTraitTest extends TestCase
{
    /**
     * filterUuid
     *
     * @see \Playground\Filters\ModelTrait::filterUuid()
     */
    public function test_filterUuid(): void
    {
        $instance = new FilterModel;

        $faker = \Faker\Factory::create();
        $uuid = $faker->uuid;
        $this->assertNotEmpty($uuid);
        $this->assertSame($uuid, $instance->filterUuid($uuid));
    }
}
