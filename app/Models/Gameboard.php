<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Gameboard extends Model
{
    use HasFactory;
    protected $fillable = ['score', 'position', 'category'];
    protected $table = 'gameboard';


}
