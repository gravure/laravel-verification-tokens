<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VerificationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_tokens', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('token');

            $table->integer('created_by')->nullable();
            $table->integer('created_for')->nullable();

            $table->longText('callback');

            $table->timestamps();

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('send_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_tokens');
    }
}
