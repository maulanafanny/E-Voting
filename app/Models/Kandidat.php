<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    //
    protected $table    = 'kandidat';
    protected $fillable = ['nama','visi','misi','periode','foto'];
}
