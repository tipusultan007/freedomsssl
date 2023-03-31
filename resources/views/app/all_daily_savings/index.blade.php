
@extends('layouts/contentLayoutMaster')

@section('title', __('Daily Savings'))

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">

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
                            <th>Date</th>
                            <th>Deposit</th>
                            <th>Withdraw</th>
                            <th>Profit</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
       {{-- <div class="modal modal-slide-in new-savings-modal fade" id="modals-slide-in">
            <div class="modal-dialog sidebar-md">
                <form class="add-new-record modal-content pt-0">
                    @csrf
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New Daily Savings Account</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        @php
                        $users = \App\Models\User::all();
                        @endphp
                        <div class="divider">
                            <div class="divider-text">Account Information</div>
                        </div>
                        <div class="row g-1">
                            <div class="col-md-12 mb-0">
                                <label class="form-label" for="user_id">Name</label>
                                <select class="select2 form-select dt-user-id" data-placeholder="Select" name="user_id" id="user_id">
                                    <option value=""></option>
                                    @forelse($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="account_no" class="form-label">Account No</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">DS</span>
                                    <input type="number" class="form-control" name="account_no" id="account_no" aria-describedby="basic-addon3">
                                </div>
                                <span id="result" class="font-small-3"></span>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label class="form-label" for="opening_date">Opening Date</label>
                                <input
                                    type="text"
                                    class="form-control dt-date dt-opening-date"
                                    id="opening_date"
                                    name="opening_date"
                                    placeholder="MM/DD/YYYY"
                                    aria-label="MM/DD/YYYY"
                                />
                            </div>
                            <div class="col-md-12 mb-0">
                                @php
                                    $introducers = \App\Models\User::role('collector')->get();
                                @endphp
                                <label for="account_no" class="form-label">Introducer</label>
                                <select name="introducer_id" id="introducer_id" data-placeholder="Select" class="select2 form-select">
                                    <option value=""></option>
                                    @forelse($introducers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <input type="hidden" name="status" value="active">
                        </div>
                        <div class="divider">
                            <div class="divider-text">Nominee Information</div>
                        </div>
                        <div class="row g-1">
                            <div class="col-md-12 mb-0">
                                <label class="form-label" for="nominee_account">{{ __('Nominee A/C List') }}</label>
                                <select class="select2 form-select dt-user-id" data-placeholder="Select" name="nominee_account" id="nominee_account">
                                    <option value=""></option>
                                    @forelse($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label class="form-label" for="nominee_name">{{ __('Name') }}</label>
                                <input
                                    type="text"
                                    id="nominee_name"
                                    class="form-control"
                                    name="name"
                                />
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="nominee_phone">{{__('Phone')}}</label>
                                <input
                                    type="text"
                                    id="nominee_phone"
                                    class="form-control dt-salary"
                                    name="phone"
                                />
                            </div>
                            <div class="col-md-12 mb-0">
                                <label class="form-label" for="nominee_address">{{ __('Address') }}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nominee_address"
                                   name="address"
                                />
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="nominee_relation">{{__('Relation')}}</label>
                                <input
                                    type="text"
                                    id="nominee_relation"
                                    class="form-control"
                                 name="relation"
                                />
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="nominee_pecentage">{{__('Percentage')}}</label>
                                <input
                                    type="number"
                                    id="nominee_pecentage"
                                    class="form-control"
                                    name="pecentage"
                                />
                            </div>
                        </div>
                        <input type="hidden" name="status" value="active">
                        <button type="button" class="btn btn-primary data-submit me-1"><span class="spinner spinner-border spinner-border-sm" style="display: none" role="status" aria-hidden="true"></span> Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>--}}
    </section>

@php
$users = \App\Models\User::all();
@endphp
    <div class="modal fade" id="createAppModal" tabindex="-1" aria-labelledby="createAppTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-3 px-sm-3">
                    <h1 class="text-center mb-1" id="createAppTitle">Create App</h1>
                    <p class="text-center mb-2">Provide application data with this form</p>

                    <div class="bs-stepper vertical wizard-modern create-app-wizard">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#create-app-details" role="tab"
                                 id="create-app-details-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="book" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Account</span>
                  <span class="bs-stepper-subtitle">Account Details</span>
                </span>
                                </button>
                            </div>

                            <div class="step" data-target="#create-app-database" role="tab"
                                 id="create-app-database-trigger">
                                <button type="button" class="step-trigger py-75">
                <span class="bs-stepper-box">
                  <i data-feather="command" class="font-medium-3"></i>
                </span>
                                    <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Nominee</span>
                  <span class="bs-stepper-subtitle">Nominee details</span>
                </span>
                                </button>
                            </div>

                            <div class="step" data-target="#create-app-submit" role="tab"
                                 id="create-app-submit-trigger">
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
                            <div id="create-app-details" class="content" role="tabpanel"
                                 aria-labelledby="create-app-details-trigger">
                                <h5 class="mb-1">Enter Account Details</h5>
                                <form>
                                    <div class="row mb-1">
                                        <div class="col-md-12 mb-1">
                                            <label class="form-label" for="user_id">Name</label>
                                            <select class="select2-size-sm form-select dt-user-id" data-allow-clear="on"
                                                    data-placeholder="-- Select User --" name="user_id" id="user_id">
                                                <option value=""></option>
                                                @forelse($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                        || {{ $user->father_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-6  mb-0">
                                            <label for="account_no" class="form-label">Account No</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">DS</span>
                                                <input type="number" class="form-control form-control-sm"
                                                       name="account_no" id="account_no">
                                            </div>
                                            <span id="result" class="font-small-3"></span>
                                        </div>


                                        <div class="mb-0 col-md-6 position-relative">
                                            <label class="form-label" for="opening_date">Opening Date</label>
                                            <input type="text" id="opening_date" name="opening_date"
                                                   class="form-control form-control-sm flatpickr-basic flatpickr-input"
                                                   placeholder="YYYY-MM-DD"
                                                   readonly="readonly">
                                        </div>

                                        <div class="col-md-12 mb-0">
                                            @php
                                                $introducers = \App\Models\User::role('collector')->get();
                                            @endphp
                                            <label for="introducer_id" class="form-label">Introducer</label>
                                            <select name="introducer_id" id="introducer_id"
                                                    class="select2-size-sm form-select">
                                                @forelse($introducers as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <input type="hidden" name="status" value="active">
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
                            <div id="create-app-database" class="content" role="tabpanel"
                                 aria-labelledby="create-app-database-trigger">
                                <h5 class="mb-1">Enter Nominee Details</h5>
                                <form>
                                    <div class="row g-1">
                                        <div class="col-md-12 mb-0">
                                            <label class="form-label" for="nominee_name">{{ __('Exist User') }}</label>
                                            <select class="select2-size-sm form-select dt-user-nominee-id"
                                                    data-allow-clear="on" name="nominee_account"
                                                    data-placeholder="-- Select User --" id="nominee_account">
                                                <option value=""></option>
                                                @forelse($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                        || {{ $user->father_name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label class="form-label" for="nominee_name">{{ __('Name') }}</label>
                                            <input
                                                type="text"
                                                id="nominee_name"
                                                class="form-control form-control-sm"
                                                name="name"
                                                placeholder="Name"
                                            />


                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label class="form-label" for="nominee_phone">{{__('Phone')}}</label>
                                            <input
                                                type="text"
                                                id="nominee_phone"
                                                class="form-control form-control-sm dt-salary"
                                                name="phone"
                                                placeholder="Phone"
                                            />


                                        </div>
                                        <div class="col-md-12 mb-0">
                                            <label class="form-label" for="nominee_address">{{ __('Address') }}</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm"
                                                id="nominee_address"
                                                name="address"
                                                placeholder="Address"
                                            />


                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label class="form-label" for="nominee_relation">{{__('Relation')}}</label>
                                            <input
                                                type="text"
                                                id="nominee_relation"
                                                class="form-control form-control-sm"
                                                name="relation"
                                                placeholder="Relation"
                                            />


                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <label class="form-label"
                                                   for="nominee_pecentage">{{__('Percentage')}}</label>
                                            <input
                                                type="number"
                                                id="percentage"
                                                class="form-control form-control-sm"
                                                name="percentage"
                                                placeholder="Percentage"
                                            />


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
    <!--/ Basic table -->
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
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

@endsection
@section('page-script')
    {{-- Page js files --}}
  {{--  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>--}}
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>

    <script>

        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData()
        {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                stateSave: true,
                order: [[1, 'asc']],
                "ajax":{
                    "url": "{{ url('dailySavingsData') }}"
                },
                "columns": [

                    { "data": "name" },
                    { "data": "account_no" },
                    { "data": "date" },
                    { "data": "deposit" },
                    { "data": "withdraw" },
                    { "data": "profit" },
                    { "data": "total" },
                    { "data": "status" },
                    { "data": "action" },
                ],
                columnDefs:[
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
                            '<a href="' +
                            userView+$id +
                            '" class="user_name text-truncate"><span class="fw-bolder">' +
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
                        targets: 7,
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
                        targets: 8,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-savings')}}/'+full['id']+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" class="dropdown-item item-reset" data-id="'+full['id']+'">' +
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
                            'data-bs-target': '#createAppModal'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],

            });
        }
        $("#account_no").on("change", function(){
            // Print entered value in a div box
            let account_digit = $(this).val();
            let account_no = account_digit.padStart(4,'0');
            if ($(this).val() !="")
            {
                let ac = "DS"+account_no;
                $("#result").empty();
                $.ajax({
                    url: "{{ url('isSavingsExist') }}/"+ac,
                    success: function (data) {
                        if (data=="yes")
                        {
                            $("#result").removeClass("text-success");
                            $("#result").addClass("text-danger");
                            $("#result").text("This A/C Number Already Exists. Please Try Another.")
                        }else {
                            $("#result").removeClass("text-danger");
                            $("#result").addClass("text-success");
                        }
                    }
                })
            }else {
                $("#result").removeClass("text-success");
                $("#result").addClass("text-danger");
                $("#result").text("Enter Valid A/C number.")
            }

        });


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
                            url: "{{ url('daily-savings') }}/"+id,
                            type: 'DELETE',
                            data: {"id": id, "_token": token},
                            success: function (){
                                $(".datatables-basic").DataTable().row( $(this).parents('tr') )
                                    .remove()
                                    .draw();
                                toastr.error('Daily savings a/c has been deleted successfully.', 'Deleted!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                            }
                        });

                    }
                })


            });
        $("#nominee_account").on("select2:select", function (e) {
            let user_id = e.params.data.id;
            $("#nominee_name").val('');
            $("#nominee_address").val('');
            $("#nominee_phone").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/" + user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data)
                    $("#nominee_name").val(data.name);
                    $("#nominee_address").val(data.present_address);
                    $("#nominee_phone").val(data.phone1);
                }
            })
        })



        $(function () {
            ('use strict');
            var modernVerticalWizard = document.querySelector('.create-app-wizard'),
                createAppModal = document.getElementById('createAppModal'),
                assetsPath = '../../../app-assets/',
                creditCard = $('.create-app-card-mask'),
                expiryDateMask = $('.create-app-expiry-date-mask'),
                cvvMask = $('.create-app-cvv-code-mask');

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
                                user_id: {
                                    required: true
                                }, account_no: {
                                    required: true
                                }, opening_date: {
                                    required: true
                                }
                            }
                        });
                    }), {
                        linear: false
                    });

                $(modernVerticalWizard)
                    .find('.btn-next')
                    .on('click', function (e) {
                        var isValid = $(this).parent().siblings('form').valid();
                        if (isValid) {
                            modernVerticalStepper.next();
                        } else {
                            e.preventDefault();
                        }
                        //modernVerticalStepper.next();
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
                            url: "{{ route('daily-savings.store') }}",
                            method: "POST",
                            data: formData,
                            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                                $this.attr('disabled', true).html("Processing...");
                            },
                            success: function (data) {
                                $this.attr('disabled', false).html($caption);
                                //$(".spinner").hide();
                                $("form").trigger('reset');
                                $("#createAppModal").modal("hide");
                                toastr.success('New Savings account successfully added.', 'New Savings!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });

                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function () {
                                $this.attr('disabled', false).html($caption);
                                //$("#createAppModal").modal("hide");
                                toastr.error('New account added failed.', 'Failed!', {
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
                        url: "{{ url('daily-reset') }}/" + id,
                        success: function () {
                            $(".datatables-basic").DataTable().destroy();
                            loadData();
                            toastr.success('Daily Savings a/c has been reset successfully.', 'Reset!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        },
                        error: function (data) {
                            toastr.error('Daily Savings a/c reset failed.', 'Failed!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        }
                    });

                }
            })


        });
    </script>
@endsection
