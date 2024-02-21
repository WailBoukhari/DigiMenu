<?php

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
        Schema::table('users', function (Blueprint $table) {
            // Add your foreign key constraint
            $table->foreignId('subscription_plan_id')->nullable()->constrained('subscription_plans')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint if needed
            $table->dropForeign(['subscription_plan_id']);
        });
    }

};
