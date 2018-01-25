<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCampaignSatatusMetricsTable.
 */
class CreateCampaignSatatusMetricsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_satatus_metrics', function(Blueprint $table) {
            $table->increments('id');
            $table->string('job_id');
            $table->string('campaign_id');
            $table->string('campaign_name');
            $table->string('advertiser_id');
            $table->string('advertiser_name');
            $table->string('advertiser_code');
            $table->float('campaign_spend');
            $table->float('campaign_budget');
            $table->integer('campaign_visits');
            $table->integer('impressions');
            $table->integer('calls');
            $table->integer('qualified_calls');
            $table->integer('emails');
            $table->integer('coupons');
            $table->integer('web_events');
            $table->integer('qualified_web_events');
            $table->float('cost_per_lead');
            $table->float('cost_per_visit');
            $table->float('click_tru_rate');
            $table->float('click_tru_call_rate');
            $table->float('position');
            $table->float('percent_daily_budget_used');
            $table->float('click_web_event');
            $table->float('percent_budget_used');
            $table->float('click_to_web_event');
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
		Schema::drop('campaign_satatus_metrics');
	}
}
