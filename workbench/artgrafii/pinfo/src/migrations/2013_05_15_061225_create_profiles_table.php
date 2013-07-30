<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('email') ; 
            $table->integer('user_id')->unsigned() ; 
            $table->string('profile_image')->nullable() ; 
            $table->string('user_name')->nullable() ; 
            $table->string('subdomain')->nullable() ; 
            $table->string('birthday')->nullable() ; 
            $table->string('gender',10)->nullable() ; 
            $table->string('homepage')->nullable() ; 
            $table->string('blog')->nullable() ; 
            $table->string('facebook')->nullable() ; 
            $table->string('twitter')->nullable() ; 
            $table->text('experience')->nullable() ; 
            $table->string('saying')->nullable() ; 
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
		Schema::drop('profiles');
	}

}
