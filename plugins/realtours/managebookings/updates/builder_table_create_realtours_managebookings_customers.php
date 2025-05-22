<?php namespace RealTours\Managebookings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRealtoursManagebookingsCustomers extends Migration
{
    public function up()
    {
        Schema::create('realtours_managebookings_customers', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('realtours_managebookings_customers');
    }
}
