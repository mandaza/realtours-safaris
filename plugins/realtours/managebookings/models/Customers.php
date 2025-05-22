<?php namespace RealTours\Managebookings\Models;

use Model;

/**
 * Model
 */
class Customers extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'realtours_managebookings_customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address'
    ];

    // Define the relationship with Booking model
    public function bookings()
    {
        return $this->hasMany('RealTours\ManageBookings\Models\Booking', 'customer_id');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }



    /**
     * @var array rules for validation.
     */
    public $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'phone' => 'required'
    ];

}
