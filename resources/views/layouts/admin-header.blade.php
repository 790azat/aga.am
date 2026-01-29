@php
    $segment = request()->segment(2);

    $icons = [
        'dashboard'  => 'gauge-high',
        'moderators' => 'user-tie',
        'films'     => 'video',
        'users'      => 'users',
        'cashier'      => 'cash-register',
        'history'      => 'clock-rotate-left',
        'settings'   => 'gear',
    ];

    // default icon if not found
    $icon = $icons[$segment] ?? 'circle';
@endphp

<h1 class="mt-4 text-capitalize">
    <i class="fa-solid fa-{{ $icon }} me-1"></i> {{ $segment }}
</h1>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active text-capitalize">
            {{ request()->segment(2) }}
        </li>
    </ol>
</nav>

{{-- CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">Primary Card</div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">Warning Card</div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white h-100">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>
