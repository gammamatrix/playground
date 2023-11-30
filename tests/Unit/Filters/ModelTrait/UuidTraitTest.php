<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait\UuidTraitTest
 *
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterUuid()
 */
class UuidTraitTest extends TraitTestCase
{
    /**
     * filterUuid
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterUuid()
     */
    public function test_filterUuid()
    {
        $faker = \Faker\Factory::create();
        $uuid = $faker->uuid;
        $this->assertNotEmpty($uuid);
        $this->assertSame($uuid, $this->mock->filterUuid($uuid));
    }
}
