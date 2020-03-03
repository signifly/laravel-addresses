<?php

namespace Signifly\Addresses\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'bool',
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($this->table)) {
            $this->setTable(config('addresses.table_name'));
        }

        parent::__construct($attributes);
    }

    /**
     * The associated addressable relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to include the billing address(es).
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  bool $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBilling(Builder $query, bool $value = true): Builder
    {
        return $query->where('is_billing', $value);
    }

    /**
     * Scope a query to include the primary address(es).
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  bool $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrimary(Builder $query, bool $value = true): Builder
    {
        return $query->where('is_primary', $value);
    }

    /**
     * Scope a query to include the shipping address(es).
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  bool $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShipping(Builder $query, bool $value = true): Builder
    {
        return $query->where('is_shipping', $value);
    }
}
