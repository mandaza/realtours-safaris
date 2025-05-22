<?php namespace RealTours\Managebookings\Models;

use Model;
use Str;

/**
 * Model
 */
class Tours extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'realtours_managebookings_tours';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'tour_name' => 'required|min:3|max:255'
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'tour_name'];

    /**
     * @var array Attributes that should be cast to native types.
     */
    protected $casts = [
        'slug' => 'string'
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'tour_name',
        'slug',
        'price',
        'duration',
        'location',
        'groupsize',
        'minimumage',
        'difficulty',
        'image',
        'thumbnail1',
        'thumbnail2',
        'overview',
        'route',
        'whythistour',
        'highlights'
    ];

    /**
     * Before validation event
     */
    public function beforeValidate()
    {
        // Generate the slug before validation
        $this->slug = Str::slug($this->tour_name);
    }
    // Mutators to strip HTML tags from rich text fields
    public function setOverviewAttribute($value)
    {
        $this->attributes['overview'] = strip_tags($value);
    }
    public function setItineraryAttribute($value)
    {
        $this->attributes['itinerary'] = strip_tags($value);
    }
    public function setTourhighlightsAttribute($value)
    {
        $this->attributes['highlights'] = strip_tags($value);
    }
    public function setRouteAttribute($value)
    {
        $this->attributes['route'] = strip_tags($value);
    }
    public function setWhythistourAttribute($value)
    {
        $this->attributes['whythistour'] = strip_tags($value);
    }

    // Define the relationship with Booking model
    public function bookings()
    {
        return $this->hasMany('RealTours\ManageBookings\Models\Booking', 'tour_id');
    }
}
