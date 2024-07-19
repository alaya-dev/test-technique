<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Importez Carbon pour manipuler les dates


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'user_id', 'deadline', 'completed_at',
    ];

    // Définir les relations si nécessaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted()
    {
        return $this->status === 'terminé';
    }

     // Événement pour mettre à jour completed_at lorsque le statut devient "terminé"
     protected static function boot()
     {
         parent::boot();
 
         static::updating(function ($task) {
             if ($task->isDirty('status') && $task->status === 'terminé') {
                 $task->completed_at = Carbon::now();
             }
         });
     }
}
