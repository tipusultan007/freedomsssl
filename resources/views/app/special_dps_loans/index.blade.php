@extends('layouts/contentLayoutMaster')

@section('title', 'Special Loans')

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
                    <table class="datatables-basic table">
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
        <div class="modal modal-slide-in fade" id="modals-slide-in">
            <div class="modal-dialog sidebar-sm">
                <form class="add-new-record modal-content pt-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                            <input
                                type="text"
                                class="form-control dt-full-name"
                                id="basic-icon-default-fullname"
                                placeholder="John Doe"
                                aria-label="John Doe"
                            />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-post">Post</label>
                            <input
                                type="text"
                                id="basic-icon-default-post"
                                class="form-control dt-post"
                                placeholder="Web Developer"
                                aria-label="Web Developer"
                            />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <input
                                type="text"
                                id="basic-icon-default-email"
                                class="form-control dt-email"
                                placeholder="john.doe@example.com"
                                aria-label="john.doe@example.com"
                            />
                            <small class="form-text"> You can use letters, numbers & periods </small>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-date">Joining Date</label>
                            <input
                                type="text"
                                class="form-control dt-date"
                                id="basic-icon-default-date"
                                placeholder="MM/DD/YYYY"
                                aria-label="MM/DD/YYYY"
                            />
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="basic-icon-default-salary">Salary</label>
                            <input
                                type="text"
                                id="basic-icon-default-salary"
                                class="form-control dt-salary"
                                placeholder="$12000"
                                aria-label="$12000"
                            />
                        </div>
                        <button type="button" class="btn btn-primary data-submit me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--/ Basic table -->

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
                                    <div class="row mb-2">
                                        @php
                                            $accounts = \App\Models\SpecialDps::with('user')->where('status','active')->get();
                                        @endphp
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <select data-allow-clear="true" name="account_no" id="account_no"
                                                        class="select2 form-select" data-placeholder="-- Select A/C --">
                                                    <option value=""></option>
                                                    @forelse($accounts as $account)
                                                        <option value="{{ $account->account_no }}">{{ $account->account_no }}
                                                            || {{ $account->user->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                <label for="account_no" class="form-label">A/C No</label>
                                                <input type="hidden" name="user_id" id="user_id">
                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="loan_amount" name="loan_amount" placeholder="Loan Amount">
                                                <label for="loan_amount" class="form-label">Loan Amount</label>
                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="interest1" name="interest1" placeholder="Interest Rate">
                                                <label for="interest1" class="form-label">Interest Rate</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="interest2" name="interest2" placeholder="Interest Rate 2">
                                                <label for="interest2" class="form-label">Special Interest Rate</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="upto_amount" name="upto_amount" placeholder="Upto Amount">
                                                <label for="upto_amount" class="form-label">Upto Amount</label>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control flatpickr-basic" id="opening_date"
                                                       name="opening_date" aria-label="DD/MM/YYYY" placeholder="Loan Date">
                                                <label for="account_no" class="form-label"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control flatpickr-basic" id="commencement"
                                                       name="commencement" aria-label="DD/MM/YYYY" placeholder="Commencement">
                                                <label for="account_no" class="form-label"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <div class="form-floating">

                                                <input type="text" class="form-control" id="note"
                                                       name="note" placeholder="Note">
                                                <label for="account_no" class="form-label">Note</label>
                                            </div>

                                        </div>
                                    </div>
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
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
                        <div class="bs-stepper-content pt-0 w-50">
                            <div class="divider">
                                <div class="divider-text">User Information</div>
                            </div>
                            <div class="user-data">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / create app modal -->

    <div
        class="modal fade text-start"
        id="modalDepositList"
        tabindex="-1"
        aria-labelledby="myModalLabel17"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Large Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    I love tart cookie cupcake. I love chupa chups biscuit. I love marshmallow apple pie wafer
                    liquorice. Marshmallow cotton candy chocolate. Apple pie muffin tart. Marshmallow halvah pie
                    marzipan lemon drops jujubes. Macaroon sugar plum cake icing toffee.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Accept</button>
                </div>
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

@endsection

@section('vendor-script')
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

    {{--<script src="{{ asset(mix('js/scripts/pages/modal-create-app.js')) }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData() {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    "url": "{{ url('dataSpecialDpsLoans') }}"
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
                columnDefs: [
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['user_id'],
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
                                '<a href="' +
                                userView + $id +
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +
                                '<small class="emp_post text-success">' +
                                full['phone'] +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },

                    {
                        // Actions
                        targets: 9,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('special-dps-loans')}}/' + full['id'] + '" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item loan-list">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Loan List</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item item-reset">' +
                                feather.icons['refresh-cw'].toSvg({class: 'font-small-4 me-50'}) +
                                'Reset</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit">' +
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

        $(document).on("click",".loan-list",function () {
            var id = $(this).data("id");
            $(".loan-list-table tbody").empty();
            $.ajax({
                url: "{{ url('specialLoanList') }}/"+id,
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
                                       <td>${b.interest1}%</td>
                                       <td>${b.interest2>0?b.interest2+"%":"N/A"}</td>
                                       <td>${b.upto_amount>0?b.upto_amount:"N/A"}</td>
                                       <td>${b.remain}</td>
                                       <td>${commencement}</td>
<td>
<a class="btn btn-sm btn-primary waves-effect" target="_blank" href="{{ url('special-loan-takens') }}/${b.id}">View</a>
</td>
</tr>
                        `);
                    })

                }
            })
            $("#loanListModal").modal("show");
        })
        $(document).on("click",".delete-record",function () {
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
                            url: "{{ url('special-dps-loans') }}/"+id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response){

                                //$("#success").html(response.message)

                                toastr.success('Special DPS Loan has been deleted successfully!', 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function (data) {
                                toastr.error('Loan deletion has been failed!', 'Failed!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        });
                }
            });
        })

        $("#createFdrModal").on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: 'Select a User'
            });
        });

        $('#account_no').on('select2:select', function (e) {
            var data = e.params.data;
            $.ajax({
                url: "{{ url('specialDpsInfoByAccount') }}/"+data.id,
                dataType: "json",
                type: "get",
                success: function (data) {
                    $("#user_id").val(data.user.id);
                    var image = '';
                    if (data.user.profile_photo_path == null) {
                        image = data.user.profile_photo_url + '&size=110';
                    } else {
                        image = data.user.profile_photo_path;
                    }
                    $(".user-data").append(`
                    <div class="user-avatar-section">
<div class="row">
<div class="col-8">
<div class="info-container">
                                <ul class="list-unstyled">
<li class="mb-0">
                                        <span class="fw-bolder me-25">Name:</span>
                                        <span>${data.user.name}</span>
                                    </li>
<li class="mb-0">
                                        <span class="fw-bolder me-25">Phone:</span>
                                        <span>${data.user.phone1}</span>
                                    </li>
<li class="mb-0">
                                        <span class="fw-bolder me-25">Father:</span>
                                        <span>${data.user.father_name}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Mother:</span>
                                        <span>${data.user.mother_name}</span>
                                    </li>
                                </ul>
                            </div>
</div>
<div class="col-4">
<img class="img-fluid rounded mt-0 mb-2" src="${image}" height="80" width="80" alt="User avatar">
</div>
<div class="col-12">
<ul class="list-unstyled">

                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Spouse:</span>
                                        <span class="badge bg-light-success">${data.user.spouse_name}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Present Address:</span>
                                        <span>${data.user.present_address}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Join Date:</span>
                                        <span>${data.user.join_date}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total Savings:</span>
                                        <span>${data.daily_savings}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total DPS:</span>
                                        <span>${data.dps}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total Special DPS:</span>
                                        <span>${data.special_dps}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Daily Loans:</span>
                                        <span>${data.daily_loans}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">DPS Loans:</span>
                                        <span>${data.dps_loans}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Special DPS Loan:</span>
                                        <span>${data.special_dps_loans}</span>
                                    </li>
</ul>
</div>
</div>

                            </div>

                    `);
                }
            })
        });

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
                            url: "{{ route('special-dps-loans.store') }}",
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
                        url: "{{ url('reset-special-loan') }}/" + id,
                        success: function () {
                            $(".datatables-basic").DataTable().destroy();
                            loadData();
                            toastr.error('Loan has been reset successfully.', 'Reset!', {
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
