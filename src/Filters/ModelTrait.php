<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Filters;

use Carbon\Carbon;

use Ramsey\Uuid\Uuid;

/**
 * \GammaMatrix\Playground\Filters\ModelTrait
 *
 * GammaMatrix filter handler
 *
 */
trait ModelTrait
{
    /**
     * Filter an array.
     *
     * @param string|array $value The value to filter.
     *
     * @return array Returns an array.
     */
    public function filterArray($value)
    {
        if (is_array($value)) {
            return $value;
        } elseif (!empty($value) && is_string($value)) {
            return (array) $value;
        }

        return [];
    }

    /**
     * Filter an array and encode it to json.
     *
     * NOTE: This may not be necessary if the field has been cast in the model.
     *
     * @param string $value The value to filter.
     *
     * @return string Returns an array converted to JSON.
     */
    public function filterArrayToJson($value)
    {
        if (is_array($value)) {
            return json_encode($value);
        } elseif (is_string($value)) {
            return $value;
        } else {
            return json_encode([]);
        }
    }

    /**
     * Filter a bit value
     *
     * @param integer $value The value to filter.
     * @param integer $exponent The maximum power of the exponent to sum.
     *
     * @return integer
     */
    public function filterBits($value, $exponent = 0)
    {
        $exponent = intval(abs($exponent));

        /**
         * @var integer $pBits The allowed permission bits: rwx
         */
        $pBits = 0;
        // $pBits = 4 + 2 + 1;

        for ($i=0; $i <= $exponent; $i++) {
            $pBits += pow(2, $i);
        }

        return intval(abs($value)) & $pBits;
    }

    /**
     * Filter a boolean value
     *
     * @param string $value The value to filter.
     *
     * @return boolean
     */
    public function filterBoolean($value)
    {
        if (is_string($value) && !is_numeric($value)) {
            return 'true' === strtolower($value);
        } elseif (is_numeric($value)) {
            return $value > 0;
        } else {
            return (bool) $value;
        }
    }

    /**
     * Filter a date value as a MySQL UTC string.
     *
     * @param string $value The date to filter.
     * @param string $locale i18n
     *
     * @return string|NULL
     */
    public function filterDate($value, $locale = 'en-US')
    {
        return is_string($value)
            && !empty($value)
            ? gmdate(DATE_MYSQL, strtotime($value)) : null
        ;
    }

    /**
     * Filter a date value as a Carbon date.
     *
     * @param string $value The date to filter.
     * @param string $locale i18n
     *
     * @return string|NULL
     */
    public function filterDateAsCarbon($value, $locale = 'en-US')
    {
        if (empty($value)) {
            return null;
        }

        return new Carbon($value);
    }

    /**
     * Filter an email address.
     *
     * @param string $email The address to filter.
     *
     * @return string
     */
    public function filterEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Filter a float value
     *
     * NOTE: Implement handling for locales.
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     *
     * @return float|NULL
     */
    public function filterFloat($value, $locale = 'en-US')
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return (new \NumberFormatter($locale, \NumberFormatter::DECIMAL))->parse($value);
    }

    /**
     * Filter HTML from content.
     *
     * FILTER_FLAG_NO_ENCODE_QUOTES - do not encode quotes.
     *
     * @param string $content The string to filter.
     *
     * @return string
     */
    public function filterHtml($content)
    {
        return filter_var($content, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    /**
     * Filter an integer value
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     *
     * @return integer
     */
    public function filterInteger($value, $locale = 'en-US')
    {
        if ('' === $value || null === $value) {
            return 0;
        }

        $value = (new \NumberFormatter($locale, \NumberFormatter::DECIMAL))->parse($value, \NumberFormatter::TYPE_INT64);

        return is_numeric($value) ? $value : 0;
    }

    /**
     * Filter an integer value ID.
     *
     * @param string $value The value to filter.
     *
     * @return integer|null
     */
    public function filterIntegerId($value)
    {
        return is_numeric($value) && ($value > 0) ? (int) $value : null;
    }

    /**
     * Filter a positive integer value or return null.
     *
     * @param string $value The value to filter.
     *
     * @return integer|null
     */
    public function filterIntegerPositive($value)
    {
        return is_numeric($value) && ($value > 0) ? (int) $value : null;
    }

    /**
     * Filter a percent value
     *
     * NOTE: Only removes the percent sign.
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     *
     * @return float
     */
    public function filterPercent($value, $locale = 'en-US')
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return $this->filterFloat(str_replace('%', '', $value), $locale);
    }

    /**
     * Filter a phone number.
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     *
     * @return string
     */
    public function filterPhone($value, $locale = 'en-US')
    {
        if (empty($value)) {
            return '';
        }

        return filter_var(
            str_replace(['-', '.', '+'], '', $value),
            FILTER_SANITIZE_NUMBER_INT
        );
    }

    /**
     * Filter the status
     *
     * TODO Determine if $input should be passed by reference: &$input
     *
     * @param array $input The status input.
     *
     * @return integer|NULL
     */
    public function filterStatus(array $input = [])
    {
        if (!isset($input['status'])) {
            return $input;
        }

        if (is_numeric($input['status'])) {
            $input['status'] = (int) abs($input['status']);
            return $input;
        }

        if (is_array($input['status'])) {
            foreach ($input['status'] as $key => $value) {
                $input['status'][$key] = (bool) $value;
            }
        }

        return $input;
    }

    /**
     * Filter common fields
     *
     * @param array $input The common fields: locale, style, klass, icon, avatar, image
     *
     * @return integer|NULL
     */
    public function filterCommonFields(array $input = [])
    {
        $input['locale'] = isset($input['locale']) ? $this->filterHtml($input['locale']) : '';
        $input['style'] = isset($input['style']) ? $this->filterHtml($input['style']) : '';
        $input['klass'] = isset($input['klass']) ? $this->filterHtml($input['klass']) : '';
        $input['icon'] = isset($input['icon']) ? $this->filterHtml($input['icon']) : '';
        $input['avatar'] = isset($input['avatar']) ? $this->filterHtml($input['avatar']) : '';
        $input['image'] = isset($input['image']) ? $this->filterHtml($input['image']) : '';

        return $input;
    }

    /**
     * Filter system fields
     *
     * @param array $input The system fields input.
     *
     * @return integer|NULL
     */
    public function filterSystemFields(array $input = [])
    {
        // Filter system fields.
        if (isset($input['gids'])) {
            $input['gids'] = (int) abs($input['gids']);
        }

        /**
         * @var integer $pBits The allowed permission bits: rwx
         */
        $pBits = 4 + 2 + 1;

        if (isset($input['po'])) {
            $input['po'] = intval(abs($input['po'])) & $pBits;
        }

        if (isset($input['pg'])) {
            $input['pg'] = intval(abs($input['pg'])) & $pBits;
        }

        if (isset($input['pw'])) {
            $input['pw'] = intval(abs($input['pw'])) & $pBits;
        }

        if (isset($input['rank'])) {
            $input['rank'] = (int) $input['rank'];
        }

        if (isset($input['size'])) {
            $input['size'] = (int) $input['size'];
        }

        return $input;
        return $this->filterStatus($input);
    }

    /**
     * Filter a UUID
     *
     * @param string $value The value to filter.
     *
     * @return integer|NULL
     */
    public function filterUuid($value)
    {
        return Uuid::isValid($value)
            ? $value : null
        ;
    }
}
