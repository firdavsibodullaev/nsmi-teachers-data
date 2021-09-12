<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('Id');
            $table->string('FullNameUz');
            $table->string('FullNameOz')->nullable();
            $table->string('FullNameRu')->nullable();
            $table->string('ShortNameUz');
            $table->string('ShortNameOz')->nullable();
            $table->string('ShortNameRu')->nullable();
            $table->foreignId('FacultyId')->references('Id')->on('faculties');
            $table->timestamp(BaseModel::CREATED_AT)->useCurrent();
            $table->timestamp(BaseModel::UPDATED_AT)->useCurrent();
            $table->softDeletes(BaseModel::DELETED_AT);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
