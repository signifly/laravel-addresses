<?php

namespace Signifly\Addresses\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAddress
{
    /**
     * Boot the `HasAddress` trait for the model.
     *
     * @return void
     */
    public static function bootHasAddress()
    {
        static::deleting(function ($model) {
            $model->address()->delete();
        });
    }

    /**
     * The associated address relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(config('addresses.address_model'), 'addressable');
    }
}
