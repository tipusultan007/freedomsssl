@extends('layouts/contentLayoutMaster')

@section('title', 'User Details')

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
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img
                                    class="img-fluid rounded mt-3 mb-2"
                                    src="{{ $user->profile_photo_url??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>{{ $user->name }}</h4>
                                    <span class="badge bg-light-secondary">Author</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="check" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $totalSavings }}</h4>
                                    <small>Savings</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="briefcase" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $totalLoans }}</h4>
                                    <small>Loans</small>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Name:</span>
                                    <span>{{ $user->name }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Gender:</span>
                                    <span>{{ ucfirst($user->gender) }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Father:</span>
                                    <span>{{ $user->father_name??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Mother:</span>
                                    <span>{{ $user->mother_name??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Marital Status:</span>
                                    <span>{{ ucfirst($user->marital_status) }}</span>
                                </li>
                                @if($user->marital_status=="married")
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Spouse Name:</span>
                                        <span>{{ ucfirst($user->spouse_name) }}</span>
                                    </li>
                                @endif
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Email:</span>
                                    <span>{{ $user->email??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Status:</span>
                                    <span class="badge bg-light-success">{{ ucfirst($user->status) }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Present Address:</span>
                                    <span>{{ $user->present_address??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Permanent Address:</span>
                                    <span>{{ $user->permanent_address??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Contact:</span>
                                    @if($user->phone1 !='NULL')
                                        <span>{{ $user->phone1 }}</span>
                                    @endif
                                    @if($user->phone2 !='NULL')
                                        <span>, {{ $user->phone2 }}</span>
                                    @endif
                                    @if($user->phone3 !='NULL')
                                        <span>, {{ $user->phone3 }}</span>
                                    @endif
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Occupation:</span>
                                    <span>{{ $user->occupation??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Workplace:</span>
                                    <span>{{ $user->workplace??'' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Join Date:</span>
                                    <span>{{ $user->join_date??'' }}</span>
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
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
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
                            aria-selected="true"
                        ><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Savings Account</span></a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="loan-tab"
                            data-bs-toggle="tab"
                            href="#loanAccount"
                            aria-controls="profile"
                            role="tab"
                            aria-selected="false"
                        ><i data-feather="lock" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan Accounts</span></a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="transaction-tab"
                            data-bs-toggle="tab"
                            href="#transaction"
                            aria-controls="transactions"
                            role="tab"
                            aria-selected="false"
                        ><i data-feather="lock" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Transactions</span></a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="report-tab"
                            data-bs-toggle="tab"
                            href="#report"
                            aria-controls="about"
                            role="tab"
                            aria-selected="false"
                        ><i data-feather="lock" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Reports</span></a
                        >
                    </li>
                </ul>


                <div class="tab-content">
                    <div class="tab-pane active" id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="table datatable-accounts">
                                <thead>
                                <tr>
                                    <th>A/C NO</th>
                                    <th>Type</th>
                                    <th>Opening Date</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                    <div class="tab-pane" id="loanAccount" aria-labelledby="profileIcon-tab" role="tabpanel">
                        <div class="card">
                            <table class="table datatable-loans">
                                <thead>
                                <tr>
                                    <th>A/C NO</th>
                                    <th>Type</th>
                                    <th>Loan</th>
                                    <th>Remain</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="transaction" aria-labelledby="disabledIcon-tab" role="tabpanel">

                    </div>
                    <div class="tab-pane" id="report" aria-labelledby="aboutIcon-tab" role="tabpanel">

                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>
    </section>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Edit User Information</h1>
                        <p>Updating user details will receive a privacy audit.</p>
                    </div>
                    <form id="editUserForm" action="{{ route("users.update",$user->id) }}" method="POST" class="row gy-1 pt-75">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditName">Name</label>
                            <input
                                type="text"
                                id="modalEditName"
                                name="name"
                                class="form-control"
                                value="{{ $user->name??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditEmail">Email</label>
                            <input
                                type="email"
                                id="modalEditEmail"
                                name="email"
                                class="form-control"
                                value="{{ $user->email??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="modalEditPhone1">Phone 1</label>
                            <input
                                type="text"
                                id="modalEditPhone1"
                                name="phone1"
                                class="form-control phone-number-mask"
                                value="{{ $user->phone1??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="modalEditPhone2">Phone 2</label>
                            <input
                                type="text"
                                id="modalEditPhone2"
                                name="phone2"
                                class="form-control phone-number-mask"
                                value="{{ $user->phone2??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="modalEditPhone3">Phone 3</label>
                            <input
                                type="text"
                                id="modalEditPhone3"
                                name="phone3"
                                class="form-control phone-number-mask"
                                value="{{ $user->phone3??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditFatherName">Father Name</label>
                            <input
                                type="text"
                                id="modalEditFatherName"
                                name="father_name"
                                class="form-control"
                                value="{{ $user->father_name??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditMotherName">Mother Name</label>
                            <input
                                type="text"
                                id="modalEditMotherName"
                                name="mother_name"
                                class="form-control"
                                value="{{ $user->mother_name??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="demo-inline-spacing">
                                <label class="form-label">Gender:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="modalEditGenderMale"
                                           value="male" @if($user->gender=='male') checked @endif>
                                    <label class="form-check-label" for="modalEditGenderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="modalEditGenderFemale"
                                           value="female" @if($user->gender=='female') checked @endif>
                                    <label class="form-check-label" for="modalEditGenderFemale">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="demo-inline-spacing">
                                <label class="form-label" for="modalEditMarital">Marital Status:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="marital_status" id="modalEditMaritalMarried"
                                           value="married" @if($user->marital_status=='married') checked @endif>
                                    <label class="form-check-label" for="modalEditMaritalMarried">Married</label>
                                </div>
                                <div class="form-check form-check-inline me-0">
                                    <input class="form-check-input" type="radio" name="marital_status"
                                           id="modalEditMaritalUnmarried" value="unmarried" @if($user->marital_status=='unmarried') checked @endif>
                                    <label class="form-check-label" for="modalEditMaritalUnmarried">Unmarried</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditSpouseName">Spouse Name</label>
                            <input
                                type="text"
                                id="modalEditSpouseName"
                                name="spouse_name"
                                class="form-control"
                                value="{{ $user->spouse_name??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditPermanentAddress">Permanent Address</label>
                            <input
                                type="text"
                                id="modalEditPermanentAddress"
                                name="permanent_address"
                                class="form-control"
                                value="{{ $user->permanent_address??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditPresentAddress">Present Address</label>
                            <input
                                type="text"
                                id="modalEditPresentAddress"
                                name="present_address"
                                class="form-control"
                                value="{{ $user->present_address??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditOccupation">Occupation</label>
                            <input
                                type="text"
                                id="modalEditOccupation"
                                name="occupation"
                                class="form-control"
                                value="{{ $user->occupation??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditWorkplace">Work Place</label>
                            <input
                                type="text"
                                id="modalEditWorkplace"
                                name="workplace"
                                class="form-control modal-edit-tax-id"
                                value="{{ $user->workplace??'' }}"
                            />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditNid">NID</label>
                            <input class="form-control" name="national_id" type="file" id="modalEditNid">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditBirthId">Birth ID</label>
                            <input class="form-control" name="birth_id" type="file" id="modalEditBirthId">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditPhoto">Photo</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditTaxID">Status</label>
                            <select name="status" id="" class="form-control form-select">
                                <option value="active" @if($user->status=="active") selected @endif>Active</option>
                                <option value="inactive" @if($user->status=="inactive") selected @endif>Inactive</option>
                                <option value="closed" @if($user->status=="closed") selected @endif>Closed</option>
                            </select>
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1 btn-update">Update</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit User Modal -->

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

        // Invoice datatable
        // --------------------------------------------------------------------
        if (dtAccountsTable.length) {
            var dtAccounts = dtAccountsTable.DataTable({
                ajax: "{{ url('userAccounts') }}/" + {{ $user->id }}, // JSON file to add data
                processing: true,
                serverSide: true,
                autoWidth: true,
                columns: [
                    // columns according to JSON
                    {data: 'account_no'},
                    {data: 'type'},
                    {data: 'opening_date'},
                    {data: 'balance'},
                    {data: 'status'},
                    {data: 'action'}
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        width: '80px',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var link = "";
                            var id = full['id'];
                            if (full['type'] == "DPS")
                            {
                                link = "{{url('all-dps')}}";
                            }else if (full['type'] == "Daily Savings")
                            {
                                link = "{{ url('daily-savings') }}";
                            }
                            return (
                                '<div class="d-flex align-items-center col-actions">' +
                                '<a class="me-1" href="'+link+'/'+id+'">' +
                                feather.icons['eye'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>' +
                                '<a class="me-1" href="' +
                                invoicePreview +
                                '" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview Invoice">' +
                                feather.icons['edit'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>' +
                                '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">' +
                                feather.icons['download'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>'
                            );
                        }
                    }
                ],
                order: [[1, 'desc']],
                dom: '<"card-header pt-1 pb-25"<"head-label"><"dt-action-buttons text-end"B>>t',
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    }
                ]
            });
            $('div.head-label').html('<h4 class="card-title">Accounts</h4>');
        }
        if (dtLoansTable.length) {
            var dtLoans = dtLoansTable.DataTable({
                serverSide: true,
                ajax: "{{ url('userLoans') }}/" + {{ $user->id }}, // JSON file to add data
                columns: [
                    // columns according to JSON
                    {data: 'account_no'},
                    {data: 'type'},
                    {data: 'loan_amount'},
                    {data: 'remain'},
                    {data: 'date'},
                    {data: 'action'}
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        width: '80px',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var link = "";
                            var id = full['id'];
                            if (full['type'] == "DPS Loan")
                            {
                                link = "{{ url('dps-loans') }}";
                            }else if (full['type'] == "Special Loan")
                            {
                                link = "{{ url('special-dps-loans') }}";
                            }else if (full['type'] == "Daily Loan")
                            {
                                link = "{{ url('daily-loans') }}";
                            }
                            return (
                                '<div class="d-flex align-items-center col-actions">' +
                                '<a class="me-1" href="'+link+'/'+id+'">' +
                                feather.icons['eye'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>' +
                                '<a class="me-1" href="' +
                                invoicePreview +
                                '" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview Invoice">' +
                                feather.icons['edit'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>' +
                                '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">' +
                                feather.icons['download'].toSvg({class: 'font-medium-2 text-body'}) +
                                '</a>'
                            );
                        }
                    }
                ],
                order: [[1, 'desc']],
                dom: '<"card-header pt-1 pb-25"<"head-label"><"dt-action-buttons text-end"B>>t',
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4]}
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    }
                ]
            });
            $('#loanAccount .head-label').html('<h4 class="card-title">Loans</h4>');
        }
/*
        $(".btn-update").on("click",function () {
            $.ajax({
                url: "{{ route("users.update",$user->id) }}",
                method: "POST",
                data: $("#editUserForm").serialize(),
                success: function (data) {
                    console.log(data)
                }
            })
        })*/
    </script>
@endsection
