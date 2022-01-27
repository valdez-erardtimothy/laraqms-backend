<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitingCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status_states = ['WAITING', 'READY', 'SERVED', 'SKIPPED ', 'CANCELLED'];
        Schema::create(
            'waiting_customers',
            function (Blueprint $table) use ($status_states) {
                $table->id();
                $table->string('customer_name');
                $table->string('email');
                $table->enum('status', $status_states)->default('WAITING');
                $table->string('queue_token', 16);
                $table->timestamp('served_at')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiting_customers');
    }
}
