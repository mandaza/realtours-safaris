<?php namespace RealTours\Managebookings;

use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'RealTours\ManageBookings\Components\ToursList' => 'ToursList',
            'RealTours\ManageBookings\Components\TourDetails' => 'TourDetails',
            'RealTours\ManageBookings\Components\BookingForm' => 'BookingForm'
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }

    public function registerBackendAssets()
    {
        $this->addCss('/plugins/realtours/managebookings/assets/css/backend.css');
    }
}
