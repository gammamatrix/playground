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
 * It is expected that the data may not have the proper type from forms.
 * These filters correct those values. Parameters must not be cast.
 * Allow the method to decide what to return to prevent model cast errors.
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
    public function filterArray($value): array
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
    public function filterArrayToJson($value): ?string
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
     */
    public function filterBits($value, $exponent = 0): int
    {
        $exponent = intval(abs($exponent));

        /**
         * @var integer $pBits The summed bit power values.
         */
        $pBits = 0;
        // $pBits = 4 + 2 + 1;

        for ($i = 0; $i <= $exponent; $i++) {
            $pBits += pow(2, $i);
        }

        return intval(abs($value)) & $pBits;
    }

    /**
     * Filter a boolean value
     *
     * @param string $value The value to filter.
     */
    public function filterBoolean($value): bool
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
     * Filter a date value as an SQL UTC string.
     *
     * @param string $value The date to filter.
     * @param string $locale i18n
     */
    public function filterDate($value, $locale = 'en-US'): ?string
    {
        return is_string($value)
            && !empty($value)
            ? gmdate(
                config('playground.date.sql', 'Y-m-d H:i:s'),
                strtotime($value)
            ) : null
        ;
    }

    /**
     * Filter a date value as a Carbon date.
     *
     * @param string $value The date to filter.
     * @param string $locale i18n
     */
    public function filterDateAsCarbon($value, $locale = 'en-US'): ?Carbon
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
     */
    public function filterEmail($email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Filter a float value
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     */
    public function filterFloat($value, $locale = 'en-US'): ?float
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return (new \NumberFormatter(
            $locale,
            \NumberFormatter::DECIMAL
        ))->parse($value);
    }

    /**
     * Filter HTML from content.
     *
     * FILTER_FLAG_NO_ENCODE_QUOTES - do not encode quotes.
     *
     * @param string $content The string to filter.
     */
    public function filterHtml($content): string
    {
        return filter_var(
            $content,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );
    }

    /**
     * Filter an integer value
     *
     * @param string $value The value to filter.
     * @param string $locale i18n
     */
    public function filterInteger($value, $locale = 'en-US'): int
    {
        if ('' === $value || null === $value) {
            return 0;
        }

        $value = (new \NumberFormatter(
            $locale,
            \NumberFormatter::DECIMAL
        ))->parse($value, \NumberFormatter::TYPE_INT64);

        return is_int($value) ? $value : 0;
    }

    /**
     * Filter an integer value ID.
     *
     * @param string $value The value to filter.
     */
    public function filterIntegerId($value): ?int
    {
        return is_numeric($value) && ($value > 0) ? (int) $value : null;
    }

    /**
     * Filter a positive integer value or return zero.
     *
     * @param string $value The value to filter.
     * @param bool $absolute Use `abs()` on the value to convert negative to positive.
     */
    public function filterIntegerPositive($value, $absolute = true): int
    {
        $value = intval($value);
        return $absolute && ($value < 0) ? (int) abs($value) : $value;
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
    public function filterPercent($value, $locale = 'en-US'): ?float
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return $this->filterFloat(str_replace('%', '', $value), $locale);
    }

    /**
     * Filter the status
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
