<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function deck()
    {
        return $this->hasOne(Deck::class);
    }
}
