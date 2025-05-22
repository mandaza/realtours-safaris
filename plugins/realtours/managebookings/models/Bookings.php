<?php namespace RealTours\Managebookings\Models;

use Model;

/**
 * Model
 */
class Bookings extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'realtours_managebookings_booking';
    protected $fillable = [
        'customer_id',
        'tour_id',
        'booking_date',
        'number_of_people',
        'special_requirements',
        'status',
        'payment_status',
        'total_amount'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'tour' => ['RealTours\Managebookings\Models\Tours', 'key' => 'tour_id'],
        'customer' => ['RealTours\Managebookings\Models\Customers', 'key' => 'customer_id'],
    ];

    // Define the relationship with Customer model
    public function customer()
    {
        return $this->belongsTo('RealTours\Managebookings\Models\Customers', 'customer_id');
    }

    // Define the relationship with Tour model
    public function tour()
    {
        return $this->belongsTo('RealTours\Managebookings\Models\Tours', 'tour_id');
    }
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    // Get status options for dropdown
    public function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected'
        ];
    }

    // Get payment status options for dropdown
    public function getPaymentStatusOptions()
    {
        return [
            self::PAYMENT_PENDING => 'Pending',
            self::PAYMENT_PAID => 'Paid',
            self::PAYMENT_REFUNDED => 'Refunded'
        ];
    }
    // Scope for pending bookings
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Scope for approved bookings
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    // Scope for paid bookings
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    /**
     * @var array rules for validation.
     */
    public $rules = [
    ];

}
