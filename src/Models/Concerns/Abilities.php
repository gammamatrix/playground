<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Abilities
 *
 * @property string[] $abilities
 */
trait Abilities
{
    /**
     * Checks to see if the user has the ability.
     *
     * @param  string  $ability  The ability to check.
     */
    public function hasAbility(string $ability): bool
    {
        if (empty($ability)) {
            return false;
        }

        $abilities = $this->getAttribute('abilities');

        return is_array($abilities) && in_array($ability, $abilities);
    }

    /**
     * Add an ability to the model.
     *
     * @param  string  $ability  The ability to add to the model.
     */
    public function addAbility(string $ability): self
    {
        if (empty($ability)) {
            return $this;
        }

        $abilities = $this->getAttribute('abilities');
        if (! is_array($abilities)) {
            $abilities = [];
        }

        if (in_array($ability, $abilities)) {
            return $this;
        }

        $abilities[] = $ability;

        $this->setAttribute('abilities', $abilities);

        return $this;
    }

    /**
     * Remove an ability from the model.
     *
     * @param  string  $ability  The ability to remove from the model.
     */
    public function removeAbility(string $ability): self
    {
        if (empty($ability)) {
            return $this;
        }

        /**
         * @var string[] $abilities
         */
        $abilities = $this->getAttribute('abilities');
        if (! is_array($abilities)) {
            $abilities = [];
        }

        if (! in_array($ability, $abilities)) {
            return $this;
        }

        $abilities = array_diff($abilities, [$ability]);

        $this->setAttribute('abilities', $abilities);

        return $this;
    }
}
