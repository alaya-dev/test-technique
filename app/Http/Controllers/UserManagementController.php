<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UserManagementController extends Controller
{
    public function getUser()
    {
        try {
            // Récupérer uniquement les utilisateurs ayant le rôle 'membre'
            $user = User::where('role', 'member')->get();

            // Logger l'événement
            Log::channel('user_management')->info('Récupération des membres', ['count' => $user->count()]);

            // Afficher la vue "liste-user" avec les données des utilisateurs
            return view("liste-user", ['data' => $user]);
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('user_management')->error('Erreur lors de la récupération des membres', ['error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-user')->with('error', 'Une erreur est survenue lors de la récupération des membres.');
        }
    }

    public function addUser(Request $req)
    {
        try {
            // Valider les données du formulaire
            $validatedData = $req->validate([
                'name' => 'required|string|alpha',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            // Créer un nouvel membre
            $user = new User;
            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->role = 'member';

            // Sauvegarder le membre
            $user->save();

            // Logger l'événement
            Log::channel('user_management')->info('Ajout d\'un nouveau membre', ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);

            // Rediriger vers la liste des membres avec un message de succès
            return redirect('/liste-user')->with('success', 'L\'utilisateur est ajouté avec succès');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('user_management')->error('Erreur lors de l\'ajout d\'un membre', ['error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-user')->with('error', 'Une erreur est survenue lors de l\'ajout de l\'utilisateur.');
        }
    }

    public function getUserId($id)
    {
        try {
            // Trouver l'membre par son ID
            $user = User::find($id);

            // Logger l'événement
            Log::channel('user_management')->info('Récupération d\'un membre pour modification', ['id' => $id]);

            // Afficher la vue "modifier-user" avec les données des utilisateurs
            return view('modifier-user', ['data' => $user]);
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('user_management')->error('Erreur lors de la récupération du membre pour modification', ['id' => $id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-user')->with('error', 'Une erreur est survenue lors de la récupération de l\'utilisateur.');
        }
    }

    public function UpdateUser(Request $req)
    {
        try {
            // Trouver l'utilisateur par son ID
            $user = User::find($req->id);

            // Mettre à jour les propriétés de l'utilisateur
            $user->name = $req->name;
            $user->email = $req->email;

            // Sauvegarder les modifications dans la table users
            $user->save();

            // Logger l'événement
            Log::channel('user_management')->info('Modification d\'un membre', ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);

            // Rediriger vers la liste des administrateurs avec un message de succès
            return redirect('/liste-user')->with('success', 'L\'utilisateur est modifié avec succès');
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('user_management')->error('Erreur lors de la modification du membre', ['id' => $req->id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-user')->with('error', 'Une erreur est survenue lors de la modification de l\'utilisateur.');
        }
    }

    public function SuppUser($id)
    {
        try {
            // Trouver l'utilisateur par son ID
            $user = User::find($id);
            
            if ($user) {
                // Supprimer l'utilisateur de la table users
                $user->delete();
                
                // Logger l'événement
                Log::channel('user_management')->info('Suppression d\'un membre', ['id' => $id]);

                // Rediriger vers la liste des utilisateurs avec un message de succès
                return redirect('/liste-user')->with('success', 'L\'utilisateur est supprimé avec succès');
            } else {
                // Logger l'événement d'échec
                Log::channel('user_management')->warning('Échec de la suppression : utilisateur non trouvé', ['id' => $id]);

                // Si l'utilisateur n'est pas trouvé, rediriger avec un message d'erreur
                return redirect('/liste-user')->with('error', 'L\'utilisateur n\'existe pas');
            }
        } catch (Exception $e) {
            // Logger l'erreur
            Log::channel('user_management')->error('Erreur lors de la suppression du membre', ['id' => $id, 'error' => $e->getMessage()]);

            // Rediriger avec un message d'erreur
            return redirect('/liste-user')->with('error', 'Une erreur est survenue lors de la suppression de l\'utilisateur.');
        }
    }
}
