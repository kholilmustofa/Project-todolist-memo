<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'completed',
        'user_id',
        'due_date',
        'notes',
        'mylist_id',
        'remind_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
        'remind_at' => 'datetime',
    ];

    /**
     * Get the user that owns the Task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mylist that owns the Task.
     */
    public function mylist(): BelongsTo
    {
        return $this->belongsTo(Mylist::class);
    }
}
