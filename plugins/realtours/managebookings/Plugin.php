<?php namespace RealTours\Managebookings;

use Backend;
use System\Classes\PluginBase;
use RealTours\Managebookings\Console\CheckTourCoordinates;
use RealTours\Managebookings\Console\ListTours;
use RealTours\Managebookings\Console\FixTourData;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Manage Bookings',
            'description' => 'Tour booking management system',
            'author'      => 'RealTours',
            'icon'        => 'icon-calendar'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        $this->registerConsoleCommand('tours.check-coordinates', CheckTourCoordinates::class);
        $this->registerConsoleCommand('tours.list', ListTours::class);
        $this->registerConsoleCommand('tours.fix-data', FixTourData::class);
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
            'RealTours\Managebookings\Components\TourMap' => 'tourmap',
            'RealTours\Managebookings\Components\ToursList' => 'tourslist',
            'RealTours\Managebookings\Components\TourDetails' => 'tourdetails',
            'RealTours\Managebookings\Components\BookingForm' => 'bookingform'
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

    public function registerNavigation()
    {
        return [
            'managebookings' => [
                'label'       => 'Tour Management',
                'url'         => Backend::url('realtours/managebookings/tours'),
                'icon'        => 'icon-calendar',
                'permissions' => ['realtours.managebookings.*'],
                'order'       => 500,
                'sideMenu'    => [
                    'tours' => [
                        'label'       => 'Tours',
                        'url'         => Backend::url('realtours/managebookings/tours'),
                        'icon'        => 'icon-map-marker',
                        'permissions' => ['realtours.managebookings.*']
                    ],
                    'bookings' => [
                        'label'       => 'Bookings',
                        'url'         => Backend::url('realtours/managebookings/bookings'),
                        'icon'        => 'icon-ticket',
                        'permissions' => ['realtours.managebookings.*']
                    ],
                    'customers' => [
                        'label'       => 'Customers',
                        'url'         => Backend::url('realtours/managebookings/customers'),
                        'icon'        => 'icon-users',
                        'permissions' => ['realtours.managebookings.*']
                    ]
                ]
            ]
        ];
    }
}
