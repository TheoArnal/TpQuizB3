<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function choices() {
        return $this->hasMany(Choice::class, 'foreign_key');
    }
    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }

    use HasFactory;
}
