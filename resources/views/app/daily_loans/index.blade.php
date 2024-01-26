
@extends('layouts/layoutMaster')

@section('title', 'দৈনিক ঋণের তালিকা')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('content')

  <!-- Basic table -->
    <section class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item active">দৈনিক ঋণের তালিকা</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('daily-loans.create') }}" target="_blank">নতুন ঋণ প্রদান</a>
      </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-bolder py-2">নাম</th>
                            <th class="fw-bolder py-2">হিসাব নং</th>
                            <th class="fw-bolder py-2">ঋণের পরিমাণ</th>
                            <th class="fw-bolder py-2">সুদ</th>
                            <th class="fw-bolder py-2">Adjust Amount</th>
                            <th class="fw-bolder py-2">ব্যালেন্স</th>
                            <th class="fw-bolder py-2">তারিখ</th>
                            <th class="fw-bolder py-2">স্ট্যাটাস</th>
                            <th class="fw-bolder py-2">#</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
    </section>
    <!--/ Basic table -->

@endsection

@section('page-script')
  <script>
    // Add this script at the end of your HTML file or in a separate .js file
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        var alertContainer = document.getElementById('alertContainer');
        if (alertContainer) {
          alertContainer.innerHTML = ''; // Remove the alert message
        }
      }, 5000); // Change 5000 to the desired duration in milliseconds (5 seconds in this example)
    });
  </script>
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

        loadData();
        function loadData() {
          $(".datatables-basic").DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ url('dailyLoanData') }}",
            columns: [
              { data: 'name' },
              { data: 'account_no' },
              { data: 'loan_amount' }, // used for sorting so will hide this column
              { data: 'interest'},
              { data: 'adjusted_amount' },
              { data: 'balance' },
              { data: 'date' },
              { data: 'status' },
              { data: '' },
            ],
            columnDefs: [
              {
                // User full name and username
                targets: 0,
                render: function (data, type, full, meta) {
                  var $name = full['name'],
                    $id = full['id'],
                    $image = full['image'];
                  if ($image != null) {
                    // For Avatar image
                    var $output =
                      '<img src="{{ asset('storage/images/profile') }}/' + $image + '" alt="Avatar" height="32" width="32">';
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
                    active: { title: 'চলমান', class: 'rounded-pill bg-label-primary' },
                    inactive: { title: 'নিষ্ক্রিয়', class: ' rounded-pill bg-label-danger' },
                    complete: { title: 'পরিশোধ', class: ' rounded-pill bg-label-success' }
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
                title: '#',
                orderable: false,
                render: function (data, type, full, meta) {
                  return (
                    '<div class="d-inline-flex">' +
                    '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                    '<i class="ti ti-dots"></i>' +
                    '</a>' +
                    '<div class="dropdown-menu dropdown-menu-end">' +
                    '<a href="{{url('daily-loans')}}/'+full['id']+'" class="dropdown-item">' +
                    'বিস্তারিত</a>' +
                    '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item text-warning item-reset">' +
                    'রিসেট</a>' +
                    '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item text-danger delete-record">' +
                    'ডিলেট</a>' +
                    '</div>' +
                    '</div>' +
                    '<a href="/daily-loans/'+full['id']+'/edit" class="item-edit">' +
                    '<i class="ti ti-edit ms-2"></i>' +
                    '</a>'
                  );
                }
              }
            ],
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7, 10, 25, 50, 75, 100,50000],
            buttons: [
              {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-3',
                text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                buttons: [
                  {
                    extend: 'print',
                    text: '<i class="ti ti-printer me-2" ></i>Print',
                    className: 'dropdown-item',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5,6]}
                  },
                  {
                    extend: 'csv',
                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                    className: 'dropdown-item',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5,6]}
                  },
                  {
                    extend: 'excel',
                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                    className: 'dropdown-item',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5,6]}
                  },
                  {
                    extend: 'pdf',
                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                    className: 'dropdown-item',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5,6]}
                  },
                  {
                    extend: 'copy',
                    text: '<i class="ti ti-copy me-2" ></i>Copy',
                    className: 'dropdown-item',
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5,6]}
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
            ],
            language: {
              paginate: {
                previous: 'Prev',
                next: 'Next'
              }
            }
          });
        }



        function deleteDpsLoan(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('daily-loans') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token
              },
              success: function () {
                resolve();
              },
              error: function (data) {
                reject();
              }
            });
          });
        }
        $(document).on('click', '.delete-record', function () {
          var id = $(this).data("id");
          Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: 'এটি আপনি পুনরায় পাবেন না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, এটি ডিলেট করুন!',
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false,
            allowOutsideClick: () => !Swal.isLoading(),
            showLoaderOnConfirm: true,
            preConfirm: () => {
              // Return the promise from the AJAX request function
              return deleteDpsLoan(id)
                .catch(() => {
                  Swal.showValidationMessage('দৈনিক ঋণ ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('দৈনিক ঋণ ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });

        function resetDailyLoan(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('reset-daily-loans') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token
              },
              success: function () {
                resolve();
              },
              error: function (data) {
                reject();
              }
            });
          });
        }
        $(document).on('click', '.item-reset', function () {
          var id = $(this).data("id");
          Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: 'এটি আপনি পুনরায় পাবেন না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false,
            allowOutsideClick: () => !Swal.isLoading(),
            showLoaderOnConfirm: true,
            preConfirm: () => {
              // Return the promise from the AJAX request function
              return deleteDpsLoan(id)
                .catch(() => {
                  Swal.showValidationMessage('দৈনিক ঋণ রিসেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('দৈনিক ঋণ রিসেট হয়েছে।', 'রিসেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });

        $("#createLoanModal").on('shown.bs.modal', function () {
            $(".select2-size-sm").select2();
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
