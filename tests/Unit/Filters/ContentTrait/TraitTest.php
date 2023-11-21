<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ContentTrait;

use GammaMatrix\Playground\Test\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ContentTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    public const TRAIT_CLASS = \GammaMatrix\Playground\Filters\ContentTrait::class;

    /**
     * @var object
     */
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

    /**
     * Test purify().
     *
     */
    public function test_purify()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->purify($expected));
    }

    /**
     * Test exorcise().
     *
     */
    public function test_exorcise()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->exorcise($expected));
    }

    /**
     * Test getHtmlPurifier().
     *
     */
    public function test_getHtmlPurifier()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier()
        );
    }

    /**
     * Test getHtmlPurifier().
     *
     */
    public function test_getHtmlPurifier_with_iframes()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier([
                'iframes' => '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%',
            ])
        );
    }

    /**
     * Test getHtmlPurifier().
     *
     */
    public function test_getHtmlPurifier_with_purifier_path()
    {
        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $this->mock->getHtmlPurifier([
                'cache' => [
                    'purifier' => '/tmp/purifier',
                ]
            ])
        );
    }

    /**
     * Test encodeURIComponent().
     *
     */
    public function test_encodeURIComponent()
    {
        $expected = 'some-string';

        $this->assertSame($expected, $this->mock->encodeURIComponent($expected));
    }
}
