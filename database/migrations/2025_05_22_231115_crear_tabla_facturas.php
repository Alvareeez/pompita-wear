<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFacturas extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();                                    // PK
            $table->foreignId('empresa_id')                  // FK a empresas(id)
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->string('numero')->unique();              // Número de factura
            $table->date('fecha_emision');                   // Fecha de emisión
            $table->date('fecha_vencimiento')->nullable();   // Fecha de vencimiento
            $table->decimal('total', 10, 2);                 // Importe total
            $table->enum('estado',['pendiente','pagada','vencida'])
                  ->default('pendiente');
            $table->json('detalle')->nullable();             // Array JSON con conceptos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
