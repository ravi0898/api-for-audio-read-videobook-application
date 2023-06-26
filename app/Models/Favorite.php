<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table='favorite';
    protected $primaryKey='id';
    protected $fillable=['book_id', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
