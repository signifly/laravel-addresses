<?php

namespace Signifly\Addresses\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddresses
{
    /**
     * Boot the addressable trait for the model.
     *
     * @return void
     */
    public static function bootHasAddresses()
    {
        static::deleting(function ($model) {
            $model->addresses()->delete();
        });
    }

    /**
     * The associated addresses relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany($this->getAddressModel(), 'addressable');
    }

    /**
     * The associated primary address relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function primaryAddress(): HasOne
    {
        return $this->hasOne($this->getAddressModel(), 'id', 'primary_address_id');
    }

    /**
     * Get the address model.
     *
     * @return string
     */
    protected function getAddressModel(): string
    {
        return config('addresses.address_model');
    }

    /**
     * Scope a query to include the primary address.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPrimaryAddress(Builder $query): Builder
    {
        $addressModel = $this->getAddressModel();
        $tableName = $this->getTable();
        $primaryKey = $this->getKeyName();

        return $query->addSelect(['primary_address_id' =>
            $addressModel::select('id')
                ->whereRaw("addressable_id = {$tableName}.{$primaryKey}")
                ->where('addressable_type', get_class())
                ->primary()
                ->limit(1),
        ])->with('primaryAddress');
    }
}
