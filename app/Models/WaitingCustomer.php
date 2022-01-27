<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $customer_name
 * @property string $email
 * @property int $queue_number
 * @property string $status
 */
class WaitingCustomer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'email'
    ];

    protected $appends = [
        'queue_number'
    ];

    /* query scopes  */


    public function scopeCreatedAt($query, DateTimeInterface|string $date = null)
    {
        if (is_null($date)) {
            $date = now();
        }

        $query->whereDate('created_at', $date);
    }

    /* accessor methods */

    /**
     * a human-readable queue number for ease of customers
     */
    public function getQueueNumberAttribute()
    {
        $last_yesterday = static::getLastYesterday()?->id ?? 0;
        return $this->id - $last_yesterday;
    }

    /* static queries */


    /**
     * @return WaitingCustomer get the last customer to queue yesterday.
     */
    public static function getLastYesterday(): ?WaitingCustomer
    {
        return static::createdAt(now()->subDay(1))
            ->orderByDesc('created_at')
            ->first();
    }

    public static function getFirstToday(): WaitingCustomer
    {
        return static::createdAt(now())->orderByAsc('created_at')->first();
    }

    /**
     * @param DateTimeInterface|string $queued_at will default to today if null
     */
    public static function findByQueueNumber(
        int $queue_number,
        DateTimeInterface|string $queued_at = null
    ): WaitingCustomer {
        // default $queued_at to today
        if (is_null($queued_at)) {
            $queued_at = now();
        }
        $first_customer = static::createdAt($queued_at)?->id ?? 1;
        return static::where('id', $queue_number + 1 - $first_customer)->firstOrFail();
    }
}
