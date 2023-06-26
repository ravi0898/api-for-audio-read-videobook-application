<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    protected $table='quiz_response';
    protected $primaryKey='id';
    protected $fillable=['book_id', 'user_id', 'name', 'admin_reply'];
}
