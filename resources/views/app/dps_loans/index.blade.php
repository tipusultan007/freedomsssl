@extends('layouts/layoutMaster')

@section('title', 'মাসিক ঋণ তালিকা')
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
            <li class="breadcrumb-item active">মাসিক ঋণের তালিকা</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('dps-loans.create') }}" target="_blank">নতুন ঋণ প্রদান</a>
      </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table-bordered table table-sm">
                        <thead>
                        <tr>
                            <th class="fw-bolder py-2">নাম</th>
                            <th class="fw-bolder py-2">হিসাব নং</th>
                            <th class="fw-bolder py-2">ঋণের পরিমাণ</th>
                            <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
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
                               <table class="table table-sm table-bordered loan-list-table">
                                   <thead>
                                   <tr>
                                     <th class="fw-bolder ">তারিখ</th>
                                     <th class="fw-bolder ">পরিমাণ</th>
                                     <th class="fw-bolder ">সুদ(%)</th>
                                     <th class="fw-bolder ">অবশিষ্ট ঋণ</th>
                                     <th></th>
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

@section('page-script')


    <script>

        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData()
        {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                lengthMenu: [
                    [10, 100, 500, 50000],
                    [10, 100, 500, 50000],
                ],
                "ajax":{
                    "url": "{{ url('dataDpsLoans') }}"
                },
                "columns": [

                    { "data": "name", name: "নাম" },
                    { "data": "account_no", name: "হিসাব নং" },
                    { "data": "loan_amount", name: "ঋণের পরিমাণ" },
                    { "data": "remain_loan", name: "অবশিষ্ট ঋণ" },
                    { "data": "date", name: "তারিখ" },
                    { "data": "status", name: "স্ট্যাটাস" },
                    { "data": "action", name: "#" },
                ],
                columnDefs:[ {
                    // User full name and username
                    targets: 0,
                    render: function (data, type, full, meta) {
                        var $name = full['name'],
                            $id = full['id'],
                            $image = full['image'];
                        if ($image != null || $image != "") {
                            // For Avatar image
                            var $output =
                                '<img src="/images/' + $image + '" alt="Avatar" height="32" width="32">';
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
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                    {
                        // Label
                        targets: 5,
                        render: function (data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                active: { title: 'চলমান', class: 'bg-primary' },
                                inactive: { title: 'নিষ্ক্রয়', class: ' bg-danger' },
                                paid: { title: 'পরিশোধ', class: ' bg-success' }
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
                    targets: 6,
                    orderable: false,
                    render: function(data, type, full, meta) {
                      return (
                        "<div class=\"d-inline-flex\">" +
                        "<a class=\"pe-1 dropdown-toggle hide-arrow text-primary\" data-bs-toggle=\"dropdown\">" +
                        '<i class="ti ti-dots-vertical ti-sm mx-1"></i>'+
                        "</a>" +
                        "<div class=\"dropdown-menu dropdown-menu-end\">" +
                        '<a href="{{url('dps-loans')}}/' + full["id"] + "\" class=\"dropdown-item\">" +
                        "বিস্তারিত</a>" +
                        "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item loan-list\">" +
                        "সকল ঋণ</a>" +
                        "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item item-reset\">" +
                        "রিসেট</a>" +
                        "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item text-danger delete-record\">" +
                        "ডিলেট</a>" +
                        "</div>" +
                        "</div>" +
                        "<a href=\"javascript:;\" class=\"item-edit\">" +
                        '<i class="ti ti-edit ti-sm me-2"></i>' +
                        "</a>"
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
                  ]
                },
              ],

            });
        }

        $('.data-submit').on('click', function () {

            $.ajax({
                url: "{{ route('dps.store') }}",
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
                     <td>তাঃ ${date} <br> আঃ ${commencement}</td>
                                       <td>${b.loan_amount}</td>
                                       <td>${b.interest1} ${b.interest2 > 0 ? " - "+b.interest2 : ""} </td>
                                       <td>${b.remain}</td>
<td>
<a class="btn btn-sm btn-primary waves-effect" target="_blank" href="{{ url('taken-loans') }}/${b.id}">বিস্তারিত</a>
</td>
</tr>
                        `);
                    })

                }
            })
            $("#loanListModal").modal("show");
        })
        // Delete Record
        function deleteDpsLoan(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('dps-loans') }}/" + id, //or you can use url: "company/"+id,
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
                  Swal.showValidationMessage('মাসিক সঞ্চয় ঋণ ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('মাসিক সঞ্চয় ঋণ ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });
        function resetMonthlyDPS(id) {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('reset-dps-loan') }}/" + id,
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
              return resetMonthlyDPS(id)
                .catch(() => {
                  Swal.showValidationMessage('ঋণ রিসেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('ঋন্টি সফলভাবে রিসেট হয়েছে।', 'রিসেট!', {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });
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
                    if (data.user.image == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.image;
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
                    if (data.user.image == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.image;
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
    </script>
@endsection
