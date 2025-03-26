<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Previous styles remain the same */
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Metrics Cards -->
            <div class="col-12">
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-primary text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h5 class="card-title">Total Suppliers</h5>
                                <h3>{{ $totalSuppliers }}</h3>
                                <p class="card-text"><small>Registered Suppliers</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-success text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <h5 class="card-title">New Suppliers</h5>
                                <h3>{{ $newSuppliersThisMonth }}</h3>
                                <p class="card-text"><small>This Month</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-warning text-dark h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h5 class="card-title">Expiring Contracts</h5>
                                <h3>{{ $expiringContracts }}</h3>
                                <p class="card-text"><small>Next 30 Days</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card dashboard-card bg-info text-white h-100">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5 class="card-title">Supplier Growth</h5>
                                <h3>{{ number_format($supplierGrowthRate, 1) }}%</h3>
                                <p class="card-text"><small>Month-over-Month</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Insights -->
                <div class="row mb-4">
                    <!-- Status Distribution -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">Supplier Status Distribution</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($statusDistribution as $status => $count)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ ucfirst($status) }} Suppliers
                                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Suppliers by State -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">Top Suppliers by State</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($suppliersByState as $stateData)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $stateData->state_id ? 'State ' . $stateData->state_id : 'Unassigned' }}
                                            <span class="badge bg-success rounded-pill">
                                                {{ $stateData->supplier_count }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Suppliers -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">Recent Suppliers</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @foreach($recentSuppliers as $supplier)
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $supplier->name }}</h6>
                                                <small>{{ $supplier->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">{{ $supplier->company_name }}</p>
                                            <small class="text-muted">
                                                <span class="badge {{ $supplier->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($supplier->status) }}
                                                </span>
                                            </small>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Actions and Insights -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <a href="{{ route('suppliers.create') }}" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-plus-circle me-2"></i>Add New Supplier
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-list me-2"></i>Manage Suppliers
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Supplier Insights</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4>{{ $totalSuppliers }}</h4>
                                        <small class="text-muted">Total Suppliers</small>
                                    </div>
                                    <div class="col-4">
                                        <h4>{{ $expiringContracts }}</h4>
                                        <small class="text-muted">Expiring Contracts</small>
                                    </div>
                                    <div class="col-4">
                                        <h4>{{ $newSuppliersThisMonth }}</h4>
                                        <small class="text-muted">New This Month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>