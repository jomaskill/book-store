<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'value',
    ];


    protected function casts(): array
    {
        return [
            'value'      => 'float:2',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class)->withPivot('quantity');
    }
}
