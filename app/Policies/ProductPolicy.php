<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create products.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(['admin', 'moderator', 'seller']) && $user->email_verified_at && $this->canPublish($user);
}

    /**
     * Determine whether the user can update the product.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return $product->user_id === $user->id || $user->hasRole(['admin', 'moderator']);
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        return $product->user_id === $user->id || $user->hasRole(['admin', 'moderator']);
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canPublish(User $user): bool
    {
        return $user->ads_in_day < app('settings')->ads_per_day;
    }
}
