@extends('layouts.layoutMaster')
@section('title','স্থায়ী সঞ্চয় তালিকা')
@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
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
    <div class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item active">স্থায়ী সঞ্চয়(FDR) তালিকা</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('fdrs.create') }}" target="_blank">নতুন FDR</a>
      </div>
    </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <table class="datatables-basic table">
          <thead class="table-light">
          <tr>
            <th class="fw-bolder py-2">নাম</th>
            <th class="fw-bolder py-2">হিসাব নং </th>
            <th class="fw-bolder py-2">মোট জমা </th>
            <th class="fw-bolder py-2">ব্যালেন্স </th>
            <th class="fw-bolder py-2">মুনাফা উত্তোলন</th>
            <th class="fw-bolder py-2">তারিখ</th>
            <th class="fw-bolder py-2"></th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

@endsection


@section('page-script')


    <script>

        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData() {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('allFdrs') }}"
                },
                "columns": [
                    {"data": "name"},
                    {"data": "account_no"},
                    {"data": "amount"},
                    {"data": "balance"},
                    {"data": "profit"},
                    {"data": "date"},
                    {"data": "options"},
                ],
                columnDefs: [
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['user_id'],
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
                                '<a href="' +
                                userView + $id +
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +

                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },

                    {
                        // Actions
                        targets: 6,
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                '<i class="ti ti-dots"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('fdrs')}}/' + full['id'] + '" class="dropdown-item">' +
                                'বিস্তারিত</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item text-warning item-reset">' +
                                'রিসেট</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item text-danger fw-bolder delete-record">' +
                                'ডিলেট</a>' +
                                '</div>' +
                                '</div>'
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
                        className: 'btn btn-label-secondary dropdown-toggle mx-3',
                        text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: '<i class="ti ti-printer me-2" ></i>Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                            },
                            {
                                extend: 'csv',
                                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                className: 'dropdown-item',
                              bom: true,
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                className: 'dropdown-item',
                              bom: true,
                              exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                                className: 'dropdown-item',
                              bom: true,
                              exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                            },
                            {
                                extend: 'copy',
                                text: '<i class="ti ti-copy me-2" ></i>Copy',
                                className: 'dropdown-item',
                              exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
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
        function resetFdr(id) {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('reset-fdr') }}/" + id,
              success: function () {
                $(".datatables-basic").DataTable().destroy();
                loadData();
                resolve();
              },
              error: function (data) {
                reject();
              }
            });
          });
        }

        $('.datatables-basic tbody').on('click', '.item-reset', function () {
          var id = $(this).data("id");
          var token = $("meta[name='csrf-token']").attr("content");

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
              return resetFdr(id)
                .catch(() => {
                  Swal.showValidationMessage('স্থায়ী সঞ্চয় রিসেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('স্থায়ী সঞ্চয় সফলভাবে রিসেট হয়েছে।', 'রিসেট!', {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });
        });
        $(document).on("click", ".deposit-list", function () {

        })

        function deleteFdrWithdraw(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('fdrs') }}/" + id, //or you can use url: "company/"+id,
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
              return deleteFdrWithdraw(id)
                .catch(() => {
                  Swal.showValidationMessage('স্থায়ী সঞ্চয় (FDR) ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('স্থায়ী সঞ্চয় (FDR) ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });

       /* $(document).on("click", ".delete-record", function () {
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
                            url: "/fdrs/" + id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response) {

                                //$("#success").html(response.message)

                                Swal.fire(
                                    'Success!',
                                    'FDR A/C has been deleted successfully!',
                                    'success'
                                )
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function (data) {
                                Swal.fire(
                                    'Failed!',
                                    'FDR A/C deletion has been failed!',
                                    'error'
                                )
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        });
                }
            });
        })*/

        $("#createFdrModal").on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: 'Select a User'
            });
        });

        $("#account_no").on("change", function () {
            // Print entered value in a div box
            let account_digit = $(this).val();
            let account_no = account_digit.padStart(4,'0');
            if ($(this).val() != "") {
                let ac = "FDR"+account_no;
                $("#result").empty();
                $.ajax({
                    url: "{{ url('is-fdr-exist') }}/" + ac,
                    success: function (data) {
                        console.log(data)
                        if (data == "yes") {
                            $("#result").removeClass("text-success");
                            $("#result").addClass("text-danger");
                            $("#result").text("This A/C Number Already Exists. Please Try Another.")
                        } else {
                            $("#result").removeClass("text-danger");
                            $("#result").addClass("text-success");
                            $("#result").text("Congrats! This A/C Number is available.")
                        }
                    }
                })
            } else {
                $("#result").removeClass("text-success");
                $("#result").addClass("text-danger");
                $("#result").text("Enter Valid A/C number.")
            }

        });


    </script>
@endsection
