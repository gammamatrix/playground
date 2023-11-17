<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Filters;

/**
 * \GammaMatrix\Playground\Filters\ContentTrait
 *
 * GammaMatrix filter handler
 *
 */
trait ContentTrait
{
    /**
     * @var \HTMLPurifier $purifier HTMLPurifier
     */
    protected $purifier;

    /**
     * Purify a string
     *
     * @param  string $item The string to purify
     *
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
     *
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
        if (null === $this->purifier) {
            $config = empty($config) ? config('playground') : $config;

            $safeIframeRegexp = !empty($config['iframes'])
                && is_string($config['iframes'])
                ? $config['iframes']
                : '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%'
            ;

            $serializerPath = !empty($config['cache'])
                && !empty($config['cache']['purifier'])
                && is_string($config['cache']['purifier'])
                ? $config['cache']['purifier']
                : null
            ;

            $hpc = \HTMLPurifier_Config::createDefault();
            $hpc->set('HTML.SafeIframe', true);
            $hpc->set('Cache.SerializerPath', $serializerPath);
            $hpc->set('URI.SafeIframeRegexp', $safeIframeRegexp);
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
        if (null === $this->purifier) {
            $this->purifier = $purifier;
        }

        return $this;
    }

    ############################################################################
    #
    # URI handling
    #
    ############################################################################

    /**
     * encodeURIComponent
     *
     * This method is supposed to be identical to the function in JavaScript.
     *
     * @link http://stackoverflow.com/questions/1734250/what-is-the-equivalent-of-javascripts-encodeuricomponent-in-php
     *
     * @param  string $str The string to encode.
     *
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
