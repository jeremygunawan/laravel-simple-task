<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Show the projects list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();

		return view('projects.index', [
			'projects' => $projects
		]);
    }

    /**
     * create
     *
     * @return View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //validate form
        $request->validate([
            'name'         => ['required', 'min:5']
        ],
        [
            'name.min' => 'Minimun: :min characters!'
        ]);

        $authUser = Auth::user();

        //create project
        Project::create([
            'name'         => $request->post('name'),
            'user_id'      => $authUser->id
        ]);

        //redirect to index
        return redirect()->route('projects.index')->with([
            'success' => 'Project Saved!'
        ]);
    }

    /**
     * edit
     *
     * @return View
     */
    public function edit($id)
    {
        $project = Project::find($id);
        
        return view('projects.edit', [
			'project' => $project
		]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //validate form
        $request->validate([
            'name'         => ['required', 'min:7']
        ],
        [
            'name.min' => 'Minimun: :min characters!'
        ]);

        $authUser = Auth::user();

        //update project
        Project::where('id', $id)->update([
            'name'         => $request->post('name'),
        ]);

        //redirect to index
        return redirect()->route('projects.index')->with([
            'success' => 'Project Updated!'
        ]);
    }

    /**
     * delete
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        //Delete Project
        Project::where('id', $request->post('id'))->delete();

        // $errors = new \stdClass;
        // $errors->department_name = ["Department Already Exist."];

        // return response()->json([
        //     'message'=>'Error Department Exist',
        //     'errors'=> $errors
        // ], 422);

        return response()->json([
            'code' => '200',
            'message'=>'Project Deleted',
            'data'=> []
        ], 200);
    }
}
