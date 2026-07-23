<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'price', 'stock', 'description'])]
class Product extends Model
{
    use HasFactory;

    public function transactions(): BelongsToMany
    {

        return $this->belongsToMany(Transaction::class, 'transaction_details')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
