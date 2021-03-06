<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(cms_table_name('fields'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('entry_id')->unsigned();
            $table->string('key');
            $table->string('type');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on(cms_table_name('entries'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(cms_table_name('fields'));
    }
}
