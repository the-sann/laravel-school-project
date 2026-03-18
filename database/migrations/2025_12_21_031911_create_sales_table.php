<?php

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->date('sale_date');
            $table->timestamps();
        });
    }

    public function down()
    {

        Schema::dropIfExists('sales');
    }
};
