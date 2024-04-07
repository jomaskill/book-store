<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'address',
        'active',
    ];

    protected $with = ['books'];

    protected function casts(): array
    {
        return [
            'active'     => 'bool',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity');
    }
}
