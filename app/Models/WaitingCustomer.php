<?php

namespace App\Models;

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

    public function scopeCreatedToday($query)
    {
        $query->whereRaw('DATE(created_at) LIKE CURDATE()');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            // append a queue_number before saving
            // (as it is not fillable)
            $last_queuer = static::lastQueueNumber();
            $customer->queue_number = $last_queuer + 1;
        });
    }

    /* static queries */
    public static function lastQueueNumber()
    {
        $number = static::createdToday()
            ->orderByDesc('created_at')
            ->first('queue_number')
            ->queue_number ?? 0;
        return $number;
    }
}
