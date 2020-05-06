<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Tasks;
use App\TaskStatus;
use Auth;
use DB;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.index');
    }

    public function getTasks(){
        $tasks = Tasks::with('taskStatus')->get();
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('tasks.register_task');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $task = Tasks::create([
            'name' => $request->name,
            'description' => $request->description,
            'reminder_date' => $request->fecha_ini,
            'expiration_date' => $request->fecha_fin,
            'user_id' => Auth::user()->id
        ])->id;


        $status = TaskStatus::create([
            'tasks_id' => $task,
            'status' => 'pending'
        ]);

        if (!$task) {
            return array('status' => 'error', 'msg' => 'Error al crear tarea');
        }

        return array('status' => 'success', 'msg' => 'Tarea creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Tasks::where('id', $id)->with('taskStatus')->first();
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $task = Tasks::find($request->id);

            $task->update([
                'name' => $request->name,
                'description' => $request->description,
                'reminder_date' => $request->fecha_ini,
                'expiration_date' => $request->fecha_fin,
                'user_id' => Auth::user()->id, 
            ]);

        $status = TaskStatus::where('tasks_id', $request->id);

        $status->update([
            'status' => $request->status
        ]);

            if (!$task) {
                return array('status' => 'error', 'msg' => 'Error al actualizar tarea');
            }

            return array('status' => 'success', 'msg' => 'Tarea actualizada exitosamente');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Tasks::where('id',$id)->with('taskStatus')->delete();
        return $result;
    }
}
