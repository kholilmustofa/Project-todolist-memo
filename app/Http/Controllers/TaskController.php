<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->with('mylist')->latest()->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        Log::info('TaskController@store Dijalankan.', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'completed' => 'boolean', // Ini akan menjadi false secara default jika tidak ada di request
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'mylist_id' => 'nullable|exists:mylists,id,user_id,' . Auth::id(),
            'remind_at' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        // Tangani mylist_id jika tidak disediakan
        if (!isset($validatedData['mylist_id'])) {
            $personalList = Auth::user()->mylists()->where('name', 'Personal')->first();
            // Jika list 'Personal' tidak ada, Anda mungkin ingin membuatnya atau menetapkan null
            $validatedData['mylist_id'] = $personalList ? $personalList->id : null;
        }

        // Pastikan 'completed' diatur ke false jika tidak ada di validatedData (saat membuat task baru)
        if (!isset($validatedData['completed'])) {
            $validatedData['completed'] = false;
        }

        // HANYA PANGGIL CREATE SATU KALI DENGAN $validatedData
        $task = Auth::user()->tasks()->create($validatedData);

        // Load relasi mylist untuk dikembalikan di response
        $task->load('mylist');

        return response()->json($task, 201);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Otorisasi: Pastikan user yang sedang login adalah pemilik task
        if ($request->user()->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'completed' => 'sometimes|boolean',
            'name' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'mylist_id' => 'nullable|exists:mylists,id,user_id,' . Auth::id(),
            'remind_at' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        $task->update($request->only([
            'name',
            'completed',
            'due_date',
            'notes',
            'mylist_id',
            'remind_at'
        ]));

        $updatedTask = $task->fresh()->load('mylist');

        return response()->json($updatedTask);
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(null, 204);
    }
}