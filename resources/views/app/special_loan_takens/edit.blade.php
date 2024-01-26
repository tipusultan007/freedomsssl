@extends('layouts/layoutMaster')

@section('title', 'বিশেষ ঋণ আপডেট ফরম')

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
  <div class="row">
    <div class="col-md-8">
      <form action="{{ route('special-loan-takens.update',$specialLoanTaken->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div id="account-details">
          <h4 class="bg-primary p-1 text-white">ঋণের তথ্য</h4>
          <div class="row mb-3">
            @php
              $accounts = \App\Models\SpecialDps::with('user')->where('status','active')->get();
            @endphp
            <div class="col-md-9 mb-2">
              <label for="account_no" class="form-label">হিসাব নং </label>
              <input type="text" name="account_no" class="form-control" value="{{ $specialLoanTaken->account_no }}">
            </div>

            <div class="col-md-3 mb-2">
              <label for="loan_amount" class="form-label">ঋণের পরিমাণ</label>
              <input type="number" class="form-control" id="loan_amount" name="loan_amount" value="{{ $specialLoanTaken->loan_amount }}">
            </div>

            <div class="col-md-3 mb-2">
              <label for="interest1" class="form-label">সুদের হার (%)</label>
              <input type="number" class="form-control" value="2" id="interest1" name="interest1" value="{{ $specialLoanTaken->interest1 }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="interest2" class="form-label">স্পেশাল সুদের হার (%)</label>
              <input type="number" class="form-control" id="interest2" name="interest2" value="{{ $specialLoanTaken->interest2 }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="upto_amount" class="form-label">Upto Amount</label>
              <input type="number" class="form-control" id="upto_amount" name="upto_amount" value="{{ $specialLoanTaken->upto_amount }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="initial_amount" class="form-label">প্রাথমিক জমা</label>
              <input type="number" class="form-control" id="initial_amount" name="initial_amount" value="{{ $specialLoanTaken->initial_amount }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">ঋণের তারিখ</label>
              <input type="date" class="form-control flatpickr-basic" id="opening_date"
                     name="opening_date" aria-label="MM/DD/YYYY" value="{{ $specialLoanTaken->date }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">হিসাব শুরু</label>
              <input type="date" class="form-control flatpickr-basic" id="commencement"
                     name="commencement" aria-label="MM/DD/YYYY" value="{{ $specialLoanTaken->commencement }}">
            </div>


            <div class="col-md-6 mb-2">
              <label for="note" class="form-label">নোট</label>
              <input type="text" class="form-control" id="note"
                     name="note" value="{{ $specialLoanTaken->note }}">
            </div>
          </div>
          <input type="hidden" name="user_id" id="user_id">
        </div>
        <div id="document-details">
          <h4 class="bg-primary p-1 text-white">ঋণের ডকুমেন্টস</h4>
          <div class="row mb-3">

            <div class="col-md-4 mb-2">
              <label for="bank_name" class="form-label">ব্যাংকের নাম</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name">
            </div>

            <div class="col-md-4 mb-2">
              <label for="branch_name" class="form-label">শাখা</label>
              <input type="text" class="form-control" id="branch_name" name="branch_name">
            </div>
            <div class="col-md-4 mb-2">
              <label for="cheque_no" class="form-label">চেক নং</label>
              <input type="text" class="form-control" id="cheque_no" name="cheque_no">
            </div>
            <div class="col-lg-6 col-md-12">
              <label for="document_name" class="form-label">ডকুমেন্টস</label>
              <input class="form-control" type="file" name="documents[]" id="documents" multiple />
            </div>

            <div class="col-md-6 mb-2">
              <label for="account_no" class="form-label">নোট</label>
              <input type="text" class="form-control" id="documents_note"
                     name="documents_note">
            </div>
          </div>
          <input type="hidden" name="created_by" value="{{ auth()->id() }}">
        </div>
        <div id="nominee-info">
          <h4 class="bg-primary p-1 text-white">ঋণের জামিনদার</h4>
          <div class="row">
            <div class="mb-1 col-md-12">
              <label class="form-label" for="name">Select User</label>
              <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- Select User --">
                <option value="">Select Guarantor</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="name">নাম</label>
              <input type="text" name="name" id="name" class="form-control"
                     placeholder="John"/>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="phone">মোবাইল</label>
              <input type="text" name="phone" id="phone" class="form-control"/>
            </div>

            <div class="mb-1 col-md-6">
              <label class="form-label" for="address">ঠিকানা</label>
              <input type="text" name="address" id="address" class="form-control"/>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="percentage">হিসাব নং</label>
              <input type="text" name="exist_ac_no" id="exist_ac_no" class="form-control"/>
            </div>
          </div>
          <input type="hidden" name="status" value="active">

        </div>
        <div class="d-flex justify-content-center">
          <button class="btn btn-success rounded-pill  mt-4 w-25" type="submit"> সাবমিট </button>
        </div>
      </form>
    </div>
    <div class="col-md-4">
      <div class="card">

        <div class="divider">
          <div class="divider-text">সদস্য তথ্য</div>
        </div>

        <div class="card-body">
          <div class="user-data">

          </div>
        </div>
      </div>

      <div class="card mt-2">

        <div class="divider">
          <div class="divider-text">জামিনদারের তথ্য</div>
        </div>
        <div class="card-body">
          <div class="guarantor-data">

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')

  <script>
    var formSection = $(".horizontal-wizard-example");
    var bsStepper = document.querySelectorAll(".bs-stepper"),
      select = $(".select2"),
      horizontalWizard = document.querySelector(".horizontal-wizard-example");
    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
      for (var el = 0; el < bsStepper.length; ++el) {
        bsStepper[el].addEventListener("show.bs-stepper", function(event) {
          var index = event.detail.indexStep;
          var numberOfSteps = $(event.target).find(".step").length - 1;
          var line = $(event.target).find(".step");

          // The first for loop is for increasing the steps,
          // the second is for turning them off when going back
          // and the third with the if statement because the last line
          // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

          for (var i = 0; i < index; i++) {
            line[i].classList.add("crossed");

            for (var j = index; j < numberOfSteps; j++) {
              line[j].classList.remove("crossed");
            }
          }
          if (event.detail.to == 0) {
            for (var k = index; k < numberOfSteps; k++) {
              line[k].classList.remove("crossed");
            }
            line[0].classList.remove("crossed");
          }
        });
      }
    }

    // select2
    select.each(function() {
      var $this = $(this);
      $this.wrap("<div class=\"position-relative\"></div>");
      $this.select2({
        placeholder: "Select value",
        dropdownParent: $this.parent()
      });
    });

    // Horizontal Wizard
    // --------------------------------------------------------------------
    if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
      var numberedStepper = new Stepper(horizontalWizard),
        $form = $(horizontalWizard).find("form");
      $form.each(function() {
        var $this = $(this);
        $this.validate({
          rules: {
            username: {
              required: true
            },
            email: {
              required: true
            },
            password: {
              required: true
            },
            "confirm-password": {
              required: true,
              equalTo: "#password"
            },
            "first-name": {
              required: true
            },
            "last-name": {
              required: true
            },
            address: {
              required: true
            },
            landmark: {
              required: true
            },
            country: {
              required: true
            },
            language: {
              required: true
            },
            twitter: {
              required: true,
              url: true
            },
            facebook: {
              required: true,
              url: true
            },
            google: {
              required: true,
              url: true
            },
            linkedin: {
              required: true,
              url: true
            }
          }
        });
      });

      $(horizontalWizard)
        .find(".btn-next")
        .each(function() {
          $(this).on("click", function(e) {
            var isValid = $(this).parent().siblings("form").valid();
            if (isValid) {
              numberedStepper.next();
            } else {
              e.preventDefault();
            }
          });
        });

      $(horizontalWizard)
        .find(".btn-prev")
        .on("click", function() {
          numberedStepper.previous();
        });

      $(horizontalWizard)
        .find(".btn-submit")
        .on("click", function() {
          var isValid = $(this).parent().siblings("form").valid();
          if (isValid) {
            $(".spinner").show();
            var formData = $("form").serializeArray();
            $.ajax({
              url: "{{ route('special-dps-loans.store') }}",
              method: "POST",
              data: formData,
              success: function(data) {
                $(".spinner").hide();
                $("form").trigger("reset");
                $("#account_no").val("").trigger("change");
                $("#guarantor_user_id").val("").trigger("change");
                $(".user-data").empty();
                $(".guarantor-data").empty();
                toastr.success("New Special Loan successfully created.", "New Special Loan!", {
                  closeButton: true,
                  tapToDismiss: false
                });
              }
            });
          }
        });
    }

    $("#account_no").on("select2:select", function(e) {
      $(".user-data").empty();
      var data = e.params.data;
      $.ajax({
        url: "{{ url('specialDpsInfoByAccount') }}/" + data.id,
        dataType: "json",
        type: "get",
        success: function(data) {
          var image = "";
          if (data.user.image == null) {
            image = data.user.profile_photo_url + "&size=110";
          } else {
            image = data.user.image;
          }
          $(".user-data").append(`
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
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
          if (data.guarantors != null) {
            $.each(data.guarantors, function(a, b) {
              $(".gtable").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
            });
          }
        }
      });
    });

    $("#guarantor_user_id").on("select2:select", function(e) {
      let user_id = e.params.data.id;
      $("#name").val("");
      $("#address").val("");
      $("#phone").val("");
      $(".guarantor-data").empty();
      $.ajax({
        url: "{{ url('getDetails') }}/" + user_id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          //console.log(data)
          $("#name").val(data.user.name);
          $("#address").val(data.user.present_address);
          $("#phone").val(data.user.phone1);

          var image = "";
          if (data.user.image == null) {
            image = data.user.profile_photo_url + "&size=110";
          } else {
            image = data.user.image;
          }
          $(".guarantor-data").append(`
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
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
          if (data.guarantors != null) {
            $.each(data.guarantors, function(a, b) {
              $(".gtable2").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
            });
          }
        }
      });
    });

  </script>
@endsection
