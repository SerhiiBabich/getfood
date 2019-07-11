<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_email', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->unique()->index();
            $table->string('email');
            $table->integer('used_token')->default(0);
            $table->timestamp('token_created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edit_email');
    }
}
