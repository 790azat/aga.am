@extends('layouts.admin')

@section('admin')
    <div class="container-fluid px-4">

        @include('layouts.admin-header')

        {{-- CHARTS --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Area Chart Example
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
                        Bar Chart Example
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover">
                    {{-- DataTables content --}}
                </table>
            </div>
        </div>

    </div>
@endsection
