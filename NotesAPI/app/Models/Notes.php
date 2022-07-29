<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_user', 'id_folder', 'public', 'id_note_type'];

    protected $table = 'notes';

    protected $primaryKey = 'id_note';

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function body()
    {
        return $this->hasMany(\App\Models\NoteBodies::class, 'id_note', 'id_note');
    }

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user', 'id_user');
    }

    public function tip()
    {
        return $this->belongsTo(\App\Models\NoteTypes::class, 'id_note_type', 'id_note_type');
    }

    public function scopeGuestOrUser($query, $user)
    {
        /*I also return less information about the note when the user in not auth, I do not return id_user and id_folder,
         maybe this is too restrictive */
        if (!$user) {
            return $query->where('public', 1)->select(['id_note', 'name', 'id_note_type']);
        }

        return $query->where('id_user', $user->id_user);
    }
}
