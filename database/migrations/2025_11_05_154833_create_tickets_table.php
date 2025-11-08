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
     Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
        $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
        $table->string('subject');
        $table->text('message');
        $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('low');
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed', 'pending'])->default('open');
        $table->json('attachments')->nullable();
        $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
        $table->boolean('is_notified')->default(false);
        $table->timestamp('resolved_at')->nullable();
        $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
