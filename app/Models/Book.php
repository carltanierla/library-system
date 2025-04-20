<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $primaryKey = 'book_id';

    public $incrementing = true;

    protected $table = 'books';

    protected $guarded = [];

    protected $fillable = [
        'book_id',
        'strand',
        'reference',
        'category',
        'track',
        'type',
        'title',
        'author',
        'year',
        'status',
        'created_at',
        'updated_at',
    ];
}
