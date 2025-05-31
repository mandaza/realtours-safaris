<?php namespace RealTours\Managebookings\Console;

use Illuminate\Console\Command;
use RealTours\Managebookings\Models\Tours;

class CheckTourCoordinates extends Command
{
    protected $name = 'tours:check-coordinates';
    protected $description = 'Check tours for valid coordinates';

    public function handle()
    {
        $this->info('Checking tour coordinates...');

        $tours = Tours::all();
        $total = $tours->count();
        $withCoords = $tours->filter(function($tour) {
            return !empty($tour->latitude) && !empty($tour->longitude)
                && $tour->latitude != 0 && $tour->longitude != 0;
        })->count();
        $active = $tours->where('is_active', 1)->count();

        $this->info("Total tours: {$total}");
        $this->info("Tours with valid coordinates: {$withCoords}");
        $this->info("Active tours: {$active}");

        if ($withCoords == 0) {
            $this->warn("\nNo tours have valid coordinates! Please add coordinates to your tours.");
            $this->table(
                ['ID', 'Tour Name', 'Location', 'Latitude', 'Longitude', 'Active'],
                $tours->map(function($tour) {
                    return [
                        'id' => $tour->id,
                        'name' => $tour->tour_name,
                        'location' => $tour->location,
                        'latitude' => $tour->latitude ?: 'Not set',
                        'longitude' => $tour->longitude ?: 'Not set',
                        'active' => $tour->is_active ? 'Yes' : 'No'
                    ];
                })
            );
        }
    }
}
