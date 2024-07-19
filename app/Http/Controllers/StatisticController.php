<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;


class StatisticController extends Controller
{
    /**
     * Récupérer les statistiques quotidiennes de l'accomplissement des tâches.
     */
    public function dailyStatistics()
    {
        try {
            $tasks = Task::whereDate('updated_at', Carbon::today())->get();
            $tasksCompleted = $tasks->where('status', 'terminé')->count();
            $totalTasks = $tasks->count();

            // Calculer le taux d'accomplissement
            $completionRate = ($totalTasks > 0) ? ($tasksCompleted / $totalTasks) * 100 : 0;

            // Calculer le temps moyen d'accomplissement
            $totalTime = $tasks->where('status', 'terminé')->sum(function ($task) {
                return $task->updated_at->diffInMinutes($task->created_at);
            });
            $averageCompletionTime = ($tasksCompleted > 0) ? $totalTime / $tasksCompleted : 0;

            // Enregistrer les statistiques calculées dans le canal 'statistics'
            Log::channel('statistics')->info('Statistiques quotidiennes calculées.', [
                'date' => Carbon::today()->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);

            return response()->json([
                'date' => Carbon::today()->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans le canal 'statistics'
            Log::channel('statistics')->error('Erreur lors du calcul des statistiques quotidiennes.', ['erreur' => $e->getMessage()]);

            return response()->json(['erreur' => 'Impossible de calculer les statistiques quotidiennes.'], 500);
        }
    }

    /**
     * Récupérer les statistiques hebdomadaires de l'accomplissement des tâches.
     */
    public function weeklyStatistics()
    {
        try {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $tasks = Task::whereBetween('updated_at', [$startOfWeek, $endOfWeek])->get();
            $tasksCompleted = $tasks->where('status', 'terminé')->count();
            $totalTasks = $tasks->count();

            // Calculer le taux d'accomplissement
            $completionRate = ($totalTasks > 0) ? ($tasksCompleted / $totalTasks) * 100 : 0;

            // Calculer le temps moyen d'accomplissement
            $totalTime = $tasks->where('status', 'terminé')->sum(function ($task) {
                return $task->updated_at->diffInMinutes($task->created_at);
            });
            $averageCompletionTime = ($tasksCompleted > 0) ? $totalTime / $tasksCompleted : 0;

            // Enregistrer les statistiques calculées dans le canal 'statistics'
            Log::channel('statistics')->info('Statistiques hebdomadaires calculées.', [
                'start_date' => $startOfWeek->format('Y-m-d'),
                'end_date' => $endOfWeek->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);

            return response()->json([
                'start_date' => $startOfWeek->format('Y-m-d'),
                'end_date' => $endOfWeek->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans le canal 'statistics'
            Log::channel('statistics')->error('Erreur lors du calcul des statistiques hebdomadaires.', ['erreur' => $e->getMessage()]);

            return response()->json(['erreur' => 'Impossible de calculer les statistiques hebdomadaires.'], 500);
        }
    }

    /**
     * Récupérer les statistiques mensuelles de l'accomplissement des tâches.
     */
    public function monthlyStatistics()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $tasks = Task::whereBetween('updated_at', [$startOfMonth, $endOfMonth])->get();
            $tasksCompleted = $tasks->where('status', 'terminé')->count();
            $totalTasks = $tasks->count();

            // Calculer le taux d'accomplissement
            $completionRate = ($totalTasks > 0) ? ($tasksCompleted / $totalTasks) * 100 : 0;

            // Calculer le temps moyen d'accomplissement
            $totalTime = $tasks->where('status', 'terminé')->sum(function ($task) {
                return $task->updated_at->diffInMinutes($task->created_at);
            });
            $averageCompletionTime = ($tasksCompleted > 0) ? $totalTime / $tasksCompleted : 0;

            // Enregistrer les statistiques calculées dans le canal 'statistics'
            Log::channel('statistics')->info('Statistiques mensuelles calculées.', [
                'start_date' => $startOfMonth->format('Y-m-d'),
                'end_date' => $endOfMonth->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);

            return response()->json([
                'start_date' => $startOfMonth->format('Y-m-d'),
                'end_date' => $endOfMonth->format('Y-m-d'),
                'taches_terminees' => $tasksCompleted,
                'taches_totales' => $totalTasks,
                'taux_accomplissement' => round($completionRate, 2) . '%',
                'temps_moyen_accomplissement' => round($averageCompletionTime, 2) . ' minutes'
            ]);
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans le canal 'statistics'
            Log::channel('statistics')->error('Erreur lors du calcul des statistiques mensuelles.', ['erreur' => $e->getMessage()]);

            return response()->json(['erreur' => 'Impossible de calculer les statistiques mensuelles.'], 500);
        }
    }
}
