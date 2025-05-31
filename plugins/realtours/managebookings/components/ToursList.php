<?php namespace RealTours\Managebookings\Components;

use Cms\Classes\ComponentBase;
use RealTours\Managebookings\Models\Tours;
use Log;

class ToursList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Tours List',
            'description' => 'Displays a list of available tours'
        ];
    }

    public function defineProperties()
    {
        return [
            'toursPerPage' => [
                'title'             => 'Tours per page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Please specify a number',
                'default'           => '6'
            ],
            'sortOrder' => [
                'title'       => 'Sort order',
                'description' => 'Attribute on which the tours should be ordered',
                'type'        => 'dropdown',
                'default'     => 'name asc'
            ]
        ];
    }

    public function getSortOrderOptions()
    {
        return [
            'name asc'  => 'Name (ascending)',
            'name desc' => 'Name (descending)',
            'price asc' => 'Price (ascending)',
            'price desc' => 'Price (descending)',
            'created_at desc' => 'Newest first',
            'created_at asc' => 'Oldest first'
        ];
    }

    public function onRun()
    {
        $this->page['search'] = input('search');
        try {
            // Get database connection details
            $connection = \DB::connection();
            $dbInfo = [
                'driver' => $connection->getDriverName(),
                'database' => $connection->getDatabaseName()
            ];

            // Try a raw query first
            $rawCount = \DB::table('realtours_managebookings_tours')->count();
            $rawTours = $rawCount > 0 ? \DB::table('realtours_managebookings_tours')->get() : null;

            // Load tours through Eloquent
            $tours = $this->loadTours();

            // Debug information
            Log::info('Tours loaded: ' . $tours->count());

            if ($tours->isEmpty()) {
                Log::info('No tours found in database');
            } else {
                foreach ($tours as $tour) {
                    Log::info('Tour found: ' . $tour->tour_name . ' (ID: ' . $tour->id . ')');
                }
            }

            $this->page['tours'] = $tours;
            $this->page['debug'] = [
                'total_tours' => $tours->count(),
                'table_name' => (new Tours)->getTable(),
                'db_connection' => json_encode($dbInfo),
                'raw_count' => $rawCount,
                'raw_tours' => $rawTours ? $rawTours->toArray() : null,
                'first_tour' => $tours->first() ? $tours->first()->toArray() : null
            ];
        } catch (\Exception $e) {
            Log::error('Error loading tours: ' . $e->getMessage());
            $this->page['error'] = $e->getMessage();
            $this->page['tours'] = collect([]);
            $this->page['debug'] = [
                'error' => $e->getMessage()
            ];
        }
    }

    protected function loadTours()
    {
        $query = Tours::query();

        // Filter for active tours
        $query->where(function($query) {
            $query->where('is_active', 1)
                  ->orWhereNull('is_active'); // Include tours where is_active is not set
        });

        $search = trim(input('search'));
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('tour_name', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%")
                  ->orWhere('overview', 'like', "%$search%")
                  ->orWhere('route', 'like', "%$search%")
                  ->orWhere('whythistour', 'like', "%$search%")
                  ->orWhere('highlights', 'like', "%$search%")
                  ->orWhere('difficulty', 'like', "%$search%")
                  ->orWhere('groupsize', 'like', "%$search%")
                  ->orWhere('duration', 'like', "%$search%")
                  ;
            });
        }

        $sortOrder = $this->property('sortOrder', 'name asc');
        list($sortField, $sortDirection) = explode(' ', $sortOrder);

        // Map the sort field to the correct database column
        $sortFieldMap = [
            'name' => 'tour_name',
            'price' => 'price',
            'created_at' => 'created_at'
        ];

        $dbField = $sortFieldMap[$sortField] ?? 'tour_name';
        $query->orderBy($dbField, $sortDirection);

        // Log the query for debugging
        Log::info('ToursList query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'sort_field' => $dbField,
            'sort_direction' => $sortDirection
        ]);

        return $query->paginate($this->property('toursPerPage'));
    }
}
