<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = 'status';
    protected $fillable = ['nama'];
    public function voters()
    {
    	return $this->belongsTo('App\Voters');
    }
}
