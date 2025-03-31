@extends('components.layouts.master')
@section('title', 'Project')

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-breadcrumb :breadcrumbs="[['name' => 'Project', 'url' => route('project.index')]]" />
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Project List</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-end">
                    {{-- @if ($permissions->contains('create_project')) --}}
                    <a href="{{ route('project.create') }}" class="btn btn-primary mb-3" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Add Project">Add Project</a>
                    {{-- @endif --}}
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project Name</th>
                            <th>Laravel Version</th>
                            <th>Database</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->laravel_version ?? '-' }}</td>
                                <td>{{ $project->database ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('project.show', $project->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="View Project Details" class="btn btn-info "><i
                                            class="fa-solid fa-folder-open"></i></a>
                                    <a href="{{ route('project.table.index', $project->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Project Table" class="btn btn-success"><i
                                            class="fa-solid fa-table-layout"></i></a>
                                    <a href="{{ route('project.edit', $project->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit Project" class="btn btn-warning "><i
                                            class="fa-solid fa-edit"></i></a>
                                    <x-delete :route="route('project.destroy', $project->id)" :message="'Are you sure you want to delete this project?'" :title="'Delete Project'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
