<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['category_slug', 'subcategory_slug']);
        });

        Schema::dropIfExists('ads');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::table('ads', function (Blueprint $table) {
            $table->string('category_slug')->after('category_id');
            $table->string('subcategory_slug')->nullable()->after('subcategory_id');
        });
    }
};
