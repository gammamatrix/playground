<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ContentTrait;

use Tests\Unit\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ContentTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \GammaMatrix\Playground\Filters\ContentTrait::class;

    public $mock;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForTrait(
            static::TRAIT_CLASS,
            [],
            '',
            true,
            true,
            true,
            $methods = []
        );
    }

    public function test_purify()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->purify($expected));
    }

    public function test_exorcise()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->exorcise($expected));
    }

    public function test_getHtmlPurifier()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier()
        );
    }

    public function test_getHtmlPurifier_with_iframes()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier([
                'iframes' => '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%',
            ])
        );
    }

    public function test_getHtmlPurifier_with_purifier_path()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier([
                'path' => '/tmp/purifier',
            ])
        );
    }

    public function test_encodeURIComponent()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->encodeURIComponent($expected));
    }
}
