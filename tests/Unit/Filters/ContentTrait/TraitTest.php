<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ContentTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ContentTrait\TraitTest
 */
class TraitTest extends TestCase
{
    public function test_purify(): void
    {
        $instance = new ContentModel;

        $expected = 'some-string';

        $this->assertSame($expected, $instance->purify($expected));
    }

    public function test_exorcise(): void
    {
        $instance = new ContentModel;

        $expected = 'some-string';

        $this->assertSame($expected, $instance->exorcise($expected));
    }

    public function test_getHtmlPurifier(): void
    {
        $instance = new ContentModel;

        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $instance->getHtmlPurifier()
        );
    }

    public function test_getHtmlPurifier_with_iframes(): void
    {
        $instance = new ContentModel;

        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $instance->getHtmlPurifier([
                'iframes' => '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%',
            ])
        );
    }

    public function test_getHtmlPurifier_with_purifier_path(): void
    {
        $instance = new ContentModel;

        $this->assertInstanceOf(
            \HTMLPurifier::class,
            $instance->getHtmlPurifier([
                'path' => '/tmp/purifier',
            ])
        );
    }

    public function test_encodeURIComponent(): void
    {
        $instance = new ContentModel;

        $expected = 'some-string';

        $this->assertSame($expected, $instance->encodeURIComponent($expected));
    }
}
