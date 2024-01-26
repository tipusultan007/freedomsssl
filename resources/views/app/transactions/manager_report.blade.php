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
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-center fw-bolder text-success">কর্মীদের রিপোর্ট</h3>
      <form action="{{ route('manager.cash.report') }}" method="get" class="mb-3">
        <div class="row">
          <div class="col-md-3 offset-md-2 mb-2">
            <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="{{ $startDate }}">
          </div>
          <div class="col-md-3 mb-2">
            <input type="text" class="form-control datepicker" id="end_date" name="end_date" value="{{ $endDate }}">
          </div>
          <div class="col-md-2 mb-2">
            <button type="submit" class="btn btn-primary">সার্চ করুন</button>
          </div>
        </div>
      </form>
      <hr>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      @if (isset($startDate) && isset($endDate))
        <div class="row mt-3">
          <div class="col-md-12">
            <p class="fw-bolder text-danger text-center">নির্বাচিত তারিখ: {{ date('d/m/Y',strtotime($startDate)) }} - {{ date('d/m/Y',strtotime($endDate)) }}</p>
          </div>
        </div>
      @endif
      <table class="table table-sm table-bordered">
        <thead class="table-light">
        <tr>
          <th class="fw-bolder fs-5 py-2">কর্মীর নাম</th>
          <th class="fw-bolder fs-5 text-center py-2">নগদ গ্রহণ</th>
          <th class="fw-bolder fs-5 text-center py-2">নগদ প্রদান</th>
          <th class="fw-bolder fs-5 text-center py-2">আয়</th>
          <th class="fw-bolder fs-5 text-center py-2">ব্যয়</th>
          <th class="fw-bolder fs-5 text-center py-2">সর্বমোট</th> <!-- New column for total per manager -->
        </tr>
        </thead>
        <tbody>
ata)
        @foreach ($managers as $manager)
          @php
            $managerSummary = $transactionSummary->where('manager_id', $manager->id)->first();
            $income = $reportData[$manager->id]['totalIncome'];
            $expense = $reportData[$manager->id]['totalExpense'];
            $totalIncomeExpense = $reportData[$manager->id]['totalProfit'];
            $totalAmount = $managerSummary ? $managerSummary->total_cashin - $managerSummary->total_cashout : 0;
            //$totalIncomeExpense =( $incomeSummary?$incomes->total_income:0) - ($expenseSummary? $expenses->total_expense:0);
          @endphp

          @if ( $income>0 || $expense>0 || $managerSummary && ($managerSummary->total_cashin  > 0 || $managerSummary->total_cashout > 0))
            <tr>
              <td>{{ $manager->name }}</td>
              <td class="text-end">{{ $managerSummary?number_format($managerSummary->total_cashin,0):0 }}</td>
              <td class="text-end">{{ $managerSummary?number_format($managerSummary->total_cashout,0):0 }}</td>
              <td class="text-end">{{ number_format($income,0) }}</td>
              <td class="text-end">{{ number_format($expense,0) }}</td>
              <td class="text-end">{{ $totalAmount + $totalIncomeExpense }}</td>
            </tr>
          @endif
        @endforeach

        <!-- Totals Row for Each Manager -->
        <tr>
          <td class="text-end fw-bolder">সর্বমোট</td>
          <td class="text-end fw-bolder bg-success text-white">{{ number_format($transactionSummary->sum('total_cashin'),0) }}</td>
          <td class="text-end fw-bolder bg-danger text-white">{{ number_format($transactionSummary->sum('total_cashout'),0) }}</td>
          <td class="text-end fw-bolder bg-success text-white">{{ number_format($totalIncomeData,0) }}</td>
          <td class="text-end fw-bolder bg-danger text-white">{{ number_format($totalExpenseData,0) }}</td>
          <td class="text-end fw-bolder bg-info text-white">{{ $transactionSummary->sum('total_cashin') + $totalIncomeData - $totalExpenseData - $transactionSummary->sum('total_cashout')  }}</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
