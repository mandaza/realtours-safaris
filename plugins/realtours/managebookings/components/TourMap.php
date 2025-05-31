<?php namespace RealTours\ManageBookings\Components;

use Cms\Classes\ComponentBase;
use RealTours\ManageBookings\Models\Tours;
use Log;

class TourMap extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Tour Map',
            'description' => 'Displays a map with tour locations and details'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        try {
            // Log the start of the component
            Log::info('TourMap component starting');

            // Get all tours from the database using the Tours model
            $tours = Tours::where(function($query) {
                    $query->whereNotNull('latitude')
                          ->whereNotNull('longitude')
                          ->where('latitude', '!=', 0)
                          ->where('longitude', '!=', 0);
                })
                ->where(function($query) {
                    $query->where('is_active', 1)
                          ->orWhereNull('is_active'); // Include tours where is_active is not set
                })
                ->get([
                    'id',
                    'tour_name',
                    'location',
                    'latitude',
                    'longitude',
                    'image',
                    'description',
                    'type',
                    'duration'
                ]);

            // Process the tours to include full media URLs
            $tours->each(function($tour) {
                if ($tour->image) {
                    $tour->image = \Media\Classes\MediaLibrary::url($tour->image);
                }
            });

            // Log the query results
            Log::info('TourMap query results:', [
                'count' => $tours->count(),
                'tours' => $tours->toArray()
            ]);

            // Check if we have any tours
            if ($tours->isEmpty()) {
                Log::warning('No tours found in the database with valid coordinates');
            }

            // Make the tours data available to the template
            $this->page['tours'] = $tours;

            // Log that we've set the tours data
            Log::info('TourMap component completed successfully');

        } catch (\Exception $e) {
            // Log any errors that occur
            Log::error('TourMap component error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Set an empty tours array to prevent template errors
            $this->page['tours'] = collect([]);
        }
    }
}
