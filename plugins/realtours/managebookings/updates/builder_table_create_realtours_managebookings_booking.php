<?php namespace RealTours\Managebookings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRealtoursManagebookingsBooking extends Migration
{
    public function up()
    {
        Schema::create('realtours_managebookings_booking', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('tour_id');
            $table->integer('customer_id');
            $table->date('booking_date');
            $table->integer('number_of_people');
            $table->text('special_requirements');
            $table->string('status');
            $table->string('payment_status');
            $table->integer('total_amount');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('realtours_managebookings_booking');
    }
}
