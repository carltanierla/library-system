<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrower extends Model
{
    protected $primaryKey = 'borrower_id';

    public $incrementing = true;

    protected $table = 'borrowers';

    protected $guarded = [];

    protected $fillable = [
        'borrower_id',
        'book_id',
        'borrower_name',
        'borrower_section',
        'borrowed_at',
        'returned_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function books(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    protected function borrowedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(' F d Y h:i:s A (l)'),
        );
    }

    protected function returnedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(' F d Y h:i:s A (l)') : 'Not yet returned'
        );
    }
}
