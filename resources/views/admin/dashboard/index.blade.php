@extends('layout.index')

@section('content')
<style>
    /* Custom Black & Green Theme */

    .bg-green-primary {
        background: linear-gradient(135deg, #00ff88, #00cc6a) !important;
    }

    .bg-green-secondary {
        background: linear-gradient(135deg, #28a745, #20c997) !important;
    }

    .bg-green-dark {
        background: linear-gradient(135deg, #155724, #1e7e34) !important;
    }

    .bg-green-light {
        background: linear-gradient(135deg, #40e0d0, #00ff88) !important;
    }

    .card-dark {
        background-color: #2d2d2d !important;
        border: 1px solid #404040 !important;
    }

    .card-header-dark {
        background-color: #1a1a1a !important;
        border-bottom: 1px solid #00ff88 !important;
        color: #00ff88 !important;
    }

    .text-green {
        color: #00ff88 !important;
    }

    .breadcrumb-dark {
        background-color: #2d2d2d !important;
        border-radius: 8px !important;
        padding: 12px 16px !important;
    }

    .breadcrumb-dark .breadcrumb-item {
        color: #00ff88 !important;
    }

    .breadcrumb-dark .breadcrumb-item.active {
        color: #ffffff !important;
    }

    .table-dark-custom {
        background-color: #2d2d2d !important;
        color: #ffffff !important;
    }

    .table-dark-custom th {
        background-color: #1a1a1a !important;
        color: #00ff88 !important;
        border-color: #404040 !important;
    }

    .table-dark-custom td {
        border-color: #404040 !important;
    }

    .dashboard-title {
        color: #00ff88 !important;
        text-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
        font-weight: bold;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 255, 136, 0.2);
        transition: all 0.3s ease;
    }

    .icon-green {
        color: #00ff88 !important;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    .chart-container {
        background-color: #1a1a1a !important;
        border-radius: 8px;
        padding: 20px;
    }
</style>

<div class=" min-vh-100 p-4">
    <h1 class="mt-4 dashboard-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Admin Dashboard
    </h1>

    <ol class="breadcrumb mb-4 breadcrumb-dark">
        <li class="breadcrumb-item active">
            <i class="fas fa-home me-1"></i>
            Dashboard
        </li>
    </ol>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-green-primary text-white card-hover">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">150</div>
                        <div class="fw-bold">Total Users</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-users fa-3x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        <i class="fas fa-eye me-1"></i>
                        View Details
                    </a>
                    <div class="small text-white">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-green-secondary text-white card-hover">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">85</div>
                        <div class="fw-bold">Active Orders</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-shopping-cart fa-3x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        <i class="fas fa-eye me-1"></i>
                        View Details
                    </a>
                    <div class="small text-white">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-green-dark text-white card-hover">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">42</div>
                        <div class="fw-bold">Products</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-box fa-3x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        <i class="fas fa-eye me-1"></i>
                        View Details
                    </a>
                    <div class="small text-white">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-green-light text-white card-hover">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">$12.5K</div>
                        <div class="fw-bold">Revenue</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-dollar-sign fa-3x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        <i class="fas fa-eye me-1"></i>
                        View Details
                    </a>
                    <div class="small text-white">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card card-dark mb-4">
                <div class="card-header card-header-dark">
                    <i class="fas fa-chart-area me-2 icon-green"></i>
                    <strong>Sales Analytics</strong>
                </div>
                <div class="card-body chart-container">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card card-dark mb-4">
                <div class="card-header card-header-dark">
                    <i class="fas fa-chart-bar me-2 icon-green"></i>
                    <strong>Monthly Revenue</strong>
                </div>
                <div class="card-body chart-container">
                    <canvas id="myBarChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card card-dark mb-4">
        <div class="card-header card-header-dark">
            <i class="fas fa-table me-2 icon-green"></i>
            <strong>Data Management</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-dark-custom table-striped table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user me-1"></i>Name</th>
                            <th><i class="fas fa-briefcase me-1"></i>Position</th>
                            <th><i class="fas fa-building me-1"></i>Office</th>
                            <th><i class="fas fa-calendar me-1"></i>Age</th>
                            <th><i class="fas fa-calendar-alt me-1"></i>Start Date</th>
                            <th><i class="fas fa-money-bill me-1"></i>Salary</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start Date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Optional: Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Add glow effect to cards on hover
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 0 20px rgba(0, 255, 136, 0.4)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 10px 20px rgba(0, 255, 136, 0.2)';
            });
        });
    });
</script>
@endsection