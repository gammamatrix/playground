<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Abilities
 *
 * @property string[] $abilities
 */
interface Abilities
{
    /**
     * Add an ability to the model.
     *
     * @param  string  $ability  The ability to add to the model.
     */
    public function addAbility(string $ability): self;

    /**
     * Checks to see if the user has the ability.
     *
     * @param  string  $ability  The ability to check.
     */
    public function hasAbility(string $ability): bool;

    /**
     * Remove an ability from the model.
     *
     * @param  string  $ability  The ability to remove from the model.
     */
    public function removeAbility(string $ability): self;
}
