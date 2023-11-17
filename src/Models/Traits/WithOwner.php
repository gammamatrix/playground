<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Traits\WithOwner
 *
 */
trait WithOwner
{
    /**
     * Access the owner of this model.
     */
    public function owner(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id',
            'owned_by_id'
        );
    }
}
