<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->enum('category', ['institution', 'company', 'umum', 'expert']);
            $table->string('institution_code')->nullable();
            $table->string('response')->default(0);
            $table->string('max_response');
            $table->timestamps();

            $table->unsignedBigInteger('parent_id')->unique()->nullable();
            $table->foreign('parent_id')->references('id')->on('institution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution');
    }
}
