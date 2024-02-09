<?php
/**
 * Playground
 */
namespace Playground\Filters;

use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * \Playground\Filters\ModelTrait
 *
 * Playground filter handler
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
     * @param mixed $value The value to filter.
     * @return array<mixed> Returns an array.
     */
    public function filterArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        } elseif (! empty($value) && is_string($value)) {
            return (array) $value;
        }

        return [];
    }

    /**
     * Filter an array and encode it to json.
     *
     * NOTE: This may not be necessary if the field has been cast in the model.
     *
     * @param mixed $value The value to filter.
     * @return string|false Returns an array converted to JSON.
     */
    public function filterArrayToJson(mixed $value): string|false
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
     * @param int $value The value to filter.
     * @param int $exponent The maximum power of the exponent to sum.
     */
    public function filterBits($value, $exponent = 0): int
    {
        $exponent = intval(abs($exponent));

        /**
         * @var int $pBits The summed bit power values.
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
     * @param mixed $value The value to filter.
     */
    public function filterBoolean(mixed $value): bool
    {
        if (is_string($value) && ! is_numeric($value)) {
            return strtolower($value) === 'true';
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
    public function filterDate(mixed $value, $locale = 'en-US'): ?string
    {
        if (empty($value) || ! (
            is_string($value)
            || $value instanceof \DateTimeInterface
        )) {
            return null;
        }

        $PLAYGROUND_DATE_SQL = config('playground.date.sql');
        if (empty($PLAYGROUND_DATE_SQL) || ! is_string($PLAYGROUND_DATE_SQL)) {
            $PLAYGROUND_DATE_SQL = 'Y-m-d H:i:s';
        }

        return Carbon::parse($value)->format($PLAYGROUND_DATE_SQL);
        // return Carbon::parse($value)->format(config('playground.date.sql', 'Y-m-d H:i:s'));
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
     * @param mixed $email The address to filter.
     */
    public function filterEmail(mixed $email): string
    {
        $email = is_string($email) ? filter_var($email, FILTER_SANITIZE_EMAIL) : '';

        return is_string($email) ? $email : '';
    }

    /**
     * Filter a float value
     *
     * @param mixed $value The value to filter.
     * @param string $locale i18n
     */
    public function filterFloat(mixed $value, $locale = 'en-US'): ?float
    {
        if ($value === '' || $value === null) {
            return null;
        }

        return is_numeric($value) ? floatval($value) : null;
        // return (new \NumberFormatter(
        //     $locale,
        //     \NumberFormatter::DECIMAL
        // ))->parse($value);
    }

    /**
     * Filter HTML from content.
     *
     * FILTER_FLAG_NO_ENCODE_QUOTES - do not encode quotes.
     *
     * @param string $content The string to filter.
     */
    public function filterHtml(string $content): string
    {
        $content = filter_var(
            $content,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );

        return is_string($content) ? $content : '';
    }

    /**
     * Filter an integer value
     *
     * @param mixed $value The value to filter.
     * @param string $locale i18n
     */
    public function filterInteger(mixed $value, $locale = 'en-US'): int
    {
        if ($value === '' || $value === null) {
            return 0;
        }

        // $value = (new \NumberFormatter(
        //     $locale,
        //     \NumberFormatter::DECIMAL
        // ))->parse($value, \NumberFormatter::TYPE_INT64);

        return is_numeric($value) ? intval($value) : 0;
        // return is_int($value) ? $value : 0;
    }

    /**
     * Filter an integer value ID.
     *
     * @param mixed $value The value to filter.
     */
    public function filterIntegerId(mixed $value): ?int
    {
        return is_numeric($value) && ($value > 0) ? (int) $value : null;
    }

    /**
     * Filter a positive integer value or return zero.
     *
     * @param mixed $value The value to filter.
     * @param bool $absolute Use `abs()` on the value to convert negative to positive.
     */
    public function filterIntegerPositive(mixed $value, $absolute = true): int
    {
        $value = is_scalar($value) ? intval($value) : 0;

        return $absolute && ($value < 0) ? (int) abs($value) : $value;
    }

    /**
     * Filter a percent value
     *
     * NOTE: Only removes the percent sign.
     *
     * @param mixed $value The value to filter.
     * @param string $locale i18n
     */
    public function filterPercent(mixed $value, $locale = 'en-US'): ?float
    {
        if ($value === '' || $value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = str_replace('%', '', $value);
        }

        return $this->filterFloat($value, $locale);
    }

    /**
     * Filter the status
     *
     * @param array<string, mixed> $input The status input.
     * @return array<string, mixed>
     */
    public function filterStatus(array $input = []): array
    {
        if (! isset($input['status'])) {
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
     * @param array<string, mixed> $input The system fields input.
     * @return array<string, mixed>
     */
    public function filterSystemFields(array $input = []): array
    {
        // Filter system fields.
        if (isset($input['gids']) && is_numeric($input['gids'])) {
            $input['gids'] = (int) abs($input['gids']);
        }

        /**
         * @var int $pBits The allowed permission bits: rwx
         */
        $pBits = 4 + 2 + 1;

        if (isset($input['po']) && is_numeric($input['po'])) {
            $input['po'] = intval(abs($input['po'])) & $pBits;
        }

        if (isset($input['pg']) && is_numeric($input['pg'])) {
            $input['pg'] = intval(abs($input['pg'])) & $pBits;
        }

        if (isset($input['pw']) && is_numeric($input['pw'])) {
            $input['pw'] = intval(abs($input['pw'])) & $pBits;
        }

        if (isset($input['rank']) && is_numeric($input['rank'])) {
            $input['rank'] = (int) $input['rank'];
        }

        if (isset($input['size']) && is_numeric($input['size'])) {
            $input['size'] = (int) $input['size'];
        }

        return $input;
    }

    /**
     * Filter a UUID
     *
     * @param mixed $value The value to filter.
     */
    public function filterUuid(mixed $value): ?string
    {
        return is_string($value) && Uuid::isValid($value)
            ? $value : null;
    }
}
