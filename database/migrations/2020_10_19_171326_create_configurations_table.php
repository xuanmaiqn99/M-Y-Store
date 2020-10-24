<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configurations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->unsigned()->unique();
			$table->string('size', 128);
			$table->string('color', 128);
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
		Schema::drop('configurations');
	}

}
