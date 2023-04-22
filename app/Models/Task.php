<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // this is allow Task to be mass-assignments
    // For example $model->fill([...])
    // otherwise single call by method create()
    // For example Task::create([''])
    protected $fillable = [
        'user_id','name','description','priority'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
