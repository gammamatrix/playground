<?php
/**
 * Playground
 */
namespace Playground\Filters;

/**
 * \Playground\Filters\ContentTrait
 *
 * Playground filter handler
 */
trait ContentTrait
{
    /**
     * @var \HTMLPurifier HTMLPurifier
     */
    protected $purifier;

    /**
     * Purify a string
     *
     * @param  string $item The string to purify
     * @return string
     */
    public function purify($item)
    {
        return $this->getHtmlPurifier()->purify($item);
    }

    /**
     * Exorcise all html from the string.
     *
     * @param  string $item The string to purify
     * @return string
     */
    public static function exorcise($item)
    {
        return htmlspecialchars(
            strip_tags($item),
            ENT_HTML5
        );
    }

    /**
     * Get HTMLPurifier
     *
     * @return \HTMLPurifier
     */
    public function getHtmlPurifier(array $config = [])
    {
        if ($this->purifier === null) {
            $config = empty($config) ? config('playground.purifier') : $config;

            $hpc = \HTMLPurifier_Config::createDefault();

            if (! empty($config['iframes'])
                && is_string($config['iframes'])
            ) {
                $hpc->set('HTML.SafeIframe', true);
                $hpc->set('URI.SafeIframeRegexp', $config['iframes']);
            }

            if (! empty($config['path'])
                && is_string($config['path'])
            ) {
                $hpc->set('Cache.SerializerPath', $config['path']);
            }

            $this->setHtmlPurifier(new \HTMLPurifier($hpc));
        }

        return $this->purifier;
    }

    /**
     * Set HTMLPurifier
     *
     * @param \HTMLPurifier $purifier The HTMLPurifier instance
     */
    public function setHtmlPurifier(\HTMLPurifier $purifier)
    {
        if ($this->purifier === null) {
            $this->purifier = $purifier;
        }

        return $this;
    }

    //###########################################################################
    //
    // URI handling
    //
    //###########################################################################

    /**
     * encodeURIComponent
     *
     * This method is supposed to be identical to the function in JavaScript.
     *
     * @link http://stackoverflow.com/questions/1734250/what-is-the-equivalent-of-javascripts-encodeuricomponent-in-php
     *
     * @param  string $str The string to encode.
     * @return string Returns an encoded URL for embedding
     */
    public static function encodeURIComponent($str)
    {
        return strtr(rawurlencode($str), [
            '%21' => '!',
            '%2A' => '*',
            '%27' => "'",
            '%28' => '(',
            '%29' => ')',
        ]);
    }
}
