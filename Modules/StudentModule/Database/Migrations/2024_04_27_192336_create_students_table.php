<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('branch_id')->index();
            $table->string('id_nu');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->integer('city_id')->index()->default(1);
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('id_expire_date')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender',20)->default('male')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
