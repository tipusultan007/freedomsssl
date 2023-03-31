@extends('layouts/contentLayoutMaster')

@section('title', 'Special DPS Details')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')

    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img
                                    class="img-fluid rounded mt-3 mb-2"
                                    src="{{ $dps->user->profile_photo_url??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>
                                        <a href="{{ route('users.show',$dps->user_id) }}">{{ $dps->user->name??"" }}</a>
                                    </h4>
                                    <span class="badge bg-light-secondary">{{ $dps->user->phone1 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $dps->balance }}</h4>
                                    <small>DPS Balance</small>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">A/C No:</span>
                                    <span>{{ $dps->account_no??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">DPS Package:</span>
                                    <span>{{ $dps->dpsPackage->name??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Package Amount:</span>
                                    <span>{{ $dps->package_amount??'' }}</span>
                                </li>
                                @php
                                    $commencement = new \Carbon\Carbon($dps->commencement);
                                    $opening_date = new \Carbon\Carbon($dps->opening_date);
                                @endphp
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Opening Date:</span>
                                    <span>{{ $opening_date->format('d-m-Y') }}</span>
                                </li>
                                <li class="mb-75">

                                    <span class="fw-bolder me-25">Commencement:</span>
                                    <span >{{ $commencement->format('d-m-Y') }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Duration:</span>
                                    <span>{{ $dps->duration??'' }}</span>
                                </li>

                                <li class="mb-75">
                                    <span class="fw-bolder me-25">status:</span>
                                    <span class="badge bg-light-success">{{ strtoupper($dps->status)??'' }}</span>
                                </li>

                            </ul>
                            @php
                            $nominee = \App\Models\Nominees::where('account_no',$dps->account_no)->first();
                            @endphp
                            @if($nominee)
                                <h4 class="mt-2">Nominee Information</h4>
                                <hr>
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Name:</span>
                                    <span><a href="{{ url('users') }}/{{ $nominee->user_id??'#' }}">{{ $nominee->name??'' }}</a></span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Phone:</span>
                                    <span>{{ $nominee->phone??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Name:</span>
                                    <span>{{ $nominee->address??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Relation:</span>
                                    <span>{{ $nominee->relation??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Percentage:</span>
                                    <span>{{ $nominee->percentage.'%'??'' }}</span>
                                </li>
                            </ul>
                            @endif
                            <div class="d-flex justify-content-center pt-2">
                                <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser"
                                   data-bs-toggle="modal">
                                    Edit
                                </a>
                                <a href="javascript:;" class="btn btn-outline-danger suspend-user">Suspended</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">
                <!-- User Pills -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#savingAccount"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">DPS Transaction</span></a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="loans-tab"
                            data-bs-toggle="tab"
                            href="#loanAccount"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan List</span></a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="datatables-basic table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Installment</th>
                                    <th>Month</th>
                                    <th>Trx ID</th>
                                    <th>Collector</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                    <div class="tab-pane " id="loanAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="taken-loans-table table table-sm">
                                <thead>
                                <tr>
                                    <th>Loan</th>
                                    <th>Interest</th>
                                    <th>Remain</th>
                                    <th>Date</th>
                                    <th>History</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>
    </section>

@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    {{-- data table --}}
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    {{--<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>--}}

    <script>
        // Variable declaration for table
        var dtAccountsTable = $('.datatable-accounts'),
            dtLoansTable = $('.datatable-loans'),
            invoicePreview = 'app-invoice-preview.html',
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
            invoicePreview = assetPath + 'app/invoice/preview';
        }
        var ac = "{{ $dps->account_no }}";

        loadSavingsCollection(ac);
        //loadLoanCollection();

        function loadSavingsCollection(ac) {

            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('dataSpecialDpsCollection') }}/"+ac,
                },
                "columns": [
                    {"data": "date"},
                    {"data": "dps_amount"},
                    {"data": "month"},
                    {"data": "trx_id"},
                    {"data": "collector"},
                    {"data": "action"},
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-savings')}}/' + full['id'] + '" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit" data-id="' + full['id'] + '">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4'}) +
                                '</a>'
                            );
                        }
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
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
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
        loadData(ac);
        function loadData(ac='')
        {
            $('.taken-loans-table').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('dataSpecialTakenLoans') }}",
                    data: {
                        account_no: ac
                    }
                },
                "columns": [
                    { "data": "loan_amount" },
                    { "data": "interest" },
                    { "data": "remain" },
                    { "data": "date" },
                    { "data": "history" },
                    { "data": "action" },
                ],
                columnDefs:[
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var id = full['id'];
                            return (
                                '<a href="{{url('special-loan-takens')}}/'+full['id']+'" class="item-edit">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                                '</a>'

                            );
                        }
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
                        text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                            }, 50);
                        }
                    },
                    {
                        text: 'Add New User',
                        className: 'add-new btn btn-primary',
                        attr: {
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#modals-slide-in'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],

            });
        }
    </script>
@endsection
