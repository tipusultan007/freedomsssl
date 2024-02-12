@extends('layouts/layoutMaster')
@section('title', 'রিপোর্ট তালিকা')
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
    <h4 class="text-success text-center fw-bolder"> রিপোর্ট তালিকা</h4>
    <hr>
    @include('app.partials.alert_success')
    <div class="card">
      <div class="card-body">
        <form method="GET" action="{{ route('generate.report') }}">
        <div class="row">
          <div class="col-md-4">
            <select name="type" class="form-control select2" id="type" data-placeholder="ধরন">
              <option value="daily_savings">দৈনিক সঞ্চয় রিপোর্ট</option>
              <option value="daily_loans">দৈনিক ঋণ রিপোর্ট</option>
              <option value="dps_savings">মাসিক সঞ্চয় রিপোর্ট</option>
              <option value="dps_loans">মাসিক ঋণ রিপোর্ট</option>
              <option value="special_dps">স্পেশাল সঞ্চয় রিপোর্ট</option>
              <option value="special_loans">স্পেশাল ঋণ রিপোর্ট</option>
              <option value="fdr">স্থায়ী সঞ্চয় রিপোর্ট</option>
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Generate</button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <table class="table table-sm table-striped table-bordered">
      <thead class="table-dark">
      <tr>
        <th class="fw-bolder">রিপোর্ট</th>
        <th class="fw-bolder">স্ট্যাটাস</th>
        <th class="fw-bolder">#</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($exports as $export)
        <tr>
          <td>{{ $export->file_name }}</td>
          <td>
            @if($export->status == 'completed')
              <span class="badge rounded-pill bg-label-success">সম্পন্ন</span>
            @elseif($export->status == 'processing')
              <span class="badge rounded-pill bg-label-warning">প্রক্রিয়াধীন</span>
            @else
              <span class="badge rounded-pill bg-label-danger">ব্যর্থ</span>
            @endif

          </td>
          <td>
           @if($export->status == 'completed')
              <a href="{{ route('exports.download', $export->id) }}" class="btn rounded-pill btn-success waves-effect waves-light"><span class="ti-xs ti ti-download me-1"></span> ডাউনলোড</a>
            @endif
            <form action="{{ route('exports.destroy', $export->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn rounded-pill btn-google-plus waves-effect waves-light" onclick="return confirm('Are you sure you want to delete this export file?')">
                <i class="tf-icons ti ti-trash-x ti-xs me-1"></i>Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <div class="mt-3">
      {{ $exports->links() }}
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
