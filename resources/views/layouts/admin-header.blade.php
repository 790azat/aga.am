@php
    $segment = request()->segment(2);

    $icons = [
        'dashboard'  => 'gauge-high',
        'moderators' => 'user-tie',
        'films'      => 'video',
        'categories' => 'tags',
        'users'      => 'users',
        'cashier'    => 'cash-register',
        'history'    => 'clock-rotate-left',
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
            {{ $segment }}
        </li>
    </ol>
</nav>
