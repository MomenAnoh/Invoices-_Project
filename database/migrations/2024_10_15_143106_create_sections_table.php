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
        Schema::create('sections', function (Blueprint $table) {
//            دلوقتي هعمل تلت حقول سيكشن وديسطكربشن و كريتد باي
            
                $table->bigIncrements('id');
                $table->string('section', 999);
                $table->text('description')->nullable();
                $table->string('Created_by', 999);
                $table->timestamps();
            });
    }
              // $table->foreign('id_Invoice')->references('id')->on('invoices')->onDelete('cascade');

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
