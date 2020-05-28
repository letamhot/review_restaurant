<?php

namespace App\Traits;

trait EloquentScope
{
    /**
     * Eloquent Query Scopes
     * For example approved($value).
     *
     * @param mixed $query
     * @param boolean $value
     */
    public function scopeApproved($query, $value)
    {
        return $query->where('is_approved', $value); // boolean
    }

    /**
     * Eloquent Query Scopes get X days before
     * For example lastDays($number).
     *
     * @param mixed $query
     * @param mixed $number
     */
    public function scopeLastDays($query, $number)
    {
        $dates = \Carbon\Carbon::today()->subDays($number);

        return $query->where('created_at', '>=', $dates);
    }

}
