<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //nome della tabella: opzionale:
    protected $table = 'posts';
    
    /* public $primaryKey = 'id';
    public $timestamps = true; */

    protected $fillable = [
        'id',
        'title',
        'body',
    ];


    public function user() {
        return $this->belongsTo('App\User');
    }
    
    


    
}
