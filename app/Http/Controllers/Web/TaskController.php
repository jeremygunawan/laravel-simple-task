<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Show the Tasks list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('priority', 'ASC')->get();
        $projects = Project::where('user_id', Auth::id())->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'projects' => $projects
        ]);
    }

    /**
     * store using ajax
     *
     * @param  mixed $request
     * @return json
     */
    public function store(Request $request)
    {
        //validate form
        $request->validate(
            [
                'name'  => ['required', 'min:5'],
                'project'  => ['required']
            ],
            [
                'name.min' => 'Minimun: :min characters!'
            ]
        );

        $authUser = Auth::user();
        $priority = Task::where('project_id', $request->project)->count() + 1;

        //create Task
        Task::create([
            'name'          => $request->post('name'),
            'priority'      => $priority,
            'project_id'    => $request->post('project'),
            'user_id'       => $authUser->id
        ]);

        return response()->json([
            'code' => '200',
            'message' => 'Task Created',
            'data' => []
        ], 200);
    }

    /**
     * Load data
     *
     * @return json
     */
    public function load($id)
    {
        $task = Task::find($id);
        $data = [];
        $data['task'] = $task;

        return response()->json([
            'code' => '200',
            'message' => 'Task Loaded',
            'data' => $data
        ], 200);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return json
     */
    public function update(Request $request, $id)
    {
        //validate form
        $request->validate(
            [
                'name'         => ['required', 'min:7'],
                'project'  => ['required']
            ],
            [
                'name.min' => 'Minimun: :min characters!'
            ]
        );

        $authUser = Auth::user();

        //update Task
        Task::where('id', $id)->update([
            'name'         => $request->post('name'),
            'project_id'    => $request->post('project'),
        ]);

        return response()->json([
            'code' => '200',
            'message' => 'Task Updated',
            'data' => []
        ], 200);
    }

    /**
     * delete
     *
     * @param  mixed $request
     * @return json
     */
    public function delete(Request $request)
    {
        //Delete Task
        Task::where('id', $request->post('id'))->delete();

        return response()->json([
            'code' => '200',
            'message' => 'Task Deleted',
            'data' => []
        ], 200);
    }

    /**
     * order priority
     *
     * @param  mixed $request
     * @return json
     */
    public function orderPriority(Request $request)
    {
        $ordering = $request->ordering;
        $project = [];
        
        //update Task
        foreach($ordering as $single){
            $task = Task::where('id', $single)->first();
            $priority = 1;
            if(!empty($project[$task->project_id])){
                $priority = $project[$task->project_id] + 1;
                $project[$task->project_id]++;
            }else{
                $project[$task->project_id] = 1;
            }
            $task->priority = $priority;
            $task->save();
        }

        return response()->json([
            'code' => '200',
            'message' => 'Task Updated',
            'data' => []
        ], 200);
    }

    /**
     * Load data By Project
     *
     * @return json
     */
    public function loadByProject($id)
    {
        //to reduce DB call
        if($id == 0){
            $tasks = Task::where('user_id', Auth::id())->orderBy('priority', 'ASC')->get();       
        }else{
            $tasks = Task::where('user_id', Auth::id())->where('project_id', $id)->orderBy('priority', 'ASC')->get();
        }
        
        $data = [];
        $data['tasks'] = $tasks;

        return response()->json([
            'code' => '200',
            'message' => 'Task Loaded',
            'data' => $data
        ], 200);
    }
}
