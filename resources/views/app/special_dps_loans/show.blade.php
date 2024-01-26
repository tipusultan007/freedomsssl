@extends('layouts/layoutMaster')

@section('title', $specialDpsLoan->account_no.' - বিশেষ ঋণ')

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
  <section class="app-user-view-account">
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
        <!-- User Card -->
        <div class="card">
          <div class="card-body">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img
                  class="img-fluid rounded mt-3 mb-2"
                  src="{{ asset('storage/images/profile/'.$specialDpsLoan->user->image) }}"
                  height="110"
                  width="110"
                  alt="User avatar"
                />
                <div class="user-info text-center">
                  <h4>
                    <a href="{{ route('users.show',$specialDpsLoan->user_id) }}">{{ $specialDpsLoan->user->name }}</a>
                  </h4>
                  <span class="badge bg-light-secondary">{{ $specialDpsLoan->user->phone1 }}</span>
                </div>
              </div>
            </div>

            <table class="table table-sm table-bordered">
              <tr>
                <th class="py-1 fw-bolder">সর্বমোট ঋণ</th>
                <th class="py-1 fw-bolder">অবশিষ্ট ঋণ</th>
              </tr>
              <tr>
                <td>{{ $specialDpsLoan->loan_amount }}</td>
                <td>{{ $specialDpsLoan->remain_loan }}</td>
              </tr>
            </table>
            <h4 class="fw-bolder border-bottom pb-50 mb-1 mt-3">বিস্তারিত</h4>
            <div class="info-container">
              <table class="table table-sm table-bordered">
                <tr class="mb-75">
                  <th class="fw-bolder py-1">হিসাব নং</th>
                  <td>{{ $specialDpsLoan->account_no??'' }}</td>
                </tr>
                <tr class="mb-75">
                  @php
                    $loans = \App\Models\SpecialLoanTaken::where('account_no',$specialDpsLoan->account_no)->get();
                    $total_interest = \App\Models\SpecialLoanInterest::where('account_no',$specialDpsLoan->account_no)->sum('total');
                  @endphp
                  <th class="fw-bolder py-1">সর্বমোট ঋণ</th>
                  <td>{{ $loans->sum('loan_amount') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="fw-bolder py-1">ঋণ ফেরত</th>
                  <td>{{ $loans->sum('loan_amount') - $loans->sum('remain') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="fw-bolder py-1">অবশিষ্ট ঋণ</th>
                  <td>{{ $loans->sum('remain') }}</td>
                </tr>
                <tr class="mb-75">

                  <th class="fw-bolder py-1">লভ্যাংশ আদায়</th>
                  <td>{{ $total_interest }}</td>
                </tr>
                <tr class="mb-75">

                  <th class="fw-bolder py-1">বকেয়া লভ্যাংশ</th>
                  <td>{{ $specialDpsLoan->dueInterest }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="fw-bolder py-1">ঋণ মওকুফ</th>
                  <td>{{ $specialDpsLoan->grace }}</td>
                </tr>

                <tr class="mb-75">
                  <th class="fw-bolder py-1">স্ট্যাটাস</th>
                  <td>
                    @if($specialDpsLoan->status == 'active')
                      <span class="badge bg-success"> চলমান </span>
                    @else
                      <span class="badge bg-danger"> পরিশোধ</span>
                    @endif
                  </td>
                </tr>

              </table>

            </div>
          </div>
        </div>
        <!-- /User Card -->
      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">
        <!-- User Pills -->
        <ul class="nav nav-pills nav-justified" role="tablist">
          <li class="nav-item ">
            <a
              class="nav-link active"
              id="loans-tab"
              data-bs-toggle="tab"
              href="#takenLoans"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">সকল ঋণের তালিকা</span></a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link "
              id="savings-tab"
              data-bs-toggle="tab"
              href="#savingAccount"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">ঋণ সংক্রান্ত লেনদেন</span></a>
          </li>


        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="takenLoans" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
              <tr>
                <th class="fw-bolder py-2">ঋণের পরিমাণ</th>
                <th class="fw-bolder py-2">সুদ</th>
                <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
                <th class="fw-bolder py-2">তারিখ</th>
                <th class="fw-bolder py-2">#</th>
              </tr>
              </thead>
              <tbody>
              @forelse($specialDpsLoan->specialLoanTakens as $loan)
                <tr>
                  <td>{{ $loan->loan_amount }}</td>
                  <td>{{ $loan->interest1 }} {{ $loan->interest2!=""?"||".$loan->interest2:"" }}</td>
                  <td>{{ $loan->remain }}</td>
                  <td>D: {{ date('d/m/Y',strtotime($loan->date)) }} <br>
                    C: {{ date('d/m/Y',strtotime($loan->commencement)) }}
                  </td>
                  <td>
                    <div class="dropdown">
                      <a href="javascript:;" class="btn p-0" id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots ti-sm text-primary"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end"  style="">
                        <a class="dropdown-item" href="{{ route('special-loan-takens.show',$loan->id) }}" target="_blank">দেখুন</a>
                        <a class="dropdown-item" href="{{ route('special-loan-takens.edit',$loan->id) }}" target="_blank">এডিট</a>
                        <a class="dropdown-item text-danger delete fw-bolder" data-id="{{ $loan->id }}" href="javascript:void(0);">ডিলেট</a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
              @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane " id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="datatables-basic table table-sm table-bordered">
              <thead class="table-light">
              <tr>
                <th class="fw-bolder py-2">তারিখ</th>
                <th class="fw-bolder py-2">সুদ</th>
                <th class="fw-bolder py-2">ঋণ ফেরত</th>
                <th class="fw-bolder py-2">ব্যালেন্স</th>
                <th class="fw-bolder py-2">আদায়কারি</th>
                <th class="fw-bolder py-2">#</th>
              </tr>
              </thead>
            </table>
          </div>
        </div>

      </div>
      <!--/ User Content -->
    </div>
  </section>

@endsection

@section('page-script')

  <script>
    // Variable declaration for table
    var dtAccountsTable = $(".datatable-accounts"),
      dtLoansTable = $(".datatable-loans"),
      invoicePreview = "app-invoice-preview.html",
      assetPath = "../../../app-assets/";

    if ($("body").attr("data-framework") === "laravel") {
      assetPath = $("body").attr("data-asset-path");
      invoicePreview = assetPath + "app/invoice/preview";
    }
    var ac = "{{ $specialDpsLoan->account_no }}";
    var loanId = "{{ $specialDpsLoan->id }}";

    loadData(loanId);

    function loadData(loanId = "") {
      $(".taken-loans-table").DataTable({
        "proccessing": true,
        "serverSide": true,
        "ajax": {
          "url": "{{ url('dataSpecialTakenLoans') }}",
          data: {
            dps_loan_id: loanId
          }
        },
        "columns": [
          { "data": "loan_amount" },
          { "data": "interest" },
          { "data": "remain" },
          { "data": "date" },
          { "data": "createdBy" },
          { "data": "action" }
        ],
        columnDefs: [
          {
            // Actions
            targets: 5,
            title: "Actions",
            orderable: false,
            render: function(data, type, full, meta) {
              var id = full["id"];
              return (
                "<div class=\"d-inline-flex\">" +
                "<a class=\"pe-1 dropdown-toggle hide-arrow text-primary\" data-bs-toggle=\"dropdown\">" +
               '<i class="ti ti-dots"></i>'+
                "</a>" +
                "<div class=\"dropdown-menu dropdown-menu-end\">" +
                '<a href="{{url('taken-loans')}}/' + full["id"] + "\" class=\"dropdown-item\">" +
                "Details</a>" +
                "<a href=\"javascript:;\" class=\"dropdown-item\">" +
                "Reset</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item delete-record\">" +
                "Delete</a>" +
                "</div>" +
                "</div>" +
                "<a href=\"javascript:;\" class=\"item-edit\">" +
               '<i class="ti ti-edit"></i>' +
                "</a>"
              );
            }
          }
        ],
        dom:
          "<\"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75\"" +
          "<\"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start\" l>" +
          "<\"col-sm-12 col-lg-8 ps-xl-75 ps-0\"<\"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap\"<\"me-1\"f>B>>" +
          ">t" +
          "<\"d-flex justify-content-between mx-2 row mb-1\"" +
          "<\"col-sm-12 col-md-6\"i>" +
          "<\"col-sm-12 col-md-6\"p>" +
          ">",
        language: {
          sLengthMenu: "Show _MENU_",
          search: "Search",
          searchPlaceholder: "Search.."
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

    loadLoanCollection(loanId);

    //loadLoanCollection();

    function loadLoanCollection(loanId) {

      $(".datatables-basic").DataTable({
        "proccessing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
          "url": "{{ url('dataSpecialLoanCollection') }}",
          data: {
            loanId: loanId
          }
        },
        "columns": [
          { "data": "date" },
          { "data": "interest" },
          { "data": "loan_installment" },
          { "data": "balance" },
          { "data": "collector" },
          { "data": "action" }
        ],
        columnDefs: [
          {
            // Actions
            targets: 5,
            title: "Actions",
            orderable: false,
            render: function(data, type, full, meta) {
              return (
                "<a href=\"javascript:;\" class=\"item-loan-delete\" data-id=\"" + full["id"] + "\">" +
                'ডিলেট'+
                "</a>"
              );
            }
          }
        ],
        dom:
          "<\"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75\"" +
          "<\"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start\" l>" +
          "<\"col-sm-12 col-lg-8 ps-xl-75 ps-0\"<\"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap\"<\"me-1\"f>B>>" +
          ">t" +
          "<\"d-flex justify-content-between mx-2 row mb-1\"" +
          "<\"col-sm-12 col-md-6\"i>" +
          "<\"col-sm-12 col-md-6\"p>" +
          ">",
        language: {
          sLengthMenu: "Show _MENU_",
          search: "Search",
          searchPlaceholder: "Search.."
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: "collection",
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
            buttons: [
              {
                extend: "print",
                text: '<i class="ti ti-printer me-2" ></i>Print',
                bom: true,
                className: "dropdown-item",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
              },
              {
                extend: "csv",
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                bom: true,
                className: "dropdown-item",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
              },
              {
                extend: "excel",
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                bom: true,
                className: "dropdown-item",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
              },
              {
                extend: "pdf",
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                bom: true,
                className: "dropdown-item",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
              },
              {
                extend: "copy",
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                bom: true,
                className: "dropdown-item",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
              }
            ],
            init: function(api, node, config) {
              $(node).removeClass("btn-secondary");
              $(node).parent().removeClass("btn-group");
              setTimeout(function() {
                $(node).closest(".dt-buttons").removeClass("btn-group").addClass("d-inline-flex mt-50");
              }, 50);
            }
          }
        ]

      });
    }

    function deleteTakenLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('special-loan-takens') }}/" + id, //or you can use url: "company/"+id,
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
    $(document).on('click', '.delete', function () {
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
          return deleteTakenLoan(id)
            .catch(() => {
              Swal.showValidationMessage('ঋণ ডিলেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('ঋন্টি সফলভাবে ডিলেট হয়েছে।', 'ডিলেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    $(document).on("click", ".item-loan-delete", function() {
      var id = $(this).attr("data-id");
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ms-1"
        },
        buttonsStyling: false
      }).then(function(result) {
        if (result.value) {
          $.ajax(
            {
              url: "{{ url('special-loan-collections') }}/" + id, //or you can use url: "company/"+id,
              type: "DELETE",
              data: {
                _token: token,
                id: id
              },
              success: function(response) {

                //$("#success").html(response.message)
                toastr["success"]("👋 Loan Installment has been deleted successfully.", "Success!", {
                  closeButton: true,
                  tapToDismiss: false
                });
                $(".datatables-basic").DataTable().destroy();
                loadLoanCollection(loanId);
              },
              error: function(data) {
                toastr["error"]("👋 Loan Installment delete failed.", "Failed!", {
                  closeButton: true,
                  tapToDismiss: false
                });
              }
            });
        }
      });
    });


  </script>
@endsection
