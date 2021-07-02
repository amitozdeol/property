<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_activity', function (Blueprint $table) {
            $table->id();
            $table->integer('tenant_id');
            $table->datetime('rent_month');
            $table->boolean('fully_paid');
            $table->decimal('value', $precision = 8, $scale = 2);
            $table->decimal('remaining', $precision = 8, $scale = 2);
            $table->integer('user_id'); //This is just for fast access of data per user.
            $table->boolean('active')->comment('Only the rows that have active = 1 will be used for quering purposes. All the other ones are just historical data.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_activity');
    }
}
