@extends('layouts/layoutMaster')

@section('title', __('নগদ গ্রহণ'))
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
    <h4 class="text-success text-center fw-bolder">নগদ গ্রহণ</h4>
    <hr>
    <form id="filter-form">
      <div class="row">
        <div class="col-md-3">
          <label for="date-filter">তারিখ:</label>
          <input type="text" id="date-filter" name="date_filter" class="form-control datepicker" placeholder="Filter by date">
        </div>
        <div class="col-md-3">
          <label for="account-no-filter">হিসাব নং:</label>
          <input type="text" id="account-no-filter" name="account_no_filter" class="form-control" placeholder="Filter by account no">
        </div>
        <div class="col-md-3">
          <label for="transactionable-type-filter">ধরন:</label>
          <select id="transactionable-type-filter" name="transactionable_type_filter" class="form-control select2">
            <option value="">All</option>
            <option value="App\Models\SavingsCollection">দৈনিক সঞ্চয় আদায়</option>
            <option value="App\Models\DailyLoanCollection">দৈনিক ঋণ আদায়</option>
            <option value="App\Models\DpsInstallment">মাসিক সঞ্চয়/ঋন আদায়</option>
            <option value="App\Models\TakenLoan">মাসিক ঋন প্রদান</option>
            <option value="App\Models\SpecialInstallment">বিশেষ সঞ্চয়/ঋন আদায়</option>
            <option value="App\Models\SpecialLoanTaken">বিশেষ ঋন প্রদান</option>
            <option value="App\Models\FdrDeposit">FDR জমা</option>
            <option value="App\Models\FdrWithdraw">FDR উত্তোলন</option>
            <option value="App\Models\FdrProfit">FDR মুনাফা উত্তোলন</option>
            <option value="App\Models\DailySavingsComplete">দৈনিক সঞ্চয় উত্তোলন (নিস্পত্তি)</option>
            <option value="App\Models\DpsComplete">মাসিক সঞ্চয় (DPS) উত্তোলন (নিস্পত্তি)</option>
            <option value="App\Models\SpecialDpsComplete">বিশেষ সঞ্চয় (Special) উত্তোলন (নিস্পত্তি)</option>
            <!-- Add more options for other types as needed -->
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="button" class="btn btn-primary w-50 me-2" onclick="applyFilters()">সার্চ</button>
          <button type="button" class="btn btn-secondary w-50" onclick="resetFilters()">রিসেট</button>
        </div>
      </div>
    </form>

    <br>

    <div class="card">
      <div class="card-body">
        <table id="transactions-table" class="table table-sm table-bordered">
          <thead class="table-light">
          <tr>
            <th class="fw-bolder py-2">তারিখ</th>
            <th class="fw-bolder py-2">ধরন</th>
            <th class="fw-bolder py-2">হিসাব নং</th>
            <th class="fw-bolder py-2">নাম</th>
            <th class="fw-bolder py-2">আদায়কারি</th>
            <th class="fw-bolder py-2">পরিমাণ</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    function applyFilters() {
      $('#transactions-table').DataTable().ajax.reload();
    }

    function resetFilters() {
      $('#date-filter').val('');
      $('#account-no-filter').val('');
      $('#transactionable-type-filter').val('');
      $('#transactions-table').DataTable().ajax.reload();
    }

    $(document).ready(function () {
      /*$('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '{{ route("data.cashin") }}',
          type: 'GET',
          data: function (d) {
            d.date_filter = $('#date-filter').val();
            d.account_no_filter = $('#account-no-filter').val();
            d.transactionable_type_filter = $('#transactionable-type-filter').val();
          }
        },
        columns: [
          { data: 'account_no', name: 'account_no' },
          { data: 'user_id', name: 'user_id' , orderable: false, searchable: false },
          { data: 'type', name: 'type' },
          { data: 'date', name: 'date' },
          { data: 'amount', name: 'amount' , orderable: false, searchable: false },
          { data: 'transactionable_type', name: 'transactionable_type' , orderable: false, searchable: false },
          { data: 'manager', name: 'manager'}
        ]
      });*/
      $('#transactions-table').DataTable({
        "proccessing": true,
        "serverSide": true,
        "order": [[0, 'desc']],
        "ajax": {
          "url": "{{ route('data.cashin') }}",
          data: function (d) {
            d.date_filter = $('#date-filter').val();
            d.account_no_filter = $('#account-no-filter').val();
            d.transactionable_type_filter = $('#transactionable-type-filter').val();
          }
        },
        "columns": [
          { data: 'date', name: 'date' },
          { data: 'transactionable_type', name: 'transactionable_type' , orderable: false, searchable: false },
          { data: 'account_no', name: 'account_no' },
          { data: 'user_id', name: 'user_id' , orderable: false, searchable: false },
          { data: 'manager', name: 'manager' , orderable: false, searchable: false},
          { data: 'amount', name: 'amount' , orderable: false, searchable: false },
        ],
        columnDefs: [
          {
            targets: 5,
            className: 'text-end'
          }
        ],
        dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
          '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
          '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: 'Search',
          searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              }
            ],
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
              $(node).parent().removeClass('btn-group');
              setTimeout(function () {
                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
              }, 50);
            }
          }
        ],

      });
    });
  </script>
@endsection
