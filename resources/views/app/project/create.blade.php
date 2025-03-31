@extends('components.layouts.master')
@section('title', 'Create Project')

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-breadcrumb :breadcrumbs="[['name' => 'Project', 'url' => route('project.index')], ['name' => 'Create Project', 'url' => route('project.create')]]" />
        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Create Project</h5>
                </div>
                <div class="card-body pt-4">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="name" required
                            value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="projectDescription" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="projectLaravelVersion" class="form-label">Laravel Version</label>
                        <select class="form-select select2" id="projectLaravelVersion" name="laravel_version">
                            <option value="">Select Laravel Version</option>
                            <option value="12.x" {{ old('laravel_version') == '12.x' ? 'selected' : '' }}>12.x</option>
                            <option value="11.x" {{ old('laravel_version') == '11.x' ? 'selected' : '' }}>11.x</option>
                            <option value="10.x" {{ old('laravel_version') == '10.x' ? 'selected' : '' }}>10.x</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="projectDatabase" class="form-label">Database</label>
                        <select class="form-select select2" id="projectDatabase" name="database">
                            <option value="">Select Database</option>
                            <option value="mysql" {{ old('database') == 'mysql' ? 'selected' : '' }}>MySQL</option>
                            <option value="pgsql" {{ old('database') == 'pgsql' ? 'selected' : '' }}>PostgreSQL</option>
                            <option value="sqlite" {{ old('database') == 'sqlite' ? 'selected' : '' }}>SQLite</option>
                            <option value="sqlsrv" {{ old('database') == 'sqlsrv' ? 'selected' : '' }}>SQL Server</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <p class="text-muted">Select the features you want to include in your project.</p>
                        @foreach ($features as $feature)
                            <div class="col-md mb-md-0 mb-5">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content"
                                        for="customCheckboxIcon{{ $feature->id }}">
                                        <span class="custom-option-body">
                                            <i class="icon-base {{ $feature->icon }}"></i>
                                            <span class="custom-option-title"> {{ $feature->name }} </span>
                                            <small> {{ $feature->description }} </small>
                                        </span>
                                        <input class="form-check-input" type="checkbox" name="feature_id[]"
                                            value="{{ $feature->id }}" id="customCheckboxIcon{{ $feature->id }}"
                                            {{ old('feature_id') && in_array($feature->id, old('feature_id')) ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i> Create Project</button>
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
