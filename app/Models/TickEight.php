<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TickEight extends Model
{
    use HasFactory;

    protected $fillable = ['word', 'answer', 'group'];
}
