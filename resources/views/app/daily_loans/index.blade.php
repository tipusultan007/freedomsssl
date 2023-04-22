
@extends('layouts/contentLayoutMaster')

@section('title', 'Daily Loans')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/modal-create-app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">


@endsection
@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <a class="dropdown-item" href="#" data-bs-toggle="modal"
           data-bs-target="#loanCollectionImportModal">
            <i class="me-1" data-feather="message-square"></i>
            <span class="align-middle">Import Daily Loan Collections</span>
        </a>
        <div class="modal fade text-start" id="loanCollectionImportModal" tabindex="-1" aria-labelledby="myModalLabel4"
             data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h4 class="modal-title text-white" id="myModalLabel4">Import Daily Loan Collections</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('daily-loan-import') }}" method="POST"
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>A/C No</th>
                            <th>Loan Amount</th>
                           {{-- <th>Interest</th>--}}
                            <th>Adjust Amount</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
    </section>
    <!--/ Basic table -->


    <!-- create app modal -->
    <div class="modal fade" id="createLoanModal" tabindex="-1" aria-labelledby="createAppTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-3 px-sm-3">
                    <h1 class="text-center mb-1" id="createAppTitle">Add New Special Loan</h1>
                    <p class="text-center mb-2">Provide Loan details with this form</p>

                    <div class="bs-stepper vertical wizard-modern create-app-wizard">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#create-app-details" role="tab" id="create-app-details-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="book" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Loan</span>
                  <span class="bs-stepper-subtitle">Loan Details</span>
                </span>
                                </button>
                            </div>
                            <div class="step" data-target="#create-app-frameworks" role="tab" id="create-app-frameworks-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="package" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Documents</span>
                  <span class="bs-stepper-subtitle">Document Details</span>
                </span>
                                </button>
                            </div>
                            <div class="step" data-target="#create-app-database" role="tab" id="create-app-database-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="command" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Guarantor</span>
                  <span class="bs-stepper-subtitle">Guarantor details</span>
                </span>
                                </button>
                            </div>

                            <div class="step" data-target="#create-app-submit" role="tab" id="create-app-submit-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="check" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Submit</span>
                  <span class="bs-stepper-subtitle">Submit your app</span>
                </span>
                                </button>
                            </div>
                        </div>

                        <!-- content -->
                        <div class="bs-stepper-content shadow-none">
                            <div id="create-app-details" class="content" role="tabpanel" aria-labelledby="create-app-details-trigger">
                                <form>
                                    <div class="row mb-3">
                                        @php
                                            $accounts = \App\Models\DailySavings::with('user')->where('status','active')->orderBy('account_no','asc')->get();
                                            $users = \App\Models\User::all();
                                            $dailyLoanPackages = \App\Models\DailyLoanPackage::all();
                                        @endphp
                                        <div class="col-md-8 mb-0">
                                            <label for="account_no" class="form-label">A/C No</label>
                                            <select data-allow-clear="true" name="account_no" id="account_no" data-placeholder="-- Select A/C --" class="select2-size-sm form-select">
                                                <option value=""></option>
                                                @forelse($accounts as $account)
                                                    <option value="{{ $account->account_no }}">{{ $account->account_no }}
                                                        || {{ $account->user->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-0">
                                            <label for="loan_amount" class="form-label">Loan Amount</label>
                                            <input type="number" class="form-control form-control-sm" id="loan_amount" name="loan_amount">
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="package_id" class="form-label">Package</label>
                                            <select name="package_id" id="package_id" data-placeholder="-- Select Package --" data-allow-clear="true" class="select2-size-sm form-select">
                                                <option value=""></option>
                                                @forelse($dailyLoanPackages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->months }} || {{ $package->interest }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <input type="hidden" name="user_id" id="user_id">
                                        <div class="col-md-4 mb-0">
                                            <label for="interest" class="form-label">Interest</label>
                                            <input type="number" class="form-control form-control-sm" id="interest" name="interest">
                                        </div>
                                        <input type="hidden" name="balance" id="loan_balance">
                                        <div class="col-md-4 mb-0">
                                            <label for="per_installment" class="form-label">Per Installment</label>
                                            <input type="number" class="form-control form-control-sm" id="per_installment" name="per_installment">
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="account_no" class="form-label">Opening Date</label>
                                            <input type="text" class="form-control form-control-sm flatpickr-basic" id="opening_date"
                                                   name="opening_date" aria-label="MM/DD/YYYY">
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label for="account_no" class="form-label">Commencement</label>
                                            <input type="text" class="form-control form-control-sm flatpickr-basic" id="commencement"
                                                   name="commencement" aria-label="MM/DD/YYYY">
                                        </div>


                                        <div class="col-md-12 mb-0">
                                            <label for="account_no" class="form-label">Note</label>
                                            <input type="text" class="form-control form-control-sm" id="note"
                                                   name="note">
                                        </div>
                                    </div>
                                </form>


                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                id="create-app-frameworks"
                                class="content"
                                role="tabpanel"
                                aria-labelledby="create-app-frameworks-trigger"
                            >
                                <h5 class="mb-1">Document Details</h5>
                                <form>
                                    <div class="row mb-3">

                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">
                                                <label for="bank_name" class="form-label">Bank Name</label>
                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="branch_name" placeholder="Branch Name" name="branch_name">
                                                <label for="branch_name" class="form-label">Branch Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="cheque_no" placeholder="Cheque No" name="cheque_no">
                                                <label for="cheque_no" class="form-label">Cheque No</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <label for="document_name" class="form-label">Upload Documents</label>
                                            <input class="form-control" type="file" name="document_name" id="document_name"
                                                   multiple/>
                                        </div>

                                    </div>
                                </form>
                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="create-app-database" class="content" role="tabpanel" aria-labelledby="create-app-database-trigger">
                                <h5 class="mb-1">Enter Guarantor Details</h5>
                                <form>
                                    @php
                                        $users = \App\Models\User::all();
                                    @endphp
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="name">Select User</label>
                                            <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-placeholder="-- Select User --">
                                                <option value=""></option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                   placeholder="John"/>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="phone">Phone</label>
                                            <input type="text" name="phone" id="phone" class="form-control"/>
                                        </div>

                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="address">Address</label>
                                            <input type="text" name="address" id="address" class="form-control"/>
                                        </div>

                                    </div>
                                </form>
                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>

                            <div
                                id="create-app-submit"
                                class="content text-center"
                                role="tabpanel"
                                aria-labelledby="create-app-submit-trigger"
                            >
                                <h3>Submit 🥳</h3>
                                <p>Submit your app to kickstart your project.</p>
                                <img
                                    src="{{asset('images/illustration/pricing-Illustration.svg')}}"
                                    height="218"
                                    alt="illustration"
                                />
                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-success btn-submit">
                                        <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                        <i data-feather="check" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / create app modal -->
@endsection


@section('vendor-script')
    {{-- vendor files --}}
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
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>


    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>


@endsection
@section('page-script')
    {{-- Page js files --}}
{{--
    <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>
--}}
    <script>
        var dt_basic_table = $('.datatables-basic'),
            dt_date_table = $('.dt-date'),
            dt_complex_header_table = $('.dt-complex-header'),
            dt_row_grouping_table = $('.dt-row-grouping'),
            dt_multilingual_table = $('.dt-multilingual'),
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
        }

        // DataTable with buttons
        // --------------------------------------------------------------------

        if (dt_basic_table.length) {
            var dt_basic = dt_basic_table.DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ url('dailyLoanData') }}",
                columns: [
                    { data: 'name' },
                    { data: 'account_no' },
                    { data: 'loan_amount' }, // used for sorting so will hide this column
                   /* { data: 'total'},*/
                    { data: 'adjusted_amount' },
                    { data: 'balance' },
                    { data: 'date' },
                    { data: 'status' },
                    { data: '' },
                ],
                columnDefs: [
                    {
                        targets: 2,
                        render: function (data, type, full, meta) {
                            let loan_amount = full['loan_amount'];
                            let interest = full['interest'];
                            var output = '<span class="text-success">'+loan_amount+ '</span>'+
                                '<span class="text-danger"> +'+interest+'</span>';
                            return output;
                        }
                    },
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['id'],
                                $image = full['profile_photo_url'];
                            if ($image != null) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6) + 1;
                                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }
                            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="avatar-wrapper">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<a href="{{ url('daily-loans') }}/'+$id +
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +
                                '<small class="emp_post text-muted">' +
                                full['phone'] +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },
                    {
                        // Label
                        targets: 6,
                        render: function (data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                active: { title: 'Active', class: 'badge-light-primary' },
                                inactive: { title: 'Inactive', class: ' badge-light-danger' },
                                paid: { title: 'Paid', class: ' badge-light-success' }
                            };
                            if (typeof $status[$status_number] === 'undefined') {
                                return data;
                            }
                            return (
                                '<span class="badge rounded-pill ' +
                                $status[$status_number].class +
                                '">' +
                                $status[$status_number].title +
                                '</span>'
                            );
                        }
                    },
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
                                '<a href="{{url('daily-loans')}}/'+full['id']+'" class="dropdown-item">' +
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
                                '<a href="" class="item-edit">' +
                                feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                                '</a>'
                            );
                        }
                    }
                ],
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    },
                    {
                        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Record',
                        className: 'create-new btn btn-primary',
                        attr: {
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#createLoanModal'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
            $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
        }



        // Flat Date picker
        if (dt_date_table.length) {
            dt_date_table.flatpickr({
                monthSelectorType: 'static',
                dateFormat: 'm/d/Y'
            });
        }
        // Delete Record
        $('.datatables-basic tbody').on('click', '.delete-record', function () {

            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('daily-loans') }}/" + id,
                        type: 'DELETE',
                        data: {"id": id, "_token": token},
                        success: function () {
                            $(".datatables-basic").DataTable().row($(this).parents('tr'))
                                .remove()
                                .draw();
                            toastr.success('Daily Loan has been deleted successfully.', 'Deleted!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        },error: function (data) {
                            toastr.error('Daily Loan delete failed.', 'Failed!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        }
                    });

                }
            })
        });

        $("#createLoanModal").on('shown.bs.modal', function () {
            $(".select2-size-sm").select2();
        });

        $(function () {
            ('use strict');
            var modernVerticalWizard = document.querySelector('.create-app-wizard'),
                createAppModal = document.getElementById('createLoanModal'),
                assetsPath = '../../../app-assets/';

            var basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    static: true,
                    altInput: true,
                    altFormat: 'd/m/Y',
                    dateFormat: 'Y-m-d'
                });
            }

            if ($('body').attr('data-framework') === 'laravel') {
                assetsPath = $('body').attr('data-asset-path');
            }

            // --- create app  ----- //
            if (typeof modernVerticalWizard !== undefined && modernVerticalWizard !== null) {
                var modernVerticalStepper = new Stepper(modernVerticalWizard, $form = $(modernVerticalWizard).find('form'),
                    $form.each(function () {
                        var $this = $(this);
                        $this.validate({
                            rules: {
                                account_no: {
                                    required: true
                                },
                                loan_amount: {
                                    required: true
                                },
                                interest1: {
                                    required: true
                                },
                                opening_date: {
                                    required: true
                                },
                                commencement: {
                                    required: true
                                },
                            }
                        });
                    }), {
                        linear: false
                    });



                $(modernVerticalWizard)
                    .find('.btn-next')
                    .on('click', function () {
                        var isValid = $(this).parent().siblings('form').valid();
                        if (isValid) {
                            modernVerticalStepper.next();
                        } else {
                            e.preventDefault();
                        }

                    });
                $(modernVerticalWizard)
                    .find('.btn-prev')
                    .on('click', function () {
                        modernVerticalStepper.previous();
                    });

                $(modernVerticalWizard)
                    .find('.btn-submit')
                    .on('click', function () {
                        var $this = $(".btn-submit"); //submit button selector using ID
                        var $caption = $this.html();// We store the html content of the submit button

                        var formData = $("form").serializeArray();
                        $.ajax({
                            url: "{{ route('daily-loans.store') }}",
                            method: "POST",
                            data: formData,
                            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                                $this.attr('disabled', true).html("Processing...");
                            },
                            success: function (data) {
                                $this.attr('disabled', false).html($caption);
                                //$(".spinner").hide();
                                $("form").trigger('reset');
                                $("#createFdrModal").modal("hide");
                                toastr.success('New Special DPS Loan successfully added.', 'New Special Loan!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });

                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function () {
                                $this.attr('disabled', false).html($caption);
                                $("#createFdrModal").modal("hide");
                                toastr.error('New Special DPS Loan account added failed.', 'Failed!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        })
                    });

                // reset wizard on modal hide
                createAppModal.addEventListener('hide.bs.modal', function (event) {
                    modernVerticalStepper.to(1);
                });
            }

            // --- / create app ----- //
        });

        $("#guarantor_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#name").val('');
            $("#address").val('');
            $("#phone").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //console.log(data)
                    $("#name").val(data.name);
                    $("#address").val(data.present_address);
                    $("#phone").val(data.phone1);
                }
            })
        })



    </script>
@endsection
