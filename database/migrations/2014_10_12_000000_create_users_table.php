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
            $table->id('Id');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Patronymic')->nullable();
            $table->string('Username')->unique();
            $table->string('Password');
            $table->date('Birth');
            $table->string('Phone', 13);
            $table->foreignId('FacultyId')->references('Id')->on('faculties');
            $table->foreignId('DepartmentId')->references('Id')->on('departments');
            $table->string('Post')->nullable();
            $table->string('Photo')->nullable();
            $table->string('Email')->nullable()->unique();
            $table->timestamp('EmailVerifiedAt')->nullable();
            $table->string('RememberToken', 100)->nullable();
            $table->timestamp(User::CREATED_AT)->useCurrent();
            $table->timestamp(User::UPDATED_AT)->useCurrent();
            $table->softDeletes(User::DELETED_AT);
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
