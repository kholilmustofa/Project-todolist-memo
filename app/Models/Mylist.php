<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;   

class Mylist extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 
        'name',   
    ];

    /**
     * Get the user that owns the Mylist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tasks for the Mylist.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
