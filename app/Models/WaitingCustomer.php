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

    protected $appends = [
        'queue_number'
    ];

    /* query scopes  */

    public function scopeCreatedToday($query)
    {
        $query->whereRaw('DATE(created_at) LIKE CURDATE()');
    }

    public function scopeUpToYesterday($query)
    {
        $query->whereDate('created_at', "<", date('Y-m-d'));
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

    public static function getLastYesterday(): ?WaitingCustomer
    {
        return static::upToYesterday()
            ->orderBydesc('created_at')
            ->first();
    }
}
