<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TaskController;

class SendTaskReminders extends Command
{
    protected $signature = 'task:reminders'; // Signature de la commande artisan

    protected $description = 'Envoyer les rappels de tâches quotidiens'; // Description de la commande

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $taskController = new TaskController();
        $taskController->sendTaskReminders(); // Appel de la méthode pour envoyer les rappels
        $this->info('Rappels de tâches envoyés avec succès.'); // Message de succès
    }
}
