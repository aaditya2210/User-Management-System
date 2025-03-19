@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary border-bottom pb-3"> Analytics Dashboard</h2>
        </div>
    </div>

    <div class="row g-4">
        <!-- Summary Cards -->
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="fas fa-users text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Users</h6>
                                <h3 class="mb-0 fw-bold" id="totalUsers">--</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="fas fa-truck text-success fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Suppliers</h6>
                                <h3 class="mb-0 fw-bold" id="totalSuppliers">--</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="fas fa-handshake text-info fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Customers</h6>
                                <h3 class="mb-0 fw-bold" id="totalCustomers">--</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart - User Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">User-Supplier-Customer Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="piechart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Bar Chart: Supplier Status -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Supplier Status Breakdown</h5>
                </div>
                <div class="card-body">
                    <div id="barchart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Suppliers by State -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Suppliers by State</h5>
                </div>
                <div class="card-body">
                    <div id="statechart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Suppliers by City -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Suppliers by City</h5>
                </div>
                <div class="card-body">
                    <div id="citychart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- CUSTOMER DATA SECTION -->
    <div class="row mb-4 mt-4">
        <div class="col-12">
            <h3 class="fw-bold text-info border-bottom pb-3">Customer Analytics</h3>
        </div>
    </div>

    <div class="row g-4">
        <!-- Customer Type Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Customer Type Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="customerTypePie" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Customer Gender Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Customer Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="customerGenderPie" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Customer Preferred Contact Method -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Preferred Contact Methods</h5>
                </div>
                <div class="card-body">
                    <div id="contactMethodChart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Customer Balance Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Customer Balance Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="balanceDistChart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Customer Nationality Distribution -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Top Customer Nationalities</h5>
                </div>
                <div class="card-body">
                    <div id="nationalityChart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Last Updated Section -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-end">
                <small class="text-muted me-2">Last updated:</small>
                <small class="text-muted" id="lastUpdated">--</small>
                <div class="spinner-border spinner-border-sm text-primary ms-2 d-none" id="refreshSpinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Load Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:['corechart', 'bar']});
    
    document.addEventListener("DOMContentLoaded", function() {
        fetchChartData();
    });

    function fetchChartData() {
        // Show loading spinner
        document.getElementById('refreshSpinner').classList.remove('d-none');
        
        fetch("{{ route('chart.data') }}")
            .then(response => response.json())
            .then(data => {
                console.log("Chart Data:", data);
                updateSummaryCards(data);
                drawCharts(data);
                drawCustomerCharts(data);
                updateLastUpdated();
                
                // Hide loading spinner
                document.getElementById('refreshSpinner').classList.add('d-none');
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                document.getElementById('refreshSpinner').classList.add('d-none');
            });
    }

    function updateSummaryCards(data) {
        document.getElementById('totalUsers').textContent = data.totalUsers || 0;
        document.getElementById('totalSuppliers').textContent = data.totalSuppliers || 0;
        document.getElementById('totalCustomers').textContent = data.totalCustomers || 0;
    }

    function updateLastUpdated() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString();
        document.getElementById('lastUpdated').textContent = timeStr;
    }

    function drawCharts(data) {
        google.charts.setOnLoadCallback(() => {
            // Pie Chart Data (Users, Suppliers, Customers)
            var pieData = google.visualization.arrayToDataTable([
                ['Type', 'Count'],
                ['Users', data.totalUsers || 0],
                ['Suppliers', data.totalSuppliers || 0],
                ['Customers', data.totalCustomers || 0]
            ]);

            var pieOptions = {
                pieHole: 0.4,
                colors: ['#4e73df', '#1cc88a', '#36b9cc'],
                chartArea: {width: '90%', height: '90%'},
                legend: {position: 'right'},
                animation: {startup: true, duration: 1500, easing: 'out'}
            };

            var pieChart = new google.visualization.PieChart(document.getElementById('piechart'));
            pieChart.draw(pieData, pieOptions);

            // Bar Chart Data (Supplier Status)
            var barData = google.visualization.arrayToDataTable([
                ['Status', 'Count', {role: 'style'}],
                ['Active', data.supplierStatusData.active || 0, '#1cc88a'],
                ['Inactive', data.supplierStatusData.inactive || 0, '#e74a3b']
            ]);

            var barOptions = {
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'},
                animation: {startup: true, duration: 1000, easing: 'inAndOut'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var barChart = new google.visualization.ColumnChart(document.getElementById('barchart'));
            barChart.draw(barData, barOptions);

            // Suppliers by State Chart
            var stateData = [['State Name', 'Suppliers', {role: 'style'}]];
            data.supplierStateData.forEach((state, index) => {
                const colorGradient = `rgb(${40 + (index * 15)}, ${115 + (index * 5)}, ${220 - (index * 15)})`;
                stateData.push([state.state_name, state.count, colorGradient]);
            });

            var stateOptions = {
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'},
                animation: {startup: true, duration: 1200, easing: 'linear'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var stateChart = new google.visualization.ColumnChart(document.getElementById('statechart'));
            stateChart.draw(google.visualization.arrayToDataTable(stateData), stateOptions);

            // Suppliers by City Chart
            var cityData = [['City Name', 'Suppliers', {role: 'style'}]];
            data.supplierCityData.forEach((city, index) => {
                const colorGradient = `rgb(${20 + (index * 10)}, ${130 + (index * 5)}, ${180 - (index * 10)})`;
                cityData.push([city.city_name, city.count, colorGradient]);
            });

            var cityOptions = {
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'},
                animation: {startup: true, duration: 1200, easing: 'linear'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var cityChart = new google.visualization.ColumnChart(document.getElementById('citychart'));
            cityChart.draw(google.visualization.arrayToDataTable(cityData), cityOptions);
        });
    }

    function drawCustomerCharts(data) {
        google.charts.setOnLoadCallback(() => {
            // Customer Type Pie Chart
            var customerTypeData = new google.visualization.DataTable();
            customerTypeData.addColumn('string', 'Customer Type');
            customerTypeData.addColumn('number', 'Count');
            
            data.customerTypeData.forEach(item => {
                customerTypeData.addRow([item.customer_type, item.count]);
            });

            var customerTypeOptions = {
                pieHole: 0.4,
                colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                chartArea: {width: '90%', height: '90%'},
                legend: {position: 'right'},
                animation: {startup: true, duration: 1500, easing: 'out'}
            };

            var customerTypePie = new google.visualization.PieChart(document.getElementById('customerTypePie'));
            customerTypePie.draw(customerTypeData, customerTypeOptions);

            // Customer Gender Pie Chart
            var customerGenderData = new google.visualization.DataTable();
            customerGenderData.addColumn('string', 'Gender');
            customerGenderData.addColumn('number', 'Count');
            
            data.customerGenderData.forEach(item => {
                customerGenderData.addRow([item.gender || 'Not Specified', item.count]);
            });

            var customerGenderOptions = {
                pieHole: 0.4,
                colors: ['#4e73df', '#e74a3b', '#1cc88a'],
                chartArea: {width: '90%', height: '90%'},
                legend: {position: 'right'},
                animation: {startup: true, duration: 1500, easing: 'out'}
            };

            var customerGenderPie = new google.visualization.PieChart(document.getElementById('customerGenderPie'));
            customerGenderPie.draw(customerGenderData, customerGenderOptions);

            // Contact Method Column Chart
            var contactMethodData = [['Contact Method', 'Count', {role: 'style'}]];
            data.customerContactMethodData.forEach((method, index) => {
                const colorGradient = `rgb(${20 + (index * 20)}, ${100 + (index * 20)}, ${200 - (index * 20)})`;
                contactMethodData.push([method.preferred_contact_method || 'Not Specified', method.count, colorGradient]);
            });

            var contactMethodOptions = {
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'},
                animation: {startup: true, duration: 1200, easing: 'linear'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var contactMethodChart = new google.visualization.ColumnChart(document.getElementById('contactMethodChart'));
            contactMethodChart.draw(google.visualization.arrayToDataTable(contactMethodData), contactMethodOptions);

            // Customer Balance Distribution Chart
            var balanceData = new google.visualization.DataTable();
            balanceData.addColumn('string', 'Balance Range');
            balanceData.addColumn('number', 'Count');
            balanceData.addColumn({type: 'string', role: 'style'});
            
            balanceData.addRow(['Low (0 - 1,000)', data.customerBalanceData['Low (0 - 1,000)'] || 0, '#1cc88a']);
            balanceData.addRow(['Medium (1,001 - 10,000)', data.customerBalanceData['Medium (1,001 - 10,000)'] || 0, '#f6c23e']);
            balanceData.addRow(['High (10,001+)', data.customerBalanceData['High (10,001+)'] || 0, '#4e73df']);

            var balanceOptions = {
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'},
                animation: {startup: true, duration: 1200, easing: 'linear'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var balanceChart = new google.visualization.ColumnChart(document.getElementById('balanceDistChart'));
            balanceChart.draw(balanceData, balanceOptions);

            // Nationality Chart - Show top 10 nationalities
            var nationalityData = [['Nationality', 'Count', {role: 'style'}]];
            
            // Get only the top 10 nationalities
            const topNationalities = data.customerNationalityData.slice(0, 10);
            
            topNationalities.forEach((nat, index) => {
                const colorGradient = `rgb(${50 + (index * 15)}, ${100 + (index * 10)}, ${180 - (index * 10)})`;
                nationalityData.push([nat.nationality || 'Not Specified', nat.count, colorGradient]);
            });

            var nationalityOptions = {
                legend: {position: 'none'},
                chartArea: {width: '90%', height: '80%'},
                animation: {startup: true, duration: 1200, easing: 'linear'},
                hAxis: {gridlines: {color: 'transparent'}},
                vAxis: {gridlines: {color: '#f8f9fc'}}
            };

            var nationalityChart = new google.visualization.BarChart(document.getElementById('nationalityChart'));
            nationalityChart.draw(google.visualization.arrayToDataTable(nationalityData), nationalityOptions);
        });
    }

    // Auto-refresh every 3 minutes (180000 milliseconds)
    setInterval(fetchChartData, 180000);
</script>
@endsection