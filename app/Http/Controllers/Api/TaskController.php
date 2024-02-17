<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Obtener los parámetros de la solicitud
        $perPage = $request->input('per_page', 3);
        $id = $request->input('id'); // Filtro por ID
        $title = $request->input('title'); // Filtro por título

        // Crear una consulta para obtener todas las tareas
        $query = Task::query();

        // Aplicar filtros si se proporcionan
        if (!empty($id)) {
            $query->where('id', $id);
        }

        if (!empty($title)) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        // Paginar el resultado de la consulta
        $tasks = $query->paginate($perPage);

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'done' => 'required',
            'user_id' => 'required'
        ]);

        $task = Task::create($request->all());

        return  $task;
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Obtener el nombre de usuario asociado a la tarea
        $task->name = User::find($task->user_id)->name ?? null;

        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'done' => 'required',
            'user_id' => 'required'
        ]);

        $task->update($request->all());

        return  $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }
}

