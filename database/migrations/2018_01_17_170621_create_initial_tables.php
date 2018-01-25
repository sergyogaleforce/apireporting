<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_report', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id');
        $table->integer('login_id')->unique();
        $table->string('report_name', 255);
        $table->string('job_name', 255);
        $table->dateTime('begin_date');
        $table->dateTime('end_date');
        $table->string('campaign_ids');
        $table->string('advertiser_ids');
        $table->string('cost_per_lead');
        $table->string('cost_per_goal_lead');
        $table->string('cost_per_visit');
        $table->string('click_tru');
        $table->string('click_to_call');
        $table->string('position');
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
        Schema::dropIfExists('api_report');
    }
}
