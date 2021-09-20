<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('RecordId')->references('Id')->on('records');
            $table->foreignId('FieldId')->references('Id')->on('fields');
            $table->longText('Value')->nullable();
            $table->string('File')->nullable();
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
        Schema::dropIfExists('values');
    }
}
