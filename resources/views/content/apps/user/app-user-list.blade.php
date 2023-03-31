@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

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
    <div class="row">
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
    </div>
  <div class="row">
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
  </div>
  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Search & Filter</h4>
      <div class="row">
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
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
<div class="toast-container">
    <div
        class="toast deleteToast position-fixed top-0 end-0 m-2"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <div class="toast-header bg-danger text-white">
            <img
                src="{{asset('images/logo/logo.png')}}"
                class="me-1"
                alt="Toast image"
                height="18"
                width="25"
            />
            <strong class="me-auto">FreedomSSSL</strong>
            <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">User successfully deleted!</div>
    </div>
</div>
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

      $(function () {
          ('use strict');

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
         // var dt_users_list;
          // Users List datatable
         // loadTable();
          if (dtUserTable.length)
          {
              dtUserTable.DataTable({
                  ajax: "{{ url('allUsers') }}", // JSON file to add data
                  columns: [
                      // columns according to JSON
                      { data: '' },
                      { data: 'name' },
                      { data: 'phone1' },
                      { data: 'father_name' },
                      { data: 'present_address' },
                      { data: 'status' },
                      { data: '' }
                  ],
                  columnDefs: [
                      {
                          // For Responsive
                          className: 'control',
                          orderable: false,
                          responsivePriority: 2,
                          targets: 0,
                          render: function (data, type, full, meta) {
                              return '';
                          }
                      },
                      {
                          // User full name and username
                          targets: 1,
                          responsivePriority: 4,
                          render: function (data, type, full, meta) {
                              var $name = full['name'],
                                  $email = full['email'],
                                  $id = full['id'],
                                  $image = full['profile_photo_url'];
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
                                  '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
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
                          // User Role
                          targets: 2,
                          render: function (data, type, full, meta) {
                              var $role = full['phone1'];
                              var roleBadgeObj = {
                                  Subscriber: feather.icons['user'].toSvg({ class: 'font-medium-3 text-primary me-50' }),
                                  Author: feather.icons['settings'].toSvg({ class: 'font-medium-3 text-warning me-50' }),
                                  Maintainer: feather.icons['database'].toSvg({ class: 'font-medium-3 text-success me-50' }),
                                  Editor: feather.icons['edit-2'].toSvg({ class: 'font-medium-3 text-info me-50' }),
                                  Admin: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' })
                              };
                              return "<span class='text-truncate align-middle'>" + roleBadgeObj[$role] + $role + '</span>';
                          }
                      },
                      {
                          targets: 4,
                          render: function (data, type, full, meta) {
                              var $billing = full['present_address'];

                              return '<span class="text-nowrap">' + $billing + '</span>';
                          }
                      },
                      {
                          // User Status
                          targets: 5,
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
                          targets: -1,
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
                                  '<a href="' +
                                  userView +
                                  '" class="dropdown-item">' +
                                  feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                  'Details</a>' +
                                  '<a href="javascript:;" data-id="'+id+'" class="dropdown-item delete-record">' +
                                  feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                  'Delete</a></div>' +
                                  '</div>' +
                                  '</div>'
                              );
                          }
                      }
                  ],
                  order: [[1, 'desc']],
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
                  ],
                  // For responsive popup
                  responsive: {
                      details: {
                          display: $.fn.dataTable.Responsive.display.modal({
                              header: function (row) {
                                  var data = row.data();
                                  return 'Details of ' + data['name'];
                              }
                          }),
                          type: 'column',
                          renderer: function (api, rowIdx, columns) {
                              var data = $.map(columns, function (col, i) {
                                  return col.columnIndex !== 6 // ? Do not show row in modal popup if title is blank (for check box)
                                      ? '<tr data-dt-row="' +
                                      col.rowIdx +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      '<td>' +
                                      col.title +
                                      ':' +
                                      '</td> ' +
                                      '<td>' +
                                      col.data +
                                      '</td>' +
                                      '</tr>'
                                      : '';
                              }).join('');
                              return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                          }
                      }
                  },
                  language: {
                      paginate: {
                          // remove previous & next text from pagination
                          previous: '&nbsp;',
                          next: '&nbsp;'
                      }
                  }
              });
          }

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
          // Form Validation
          if (newUserForm.length) {
              newUserForm.validate({
                  errorClass: 'error',
                  rules: {
                      'name': {
                          required: true
                      },
                      'email': {
                          required: true
                      },
                      'phone1': {
                          required: true
                      },
                      'join_date': {
                          required: true
                      }
                  }
              });

              newUserForm.on('submit', function (e) {

                  var isValid = newUserForm.valid();
                  e.preventDefault();
                  if (isValid) {
                      $(".spinner").show();
                      $.ajax({
                          url: "{{ route('users.store') }}",
                          method: 'POST',
                          data: newUserForm.serialize(),
                          success: function (data) {
                              console.log(data)
                              newUserSidebar.modal('hide');
                          }
                      })

                  }else {
                      $(".spinner").hide();
                  }
              });
          }

          // Phone Number
          if (dtContact.length) {
              dtContact.each(function () {
                  new Cleave($(this), {
                      phone: true,
                      phoneRegionCode: 'BD'
                  });
              });
          }


      });

      function deleteUser(id) {
          //console.log(id);
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
                  var token = $("meta[name='csrf-token']").attr("content");
                  $.ajax({
                          url: "{{ url('users') }}/"+id,
                          type: 'DELETE',
                          data: {"id": id, "_token": token},
                          success: function (){
                              console.log("it Works");
                              $(".deleteToast").toast('show');
                          }
                      });

              }
          })
      }

  </script>
@endsection
