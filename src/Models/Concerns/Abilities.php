<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Abilities
 */
trait Abilities
{
    /**
     * Checks to see if the user has the ability.
     *
     * @param mixed $ability The ability to check.
     */
    public function hasAbility(mixed $ability): bool
    {
        if (empty($ability) || ! is_string($ability)) {
            return false;
        }

        $abilities = $this->getAttribute('abilities');

        return is_array($abilities) && in_array($ability, $abilities);
    }

    /**
     * Add a ability to the model.
     *
     * @param mixed $ability The ability to add to the model.
     */
    public function addAbility(mixed $ability): void
    {
        $abilities = $this->getAttribute('abilities');
        if (! is_array($abilities)) {
            $abilities = [];
        }

        if (empty($ability)
            || ! is_string($ability)
            || in_array($ability, $abilities)
        ) {
            return;
        }

        $abilities[] = $ability;

        $this->setAttribute('abilities', $abilities);
    }

    /**
     * Remove a ability from the model.
     *
     * @param mixed $ability The ability to remove from the model.
     */
    public function removeAbility(mixed $ability): void
    {
        $abilities = $this->getAttribute('abilities');
        if (! is_array($abilities)) {
            $abilities = [];
        }

        if (empty($ability)
            || ! is_string($ability)
            || ! in_array($ability, $abilities)
        ) {
            return;
        }

        $abilities = array_diff($abilities, [$ability]);

        $this->setAttribute('abilities', $abilities);
    }
}
