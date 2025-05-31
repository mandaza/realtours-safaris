<?php namespace RealTours\Managebookings\Console;

use Illuminate\Console\Command;
use RealTours\Managebookings\Models\Tours;

class ListTours extends Command
{
    protected $name = 'tours:list';
    protected $description = 'List all tours in the database';

    public function handle()
    {
        $this->info('Listing all tours...');

        $tours = Tours::all();

        if ($tours->isEmpty()) {
            $this->warn('No tours found in the database!');
            return;
        }

        $this->info("\nFound {$tours->count()} tours:");

        $headers = ['ID', 'Name', 'Location', 'Price', 'Duration', 'Active', 'Slug'];
        $rows = $tours->map(function($tour) {
            return [
                'id' => $tour->id,
                'name' => $tour->tour_name,
                'location' => $tour->location,
                'price' => $tour->price ? '$' . $tour->price : 'Not set',
                'duration' => $tour->duration ?: 'Not set',
                'active' => $tour->is_active ? 'Yes' : 'No',
                'slug' => $tour->slug ?: 'Not set'
            ];
        })->toArray();

        $this->table($headers, $rows);

        // Show raw data for debugging
        $this->info("\nRaw tour data:");
        foreach ($tours as $tour) {
            $this->line("\nTour #{$tour->id}:");
            $this->line(json_encode($tour->toArray(), JSON_PRETTY_PRINT));
        }
    }
}
