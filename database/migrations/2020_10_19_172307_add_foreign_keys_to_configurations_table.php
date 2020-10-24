<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('configurations', function(Blueprint $table)
		{
			$table->foreign('product_id')->references('id')->on('products')
				->onUpdate('cascade')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configurations', function(Blueprint $table)
		{
			$table->dropForeign('configurations_product_id_foreign');
		});
	}

}
