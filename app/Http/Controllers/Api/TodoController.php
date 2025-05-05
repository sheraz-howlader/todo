<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDoRequest;
use App\Models\ToDo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = ToDo::all();
        return response()->json(['todos' => $todos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToDoRequest $request)
    {
        ToDo::create([
            'name' => $request->task_name,
            'description' => $request->description
        ]);

        $response = [
            'success' => true,
            'message' => 'You have successfully save task!'
        ];
        return response()->json($response, 200);
    }

    public function completeTask(Request $request)
    {
        $task = ToDo::findOrFail($request->task_id);

        $task->update([
            'is_complete' => (bool) $request->status
        ]);

        $response = [
            'success' => true,
            'message' => $task->is_complete
            ? "You have successfully completed {$task->name} task!"
            : "Your task has been marked as incomplete!",
        ];
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = ToDo::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ToDoRequest $request)
    {
        ToDo::where('id', $id)->update([
            'name' => $request->task_name,
            'description' => $request->description
        ]);

        $response = [
            'success' => true,
            'message' => 'You have successfully update task!'
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = ToDo::findOrFail($id);
        $task->delete();

        $response = [
            'success' => true,
            'message' => 'You have successfully deleted task!'
        ];
        return response()->json($response, 200);
    }
}
