@extends('layouts/contentLayoutMaster')

@section('title', 'DPS Loans')
@section('breadcrumb-menu')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#dpsLoanImportModal">
                        <i class="me-1" data-feather="check-square"></i>
                        <span class="align-middle">Import DPS Loan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">


    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table table-sm">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>A/C</th>
                            <th>Loan</th>
                            <th>Interest</th>
                            <th>Paid</th>
                            <th>Remain</th>
                            <th>Date</th>
                            <th>Created By</th>
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
    <div class="modal fade text-start" id="dpsLoanImportModal" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title text-white" id="myModalLabel4">Import Savings Collections</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('dps-loan-import') }}" method="POST"
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
    <div class="modal fade text-start" id="loanListModal" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title text-white" id="myModalLabel">Loan List - <span id="ac_name"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                               <table class="table table-sm loan-list-table">
                                   <thead>
                                   <tr>
                                       <th>Date</th>
                                       <th>Loan</th>
                                       <th>Interest 1</th>
                                       <th>Interest 2</th>
                                       <th>Upto Amount</th>
                                       <th>Remain</th>
                                       <th>Commencement</th>
                                       <th>Action</th>
                                   </tr>
                                   </thead>
                                   <tbody></tbody>
                               </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- create app modal -->
    <div class="modal fade" id="createFdrModal" tabindex="-1" aria-labelledby="createAppTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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
                                            $accounts = \App\Models\Dps::with('user')->where('status','active')->get();
                                        @endphp
                                        <div class="col-md-6 mb-2">
                                            <label for="account_no" class="form-label">A/C No</label>
                                            <select data-allow-clear="true" name="account_no" id="account_no" class="select2 form-select" data-placeholder="Select Account">

                                                <option value="">Select Account</option>
                                                @forelse($accounts as $account)
                                                    <option value="{{ $account->account_no }}">{{ $account->account_no }}
                                                        || {{ $account->user->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label for="loan_amount" class="form-label">Loan Amount</label>
                                            <input type="text" class="form-control" id="loan_amount" name="loan_amount">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label for="interest1" class="form-label">Interest Rate</label>
                                            <input type="number" class="form-control" id="interest1" name="interest1">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="interest2" class="form-label">Special Interest Rate</label>
                                            <input type="number" class="form-control" id="interest2" name="interest2">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="upto_amount" class="form-label">Upto Amount</label>
                                            <input type="text" class="form-control" id="upto_amount" name="upto_amount">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="account_no" class="form-label">Loan Date</label>
                                            <input type="text" class="form-control flatpickr-basic" id="opening_date"
                                                   name="opening_date" aria-label="MM/DD/YYYY">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label for="account_no" class="form-label">Commencement</label>
                                            <input type="text" class="form-control flatpickr-basic" id="commencement"
                                                   name="commencement" aria-label="MM/DD/YYYY">
                                        </div>


                                        <div class="col-md-12 mb-2">
                                            <label for="account_no" class="form-label">Note</label>
                                            <input type="text" class="form-control" id="note"
                                                   name="note">
                                        </div>
                                    </div>
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                                    <input type="hidden" name="user_id" id="user_id">
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

                                        <div class="col-md-4 mb-2">
                                            <label for="bank_name" class="form-label">Bank Name</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                                        </div>

                                        <div class="col-md-4 mb-2">
                                            <label for="branch_name" class="form-label">Branch Name</label>
                                            <input type="text" class="form-control" id="branch_name" name="branch_name">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="cheque_no" class="form-label">Cheque No</label>
                                            <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <label for="document_name" class="form-label">Upload Documents</label>
                                            <input class="form-control" type="file" name="document_name" id="document_name" multiple />
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label for="account_no" class="form-label">Note</label>
                                            <input type="text" class="form-control" id="note"
                                                   name="note">
                                        </div>
                                    </div>
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
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
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            @php
$users = \App\Models\User::all();
 @endphp
                                            <label class="form-label" for="name">Select User</label>
                                            <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- Select User --">
                                                <option value="">Select Guarantor</option>
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

                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="address">Address</label>
                                            <input type="text" name="address" id="address" class="form-control"/>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="percentage">A/C No</label>
                                            <input type="text" name="exist_ac_no" id="exist_ac_no" class="form-control"/>
                                        </div>
                                    </div>


                                    <input type="hidden" name="status" value="active">
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
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
                        <div class="bs-stepper-content detail-data w-50 pt-0">

                                <div class="divider">
                                    <div class="divider-text">Applicant's Information</div>
                                </div>
                                <div class="user-data">

                                </div>


                                <div class="divider">
                                    <div class="divider-text">Guarantor's Information</div>
                                </div>
                                <div class="guarantor-data">

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
    <!-- vendor files -->
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

    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

@endsection
@section('page-script')
    {{-- Page js files --}}
    {{--  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>--}}
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    <script>

        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData()
        {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('dataDpsLoans') }}"
                },
                "columns": [

                    { "data": "name" },
                    { "data": "account_no" },
                    { "data": "loan_amount" },
                    { "data": "interest" },
                    { "data": "total_paid" },
                    { "data": "remain_loan" },
                    { "data": "date" },
                    { "data": "createdBy" },
                    { "data": "status" },
                    { "data": "action" },
                ],
                columnDefs:[ {
                    // User full name and username
                    targets: 0,
                    render: function (data, type, full, meta) {
                        var $name = full['name'],
                            $id = full['id'],
                            $image = full['photo'];
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
                            '<a href="' +
                            userView+$id +
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
                        targets: 8,
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
                        targets: 9,
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
                                '<a href="{{url('dps-loans')}}/'+full['id']+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="'+id+'" class="dropdown-item loan-list" data-id="'+id+'">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Loan List</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item item-reset">' +
                                feather.icons['refresh-cw'].toSvg({class: 'font-small-4 me-50'}) +
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
                            'data-bs-target': '#createFdrModal'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],

            });
        }

        $('.data-submit').on('click', function () {

            $.ajax({
                url: "{{ route('all-dps.store') }}",
                method: "POST",
                data: $(".add-new-record").serialize(),
                success: function (data) {
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('New DPS account successfully added.', 'New DPS!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".modal").modal('hide');
                }

            })
        });
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

        $(document).on("click",".loan-list",function () {
            var id = $(this).data("id");
            $(".loan-list-table tbody").empty();
            $.ajax({
                url: "{{ url('loanList') }}/"+id,
                dataType: "JSON",
                success: function (data) {
                    console.log(data)
                    $.each(data,function (a,b) {
                        let date = formatDate(new Date(b.date));
                        let commencement = formatDate(new Date(b.commencement));
                        $(".loan-list-table tbody").append(`
                        <tr>
                     <td>${date}</td>
                                       <td>${b.loan_amount}</td>
                                       <td>${b.interest1}</td>
                                       <td>${b.interest2>0?b.interest2:"N/A"}</td>
                                       <td>${b.upto_amount>0?b.upto_amount:"N/A"}</td>
                                       <td>${b.remain}</td>
                                       <td>${commencement}</td>
<td>
<a class="btn btn-sm btn-primary waves-effect" href="{{ url('taken-loans') }}/${b.id}">View</a>
</td>
</tr>
                        `);
                    })

                }
            })
            $("#loanListModal").modal("show");
        })
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
                        url: "{{ url('dps-loans') }}/"+id,
                        type: 'DELETE',
                        data: {"id": id, "_token": token},
                        success: function (){
                            $(".datatables-basic").DataTable().row( $(this).parents('tr') )
                                .remove()
                                .draw();
                            toastr.error('DPS Loan a/c has been deleted successfully.', 'Deleted!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        }
                    });

                }
            })


        });
        $('.datatables-basic tbody').on('click', '.item-reset', function () {

            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('reset-loan') }}/" + id,
                        success: function () {
                            $(".datatables-basic").DataTable().destroy();
                            loadData();
                            toastr.success('Loan has been reset successfully.', 'Reset!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        },
                        error: function (data) {
                            toastr.error('Loan reset failed.', 'Failed!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        }
                    });

                }
            })


        });
        $('#account_no').on('select2:select', function (e) {
            $(".user-data").empty();
            var data = e.params.data;
            $.ajax({
                url: "{{ url('dpsInfoByAccount') }}/"+data.id,
                dataType: "json",
                type: "get",
                success: function (data) {
                    $("#user_id").val(data.user.id);
                    var image = '';
                    if (data.user.profile_photo_path == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.profile_photo_path;
                    }
                    $(".user-data").append(`
                    <!--<div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="80" width="80" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>-->
                           <!-- <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>-->
<table class="table table-sm">
<tr>
<td><b>${data.user.name}</b> <br>
<span class="badge bg-light-secondary">${data.user.phone1}</span>
</td>
<td><img class="img-fluid rounded" src="${image}" height="60" width="60" alt="User avatar"></td>
</tr>
</table>
                            <div class="info-container">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td class="fw-bolder me-25">Father:</td>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Mother:</td>
                                        <td>${data.user.mother_name}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bolder me-25">Join Date:</td>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Savings:</td>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total DPS:</td>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Special DPS:</td>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Daily Loans:</td>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">DPS Loans:</td>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Special DPS Loan:</td>
                                        <td>${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">FDR:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">Guarantor:</td>
                                        <td class="gtable"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
                    if (data.guarantors != null)
                    {
                        $.each(data.guarantors,function (a,b) {
                            $(".gtable").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
                        })
                    }
                }
            })
        });
        $("#guarantor_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#name").val('');
            $("#address").val('');
            $("#phone").val('');
            $(".guarantor-data").empty();
            $.ajax({
                url: "{{ url('getDetails') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //console.log(data)
                    $("#name").val(data.user.name);
                    $("#address").val(data.user.present_address);
                    $("#phone").val(data.user.phone1);

                    var image = '';
                    if (data.user.profile_photo_path == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.profile_photo_path;
                    }
                    $(".guarantor-data").append(`
                 <table class="table table-sm">
<tr>
<td><b>${data.user.name}</b> <br>
<span class="badge bg-light-secondary">${data.user.phone1}</span>
</td>
<td><img class="img-fluid rounded" src="${image}" height="60" width="60" alt="User avatar"></td>
</tr>
</table>
                            <div class="info-container">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td class="fw-bolder me-25">Father:</td>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Mother:</td>
                                        <td>${data.user.mother_name}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bolder me-25">Join Date:</td>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Savings:</td>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total DPS:</td>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Special DPS:</td>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Daily Loans:</td>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">DPS Loans:</td>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Special DPS Loan:</td>
                                        <td>${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">FDR:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">Guarantor:</td>
                                        <td class="gtable2"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
                    if (data.guarantors != null)
                    {
                        $.each(data.guarantors,function (a,b) {
                            $(".gtable2").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
                        })
                    }
                }
            })
        })

        $(function () {
            ('use strict');
            var modernVerticalWizard = document.querySelector('.create-app-wizard'),
                createAppModal = document.getElementById('createFdrModal'),
                assetsPath = '../../../app-assets/';

            var basicPickr = $('.flatpickr-basic');
            if (basicPickr.length) {
                basicPickr.flatpickr({
                    static: true,
                    altInput: true,
                    altFormat: 'd/m/Y',
                    dateFormat: 'Y-m-d',
                    allowInput: true
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
                            url: "{{ route('dps-loans.store') }}",
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
                                toastr.success('New DPS Loan successfully added.', 'New DPS Loan!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".user-data").empty();
                                $(".guarantor-data").empty();

                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function () {
                                $this.attr('disabled', false).html($caption);
                                $("#createFdrModal").modal("hide");
                                toastr.error('New DPS Loan account added failed.', 'Failed!', {
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
    </script>
@endsection
