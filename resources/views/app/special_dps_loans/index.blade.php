@extends('layouts/layoutMaster')

@section('title', 'বিশেষ ঋণ তালিকা')

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
          <li class="breadcrumb-item active">বিশেষ ঋণের তালিকা</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('special-dps-loans.create') }}" target="_blank">নতুন ঋণ প্রদান</a>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <table class="datatables-basic table table-sm table-bordered">
            <thead>
            <tr>
              <th class="fw-bolder">নাম</th>
              <th class="fw-bolder">হিসাব নং</th>
              <th class="fw-bolder">সর্বমোট ঋণ</th>
              <th class="fw-bolder">অবশিষ্ট ঋণ</th>
              <th class="fw-bolder">তারিখ</th>
              <th class="fw-bolder">স্ট্যাটাস</th>
              <th>#</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!--/ Basic table -->

  <div class="modal fade text-start" id="loanListModal" tabindex="-1" aria-labelledby="myModalLabel4"
       data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
          <h4 class="modal-title text-white" id="myModalLabel">সকল ঋণ - <span id="ac_name"></span></h4>
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
    function padTo2Digits(num) {
      return num.toString().padStart(2, "0");
    }

    function formatDate(date) {
      return [
        padTo2Digits(date.getDate()),
        padTo2Digits(date.getMonth() + 1),
        date.getFullYear()
      ].join("/");
    }

    loadData();
    var assetPath = $("body").attr("data-asset-path"),
      userView = '{{ url('users') }}/';

    function loadData() {
      $(".datatables-basic").DataTable({
        "proccessing": true,
        "serverSide": true,
        stateSave: true,
        "ajax": {
          "url": "{{ url('dataSpecialDpsLoans') }}"
        },
        "columns": [
          { "data": "name" },
          { "data": "account_no" },
          { "data": "loan_amount" },
          { "data": "remain_loan" },
          { "data": "date" },
          { "data": "status" },
          { "data": "action" }
        ],
        columnDefs: [
          {
            // User full name and username
            targets: 0,
            render: function(data, type, full, meta) {
              var $name = full["name"],
                $id = full["user_id"],
                $image = full["image"];
              if ($image != null) {
                // For Avatar image
                var $output =
                  "<img src=\"{{ asset('storage/images/profile') }}/" + $image + "\" alt=\"Avatar\" height=\"32\" width=\"32\">";
              } else {
                // For Avatar badge
                var stateNum = Math.floor(Math.random() * 6) + 1;
                var states = ["success", "danger", "warning", "info", "dark", "primary", "secondary"];
                var $state = states[stateNum],
                  $name = full["name"],
                  $initials = $name.match(/\b\w/g) || [];
                $initials = (($initials.shift() || "") + ($initials.pop() || "")).toUpperCase();
                $output = "<span class=\"avatar-content\">" + $initials + "</span>";
              }
              var colorClass = $image === "" ? " bg-light-" + $state + " " : "";
              // Creates full output for row
              var $row_output =
                "<div class=\"d-flex justify-content-left align-items-center\">" +
                "<div class=\"avatar-wrapper\">" +
                "<div class=\"avatar " +
                colorClass +
                " me-1\">" +
                $output +
                "</div>" +
                "</div>" +
                "<div class=\"d-flex flex-column\">" +
                "<a href=\"" +
                userView + $id +
                "\" class=\"user_name text-truncate text-body\"><span class=\"fw-bolder\">" +
                $name +
                "</span></a>" +
                "</div>" +
                "</div>";
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
                '<a href="{{url('special-dps-loans')}}/' + full["id"] + "\" class=\"dropdown-item\">" +
                "বিস্তারিত</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item loan-list\">" +
                "সকল ঋণ</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item text-warning item-reset\">" +
                "রিসেট</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item text-danger delete-record\">" +
                "ডিলেট</a>" +
                "</div>" +
                "</div>"
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

    $(document).on("click", ".loan-list", function() {
      var id = $(this).data("id");
      $(".loan-list-table tbody").empty();
      $.ajax({
        url: "{{ url('specialLoanList') }}/" + id,
        dataType: "JSON",
        success: function(data) {
          console.log(data);
          $.each(data, function(a, b) {
            let date = formatDate(new Date(b.date));
            let commencement = formatDate(new Date(b.commencement));
            $(".loan-list-table tbody").append(`
                        <tr>
                     <td>তাঃ ${date} <br> আঃ ${commencement}</td>
                                       <td>${b.loan_amount}</td>
                                       <td>${b.interest1} ${b.interest2 > 0 ? " - "+b.interest2 : ""} </td>
                                       <td>${b.remain}</td>
<td>
<a class="btn btn-sm btn-primary waves-effect" target="_blank" href="{{ url('special-loan-takens') }}/${b.id}">বিস্তারিত</a>
</td>
</tr>
                        `);
          });

        }
      });
      $("#loanListModal").modal("show");
    });
    function deleteDpsLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('special-dps-loans') }}/" + id, //or you can use url: "company/"+id,
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
              Swal.showValidationMessage('বিশেষ সঞ্চয় ঋণ ডিলেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('বিশেষ সঞ্চয় ঋণ ডিলেট হয়েছে।', 'ডিলেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          $(".datatables-basic").DataTable().destroy();
          loadData();
        }
      });
    });

    $("#createFdrModal").on("shown.bs.modal", function() {
      $(".select2").select2({
        placeholder: "Select a User"
      });
    });

    $("#account_no").on("select2:select", function(e) {
      var data = e.params.data;
      $.ajax({
        url: "{{ url('specialDpsInfoByAccount') }}/" + data.id,
        dataType: "json",
        type: "get",
        success: function(data) {
          $("#user_id").val(data.user.id);
          var image = "";
          if (data.user.image == null) {
            image = data.user.profile_photo_url + "&size=110";
          } else {
            image = data.user.image;
          }
          $(".user-data").append(`
                    <div class="user-avatar-section">
<div class="row">
<div class="col-8">
<div class="info-container">
                                <ul class="list-unstyled">
<li class="mb-0">
                                        <span class="fw-bolder me-25">Name:</span>
                                        <span>${data.user.name}</span>
                                    </li>
<li class="mb-0">
                                        <span class="fw-bolder me-25">Phone:</span>
                                        <span>${data.user.phone1}</span>
                                    </li>
<li class="mb-0">
                                        <span class="fw-bolder me-25">Father:</span>
                                        <span>${data.user.father_name}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Mother:</span>
                                        <span>${data.user.mother_name}</span>
                                    </li>
                                </ul>
                            </div>
</div>
<div class="col-4">
<img class="img-fluid rounded mt-0 mb-2" src="${image}" height="80" width="80" alt="User avatar">
</div>
<div class="col-12">
<ul class="list-unstyled">

                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Spouse:</span>
                                        <span class="badge bg-light-success">${data.user.spouse_name}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Present Address:</span>
                                        <span>${data.user.present_address}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Join Date:</span>
                                        <span>${data.user.join_date}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total Savings:</span>
                                        <span>${data.daily_savings}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total DPS:</span>
                                        <span>${data.dps}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Total Special DPS:</span>
                                        <span>${data.special_dps}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Daily Loans:</span>
                                        <span>${data.daily_loans}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">DPS Loans:</span>
                                        <span>${data.dps_loans}</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bolder me-25">Special DPS Loan:</span>
                                        <span>${data.special_dps_loans}</span>
                                    </li>
</ul>
</div>
</div>

                            </div>

                    `);
        }
      });
    });

    $(function() {
      ("use strict");
      var modernVerticalWizard = document.querySelector(".create-app-wizard"),
        createAppModal = document.getElementById("createFdrModal"),
        assetsPath = "../../../app-assets/";

      var basicPickr = $(".flatpickr-basic");
      if (basicPickr.length) {
        basicPickr.flatpickr({
          static: true,
          altInput: true,
          altFormat: "d/m/Y",
          dateFormat: "Y-m-d"
        });
      }

      if ($("body").attr("data-framework") === "laravel") {
        assetsPath = $("body").attr("data-asset-path");
      }

      // --- create app  ----- //
      if (typeof modernVerticalWizard !== undefined && modernVerticalWizard !== null) {
        var modernVerticalStepper = new Stepper(modernVerticalWizard, $form = $(modernVerticalWizard).find("form"),
          $form.each(function() {
            var $this = $(this);
            $this.validate({
              rules: {
                account_no: {
                  required: true
                },
                loan_amount: {
                  required: true
                },
                interest1: {
                  required: true
                },
                opening_date: {
                  required: true
                },
                commencement: {
                  required: true
                }
              }
            });
          }), {
            linear: false
          });


        $(modernVerticalWizard)
          .find(".btn-next")
          .on("click", function() {
            var isValid = $(this).parent().siblings("form").valid();
            if (isValid) {
              modernVerticalStepper.next();
            } else {
              e.preventDefault();
            }

          });
        $(modernVerticalWizard)
          .find(".btn-prev")
          .on("click", function() {
            modernVerticalStepper.previous();
          });

        $(modernVerticalWizard)
          .find(".btn-submit")
          .on("click", function() {
            var $this = $(".btn-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button

            var formData = $("form").serializeArray();
            $.ajax({
              url: "{{ route('special-dps-loans.store') }}",
              method: "POST",
              data: formData,
              beforeSend: function() {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                $this.attr("disabled", true).html("Processing...");
              },
              success: function(data) {
                $this.attr("disabled", false).html($caption);
                //$(".spinner").hide();
                $("form").trigger("reset");
                $("#createFdrModal").modal("hide");
                toastr.success("New Special DPS Loan successfully added.", "New Special Loan!", {
                  closeButton: true,
                  tapToDismiss: false
                });

                $(".datatables-basic").DataTable().destroy();
                loadData();
              },
              error: function() {
                $this.attr("disabled", false).html($caption);
                $("#createFdrModal").modal("hide");
                toastr.error("New Special DPS Loan account added failed.", "Failed!", {
                  closeButton: true,
                  tapToDismiss: false
                });
                $(".datatables-basic").DataTable().destroy();
                loadData();
              }
            });
          });

        // reset wizard on modal hide
        createAppModal.addEventListener("hide.bs.modal", function(event) {
          modernVerticalStepper.to(1);
        });
      }

      // --- / create app ----- //
    });
    /*$(".datatables-basic tbody").on("click", ".item-reset", function() {
      var id = $(this).data("id");
      var token = $("meta[name='csrf-token']").attr("content");

      Swal.fire({
        title: "আপনি কি নিশ্চিত?",
        text: "এটি আপনি পুনরায় পাবেন না!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "হ্যাঁ, এটি রিসেট করুন!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ms-1"
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ url('reset-special-loan') }}/" + id,
            success: function() {
              $(".datatables-basic").DataTable().destroy();
              loadData();
              toastr.success("ঋণটি সফলভাবে রিসেট হয়েছে.", "রিসেট!", {
                closeButton: true,
                tapToDismiss: false
              });
            },
            error: function(data) {
              toastr.error("ঋণ রিসেট ব্যর্থ হয়েছে.", "ব্যর্থ!", {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });
        }
      });
    });*/

    function resetSpecialLoan(id) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-special-loan') }}/" + id,
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
          return resetSpecialLoan(id)
            .catch(() => {
              Swal.showValidationMessage('ঋণ রিসেট ব্যর্থ হয়েছে');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('ঋণটি সফলভাবে রিসেট হয়েছে', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
        }
      });
    });


    $("#guarantor_user_id").on("select2:select", function(e) {
      let user_id = e.params.data.id;
      $("#name").val("");
      $("#address").val("");
      $("#phone").val("");
      $.ajax({
        url: "{{ url('userProfile') }}/" + user_id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          //console.log(data)
          $("#name").val(data.name);
          $("#address").val(data.present_address);
          $("#phone").val(data.phone1);
        }
      });
    });
  </script>
@endsection
