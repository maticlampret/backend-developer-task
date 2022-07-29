<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folders extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_user'];

    protected $table = 'folders';

    protected $primaryKey = 'id_folder';

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user', 'id_user');
    }

    public function notes()
    {
        return $this->hasMany(\App\Models\Notes::class, 'id_folder', 'id_folder');
    }
}
