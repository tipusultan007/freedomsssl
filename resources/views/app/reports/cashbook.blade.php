
@extends('layouts/layoutMaster')

@section('title', 'Cash Book')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <style>
        h6.transaction-title.cashin-cat,h6.transaction-title.cashout-cat {
            cursor: pointer;
            border-bottom: 1px solid transparent;
        }
        h6.transaction-title.cashin-cat:hover,h6.transaction-title.cashout-cat:hover {
            border-bottom: 1px solid #6EA152;
        }
    </style>
@endsection

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                            <input type="text" id="date_from" name="from" class="form-control flatpickr-basic"
                                   placeholder="Start Date"/>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                            <input type="text" class="form-control flatpickr-basic" name="to"
                                   id="date_to"  placeholder="End Date">
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <button class="btn btn-primary" id="btn-filter" type="button">Filter</button>
                    </div>
                </div>
                <h6 class="text-secondary mt-1">Viewing Data Between: <span class="text-success from"></span> and <span class="text-success to"></span></h6>
            </div>
        </div>
        <div class="row match-height">

            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-transaction">
                    <div class="card-header bg-warning">
                        <h4 class="card-title text-white">Cash Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="transaction-item">
                            <div class="d-flex">
                                <div class="transaction-percentage">
                                    <h6 class="transaction-title">Cash Received</h6>
                                </div>
                            </div>
                            <div class="fw-bolder text-success cash-receieved-total"></div>
                        </div>
                        <div class="transaction-item">
                            <div class="d-flex">
                                <div class="transaction-percentage">
                                    <h6 class="transaction-title">Cash Payments</h6>
                                </div>
                            </div>
                            <div class="fw-bolder text-danger cash-payment-total"></div>
                        </div>
                        <hr>
                        <div class="transaction-item">
                            <div class="d-flex">
                                <div class="transaction-percentage">
                                    <h6 class="transaction-title">Total</h6>
                                </div>
                            </div>
                            <div class="fw-bolder text-indigo-700 cash-summary-total"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-transaction">
                    <div class="card-header bg-success">
                        <h4 class="card-title text-white">Cash Received</h4>
                    </div>
                    <div class="card-body cashin-summary">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-transaction">
                    <div class="card-header bg-danger">
                        <h4 class="card-title text-white">Cash Payments</h4>
                        <div class="dropdown chart-dropdown text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-3 cursor-pointer" data-bs-toggle="dropdown"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Last 28 Days</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body cashout-summary">

                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <!-- Company Table Card -->
            <div id="cashin-report" class="col-lg-12 col-12 d-none">
                <div class="card card-cashin-table">
                    <div class="card-header bg-gradient-success border-bottom p-1">
                        <h4 class="text-white cat-title"></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="cashin-tables table table-xs">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>TRX ID</th>
                                    <th>A/C No</th>
                                    <th>A/C Holder</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="cashout-report" class="col-lg-12 col-12 d-none">
                <div class="card card-cashout-table">
                    <div class="card-header bg-gradient-danger border-bottom p-1">
                        <h4 class="text-white cat-title"></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="cashout-tables table table-xs">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>TRX ID</th>
                                    <th>A/C No</th>
                                    <th>A/C Holder</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Company Table Card -->
        </div>
    </section>
    <!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    <script>

        var from = new Date().toJSON().slice(0, 10);
        var to = new Date().toJSON().slice(0, 10);

        $(".from").text(formatDate(new Date(from)));
        $(".to").text(formatDate(new Date(to)));

        loadCashbook(from,to);

        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return [
                padTo2Digits(date.getDate()),
                padTo2Digits(date.getMonth() + 1),
                date.getFullYear(),
            ].join('/');
        }

        $("#btn-filter").on('click',function () {
            from = $("input[name=from]").val();
            to = $("input[name=to]").val();
            $(".cashin-summary").empty();
            $(".cashout-summary").empty();
            $(".from").text(formatDate(new Date(from)));
            $(".to").text(formatDate(new Date(to)));
            loadCashbook(from,to);
        })

        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        $(document).on('click','.cashin-cat',function () {
                let id = $(this).data('id');
                let title = $(this).text();
                let card_title = $(".cat-title").text();
                if (card_title != title) {
                    $(".cashin-tables").DataTable().destroy();
                    $(".cat-title").text(title);
                    $("#cashin-report").removeClass('d-none');
                    $("#cashout-report").addClass('d-none');
                    loadData(id, from, to);
                }
            })
        $(document).on('click','.cashout-cat',function () {
            let id = $(this).data('id');
            let title = $(this).text();
            let card_title = $(".cat-title").text();
            if (card_title != title) {
                $(".cashout-tables").DataTable().destroy();
                $(".cat-title").text(title);
                $("#cashin-report").addClass('d-none');
                $("#cashout-report").removeClass('d-none');
                loadCashoutData(id, from, to);
            }
        })
        function loadData(id,from,to) {
            $('.cashin-tables').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('cashinByCategory') }}",
                    "data":{cashin_category_id: id, from:from,to:to}
                },
                "columns": [
                    {"data": "date"},
                    {"data": "trx_id"},
                    {"data": "account_no"},
                    {"data": "name"},
                    {"data": "amount"}
                ],
                columnDefs: [
                    {
                        targets: -1,
                        className: 'text-align-right'
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
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: '<i class="ti ti-printer me-2" ></i>Print',
                                className: 'dropdown-item',

                            },
                            {
                                extend: 'csv',
                                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                className: 'dropdown-item',

                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                className: 'dropdown-item',

                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                                className: 'dropdown-item',

                            },
                            {
                                extend: 'copy',
                                text: '<i class="ti ti-copy me-2" ></i>Copy',
                                className: 'dropdown-item',

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
        }
        function loadCashoutData(id,from, to) {
            $('.cashout-tables').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('cashoutByCategory') }}",
                    "data":{cashout_category_id: id, from:from,to:to}
                },
                "columns": [
                    {"data": "date"},
                    {"data": "trx_id"},
                    {"data": "account_no"},
                    {"data": "name"},
                    {"data": "amount"}
                ],
                columnDefs: [
                    /*{
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $date = full['date'],
                                $trx = full['trx_id'];
                            var $row_output = `
                            <div class="fw-bolder">${$date}</div>
<div> ${$trx} </div>
                            `;
                            return $row_output;
                        }
                    },
                    {
                        // User full name and username
                        targets: 1,
                        render: function (data, type, full, meta) {
                            var $ac = full['account_no'],
                                $name = full['name'];
                            var $row_output = `
                            <div class="fw-bolder">${$ac}</div>
<div> ${$name} </div>
                            `;
                            return $row_output;
                        }
                    },*/
                    {
                        targets: -1,
                        className: 'text-align-right'
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
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: '<i class="ti ti-printer me-2" ></i>Print',
                                className: 'dropdown-item',

                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + INDX( 	 �U(�           (   �
  �           �    �          g�    ` L     `�    �W�Z��W�Z�|5�Z�|5�Z�                       a r - a e     j�    ` L     `�    �W�Z��W�Z�|5�Z�|5�Z�                       c a - e s     q�    ` L     `�    �W�Z��W�Z�|5�Z�|5�Z�                       c s - c z     r�    ` L     `�    �W�Z��W�Z�|5�Z�|5�Z�                       d a - d k     u�    ` L     `�    D�Z�D�Z�|5�Z�|5�Z�                      d e - d e     v�    ` L     `�    D�Z�D�Z�|5�Z�|5�Z�                       e n - a e     x�    ` L     `�    D�Z�D�Z�x]�Z�x]�Z�                       e n - g b     y�    ` L     `�    D�Z�D�Z�x]�Z�x]�Z�                       e n - i l     z�    ` L     `�    D�Z�D�Z�x]�Z�x]�Z�                       e s - e s     {�    ` L     `�    D�Z�D�Z�x]�Z�x]�Z�                       e u - e s    |�    ` L     `�    H��Z�H��Z�x]�Z�x]�Z�                       f i - f i     }�    ` L     `�    H��Z�H��Z�x]�Z�x]�Z�                       f r - f r     ~�    ` L     `�    H��Z�H��Z�x]�Z�x]�Z�                       f r - m a     ��    ` L     `�    H��Z�H��Z�h��Z�h��Z�                       h e - i l     ��    ` L     `�    H��Z�H��Z�h��Z�h��Z�                       h r - h r     ��    ` L     `�    H��Z H��Z�h��Z�h��Z�                       h u - h u     ��    ` L     `�    H��Z�H��Z�h��Z�h��Z�                       i t - i t     ��    ` L     `�    8��Z�8��Z�h��Z�h��Z�                       j a - j p     ��    ` L     `�    8��Z�8��Z�h��Z�h��Z�                       k o - k r     ��    ` L     `�    8��Z�8��Z�d��Z�h��Z�                       n b - n o     ��    ` L     `�    8��Z�8��Z�d��Z�d��Z�                      n l - n l     ��    ` L     `�    1�Z�1�Z�d��Z�d��Z�                       p l - p l     ��    ` L     `�    1�Z�1�Z�d��Z�d��Z�                       p t - b r     ��    ` L     `�    1�Z�1�Z�d��Z�d��Z�                       r o - r o     ��    ` J     `�    1�Z�1�Z�d��Z�d��Z�                       r o o t       ��    ` L     `�    "+�Z�"+�Z�d��Z�d��Z�                       r u - r u    ��    ` L     `�    "+�Z�"+�Z�l��Z�l��Z�                       s k - s k     ��    ` L     `�    "+�Z�"+�Z�l��Z�l��Z�                       s l - s i     ��    ` L     `�    "+�Z�"+�Z�l��Z�l��Z�                       s l - s l     ��    ` L     `�    "+�Z�"+�Z�l��Z�l��Z�                       s v - s e     ��    ` L     `�    "+�Z�"+�Z�l��Z�l��Z�                       t r - t r     �    p \     `�    �.P�� �.P����0;�Z��0;�Z�       �              
u i - s t r i n g s . j s     �    h X     `�    �.P����.P����0;�Z��0;�Z�       �              U I - S T R ~ 1 . J S ��    ` L     `�    R�Z�R�Z�l��Z�l��Z�                       u k - u a     ��    ` L     `�    R�Z�R�Z�l��Z�l��Z�                       z h - c n     ��    ` L     `�    R�Z�R�Z�N��Z�N��Z�          
