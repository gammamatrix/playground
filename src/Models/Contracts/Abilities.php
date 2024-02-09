<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Abilities
 *
 * @property array<int, string> $abilities
 */
interface Abilities
{
    /**
     * Add a ability to the model.
     *
     * @param mixed $ability The ability to add to the model.
     */
    public function addAbility(mixed $ability): void;

    /**
     * Checks to see if the user has the ability.
     *
     * @param mixed $ability The ability to check.
     */
    public function hasAbility(mixed $ability): bool;

    /**
     * Remove a ability from the model.
     *
     * @param mixed $ability The ability to remove from the model.
     */
    public function removeAbility(mixed $ability): void;
}
