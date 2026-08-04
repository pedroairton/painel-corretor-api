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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->decimal('income', 12, 2)->nullable();
            $table->date('birth_date')->nullable();
            $table->text('needs')->nullable();
            $table->boolean('has_property')->default(false);
            $table->enum('marital_status', [
                'single',
                'married',
                'divorced',
                'widowed',
                'stable_union',
            ])->nullable();
            $table->boolean('has_children')->default(false);
            $table->text('notes')->nullable();
            $table->string('interest_status')->default('moderated_interest');
            $table->unsignedTinyInteger('priority')->default(3);
            $table->dateTime('last_contact_at')->nullable();
            $table->dateTime('next_contact_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->index('interest_status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
