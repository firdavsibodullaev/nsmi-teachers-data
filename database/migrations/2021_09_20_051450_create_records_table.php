<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('UserId')->references('Id')->on('users');
            $table->foreignId('TableId')->nullable()->references('Id')->on('tables');
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
        Schema::dropIfExists('records');
    }
}
