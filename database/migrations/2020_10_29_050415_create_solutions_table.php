<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->enum('dimensi', ['commitment', 'leadership', 'responsibility', 'engagement', 'risk', 'competence', 'informationcommunication', 'organizationallearning']);
            $table->string('solution');
            $table->string('article')->nullable();
            $table->string('tahun')->nullable();
            $table->string('author')->nullable();
            $table->string('link_doi')->nullable();
            $table->string('company_background')->nullable();
            $table->mediumText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solutions');
    }
}
