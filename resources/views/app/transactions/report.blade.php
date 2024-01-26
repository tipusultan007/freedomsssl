@extends('layouts/layoutMaster')

@section('title', __('ক্যাশ রিপোর্ট'))
@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
@endsection
@section('content')
  @php
    $totalCashin = 0;
    $totalCashout = 0;
    $totalIncome = 0;
    $totalExpense = 0;
  @endphp
  <div class="container-fluid">
    <h3 class="text-center fw-bolder text-success">ক্যাশ রিপোর্ট</h3>
    <hr>
    <form action="{{ route('cash.report') }}" method="get">
      <div class="row mb-3 mx-auto">
        <div class="col-md-3 offset-md-2 mb-2 ">
          <input type="text" id="start_date" name="start_date" class="form-control datepicker"
                 value="{{ old('start_date', $startDate) }}">
        </div>
        <div class="col-md-3 mb-2">
          <input type="text" id="end_date" name="end_date" class="form-control datepicker"
                 value="{{ old('end_date', $endDate) }}">
        </div>
        <div class="col-md-3 mb-2">
          <button type="submit" class="btn btn-primary">ফিল্টার</button>
        </div>
      </div>
      @if (isset($startDate) && isset($endDate))
        <div class="row mt-3">
          <div class="col-md-12">
            <p class="fw-bolder text-danger text-center">নির্বাচিত তারিখ: {{ date('d/m/Y',strtotime($startDate)) }}
              - {{ date('d/m/Y',strtotime($endDate)) }}</p>
          </div>
        </div>
      @endif
    </form>
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-header bg-success py-0">
                <h4 class="card-title text-white py-2 mb-0">নগদ গ্রহণ</h4>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-bordered table-striped">
                  @foreach ($renamedCashinSums as $sum)
                    @php
                      $totalCashin += $sum->sum_amount;
                    @endphp
                    <tr>
                      <th class="fw-bolder py-2">{{ $sum->renamed_type }}</th>
                      <td class="text-end">{{ number_format($sum->sum_amount,0) }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-header py-0 bg-danger">
                <h4 class="card-title text-white py-2 mb-0">নগদ প্রদান</h4>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-bordered table-striped">
                  @foreach ($renamedCashoutSums as $sum)
                    @php
                      $totalCashout += $sum->sum_amount;
                    @endphp
                    <tr>
                      <th class="fw-bolder py-2">{{ $sum->renamed_type }}</th>
                      <td class="text-end">{{ number_format($sum->sum_amount,0) }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-header py-0 bg-success">
                <h4 class="card-title text-white py-2 mb-0">সকল আয়</h4>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-bordered table-striped">
                  @foreach ($summaryIncomeData as $income)
                    @php
                      $totalIncome += $income['total_amount'];
                    @endphp
                    <tr>
                      <th class="fw-bolder py-2">{{ $income['category_name'] }}</th>
                      <td class="text-end">{{ $income['total_amount'] }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-header py-0 bg-danger">
                <h4 class="card-title text-white py-2 mb-0">সকল ব্যয়</h4>
              </div>
              <div class="card-body p-0">
                <table class="table table-sm table-bordered table-striped">
                  @foreach ($summaryExpenseData as $expense)
                    @php
                      $totalExpense += $expense['total_amount'];
                    @endphp
                    <tr>
                      <th class="fw-bolder py-2">{{ $expense['category_name'] }}</th>
                      <td class="text-end">{{ $expense['total_amount'] }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body p-0">
            <table class="table table-sm table-bordered">
              <tr>
                <th class="py-2 fw-bolder fs-5 text-success">নগদ গ্রহণ</th>
                <td class="text-end fw-bolder fs-5 text-success">{{ $totalCashin }}</td>
              </tr>
              <tr>
                <th class="py-2 fw-bolder fs-5 text-danger">নগদ প্রদান</th>
                <td class="text-end fw-bolder fs-5 text-danger">{{ $totalCashout }}</td>
              </tr>
              <tr>
                <th class="py-2 fw-bolder fs-5 text-success">আয়</th>
                <td class="text-end fw-bolder fs-5 text-success">{{ $totalIncome }}</td>
              </tr>
              <tr>
                <th class="py-2 fw-bolder fs-5 text-danger">ব্যয়</th>
                <td class="text-end fw-bolder fs-5 text-danger">{{ $totalExpense }}</td>
              </tr>
              <tr>
                <th class="text-end py-2 fw-bolder fs-5">সর্বমোট =</th>
                <td class="text-end text-white bg-primary fs-5">{{ $totalCashin - $totalCashout + $totalIncome - $totalExpense}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
