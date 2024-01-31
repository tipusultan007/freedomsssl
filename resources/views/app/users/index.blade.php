@extends('layouts/layoutMaster')

@section('title', 'সদস্য তালিকা')

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
  <style>
    #user-list-table {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #user-list-table td, #user-list-table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #user-list-table tr:nth-child(even){background-color: #f2f2f2;}

    #user-list-table tr:hover {background-color: #f2f2f2;}

    #user-list-table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: center;
      background-color: #7367f0;
      color: white;
    }
  </style>
    <!-- users list start -->
    <section class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item active">সদস্য তালিকা</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('users.create') }}">নতুন সদস্য</a>
      </div>
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table id="user-list-table" class="user-list-table table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="fw-bolder py-2">ছবি</th>
                        <th class="fw-bolder py-2">ব্যক্তিগত তথ্য</th>
                        <th class="fw-bolder py-2">ঠিকানা</th>
                        <th class="fw-bolder py-2">হিসাব তথ্য</th>
                        <th class="fw-bolder py-2">তারিখ</th>
                        <th class="fw-bolder py-2">স্ট্যাটাস</th>
                        <th class="fw-bolder py-2"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- list and filter end -->
    </section>

@endsection


@section('page-script')

    <script>


        loadData();

        var dtUserTable = $('.user-list-table'),
            dtContact = $('.dt-phone'),
            statusObj = {
                active: { title: 'Active', class: 'badge-light-success' },
                inactive: { title: 'Inactive', class: 'badge-light-secondary' }
            };

        var assetPath = '../../../app-assets/',
            userView = '{{ url('users') }}/';



       var statusObj = {
          inactive: { title: 'Pending', class: 'bg-label-warning' },
          active: { title: 'Active', class: 'bg-label-success' },
          closed: { title: 'Inactive', class: 'bg-label-secondary' }
        };

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

                    { data: 'image' },
                    { data: 'bio' },
                    { data: 'address' },
                    { data: 'ac_details' },
                    { data: 'join_date' },
                    { data: 'status' },
                    { data: '' }
                ],
                columnDefs: [

                  {
                    // User Status
                    targets: 5,
                    render: function (data, type, full, meta) {
                      var $status = full['status'];

                      return (
                        '<span class="badge ' +
                        statusObj[$status].class +
                        '" text-capitalized>' +
                        statusObj[$status].title +
                        '</span>'
                      );
                    }
                  },
                    {
                        // Actions
                        targets: 6,

                        orderable: false,
                      render: function(data, type, full, meta) {
                        return (
                          '<div class="d-flex align-items-center">' +
                          '<a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical text-primary ti-sm mx-1"></i></a>' +
                          '<div class="dropdown-menu dropdown-menu-end m-0">' +
                          '<a href="/users/'+full['id']+'" class="dropdown-item">বিস্তারিত</a>' +
                          '<a href="/users/'+full['id']+'/edit" class="dropdown-item">সম্পাদনা</a>' +
                          '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item delete text-danger fw-bolder">ডিলেট</a>' +
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
                          exportOptions: {
                            columns: [0,1, 2, 3,4,5],
                          }
                        },
                        {
                          extend: 'csv',
                          text: '<i class="ti ti-file-text me-2" ></i>Csv',
                          bom: true,
                          className: 'dropdown-item',
                          exportOptions: {
                            columns: [0,1, 2, 3,4,5],
                          }
                        },
                        {
                          extend: 'excel',
                          text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                          bom: true,
                          className: 'dropdown-item',
                          exportOptions: {
                            columns: [0,1, 2, 3,4,5],
                          }
                        },
                        {
                          extend: 'pdf',
                          text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                          bom: true,
                          className: 'dropdown-item',
                          exportOptions: {
                            columns: [0,1, 2, 3,4,5],
                          }
                        },
                        {
                          extend: 'copy',
                          text: '<i class="ti ti-copy me-2" ></i>Copy',
                          className: 'dropdown-item',
                          exportOptions: {
                            columns: [0,1, 2, 3,4,5],
                          }
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
                ]

            });
        }

        // Delete Record
        $('.user-list-table tbody').on('click', '.delete', function () {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'হ্যাঁ!',
                cancelButtonText: 'না!',
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
                            toastr.error('গ্রাহক সফলভাবে মুছে ফেলা হয়েছে.', 'মুছে ফেলা হয়েছে!', {
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
