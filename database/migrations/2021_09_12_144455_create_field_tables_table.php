<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_tables', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('TableId')->references('Id')->on('tables');
            $table->foreignId('FieldId')->references('Id')->on('fields');
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
        Schema::dropIfExists('field_tables');
    }
}
