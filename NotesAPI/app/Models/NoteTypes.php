<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteTypes extends Model
{
    protected $fillable = ['name'];

    protected $table = 'note_types';

    protected $primaryKey = 'id_note_type';

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function isTextBody()
    {
        return $this->name == 'Text note';
    }
}
