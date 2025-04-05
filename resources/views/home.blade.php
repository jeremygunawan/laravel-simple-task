@extends('layouts.app')

@section('page-title', 'home')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="contract-employee-name">Project</label>
                        <select name="project" id="project-dropdown" class="form-select">
                            <option value="0">All Projects</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table id="task-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">TASK NAME</th>
                                <th scope="col">PROJECT NAME</th>
                                <th scope="col">CREATED AT</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($tasks as $key => $task)
                            <tr id="{{++$key}}" data-taskid="{{$task->id}}">
                                <td class="text-center">
                                    {{ $task->name }}
                                </td>
                                <td class="text-center">
                                    {{ $task->getProjectName() }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Tasks Empty.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                    <p class="result"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
