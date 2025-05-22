<?php namespace RealTours\ManageBookings\Components;
use Cms\Classes\ComponentBase;
use RealTours\ManageBookings\Models\Tours;


class TourDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Tour Details',
            'description' => 'Displays the details for a single tour.'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Tour Slug',
                'description' => 'The slug of the tour to display',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');
        \Log::info('TourDetails slug: ' . $slug);
        $tour = Tours::where('slug', $slug)->first();
        \Log::info('TourDetails found tour: ' . json_encode($tour));
        $this->page['tour'] = $tour;
    }
}
