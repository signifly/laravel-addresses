<?php

namespace Signifly\Addresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
}
