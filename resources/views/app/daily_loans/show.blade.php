@extends('layouts/contentLayoutMaster')

@section('title', 'Loan Details')
@section('breadcrumb-menu')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#savingsImportModal">
                        <i class="me-1" data-feather="check-square"></i>
                        <span class="align-middle">Import Savings Collections</span>
                    </a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loanCollectionImportModal">
                        <i class="me-1" data-feather="message-square"></i>
                        <span class="align-middle">Import Daily Loan Collections</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">


    <style>
        .inline-spacing > * {
            margin-top: 14px;
            margin-right: 15px;
        }
    </style>
@endsection

@section('content')
    @php
        $collectors = \App\Models\User::role('super-admin')->get();
    @endphp
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
                                    src="{{ $dailyLoan->user->profile_photo_url??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>
                                        <a href="{{ route('users.show',$dailyLoan->user_id) }}">{{ $dailyLoan->user->name }}</a>
                                    </h4>
                                    <span class="badge bg-light-secondary">{{ $dailyLoan->user->phone1 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $dailyLoan->balance }}</h4>
                                    <small>Loan</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <a
                                class="btn d-block btn-primary me-1"
                                data-bs-toggle="collapse"
                                href="#details"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapseExample"
                            >
                                Account Details
                            </a>
                            <div class="collapse mt-2" id="details">
                                <ul class="list-unstyled">
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">A/C No:</span>
                                        <span>{{ $dailyLoan->account_no??'' }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Opening Date:</span>
                                        <span>{{ $dailyLoan->opening_date??'' }}</span>
                                    </li>
                                    <li class="mb-75">
                                        @php
                                            //$commencement = \Carbon\Carbon::createFromFormat('Y-m-d',$dailySavings->commencement);
                                        $paidLoan = \App\Models\DailyLoanCollection::where('daily_loan_id',$dailyLoan->id)->sum('loan_installment');
                                        @endphp
                                        <span class="fw-bolder me-25">Commencement:</span>
                                        <span >{{ $dailyLoan->commencement }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Paid:</span>
                                        <span>{{ $paidLoan }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Adjusted Amount:</span>
                                        <span>{{ $dailyLoan->adjusted_amount }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Balance:</span>
                                        <span>{{ $dailyLoan->balance }}</span>
                                    </li>


                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">status:</span>
                                        <span class="badge bg-light-success">{{ strtoupper($dailyLoan->status)??'' }}</span>
                                    </li>

                                </ul>
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
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#allTransactions"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan Transactions</span></a>
                    </li>

                </ul>

                <div class="tab-content">
                     <div class="tab-pane active" id="allTransactions" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="loan-transactions table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Late Fee</th>
                                    <th>Other Fee</th>
                                    <th>Balance</th>
                                    <th>Note</th>
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
    <!-- Modal -->
    <div class="modal fade" id="edit-saving-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Savings Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" id="edit-form">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-column">Name</label>: <span class="edit-name text-success"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="last-name-column">A/C No</label>: <span class="edit-account-no text-success"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="city-column">Savings Amount</label>
                                    <input type="number" class="form-control savings_amount" name="saving_amount">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="country-floating">Date</label>
                                    <input type="text" class="form-control date flatpickr-basic" name="date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-column">Late Fee</label>
                                    <input type="number" class="form-control late_fee" name="late_fee">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Other Fee</label>
                                    <input type="number" class="form-control other_fee" name="other_fee">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-column">Savings Type</label>
                                    <select name="type" class="type form-control">
                                        <option value="">- Select Type -</option>
                                        <option value="deposit">Deposit</option>
                                        <option value="withdraw">Withdraw</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Balance</label>
                                    <input type="number" class="form-control balance" name="balance">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-column">Collector</label>
                                    <select name="collector_id" class="collector_id form-control">
                                        <option value="">Select Collector</option>
                                        @foreach($collectors as $collector)
                                            <option
                                                value="{{ $collector->id }}">{{ $collector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Note</label>
                                    <input type="text" class="form-control note" name="note">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-edit" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-loan-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Loan Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" id="edit-loan-form">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-column">Name</label>: <span class="edit-name text-success"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="last-name-column">A/C No</label>: <span class="edit-account-no text-success"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="city-column">Loan Installment</label>
                                    <input type="number" class="form-control loan_installment" name="loan_installment">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="city-column">Installment No</label>
                                    <input type="number" class="form-control installment_no" name="installment_no">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="country-floating">Date</label>
                                    <input type="text" class="form-control date flatpickr-basic" name="date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-column">Late Fee</label>
                                    <input type="number" class="form-control loan_late_fee" name="loan_late_fee">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Other Fee</label>
                                    <input type="number" class="form-control loan_other_fee" name="loan_other_fee">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label">Balance</label>
                                    <input type="number" class="form-control loan_balance" name="loan_balance">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-column">Collector</label>
                                    <select name="collector_id" class="collector_id form-control">
                                        <option value="">Select Collector</option>
                                        @foreach($collectors as $collector)
                                            <option
                                                value="{{ $collector->id }}">{{ $collector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Note</label>
                                    <input type="text" class="form-control loan_note" name="loan_note">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-edit-loan" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="loanCollectionImportModal" tabindex="-1" aria-labelledby="myModalLabel4"
         data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title text-white" id="myModalLabel4">Import Daily Loan Collections</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('daily-loan-collection-import') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                                <label for="formFile" class="form-label">Select Excel File</label>
                                <input class="form-control" name="file" type="file" id="formFile">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--@include('content/_partials/_modals/modal-edit-user')--}}
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

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
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
        var loanId = "{{ $dailyLoan->id }}";

        loadLoanCollection(loanId);
        function loadLoanCollection(loan_id ='')
        {
            $('.loan-transactions').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax":{
                    "url": "{{ url('getLoanCollectionDataByLoan') }}",
                    type: "GET",
                    data: {id:loan_id}
                },
                "columns": [
                    { "data": "date" },
                    { "data": "amount" },
                    { "data": "late_fee" },
                    { "data": "other_fee" },
                    { "data": "balance" },
                    { "data": "note" },
                    { "data": "collector" },
                    { "data": "action" },
                ],
                columnDefs:[
                    {
                        // Actions
                        targets: 7,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-loan-collections')}}/'+full['id']+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item delete-loan-record">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit-loan" data-id="'+full["id"]+'">' +
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
                    }
                ],

            });
        }

        $(document).on("click", ".item-edit-loan", function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('getLoanCollectionData') }}/" + id,
                dataType: "JSON",
                success: function (data) {
                    var user = data.user;
                    $(".edit-name").text(user.name);
                    $(".edit-account-no").text(data.account_no);
                    $(".loan_installment").val(data.loan_installment);
                    $(".installment_no").val(data.installment_no);
                    $(".loan_late_fee").val(data.loan_late_fee);
                    $(".loan_other_fee").val(data.loan_other_fee);
                    $(".loan_balance").val(data.loan_balance);
                    $(".date").val(data.date);
                    $(".collector_id").val(data.collector_id);
                    $("input[name='id']").val(data.id);
                    $(".loan_note").val(data.loan_note);
                    $("#edit-loan-collection-modal").modal("show");
                }
            })
        })
        $(".btn-edit-loan").on("click", function () {
            var id = $("input[name='id']").val();
            var $this = $(".btn-edit-loan"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            $.ajax({
                url: "{{ url('daily-loan-collections') }}/" + id,
                method: "PUT",
                data: $("#edit-loan-form").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#edit-loan-collection-modal").modal("hide");
                    toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    $(".loan-transactions").DataTable().destroy();
                    loadLoanCollection(loanId);

                    resetForm();

                },
                error: function (data) {
                    $("#edit-loan-collection-modal").modal("hide");
                    $this.attr('disabled', false).html($caption);
                    toastr['error']('Submission failed. Please try again.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }
            })
        })
    </script>
@endsection
