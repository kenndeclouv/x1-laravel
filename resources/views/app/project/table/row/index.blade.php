@extends('components.layouts.master')
@section('title', 'Project Table')

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });

        $(document).on('click', '.edit-project-table', function() {
            const tableId = $(this).data('table-id');
            const projectId = $(this).data('project-id');
            const tableName = $(this).data('table-name');
            const tableDescription = $(this).data('table-description');

            $('#editProjectTableModal').modal('show');
            $('#editProjectTableModal').find('input[name="name"]').val(tableName);
            $('#editProjectTableModal').find('textarea[name="description"]').val(tableDescription);
            $('#editProjectTableModal').find('form').attr('action', `/project/table/update/${tableId}`);
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-breadcrumb :breadcrumbs="[
            ['name' => 'Project', 'url' => route('project.index')],
            ['name' => 'Project Table ' . $project->name, 'url' => route('project.table.index', $project->id)],
        ]" />
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Project Table</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addProjectTableModal" title="Add Project Table">
                        Add Project Table
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addProjectTableModal" tabindex="-1"
                        aria-labelledby="addProjectTableModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProjectTableModalLabel">Add Project Table</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('project.table.store', $project->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tableName" class="form-label">Table Name</label>
                                            <input type="text" class="form-control" id="tableName" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tableDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="tableDescription" name="description"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Table Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $table->name }}</td>
                                <td>
                                    <a href="{{ route('project.table.show', $table->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Table Rows" class="btn btn-success"><i
                                            class="fa-solid fa-table-rows"></i></a>
                                    <button type="button" class="btn btn-warning edit-project-table"
                                        title="Edit Project Table" data-project-id="{{ $project->id }}"
                                        data-table-id="{{ $table->id }}" data-table-name="{{ $table->name }}"
                                        data-table-description="{{ $table->description }}"
                                        data-table-project-id="{{ $project->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit Project Table">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <x-delete :route="route('project.table.destroy', $table->id)" :message="'Are you sure you want to delete this project table?'" :title="'Delete Project Table'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProjectTableModal" tabindex="-1" aria-labelledby="editProjectTableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectTableModalLabel">Edit Project
                        Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tableName" class="form-label">Table Name</label>
                            <input type="text" class="form-control" id="tableName" name="name" value=""
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tableDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="tableDescription" name="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
