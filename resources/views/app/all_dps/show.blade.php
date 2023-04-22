@extends('layouts/contentLayoutMaster')

@section('title', 'DPS Details')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <style>
        table.closing-form input{
            padding-right: 28px;
        }
    </style>
@endsection

@section('content')
    <section class="app-user-view-account">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img
                                    class="img-fluid rounded mt-3 mb-2"
                                    src="{{ asset('/images/avatars') }}/{{ $dps->user->profile_photo_path??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>
                                        <a href="{{ url('users') }}/{{ $dps->user_id }}">{{ $dps->user->name }}</a>
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
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Account Details</h4>
                            </div>
                            <div class="card-body">
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
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Opening Date:</span>
                                        <span>{{ $dps->opening_date??'' }}</span>
                                    </li>
                                    <li class="mb-75">
                                        @php
                                            $commencement = \Carbon\Carbon::createFromFormat('Y-m-d',$dps->commencement);
                                        @endphp
                                        <span class="fw-bolder me-25">Commencement:</span>
                                        <span>{{ $commencement->format('d-m-Y') }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Duration:</span>
                                        <span>{{ $dps->duration??'' }}</span>
                                    </li>

                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">status:</span>
                                        <span class="badge bg-light-success">{{ strtoupper($dps->status)??'' }}</span>
                                    </li>
                                    <li>
                                        @php
                                            $closing = \App\Models\ClosingAccount::where('dps_id',$dps->id)->first();
                                        @endphp
                                        @if($dps->status=="active")
                                            <button class="btn btn-danger" id="btn-complete">Make Complete</button>
                                        @else
                                            <button data-id="{{ $closing->id }}" class="btn btn-success" id="btn-active">Make Active</button>
                                        @endif
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Nominee Details</h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $nominee = \App\Models\Nominees::where('account_no',$dps->account_no)->first();
                                @endphp
                                @if($nominee)
                                    <ul class="list-unstyled">
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Name:</span>
                                            <span><a
                                                    href="{{ url('users') }}/{{ $nominee->user_id??'#' }}">{{ $nominee->name??'' }}</a></span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">

                <!-- User Card -->



                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
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
                                    <th>Trx ID</th>
                                    <th>DPS</th>
                                    <th>Late Fee</th>
                                    <th>Other Fee</th>
                                    <th>Month</th>
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
    <div class="modal fade"
         id="modalComplete"
         tabindex="-1"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Closing Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form id="formClosing">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-striped table-bordered closing-form">
                            <tr>
                                <th>Deposited</th> <td class="text-end">{{ $dps->balance }}</td>
                            </tr>
                            <tr>
                                <th>Profit</th> <td class="text-end">{{ $dps->profit }}</td>
                            </tr>
                            <tr>
                                <th>Total</th> <td class="text-end total">{{ $dps->balance + $dps->profit }}</td>
                            </tr>
                            <tr>
                                <th>Service Fee</th> <td class="text-end p-0"><input class="form-control border-0 service_fee text-end" type="number" value="0" name="service_charge"></td>
                            </tr>
                            <tr>
                                <th>Date</th> <td class="text-end p-0"><input type="text" name="date" class="form-control  text-end border-0 flatpickr-basic"></td>
                            </tr>
                        </table>
                        <input type="hidden" name="status" value="active">
                        <input type="hidden" name="user_id" value="{{ $dps->user_id }}">
                        <input type="hidden" name="account_no" value="{{ $dps->account_no }}">
                        <input type="hidden" name="deposit" value="{{ $dps->balance }}">
                        <input type="hidden" name="profit" value="{{ $dps->profit }}">
                        <input type="hidden" name="total" value="{{ $dps->balance + $dps->profit }}">
                        <input type="hidden" name="dps_id" value="{{ $dps->id }}">
                        <input type="hidden" name="created_by" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-paid">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    {{--<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>--}}

    <script>
        $("#btn-complete").on("click",function () {
            $("#modalComplete").modal("show");
        })
        var total =  {{ $dps->balance + $dps->profit }};
        var service_fee = 0;
        $(".service_fee").on("input",function () {
            let fee = $(this).val();
            let tempTotal = total;
            $(".total").text(total-fee);
            $("input[name='total']").val(total-fee);
        })

        $("#btn-paid").on("click",function () {
            var $this = $(".btn-confirm"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button

            $.ajax({
                url: "{{ route('closing-accounts.store') }}",
                method: "POST",
                data: $("#formClosing").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#modalComplete").modal("hide");
                    toastr['success']('DPS has been closed successfully!', 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    $("#modalComplete").modal("hide");
                },
                error: function (data) {
                    $("#modalComplete").modal("hide");
                    $this.attr('disabled', false).html($caption);
                    toastr['error']('DPS closing failed. Please try again.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }
            })
        })
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
                    "url": "{{ url('dataDpsCollection') }}/" + ac,
                },
                "columns": [
                    {"data": "date"},
                    {"data": "trx_id"},
                    {"data": "dps_amount"},
                    {"data": "late_fee"},
                    {"data": "other_fee"},
                    {"data": "month"},
                    {"data": "action"},
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 6,
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

        function loadData(ac = '') {
            $('.taken-loans-table').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('dataTakenLoans') }}",
                    data: {
                        account_no: ac
                    }
                },
                "columns": [
                    {"data": "loan_amount"},
                    {"data": "interest"},
                    {"data": "remain"},
                    {"data": "date"},
                    {"data": "history"},
                    {"data": "action"},
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var id = full['id'];
                            return (
                                '<a href="{{url('taken-loans')}}/' + full['id'] + '" class="item-edit">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4'}) +
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
