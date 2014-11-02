<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KkstudioCreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kkstudio_portfolio_projects', function($table) {

			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->text('description')->nullable();
			$table->integer('category_id')->nullable();
			$table->string('image')->nullable();
			$table->integer('position');
			$table->nullableTimestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kkstudio_portfolio_projects');
	}

}
