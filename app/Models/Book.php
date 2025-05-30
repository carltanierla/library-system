<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'image',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['created_at', 'updated_at'];

    protected function strand(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }

    protected function reference(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function category(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function track(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function type(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function author(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function year(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }
    protected function status(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str($value)->squish()
        );
    }

    public function borrowers(): HasMany
    {
        return $this->hasMany(Borrower::class, 'book_id', 'book_id');
    }

}
