@extends('layouts/contentLayoutMaster')

@section('title', 'Users')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <style>
        /* Style for positioning toast */
        .toast{
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection

@section('content')
    <!-- users list start -->
    <section class="app-user-list">
       {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">
                            <br>
                            <button class="btn btn-success">Import User Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>--}}
        {{--<div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">21,459</h3>
                            <span>Total Users</span>
                        </div>
                        <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="user" class="font-medium-4"></i>
            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">4,567</h3>
                            <span>Paid Users</span>
                        </div>
                        <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="user-plus" class="font-medium-4"></i>
            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">19,860</h3>
                            <span>Active Users</span>
                        </div>
                        <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="user-check" class="font-medium-4"></i>
            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">237</h3>
                            <span>Pending Users</span>
                        </div>
                        <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="user-x" class="font-medium-4"></i>
            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        <!-- list and filter start -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="user-list-table table table-sm">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Father</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog modal-xl">
                    <form class="add-new-user modal-content pt-0">
                        @csrf
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="row">
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="name">{{__('Name')}}</label>
                                    <input
                                        type="text"
                                        class="form-control dt-name"
                                        id="name"
                                        name="name"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="email">{{__('Email')}}</label>
                                    <input
                                        type="text"
                                        id="email"
                                        class="form-control dt-email"
                                        name="email" autocomplete="off"
                                    />
                                </div>

                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="phone">{{__('Phone')}}</label>
                                    <input
                                        type="text"
                                        id="phone"
                                        class="form-control dt-phone"
                                        name="phone1" autocomplete="off"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="password">{{__('Password')}}</label>
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control dt-password"
                                        name="password" autocomplete="off"
                                    />
                                </div>
                                <div class="mb-1 col-md-6 position-relative">
                                    <label class="form-label" for="birthdate">{{__('Date of Birth')}}</label>
                                    <input type="text" id="birthdate" name="birthdate" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                </div>

                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="father_name">{{__('Father Name')}}</label>
                                    <input
                                        type="text"
                                        id="father_name"
                                        class="form-control dt-father-name"
                                        name="father_name"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="mother_name">{{__('Mother Name')}}</label>
                                    <input
                                        type="text"
                                        id="mother_name"
                                        class="form-control dt-mother-name"
                                        name="mother_name"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="gender">{{__('Gender')}}</label>
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="gender" id="radiobtn_male" value="male" checked="">
                                            <label class="form-check-label" for="radiobtn_male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="gender" id="radiobtn_female" value="female">
                                            <label class="form-check-label" for="radiobtn_female">Female</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="marital_status">{{__('Marital Status')}}</label>
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="marital_status" id="radiobtn_married" value="married" checked="">
                                            <label class="form-check-label" for="radiobtn_married">Married</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="marital_status" id="radiobtn_unmarried" value="unmarried">
                                            <label class="form-check-label" for="radiobtn_unmarried">Unmarried</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="spouse_name">{{__('Spouse Name')}}</label>
                                    <input
                                        type="text"
                                        id="spouse_name"
                                        class="form-control dt-spouse-name"
                                        name="spouse_name"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="present_address">{{__('Present Address')}}</label>
                                    <input
                                        type="text"
                                        id="present_address"
                                        class="form-control dt-present-address"
                                        name="present_address"
                                    />
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="permanent_address">{{__('Permanent Address')}}</label>
                                    <input
                                        type="text"
                                        id="permanent_address"
                                        class="form-control dt-permanent-address"
                                        name="permanent_address"
                                    />
                                </div>

                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="photo">{{__('Photo')}}</label>
                                    <input class="form-control" name="profile_photo_url" type="file" id="photo">
                                </div>
                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="national_id">{{__('NID')}}</label>
                                    <input class="form-control" name="national_id" type="file" id="national_id">
                                </div>

                                @php
                                    $roles = \Spatie\Permission\Models\Role::get();
                                @endphp

                                <div class="mb-1 col-md-6">
                                    <label class="form-label" for="user-role">User Role</label>
                                    <select id="user-role" name="roles[]" class="select2 form-select">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-1 col-md-6 position-relative">
                                    <label class="form-label" for="join_date">{{__('Join Date')}}</label>
                                    <input type="text" id="join_date" name="join_date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-1 data-submit"><span class="spinner spinner-border spinner-border-sm" style="display: none" role="status" aria-hidden="true"></span> Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
        </div>
        <!-- list and filter end -->
    </section>
    <!-- users list ends -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Edit User Information</h1>
                        <p>Updating user details will receive a privacy audit.</p>
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75">
                        @csrf
                        @method('PATCH')
                            <div class="mb-1 col-md-4">
                                <input type="hidden" name="id" id="edit_userid">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        class="form-control dt-name"
                                        id="edit_name"
                                        name="name"
                                        placeholder="Name"
                                    />
                                    <label class="form-label" for="name">{{__('Name')}}</label>
                                </div>

                            </div>
                            <div class="mb-1 col-md-4">
                               <div class="form-floating">
                                   <input
                                       type="text"
                                       id="edit_email"
                                       class="form-control dt-email"
                                       name="email" autocomplete="off"
                                       placeholder="Email"
                                   />
                                   <label class="form-label" for="email">{{__('Email')}}</label>
                               </div>

                            </div>

                            <div class="mb-1 col-md-4">
                                <div class="form-floating">
                                <input
                                    type="text"
                                    id="edit_phone"
                                    class="form-control dt-phone"
                                    name="phone1" autocomplete="off"
                                    placeholder="Phone"
                                />
                                    <label class="form-label" for="phone">{{__('Phone')}}</label>
                                </div>
                            </div>

                            <div class="mb-1 col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="edit_birthdate" name="birthdate" class="form-control flatpickr-basic" placeholder="Date Of Birth" />
                                    <label class="form-label" for="birthdate">{{__('Date of Birth')}}</label>
                                </div>

                            </div>

                            <div class="mb-1 col-md-4">
                              <div class="form-floating">
                                  <input
                                      type="text"
                                      id="edit_father_name"
                                      class="form-control dt-father-name"
                                      name="father_name"
                                      placeholder="Father Name"
                                  />
                                  <label class="form-label" for="father_name">{{__('Father Name')}}</label>
                              </div>

                            </div>
                            <div class="mb-1 col-md-4">
                               <div class="form-floating">
                                   <input
                                       type="text"
                                       id="edit_mother_name"
                                       class="form-control dt-mother-name"
                                       name="mother_name"
                                       placeholder="Mother Name"
                                   />
                                   <label class="form-label" for="mother_name">{{__('Mother Name')}}</label>
                               </div>

                            </div>
                            <div class="mb-1 col-md-6">
                                <label class="form-label mb-0" for="gender">{{__('Gender')}}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline mt-0">
                                        <input class="form-check-input" type="radio" name="gender" id="edit_radiobtn_male" value="male">
                                        <label class="form-check-label" for="edit_radiobtn_male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-0">
                                        <input class="form-check-input" type="radio" name="gender" id="edit_radiobtn_female" value="female">
                                        <label class="form-check-label" for="edit_radiobtn_female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 col-md-6">
                                <label class="form-label mb-0" for="marital_status">{{__('Marital Status')}}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline mt-0">
                                        <input class="form-check-input" type="radio" name="marital_status" id="edit_radiobtn_married" value="married">
                                        <label class="form-check-label" for="edit_radiobtn_married">Married</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-0">
                                        <input class="form-check-input" type="radio" name="marital_status" id="edit_radiobtn_unmarried" value="unmarried">
                                        <label class="form-check-label" for="edit_radiobtn_unmarried">Unmarried</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 col-md-4">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        id="edit_spouse_name"
                                        class="form-control dt-spouse-name"
                                        name="spouse_name"
                                        placeholder="Spouse Name"
                                    />
                                    <label class="form-label" for="spouse_name">{{__('Spouse Name')}}</label>
                                </div>

                            </div>
                            <div class="mb-1 col-md-4">
                               <div class="form-floating">
                                   <input
                                       type="text"
                                       id="edit_present_address"
                                       class="form-control dt-present-address"
                                       name="present_address"
                                       placeholder="Present Address"
                                   />
                                   <label class="form-label" for="present_address">{{__('Present Address')}}</label>
                               </div>

                            </div>
                            <div class="mb-1 col-md-4">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        id="edit_permanent_address"
                                        class="form-control dt-permanent-address"
                                        name="permanent_address"
                                        placeholder="Permanent Address"
                                    />
                                    <label class="form-label" for="permanent_address">{{__('Permanent Address')}}</label>
                                </div>

                            </div>

                            <div class="mb-1 col-md-6">
                                <label class="form-label" for="photo">{{__('Photo')}}</label>
                                <input class="form-control" name="profile_photo_url" type="file" id="edit_photo">
                            </div>
                            <div class="mb-1 col-md-6">
                                <label class="form-label" for="national_id">{{__('NID')}}</label>
                                <input class="form-control" name="national_id" type="file" id="edit_national_id">
                            </div>

                            @php
                                $roles = \Spatie\Permission\Models\Role::get();
                            @endphp

                            <div class="mb-1 col-md-6">

                                <select id="edit_user-role" name="roles" class="select2 form-select" data-placeholder="Select Role">
                                    <option value=""></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1 col-md-6 position-relative">
                               <div class="form-floating">
                                   <input type="text" id="edit_join_date" name="join_date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                   <label class="form-label" for="join_date">{{__('Join Date')}}</label>
                               </div>
                            </div>

                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1 btn-update">Update</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit User Modal -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
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
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    {{--<script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>--}}
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    {{--<script src="{{ asset(mix('js/scripts/components/components-bs-toast.js')) }}"></script>--}}
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        loadData();

        var dtUserTable = $('.user-list-table'),
            newUserSidebar = $('.new-user-modal'),
            newUserForm = $('.add-new-user'),
            select = $('.select2'),
            dtContact = $('.dt-phone'),
            statusObj = {
                active: { title: 'Active', class: 'badge-light-success' },
                inactive: { title: 'Inactive', class: 'badge-light-secondary' }
            };

        var assetPath = '../../../app-assets/',
            userView = '{{ url('users') }}/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
            userView = '{{ url('users') }}/';
        }

        select.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
        function loadData()
        {
            $('.user-list-table').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('userData') }}"
                },
                columns: [
                    // columns according to JSON

                    { data: 'name' },
                    { data: 'phone' },
                    { data: 'father_name' },
                    { data: 'present_address' },
                    { data: 'status' },
                    { data: '' }
                ],
                columnDefs: [
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $email = full['email'],
                                $id = full['id'],
                                $image = full['profile_photo_path'];
                            if ($image) {
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
                                $email +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },

                    {
                        // User Status
                        targets: 4,
                        render: function (data, type, full, meta) {
                            var $status = full['status'];

                            return (
                                '<span class="badge rounded-pill ' +
                                statusObj[$status].class +
                                '" text-capitalized>' +
                                statusObj[$status].title +
                                '</span>'
                            );
                        }
                    },
                    {
                        // Actions
                        targets: 5,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var id = full['id'];
                            return (
                                '<div class="btn-group">' +
                                '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{ url('users') }}/'+id+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="'+id+'" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a></div>' +
                                '</div>' +
                                '</div>'+
                                '<a href="javascript:;" class="item-edit" data-id="'+id+'">' +
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
                                exportOptions: { columns: [1, 2, 3, 4, 5] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [1, 2, 3, 4, 5] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [1, 2, 3, 4, 5] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [1, 2, 3, 4, 5] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [1, 2, 3, 4, 5] }
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
                ]

            });
        }


        //Edit User
        $(".user-list-table tbody").on('click','.item-edit',function () {
            var id = $(this).data("id");
            $.ajax({
                url: "{{ url('userInfo') }}/"+id,
                dataType: "JSON",
                success: function (data) {
                    var user = data.user;
                    $("#edit_userid").val(user.id);
                    $("#edit_name").val(user.name);
                    $("#edit_email").val(user.email);
                    $("#edit_phone").val(user.phone);
                    $("#edit_birthdate").val(user.birthdate);
                    $("#edit_father_name").val(user.father_name);
                    $("#edit_mother_name").val(user.mother_name);
                    if (user.gender=='male')
                    {
                        $("#edit_radiobtn_male").attr("checked",true);
                    }else if(user.gender=='male')
                    {
                        $("#edit_radiobtn_female").attr("checked",true)
                    }

                    if (user.marital_status=='married')
                    {
                        $("#edit_radiobtn_married").attr("checked",true);

                    }else if(user.marital_status=='unmarried')
                    {
                        $("#edit_radiobtn_unmarried").attr("checked",true)
                    }

                    $("#edit_spouse_name").val(user.spouse_name);
                    $("#edit_present_address").val(user.present_address);
                    $("#edit_permanent_address").val(user.permanent_address);
                    $("#edit_user-role").val(user.roles);

                }
            })
            $("#editUserModal").modal("show");
        })
        $(".btn-update").click(function () {
            var id = $("#edit_userid").val();
            var $this = $(".btn-update");
            var $caption = $this.html();
            $.ajax({
                url: "{{ url('users') }}/"+id,
                type: 'PUT',
                data: $("#editUserForm").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#editUserModal").modal("hide");
                    $("#editUserForm").trigger("reset");
                    toastr.success('User data updated successfully.', 'Updated!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                },
                error: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#editUserModal").modal("hide");
                    toastr.error('User data update failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $("#editUserForm").trigger("reset");
                }
            })
        })
        // Delete Record
        $('.user-list-table tbody').on('click', '.delete-record', function () {
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
                    $(".user-list-table").DataTable().row( $(this).parents('tr') )
                        .remove()
                        .draw();
                    $.ajax({
                        url: "{{ url('users') }}/"+id,
                        type: 'DELETE',
                        data: {"id": id, "_token": token},
                        success: function (){
                            $(".user-list-table").DataTable().destroy();
                            loadData();
                            // $(".deleteToast").toast('show');
                            toastr.error('User has been deleted successfully.', 'Deleted!', {
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
