<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskModified;
use App\Notifications\TaskTerminated;
use App\Notifications\TaskReminder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Afficher le formulaire d'ajout de tâche
    public function showAddTaskForm()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Passer les utilisateurs à la vue
        return view('ajout-task', compact('users'));
    }

    public function addTask(Request $request)
    {
        try {
            // Créer une nouvelle tâche
            $task = new Task;
            $task->title = $request->titre;
            $task->description = $request->description;
            $task->deadline = $request->deadline;
            $task->user_id = $request->user_id; // Assigner la tâche à l'utilisateur

            // Sauvegarder la tâche
            $task->save();

            // Notification d'attribution de tâche
            $user = User::find($request->user_id);
            $user->notify(new TaskAssigned($task));

            // Logger l'événement
            Log::channel('task_management')->info('Tâche ajoutée', ['id' => $task->id, 'titre' => $task->title, 'assingné_à' =>$task->user->name, 'deadline' =>$task->deadline]);

            // Rediriger vers la liste des tâches avec un message de succès
            return redirect('liste-task')->with('success', 'Tâche ajoutée avec succès');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de l\'ajout de la tâche', ['error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('liste-task')->with('error', 'Une erreur est survenue lors de l\'ajout de la tâche.');
        }
    }

    // Afficher la liste des tâches
    public function getTask()
    {
        $data = Task::all();
        return view('liste-task', compact('data'));
    }

    // Afficher le formulaire de modification d'une tâche par ID
    public function getTaskId($id)
    {
        $task = Task::findOrFail($id);
        return view('modifier-task', compact('task'));
    }

    // Mettre à jour une tâche
    public function UpdateTask(Request $req)
    {
        try {
            // Valider les données du formulaire
            $validatedData = $req->validate([
                'title' => 'required|string', // Le titre est requis et doit être une chaîne de caractères
                'description' => 'nullable|string', // La description est optionnelle et doit être une chaîne de caractères
                'deadline' => 'nullable|date', // La date limite est optionnelle et doit être une date valide
            ]);

            // Trouver la tâche à mettre à jour par son ID
            $task = Task::find($req->id);

            // Mettre à jour le titre et la description de la tâche
            $task->title = $req->title;
            $task->description = $req->description;

            // Mettre à jour la date limite si elle est fournie
            if ($req->deadline) {
                $task->deadline = Carbon::parse($req->deadline);
            } else {
                $task->deadline = null; // Sinon, annuler la date limite
            }

            // Sauvegarder les modifications de la tâche dans la base de données
            $task->save();

            // Récupérer l'utilisateur assigné à cette tâche pour envoyer la notification
            $assignedUser = User::findOrFail($task->user_id);

            // Envoyer une notification de modification de tâche à l'utilisateur assigné
            $assignedUser->notify(new TaskModified($task));

            // Logger l'événement
            Log::channel('task_management')->info('Tâche modifiée', ['id' => $task->id, 'titre' => $task->title, 'assigné_à' =>$task->user_id, 'deadline' =>$task->deadline]);

            // Rediriger vers la liste des tâches avec un message de succès
            return redirect('/liste-task')->with('success', 'La tâche est modifiée avec succès');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de la modification de la tâche', ['id' => $req->id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-task')->with('error', 'Une erreur est survenue lors de la modification de la tâche.');
        }
    }

    // Mettre à jour le statut d'une tâche
    public function updateStatus(Request $request, $id)
    {
        try {
            // Trouver la tâche à mettre à jour
            $task = Task::findOrFail($id);
        
            // Vérifiez si la tâche est déjà terminée et essaye de changer en attente
            if ($task->status === 'terminé' && $task->status == 'en attente') {
                return redirect('/home')->with('error', 'Impossible de changer une tâche terminée en attente.');
            }
        
            // Mettre à jour l'état en fonction de l'action (basculer entre 'en attente' et 'terminé')
            if ($task->status == 'en attente') {
                $task->status = 'terminé';
                $task->save();
        
                // Récupérer le leader de l'équipe (ajustez cette partie selon votre logique de rôle et d'utilisateur)
                $leader = User::where('role', 'leader')->first();
        
                // Envoyer la notification au leader
                Notification::send($leader, new TaskTerminated($task));
        
                // Logger l'événement
                Log::channel('task_management')->info('Tâche terminée', ['id' => $task->id, 'title' => $task->title]);
        
                return redirect('/home')->with('success', 'Statut de la tâche mis à jour avec succès et notification envoyée au leader.');
            }
        
            // Sauvegarder les modifications
            $task->save();
        
            // Logger l'événement
            Log::channel('task_management')->info('Statut de la tâche mis à jour', ['id' => $task->id, 'status' => $task->status]);
        
            // Redirection vers la liste des tâches avec un message de succès
            return redirect('/home')->with('success', 'Statut de la tâche mis à jour avec succès');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de la mise à jour du statut de la tâche', ['id' => $id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/home')->with('error', 'Une erreur est survenue lors de la mise à jour du statut de la tâche.');
        }
    }

    // Supprimer une tâche
    public function SuppTask($id)
    {
        try {
            // Trouver la tache à supprimer
            $task = Task::find($id);
            
            if ($task) {
                // Supprimer la tache de la base de données
                $task->delete();

                // Logger l'événement
                Log::channel('task_management')->info('Tâche supprimée', ['id' => $id]);
            }

            // Rediriger vers la liste des taches avec un message de succès
            return redirect('/liste-task')->with('success', 'La tache a été supprimée avec succès.');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de la suppression de la tâche', ['id' => $id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-task')->with('error', 'Une erreur est survenue lors de la suppression de la tâche.');
        }
    }

    // Récupérer les tâches assignées à un membre
    public function getTaskMember()
    {
        try {
            $data = Task::where('user_id', auth()->user()->id)->get();

            // Logger l'événement
            Log::channel('task_management')->info('Récupération des tâches assignées au membre', ['user_id' => auth()->user()->id, 'count' => $data->count()]);

            return view('home', compact('data'));
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de la récupération des tâches assignées au membre', ['user_id' => auth()->user()->id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/home')->with('error', 'Une erreur est survenue lors de la récupération des tâches.');
        }
    }

    // Envoyer des rappels de tâches
    public function sendTaskReminders()
    {
        try {
            // Récupérer les tâches en attente qui nécessitent un rappel
            $tasks = Task::where('status', 'en attente')->get();
        
            foreach ($tasks as $task) {
                // Envoyer une notification à l'utilisateur assigné
                $task->user->notify(new TaskReminder($task));
        
                // Récupérer le leader de l'équipe (à ajuster selon votre logique)
                $leader = User::where('role', 'leader')->first();
        
                // Vérifier si le leader existe et lui envoyer une notification
                if ($leader) {
                    $leader->notify(new TaskReminder($task));
                }
            }

            // Logger l'événement
            Log::channel('task_management')->info('Rappels de tâches envoyés', ['task_count' => $tasks->count()]);
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('task_management')->error('Erreur lors de l\'envoi des rappels de tâches', ['error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/home')->with('error', 'Une erreur est survenue lors de l\'envoi des rappels de tâches.');
        }
    }
}
