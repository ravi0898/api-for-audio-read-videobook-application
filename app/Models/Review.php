<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Review  extends Model
{
    protected $table='reviews';
    protected $primaryKey='id';
    protected $fillable=['name', 'review', 'rating', 'book_id', 'user_id', 'reply'];
}
