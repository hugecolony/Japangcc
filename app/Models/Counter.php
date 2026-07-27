<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Counter extends Model
{
    protected $fillable = ['key', 'last_number'];

    /**
     * Atomically get the next number for a given key.
     * Locks the row (or creates it) inside a transaction so concurrent
     * requests never receive the same number.
     */
    public static function nextNumber(string $key): int
    {
        return DB::transaction(function () use ($key) {
            $counter = self::lockForUpdate()->firstOrCreate(
                ['key' => $key],
                ['last_number' => 0]
            );

            $counter->increment('last_number');

            return $counter->last_number;
        });
    }
}
