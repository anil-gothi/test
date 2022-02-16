<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id()->index();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('recurrence_flag')->default(0)->comment('0:Repeat,1:Repeat on the');
            $table->string('repeat_flag_1')->nullable()->comment('Every,Every Other,Every Third,Every Fourth');
            $table->string('repeat_flag_2')->nullable()->comment('Day,Week,Month,Year');
            $table->string('repeat_on_the_flag_1')->nullable()->comment('First,Second,Third,Fourth');
            $table->string('repeat_on_the_flag_2')->nullable()->comment('Sun,Mon,Tue,Wed,Thu,Fri,Sat');
            $table->string('repeat_on_the_flag_3')->nullable()->comment('Month,3 Months,6 Months,Year');
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
        Schema::dropIfExists('events');
    }
}
