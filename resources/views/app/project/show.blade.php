@extends('components.layouts.master')

@section('title', 'Project Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-breadcrumb :breadcrumbs="[['name' => 'Project', 'url' => route('project.index')], ['name' => 'Project Details ' . $project->name, 'url' => route('project.show', $project->id)]]" />
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Project Details</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Project Name</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $project->name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Laravel Version</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $project->laravel_version ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Database</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $project->database ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Description</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $project->description ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Features</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $project->features->pluck('name')->implode(', ') ?? '-' }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('project.index') }}" class="btn btn-secondary" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Back"><i class="fa-solid fa-arrow-left"></i></a>
                        <a href="{{ route('project.edit', $project->id) }}" class="btn btn-warning" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Edit Project"><i class="fa-solid fa-edit"></i></a>
                        <x-delete :route="route('project.destroy', $project->id)" :message="'Are you sure you want to delete this project?'" :title="'Delete Project'" />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
