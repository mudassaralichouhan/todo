<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ToDo extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'todos';

    protected $fillable = [
        'title', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
