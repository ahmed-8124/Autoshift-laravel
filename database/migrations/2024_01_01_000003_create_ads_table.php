<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('make_id')->constrained();
            $table->enum('type', ['car', 'bike'])->default('car');
            $table->string('model');
            $table->integer('year');
            $table->decimal('price', 12, 2);
            $table->integer('mileage')->default(0);
            $table->enum('fuel_type', ['Petrol','Diesel','CNG','Hybrid','Electric'])->default('Petrol');
            $table->enum('transmission', ['Manual','Automatic'])->default('Manual');
            $table->integer('engine_cc')->nullable();
            $table->string('color')->nullable();
            $table->enum('condition_type', ['Used','New'])->default('Used');
            $table->string('city');
            $table->text('description')->nullable();
            $table->enum('status', ['pending','active','sold','rejected'])->default('pending');
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ads'); }
};
