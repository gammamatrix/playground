<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Traits\WithModifier
 *
 */
trait WithModifier
{
    /**
     * Access the modifier of this model.
     */
    public function modifier(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id',
            'modified_by_id'
        );
    }
}
