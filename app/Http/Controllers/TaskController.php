<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3'
        ]);

        $newTask = Task::create([
            'name' => $validated['name'],
        ]);

        return $newTask;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingTask = Task::find($id);
        if ($existingTask) {
            if ($existingTask->status == StatusEnum::PENDING->value) {
                $existingTask->status = StatusEnum::COMPLETED;
                $existingTask->completed_at = Carbon::now();
                $existingTask->save();
                return $existingTask;
            } else {
                return "Task already completed";
            }
        } else {
            return "No task found!";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $existingTask = Task::find($id);
        if ($existingTask) {
            $existingTask->delete();
            return 'Task deleted successfully';
        } else {
            return "No task found!";
        }
    }
}
