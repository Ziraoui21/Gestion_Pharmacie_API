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
        Schema::create('medicament_facture', function (Blueprint $table) {
            $table->unsignedBigInteger("medicament_id");
            $table->unsignedBigInteger("facture_id");
            $table->primary(['medicament_id','facture_id'],'PK_medicament_facture');
            $table->foreign("medicament_id")->references("id")->on("medicaments");
            $table->foreign("facture_id")->references("id")->on("factures");
            $table->integer('qte');
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
        Schema::dropIfExists('medicament_facture');
    }
};
