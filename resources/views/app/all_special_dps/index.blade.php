@extends('layouts/layoutMaster')

@section('title', __('বিশেষ সঞ্চয় (মাসিক)'))


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
    @php
    $users = \App\Models\User::all();
    @endphp
    <section class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item active">বিশেষ সঞ্চয় তালিকা</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('special-dps.create') }}" target="_blank">নতুন সঞ্চয় হিসাব</a>
      </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table table-sm">
                        <thead class="table-light">
                        <tr>
                          <th class="py-2 fw-bolder">হিসাব নং</th>
                            <th class="py-2 fw-bolder">নাম</th>
                            <th class="py-2 fw-bolder">তারিখ</th>
                            <th class="py-2 fw-bolder">প্যাকেজ</th>
                            <th class="py-2 fw-bolder">প্রাথমিক জমা</th>
                            <th class="py-2 fw-bolder">ব্যালেন্স</th>
                            <th class="py-2 fw-bolder">স্ট্যাটাস</th>
                            <th class="py-2">#</th>
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

        loadData();

        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';
        var prefixMask = $('#account_no');
        function loadData() {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('specialDpsData') }}"
                },
                "columns": [

                  {"data": "account_no"},
                    {"data": "name"},
                    {"data": "date"},
                    {"data": "package"},
                    {"data": "initial_deposit"},
                    {"data": "balance"},
                    {"data": "status"},
                    {"data": "action"},
                ],
                columnDefs: [
                    {
                        // Label
                        targets: 6,
                        render: function (data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                active: {title: 'চলমান', class: 'bg-success bg-glow'},
                                complete: {title: 'পরিশোধ', class: ' bg-danger bg-glow'}
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
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                '<i class="ti ti-dots"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('special-dps')}}/' + full['id'] + '" class="dropdown-item">' +
                                'বিস্তারিত</a>' +
                                '<a href="{{url('special-dps')}}/' + full['id'] + '/edit" class="dropdown-item">' +
                                'এডিট</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item item-reset">' +
                                'রিসেট</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item fw-bolder text-danger delete-record">' +
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
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'copy',
                                text: '<i class="ti ti-copy me-2" ></i>Copy',
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

                ],

            });
        }

        $('.data-submit').on('click', function () {

            $.ajax({
                url: "{{ route('special-dps.store') }}",
                method: "POST",
                data: $(".add-new-record").serialize(),
                success: function (data) {
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('New Special DPS  account successfully added.', 'New Special DPS!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".modal").modal('hide');
                }

            })

            /* if ($account_no != '') {
                 dt_basic.row
                     .add({
                         id: count,
                         account_no: $account_no,
                         user_id: $user_id,
                         opening_date: $opening_date,
                         status: 'active'
                     })
                     .draw();
                 count++;
                 $('.modal').modal('hide');
             }*/
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
                        url: "{{ url('special-dps') }}/" + id,
                        type: 'DELETE',
                        data: {"id": id, "_token": token},
                        success: function () {
                            $(".datatables-basic").DataTable().row($(this).parents('tr'))
                                .remove()
                                .draw();
                            toastr.error('DPS a/c has been deleted successfully.', 'Deleted!', {
                                closeButton: true,
                                tapToDismiss: false
                            });
                        }
                    });

                }
            })


        });

        function resetSpecialDPS(id) {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('reset-special-dps') }}/" + id,
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
              return resetSpecialDPS(id)
                .catch(() => {
                  Swal.showValidationMessage('DPS একাউন্ট রিসেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('DPS একাউন্টটি সফলভাবে রিসেট হয়েছে।', 'রিসেট!', {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });
        });

        $(document).on('change','#account_no',function () {
            //let ac = "ML-"+$(this).val();
            let account_digit = $(this).val();
            let account_no = account_digit.padStart(4,'0');
            let ac = "ML"+account_no;
            $("#result").empty();
            if ($(this).val() != ""){
                $.ajax({
                    url: "{{ url('special-dps-exist') }}/"+ac,
                    type: "GET",
                    success: function (data) {
                        if (data > 0) {
                            $("#result").removeClass("text-success");
                            $("#result").addClass("text-danger");
                            $("#result").text("This A/C Number Already Exists. Please Try Another.")
                            $(".btn-next").prop("disabled",true);
                        } else {
                            $("#result").removeClass("text-danger");
                            $(".btn-next").prop("disabled",false);
                        }
                    }
                })
            }

        })

        $("#user_nominee_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#nominee_name").val('');
            $("#nominee_address").val('');
            $("#nominee_phone").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
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
    </script>
@endsection
