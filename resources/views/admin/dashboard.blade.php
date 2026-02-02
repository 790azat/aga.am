@extends('layouts.admin')

@section('admin')
    <div class="container-fluid px-4">

        @include('layouts.admin-header')

        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        GA4 Active Users (Area Chart)
                    </div>
                    <div class="card-body">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        GA4 Active Users (Bar Chart)
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
