<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('amount');
            $table->enum('type', ['BCA', 'BNI', 'BRI', 'Maybank', 'Mandiri', 'Permata']);
            $table->string('total');
            $table->enum('status', ['Success', 'Pending', 'Failed'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->enum('wallet_type', ['deposit', 'withdraw'])->default('deposit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
