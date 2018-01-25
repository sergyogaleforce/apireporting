<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCampaignSummaryActivitiesTable.
 */
class CreateCampaignSummaryActivitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_summary_activities', function(Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->string('advertiser_id');
            $table->string('advertiser_name');
            $table->string('advertiser_code');
            $table->string('campaign_id');
            $table->string('campaign_name');
            $table->float('total_spend');
            $table->float('total_adjustment');
            $table->float('total_fees');
            $table->integer('total_visits');
            $table->integer('total_impressions');
            $table->integer('total_calls');
            $table->integer('total_emails');
            $table->integer('total_coupons');
            $table->integer('total_web_links');
            $table->integer('total_web_events');
            $table->dateTime('last_updated');
            $table->dateTime('camp_start_date');
            $table->dateTime('camp_end_date');
            $table->date('camp_target_duration');
            $table->float('camp_budget');
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
		Schema::drop('campaign_summary_activities');
	}
}
