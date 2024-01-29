@extends('layouts/layoutMaster')

@section('title', 'ড্যাশবোর্ড')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/cards-statistics.js')}}"></script>
@endsection

@section('content')
  <div class="row">
    <!-- Statistics -->
    <div class="col-lg-8 mb-4 col-md-12">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-0">পরিসংখ্যান</h5>
          <small class="text-muted"></small>
        </div>
        <div class="card-body pt-2">
          <div class="row gy-3">
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0 dash-font">{{ $data['totalDeposit'] }}</h5>
                  <small>সঞ্চয় জমা</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0 dash-font">{{ $data['totalWithdraw'] }}</h5>
                  <small>সঞ্চয় উত্তোলন</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0 dash-font">{{ $data['totalProfit'] }}</h5>
                  <small>লভ্যাংশ প্রদান</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0 dash-font">{{ $data['totalRemainSavings'] }}</h5>
                  <small>অবশিষ্ট জমা</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Orders -->
    <div class="col-lg-2 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <div class="badge rounded-pill p-2 bg-label-danger mb-2"><i class="ti ti-briefcase ti-sm"></i></div>
          <h5 class="card-title dash-font mb-2">{{ $data['total_loan'] }}</h5>
          <small>ঋণ প্রদান</small>
        </div>
      </div>
    </div>

    <!-- Reviews -->
    <div class="col-lg-2 col-6 mb-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <div class="badge rounded-pill p-2 bg-label-success mb-2"><i class="ti ti-message-dots ti-sm"></i></div>
          <h5 class="card-title mb-2 dash-font">{{ $data['total_loan_return'] }}</h5>
          <small>ঋণ ফেরত</small>
        </div>
      </div>
    </div>

    <!-- Orders last week -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-3">
          <h5 class="card-title mb-0">ঋণ প্রদান</h5>
          <small class="text-muted">গত মাসে</small>
        </div>
        <div class="card-body">
          <div id="ordersLastWeek"></div>
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h4 class="mb-0">124k</h4>
            <small class="text-success">+12.6%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sales last year -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">ঋণ ফেরত</h5>
          <small class="text-muted">গত মাসে</small>
        </div>
        <div id="salesLastYear"></div>
        <div class="card-body pt-0">
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">175k</h4>
            <small class="text-danger">-16.2%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Profit last month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">ঋণের লভ্যাংশ</h5>
          <small class="text-muted">গত মাসে</small>
        </div>
        <div class="card-body">
          <div id="profitLastMonth"></div>
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">624k</h4>
            <small class="text-success">+8.24%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sessions Last month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">স্থায়ী সঞ্চয় জমা</h5>
          <small class="text-muted">গত মাসে</small>
        </div>
        <div class="card-body">
          <div id="sessionsLastMonth"></div>
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">45.1k</h4>
            <small class="text-success">+12.6%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Expenses -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">82.5k</h5>
          <small class="text-muted">স্থায়ী সঞ্চয় উত্তোলন</small>
        </div>
        <div class="card-body">
          <div id="expensesChart"></div>
          <div class="mt-3 text-center">
            <small class="text-muted mt-3">$21k Expenses more than last month</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Impression -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">মুনাফা উত্তোলন</h5>
          <small class="text-muted">গত মাসে</small>
        </div>
        <div class="card-body">
          <div id="impressionThisWeek"></div>
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">26.1k</h4>
            <small class="text-danger">-24.5%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Border Shadow -->

    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-truck ti-md"></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ number_format($data['daily_loan'],0) }}</h4>
          </div>
          <p class="mb-1">দৈনিক ঋণ প্রদান</p>
          <p class="mb-0">
            <span class="fw-medium me-1 text-success">+{{ number_format($data['daily_loan_return'],0) }}</span>
            <small class="text-muted">ঋণ ফেরত</small>
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-warning"><i class='ti ti-alert-triangle ti-md'></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ number_format($data['monthly_loan'],0) }}</h4>
          </div>
          <p class="mb-1">মাসিক ঋণ প্রদান</p>
          <p class="mb-0">
            <span class="fw-medium me-1 text-success">+{{ number_format($data['monthly_loan_return'],0) }}</span>
            <small class="text-muted">ঋণ ফেরত</small>
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card card-border-shadow-danger h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-danger"><i class='ti ti-git-fork ti-md'></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ number_format($data['special_loan'],0) }}</h4>
          </div>
          <p class="mb-1">বিশেষ ঋণ প্রদান</p>
          <p class="mb-0">
            <span class="fw-medium me-1 text-success">+{{ number_format($data['special_loan_return'],0) }}</span>
            <small class="text-muted">ঋণ ফেরত</small>
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card card-border-shadow-info h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2 pb-1">
            <div class="avatar me-2">
              <span class="avatar-initial rounded bg-label-info"><i class='ti ti-clock ti-md'></i></span>
            </div>
            <h4 class="ms-1 mb-0">{{ number_format($data['fdr_profit_withdraw']) }}</h4>
          </div>
          <p class="mb-1">FDR মুনাফা উত্তোলন</p>
          <p class="mb-0">
            <span class="fw-medium me-1">-2.5%</span>
            <small class="text-muted">than last week</small>
          </p>
        </div>
      </div>
    </div>
    <!--/ Card Border Shadow -->
    <!-- Cards with few info -->
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-0 me-2">{{ number_format($data['daily_savings_remain']) }}</h5>
            <small>অবশিষ্ট দৈনিক সঞ্চয়</small>
          </div>
          <div class="card-icon">
          <span class="badge bg-label-primary rounded-pill p-2">
            <i class='ti ti-cpu ti-sm'></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-0 me-2">{{ number_format($data['monthly_savings_remain']) }}</h5>
            <small>অবশিষ্ট মাসিক সঞ্চয়</small>
          </div>
          <div class="card-icon">
          <span class="badge bg-label-success rounded-pill p-2">
            <i class='ti ti-server ti-sm'></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-0 me-2">{{ number_format($data['special_savings_remain']) }}</h5>
            <small>অবশিষ্ট বিশেষ সঞ্চয়</small>
          </div>
          <div class="card-icon">
          <span class="badge bg-label-danger rounded-pill p-2">
            <i class='ti ti-chart-pie-2 ti-sm'></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="card-title mb-0">
            <h5 class="mb-0 me-2">{{ number_format($data['fdr_savings_remain']) }}</h5>
            <small>অবশিষ্ট স্থায়ী সঞ্চয়</small>
          </div>
          <div class="card-icon">
          <span class="badge bg-label-warning rounded-pill p-2">
            <i class='ti ti-alert-octagon ti-sm'></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <!--/ Cards with few info -->

    <!-- Cards with charts & info -->
    <!-- Subscriber Gained -->
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body pb-0">
          <div class="card-icon">
          <span class="badge bg-label-primary rounded-pill p-2">
            <i class='ti ti-users ti-sm'></i>
          </span>
          </div>
          <h5 class="card-title mb-0 mt-2">92.6k</h5>
          <small>Subscribers Gained</small>
        </div>
        <div id="subscriberGained"></div>
      </div>
    </div>

    <!-- Quarterly Sales -->
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body pb-0">
          <div class="card-icon">
          <span class="badge bg-label-danger rounded-pill p-2">
            <i class='ti ti-shopping-cart ti-sm'></i>
          </span>
          </div>
          <h5 class="card-title mb-0 mt-2">36.5%</h5>
          <small>Quarterly Sales</small>
        </div>
        <div id="quarterlySales"></div>
      </div>
    </div>

    <!-- Order Received -->
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body pb-0">
          <div class="card-icon">
          <span class="badge bg-label-warning rounded-pill p-2">
            <i class='ti ti-package ti-sm'></i>
          </span>
          </div>
          <h5 class="card-title mb-0 mt-2">97.5k</h5>
          <small>Order Received</small>
        </div>
        <div id="orderReceived"></div>
      </div>
    </div>

    <!-- Revenue Generated -->
    <div class="col-lg-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-body pb-0">
          <div class="card-icon">
          <span class="badge bg-label-success rounded-pill p-2">
            <i class='ti ti-credit-card ti-sm'></i>
          </span>
          </div>
          <h5 class="card-title mb-0 mt-2">97.5k</h5>
          <small>Revenue Generated</small>
        </div>
        <div id="revenueGenerated"></div>
      </div>
    </div>

    <!-- Average Daily Sales -->
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h5 class="mb-2 card-title">Average Daily Sales</h5>
          <p class="mb-0">Total Sales This Month</p>
          <h5 class="mb-0">$28,450</h5>
        </div>
        <div class="card-body px-0">
          <div id="averageDailySales"></div>
        </div>
      </div>
    </div>

    <!-- Sales Overview -->
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <small class="d-block mb-2 text-muted">Sales Overview</small>
            <p class="card-text text-success">+18.2%</p>
          </div>
          <h4 class="card-title mb-1">$42.5k</h4>
        </div>
        <div class="card-body">
          <div class="row mt-4">
            <div class="col-4">
              <div class="d-flex gap-2 align-items-center mb-2">
                <span class="badge bg-label-info p-1 rounded"><i class="ti ti-shopping-cart ti-xs"></i></span>
                <p class="mb-0">Order</p>
              </div>
              <h5 class="mb-0 pt-1">62.2%</h5>
              <small class="text-muted">6,440</small>
            </div>
            <div class="col-4">
              <div class="divider divider-vertical">
                <div class="divider-text">
                  <span class="badge-divider-bg bg-label-secondary">VS</span>
                </div>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                <p class="mb-0">Visits</p>
                <span class="badge bg-label-primary p-1 rounded"><i class="ti ti-link ti-xs"></i></span>
              </div>
              <h5 class="mb-0 pt-1">25.5%</h5>
              <small class="text-muted">12,749</small>
            </div>
          </div>
          <div class="d-flex align-items-center mt-4">
            <div class="progress w-100" style="height: 8px;">
              <div class="progress-bar bg-info" style="width: 70%" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Avg Daily Traffic -->
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0 d-flex justify-content-between align-items-start">
          <div class="card-title mb-0">
            <h3 class="mb-0">2.84k</h3>
            <small class="text-muted">Avg Daily Traffic</small>
          </div>
          <div class="badge bg-label-success">+92k</div>
        </div>
        <div class="card-body">
          <div id="averageDailyTraffic"></div>
        </div>
      </div>
    </div>

    <!-- Statistics -->
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-start justify-content-between pb-2">
          <h5 class="card-title mb-0">Statistics</h5>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="progressStat" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="progressStat">
              <a class="dropdown-item" href="javascript:void(0);">View More</a>
              <a class="dropdown-item" href="javascript:void(0);">Delete</a>
            </div>
          </div>
        </div>
        <div class="card-body pt-1">
          <div class="d-flex justify-content-between align-items-center mb-2 gap-3 pt-1">
            <h6 class="mb-0">Subscribers Gained</h6>
            <div class="badge bg-label-success">+92k</div>
          </div>
          <div class="d-flex justify-content-between gap-3">
            <p class="mb-0">1.2k new subscriber</p>
            <span class="text-muted">85%</span>
          </div>
          <div class="d-flex align-items-center mt-1">
            <div class="progress w-100" style="height: 8px;">
              <div class="progress-bar bg-primary" style="width: 85%" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-4 mb-2 gap-3 pt-1">
            <h6 class="mb-0">Orders Received</h6>
            <div class="badge bg-label-success">+38k</div>
          </div>
          <div class="d-flex justify-content-between gap-3">
            <p class="mb-0">2.4k new orders</p>
            <span class="text-muted">65%</span>
          </div>
          <div class="d-flex align-items-center mt-1">
            <div class="progress w-100" style="height: 8px;">
              <div class="progress-bar bg-info" style="width: 65%" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Profit -->
    <div class="col-lg-2 col-6 mb-4 mb-lg-0">
      <div class="card h-100">
        <div class="card-body">
          <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-credit-card ti-sm"></i></div>
          <h5 class="card-title mb-1 pt-1">Total Profit</h5>
          <small class="text-muted">Last week</small>
          <p class="mb-2 mt-1">1.28k</p>
          <div class="pt-1">
            <span class="badge bg-label-danger">-12.2%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Sales -->
    <div class="col-lg-2 col-6 mb-4 mb-lg-0">
      <div class="card h-100">
        <div class="card-body">
          <div class="badge p-2 bg-label-success mb-2 rounded"><i class="ti ti-credit-card ti-sm"></i></div>
          <h5 class="card-title mb-1 pt-1">Total Sales</h5>
          <small class="text-muted">Last week</small>
          <p class="mb-2 mt-1">$4,673</p>
          <div class="pt-1">
            <span class="badge bg-label-success">+25.2%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Revenue Growth -->
    <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between">
          <div class="d-flex flex-column">
            <div class="card-title mb-auto">
              <h5 class="mb-1 text-nowrap">Revenue Growth</h5>
              <small>Weekly Report</small>
            </div>
            <div class="chart-statistics">
              <h3 class="card-title mb-1">$4,673</h3>
              <span class="badge bg-label-success">+15.2%</span>
            </div>
          </div>
          <div id="revenueGrowth"></div>
        </div>
      </div>
    </div>

    <!-- Generated Leads -->
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between">
          <div class="d-flex flex-column">
            <div class="card-title mb-auto">
              <h5 class="mb-0 text-nowrap">Generated Leads</h5>
              <small>Monthly Report</small>
            </div>
            <div class="chart-statistics">
              <h3 class="card-title mb-0">4,350</h3>
              <small class="text-success text-nowrap fw-medium"><i class='ti ti-chevron-up me-1'></i> 15.8%</small>
            </div>
          </div>
          <div id="generatedLeadsChart"></div>
        </div>
      </div>
    </div>
    <!--/ Cards with charts & info -->
  </div>
@endsection
