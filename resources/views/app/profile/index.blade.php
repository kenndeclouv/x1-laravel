@extends('components.layouts.master')
@section('title', 'Profile')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <div class="rounded-top overflow-hidden d-flex align-items-center" style="height: 300px; width: 100%;">
                            <img src="{{ $background }}" alt="" class="w-100 img-fluid rounded-top">
                        </div>
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="{{ $user->photo }}" style="width: 100px"
                                alt="user image" class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6">{{ $user->name }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="icon-base ti tabler-arrow-badge-down"></i><span class="fw-medium">{{ $user->roles->first()->name ?? 'No Role' }}</span>
                                        </li>
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="icon-base ti tabler-calendar"></i><span class="fw-medium"> Joined {{ formatDate($user->created_at) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary mb-1 waves-effect waves-light">
                                    <i class="ti ti-user-check ti-xs me-2"></i>Connected
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
