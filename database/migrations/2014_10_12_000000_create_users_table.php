<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->enum('role', User::$ROLES)->default('buyer');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('active')->default(1);
            $table->string('channels')->default('email');
            $table->string('telegram_token')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedInteger('ads_in_day')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
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
