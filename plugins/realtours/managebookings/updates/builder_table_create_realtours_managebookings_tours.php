<?php namespace RealTours\Managebookings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRealtoursManagebookingsTours extends Migration
{
    public function up()
    {
        Schema::create('realtours_managebookings_tours', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('tour_name');
            $table->string('slug')->nullable();
            $table->decimal('price', 10, 0)->nullable();
            $table->string('duration')->nullable();
            $table->string('location')->nullable();
            $table->string('groupsize')->nullable();
            $table->string('minimumage')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail1')->nullable();
            $table->string('thumbnail2')->nullable();
            $table->text('overview')->nullable();
            $table->text('route')->nullable();
            $table->text('whythistour')->nullable();
            $table->text('highlights')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('realtours_managebookings_tours');
    }
}
