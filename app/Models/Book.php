<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table='book';
    protected $primaryKey='id';
    protected $fillable=['title', 'category', 'author_name', 'english_fluency', 'english_accent', 'total_words', 'genre', 'total_time', 'level', 'book_thumbnail', 'status', 'book_description', 'audio', 'audio_title', 'video', 'video_title', 'home_category', 'showbookto'];

    
}
