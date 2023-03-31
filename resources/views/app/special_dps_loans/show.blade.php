@extends('layouts/contentLayoutMaster')

@section('title', 'Special Loan Details')

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
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
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
                                    src="{{ $specialDpsLoan->user->profile_photo_url??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>
                                        <a href="{{ route('users.show',$specialDpsLoan->user_id) }}">{{ $specialDpsLoan->user->name }}</a>
                                    </h4>
                                    <span class="badge bg-light-secondary">{{ $specialDpsLoan->user->phone1 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $specialDpsLoan->remain_loan }}</h4>
                                    <small>Loan Balance</small>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">A/C No:</span>
                                    <span>{{ $specialDpsLoan->account_no??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    @php
                                        $loans = \App\Models\SpecialLoanTaken::where('account_no',$specialDpsLoan->account_no)->get();
                                        $total_interest = \App\Models\SpecialLoanInterest::where('account_no',$specialDpsLoan->account_no)->sum('total');
                                    @endphp
                                    <span class="fw-bolder me-25">Total Loan:</span>
                                    <span>{{ $loans->sum('loan_amount') }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Total Paid:</span>
                                    <span>{{ $loans->sum('loan_amount') - $loans->sum('remain') }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Remain:</span>
                                    <span>{{ $loans->sum('remain') }}</span>
                                </li>
                                <li class="mb-75">

                                    <span class="fw-bolder me-25">Paid Interest:</span>
                                    <span>{{ $total_interest }}</span>
                                </li>
                                <li class="mb-75">

                                    <span class="fw-bolder me-25">Due Interest:</span>
                                    <span >{{ $specialDpsLoan->dueInterest }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Grace:</span>
                                    <span>{{ $specialDpsLoan->grace }}</span>
                                </li>

                                <li class="mb-75">
                                    <span class="fw-bolder me-25">status:</span>
                                    <span class="badge bg-light-success">{{ strtoupper($specialDpsLoan->status)??'' }}</span>
                                </li>

                            </ul>
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
                    <li class="nav-item ">
                        <a
                            class="nav-link active"
                            id="loans-tab"
                            data-bs-toggle="tab"
                            href="#takenLoans"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan List</span></a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link "
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#savingAccount"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan Transaction</span></a>
                    </li>


                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="takenLoans" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="taken-loans-table table table-sm">
                                <thead>
                                <tr>
                                    <th>Loan</th>
                                    <th>Interest</th>
                                    <th>Remain</th>
                                    <th>Date</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                    <div class="tab-pane " id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="datatables-basic table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Interest</th>
                                    <th>Loan Payment</th>
                                    <th>Balance</th>
                                    <th>Collector</th>
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
    @include('content/_partials/_modals/modal-upgrade-plan')
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
        var ac = "{{ $specialDpsLoan->account_no }}";
        var loanId = "{{ $specialDpsLoan->id }}";

        loadData(loanId);
        function loadData(loanId='')
        {
            $('.taken-loans-table').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('dataSpecialTakenLoans') }}",
                    data: {
                        dps_loan_id: loanId
                    }
                },
                "columns": [
                    { "data": "loan_amount" },
                    { "data": "interest" },
                    { "data": "remain" },
                    { "data": "date" },
                    { "data": "createdBy" },
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
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('taken-loans')}}/'+full['id']+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" class="dropdown-item">' +
                                feather.icons['archive'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Reset</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit">' +
                                feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
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

        loadLoanCollection(loanId);
        //loadLoanCollection();

        function loadLoanCollection(loanId) {

            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('dataSpecialLoanCollection') }}",
                    data: {
                        loanId: loanId
                    }
                },
                "columns": [
                    {"data": "date"},
                    {"data": "interest"},
                    {"data": "loan_installment"},
                    {"data": "balance"},
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
                                '<a href="javascript:;" class="item-loan-delete" data-id="' + full['id'] + '">' +
                                feather.icons['trash'].toSvg({class: 'font-small-4'}) +
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

        $(document).on("click", ".item-loan-delete", function () {
            var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax(
                        {
                            url: "{{ url('special-loan-collections') }}/" + id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response) {

                                //$("#success").html(response.message)
                                toastr['success']('👋 Loan Installment has been deleted successfully.', 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadLoanCollection(loanId);
                            },
                            error: function (data) {
                                toastr['error']('👋 Loan Installment delete failed.', 'Failed!', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                            }
                        });
                }
            });
        })

    </script>
@endsection
