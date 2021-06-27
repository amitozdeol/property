<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_unit', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->string('unit', 100);
            $table->integer('size')->nullable();
            $table->decimal('rent', $precision = 8, $scale = 2);
            $table->decimal('deposit', $precision = 8, $scale = 2);
            $table->string('address', 1000);
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
        Schema::dropIfExists('property_unit');
    }
}
