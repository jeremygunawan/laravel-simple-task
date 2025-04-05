@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="/projects/create" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">CREATED AT</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td class="text-center">
                                    {{ $project->name }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a href="/projects/edit/{{$project->id}}" class="btn btn-info"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" data-id="{{$project->id}}" class="btn btn-danger btn-delete"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Projects Empty.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "Failed!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

    </script>

    <script src="{{ asset('assets/js/projects.js') }}"></script>
@endsection
