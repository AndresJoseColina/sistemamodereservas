<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToBravoToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'bravo_tours';

        if (!Schema::hasColumn($table, 'enable_service_fee')) //check the column
        {
            Schema::table($table, function (Blueprint $table) {
                $table->text('enable_service_fee')->nullable();
            });
        }
        if (!Schema::hasColumn($table, 'service_fee')) //check the column
        {
            Schema::table($table, function (Blueprint $table) {
                $table->text('service_fee')->nullable();
            });
        }
        if (!Schema::hasColumn($table, 'surrounding')) //check the column
        {
            Schema::table($table, function (Blueprint $table) {
                $table->text('surrounding')->nullable();
            });
        }
        if (!Schema::hasColumn($table, 'min_day_before_booking')) //check the column
        {
            Schema::table($table, function (Blueprint $table) {
                $table->text('min_day_before_booking')->nullable();
            });
        }

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bravo_tours', function (Blueprint $table) {
            //
        });
    }
}
