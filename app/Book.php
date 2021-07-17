<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    protected $table = 'books';

     protected $primaryKey = 'book_id';
}
