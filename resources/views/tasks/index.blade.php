@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="#" id="btn-add-task" class="btn btn-md btn-success mb-3">ADD TASK</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">TASK NAME</th>
                                <th scope="col">PROJECT NAME</th>
                                <th scope="col">CREATED AT</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td class="text-center">
                                    {{ $task->name }}
                                </td>
                                <td class="text-center">
                                    {{ $task->getProjectName() }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a href="#" data-id="{{$task->id}}" class="btn btn-info btn-edit"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" data-id="{{$task->id}}" class="btn btn-danger btn-delete"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Tasks Empty.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.addtaskmodal')
@endsection

@section('footer-script')
    <script src="{{ asset('assets/js/task.js') }}"></script>
@endsection
