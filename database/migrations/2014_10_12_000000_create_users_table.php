<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('permission_version')->default(0);
            $table->text('remember_token')->nullable();
            $table->timestamps();
        });
    }

    public function rememberToken()
    {
        return $this->text('remember_token')->nullable();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
