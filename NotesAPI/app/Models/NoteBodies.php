<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteBodies extends Model
{
    protected $fillable = ['id_note', 'text'];

    protected $table = 'note_bodies';

    protected $primaryKey = 'id_note_body';

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;
}
