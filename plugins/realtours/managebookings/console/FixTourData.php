<?php namespace RealTours\Managebookings\Console;

use Illuminate\Console\Command;
use RealTours\Managebookings\Models\Tours;
use Str;

class FixTourData extends Command
{
    protected $name = 'tours:fix-data';
    protected $description = 'Fix tour data by cleaning up fields and regenerating slugs';

    public function handle()
    {
        $this->info('Fixing tour data...');

        $tours = Tours::all();

        if ($tours->isEmpty()) {
            $this->warn('No tours found in the database!');
            return;
        }

        $this->info("\nFound {$tours->count()} tours to fix:");

        foreach ($tours as $tour) {
            $this->line("\nFixing tour #{$tour->id}: {$tour->tour_name}");

            // Clean up tour name
            $tour->tour_name = strip_tags($tour->tour_name);

            // Regenerate slug
            $tour->slug = Str::slug($tour->tour_name);

            // Clean up other text fields
            $fieldsToClean = [
                'overview', 'route', 'whythistour', 'highlights',
                'description', 'location', 'duration', 'groupsize',
                'minimumage', 'difficulty'
            ];

            foreach ($fieldsToClean as $field) {
                if (!empty($tour->$field)) {
                    $tour->$field = strip_tags($tour->$field);
                }
            }

            // Ensure price is numeric
            if (!empty($tour->price)) {
                $tour->price = (float) preg_replace('/[^0-9.]/', '', $tour->price);
            }

            // Ensure is_active is boolean
            $tour->is_active = (bool) $tour->is_active;

            try {
                $tour->save();
                $this->info("✓ Tour #{$tour->id} fixed successfully");
            } catch (\Exception $e) {
                $this->error("✗ Error fixing tour #{$tour->id}: " . $e->getMessage());
            }
        }

        $this->info("\nTour data fix completed!");
    }
}
