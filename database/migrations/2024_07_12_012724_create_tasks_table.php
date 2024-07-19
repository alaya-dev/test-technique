<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['en attente', 'terminé'])->default('en attente');
            $table->unsignedBigInteger('user_id'); // Clé étrangère pour l'utilisateur qui possède la tâche
            $table->date('deadline')->nullable();
            $table->timestamp('completed_at')->nullable(); // Champ pour enregistrer la date de complétion
            $table->timestamps();

            // Clé étrangère vers la table des utilisateurs
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
