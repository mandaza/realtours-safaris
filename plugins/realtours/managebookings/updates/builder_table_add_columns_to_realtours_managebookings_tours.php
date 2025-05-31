<?php namespace RealTours\Managebookings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableAddColumnsToRealtoursManagebookingsTours extends Migration
{
    public function up()
    {
        Schema::table('realtours_managebookings_tours', function($table)
        {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('type')->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('realtours_managebookings_tours', function($table)
        {
            $table->dropColumn(['latitude', 'longitude', 'is_active', 'type', 'description']);
        });
    }
}
