@extends('layouts.layoutMaster')
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
    <form id="collectionForm" method="POST" action="{{ route('dps-collections.store') }}">
      @csrf
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6 col-md-6 col-12">
              @php
                $accounts = \App\Models\Dps::with('user')->where('status','active')->get();
              @endphp
              <div class="mb-1">
                <select class="select2 form-select" name="account_no" id="account_no"
                        data-placeholder="Select A/C No" data-allow-clear="on">
                  <option value=""></option>
                  @foreach($accounts as $account)
                    <option value="{{$account->account_no}}"> {{$account->account_no}}
                      || {{$account->user->name}} </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
              <div class="mb-1">
                <input type="date" id="date" class="form-control"
                       value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY"/>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
              <div class="mb-1">
                <button type="button" class="btn btn-info btn-dps-info">
                  অনুসন্ধান
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card collection-form">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="dps_amount">মাসিক সঞ্চয়</label>
                  <input type="number" class="form-control "
                         name="dps_amount" id="dps_amount"
                         placeholder="DPS AMOUNT" readonly>

                </div>

                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="dps_installments">
                    # কিস্তি সংখ্যা</label>
                  <input type="number" class="form-control "
                         name="dps_installments" id="dps_installments"
                         placeholder="# INSTALLMENTS">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="receipt_no">রিসিপ্ট নং</label>
                  <input type="text" class="form-control" name="receipt_no"
                         id="receipt_no"
                         placeholder="Note">

                </div>

                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="late_fee">বিলম্ব ফি</label>
                  <input type="number" class="form-control" name="late_fee" id="late_fee"
                         placeholder="Late Fee">

                </div>

                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="other_fee">অন্যান্য ফি</label>
                  <input type="number" class="form-control" name="other_fee"
                         id="other_fee"
                         placeholder="OTHER FEE">

                </div>

                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="due">বকেয়া</label>
                  <input type="number" class="form-control" name="due" id="due"
                         placeholder="DUE">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="due_return">বকেয়া ফেরত</label>
                  <input type="number" class="form-control" name="due_return"
                         id="due_return"
                         placeholder="DUE RETURN">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="advance">অগ্রিম</label>
                  <input type="number" class="form-control" name="advance" id="advance"
                         placeholder="ADVANCE">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="advance_return">অগ্রিম সমন্বয়</label>
                  <input type="number" class="form-control" name="advance_return"
                         id="advance_return"
                         placeholder="ADVANCE">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="grace">ছাড়</label>
                  <input type="number" class="form-control" name="grace"
                         id="grace"
                         placeholder="GRACE">

                </div>
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="date">তারিখ</label>
                  <input type="date" class="form-control" name="date"
                         value="{{ date('Y-m-d') }}" id="date2">

                </div>
                <input type="hidden" id="total" name="total">
                <div class="col-lg-4 my-1">
                  <label class="font-small-2 fw-bold" for="dps_note">নোট</label>
                  <input type="text" class="form-control" name="dps_note" id="dps_note"
                         placeholder="Note">

                </div>

                <div class="col-xl-4 col-md-4 col-12 my-1">
                  <div class="mb-1">
                    <select class="select2 form-select" name="deposited_via" id="deposited_via">
                      <option value="cash">ক্যাশ</option>
                      <option value="bkash">বিকাশ</option>
                      <option value="nagad">নগদ</option>
                      <option value="bank">ব্যাংক</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-8 deposited_via_details my-1">
                  <div class="mb-1">
                    <input type="text" class="form-control" name="deposited_via_details" id="deposited_via_details"
                           placeholder="Bank / Bkash/ Nagad Details">
                  </div>
                </div>
              </div>

            </div>

            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-primary btn-submit w-25"
                      onclick="modalData()">
                সাবমিট
              </button>
            </div>

          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-4">
    <h6 class="bg-dark text-center text-white fw-bolder">সদস্যের সংক্ষিপ্ত বিবরণী</h6>
    <div id="info">

    </div>
  </div>
</div>


<div class="modal fade" id="modalCollection" tabindex="-1" aria-labelledby="modalCollectionTitle"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary py-1">
        <h5 class="modal-title text-white" id="modalCollectionTitle">মাসিক সঞ্চয় জমা</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formCollection">
        @csrf
        <div class="modal-body">
          <table class="table table-sm table-collection-info">

          </table>
          {{-- <input type="hidden" name="account_no">
           <input type="hidden" name="user_id">
           <input type="hidden" name="collector_id">
           <input type="hidden" name="saving_amount">
           <input type="hidden" name="saving_type">
           <input type="hidden" name="late_fee">
           <input type="hidden" name="other_fee">
           <input type="hidden" name="loan_installment">
           <input type="hidden" name="installment_no">
           <input type="hidden" name="loan_late_fee">
           <input type="hidden" name="loan_other_fee">
           <input type="hidden" name="saving_note">
           <input type="hidden" name="loan_note">
           <input type="hidden" name="daily_savings_id">
           <input type="hidden" name="daily_loan_id">
           <input type="hidden" name="date">
           <input type="hidden" name="collection_date">
           <input type="hidden" name="created_by" value="{{ \Illuminate\Support\Facades\Auth::id() }}">--}}
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">বাতিল</button>
          <button type="button" class="btn btn-primary btn-confirm">সাবমিট</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection
@section('page-script')
  <script>
    $(document).ready(function() {
      $("select").select2();
    });
  </script>
  <script>

    var taken_loans = '';
    var total_interest = 0;
    var dps_amount = 0;
    var dpsInstallments = 0;

    var account_holder = "";

    var temp_dps_amount = 0;

    $(".deposited_via_details").hide();

    $("#deposited_via").on("select2:select",function (e) {
      var value = e.params.data.id;
      if (value !== 'cash')
      {
        $(".deposited_via_details").show();
      }else {
        $(".deposited_via_details").hide();
      }
    })
    //modalData();
    var editDate = $('#edit_date');
    if (editDate.length) {
      editDate.flatpickr({
        static: true,
        altInput: true,
        altFormat: 'd/m/Y',
        dateFormat: 'Y-m-d',
      });
    }

    function modalData() {
      let account_no = $("#account_no option:selected").val();
      let dps_amount = $("#dps_amount").val();
      let dps_installments = $("#dps_installments").val();
      let receipt_no = $("#receipt_no").val();
      let late_fee = $("#late_fee").val();
      let other_fee = $("#other_fee").val();
      let due = $("#due").val();
      let due_return = $("#due_return").val();
      let advance = $("#advance").val();
      let advance_return = $("#advance_return").val();
      let date = $("#date").val();
      let dps_note = $("#dps_note").val();
      let grace = $("#grace").val();
      let acc_holder = account_holder;

      $(".table-collection-info").empty();
      var total = 0;


      if (dps_amount != 0) {
        total += parseInt(dps_amount);
        $(".table-collection-info").append(`

<tr>
                    <th class="py-1">নাম</th>
                    <td>${acc_holder}</td>
                </tr>
<tr>
                    <th class="py-1">হিসাব নং</th>
                    <td>${account_no}</td>
                </tr>
<tr>
                    <th class="py-1">তারিখ</th>
                    <td>${date}</td>
                </tr>
<tr>
                    <th class="py-1">রিসিপ্ট নং</th>
                    <td>${receipt_no}</td>
                </tr>
           <tr>
                    <th class="py-1">জমা</th>
                    <td class="text-end">${dps_amount}</td>
                </tr>
            `);
      }

      if (late_fee != "") {
        total += parseInt(late_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বিলম্ব ফি</th>
                    <td class="text-end">${late_fee}</td>
                </tr>
            `);
      }
      if (other_fee != "") {
        total += parseInt(other_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অন্যান্য ফি</th>
                    <td class="text-end">${other_fee}</td>
                </tr>
            `);
      }

      if (due != "") {
        total -= parseInt(due);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বকেয়া</th>
                    <td class="text-end">${due}</td>
                </tr>
            `);
      }
      if (due_return != "") {
        total += parseInt(due_return);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বকেয়া ফেরত</th>
                    <td class="text-end">${due_return}</td>
                </tr>
            `);
      }

      if (advance != "") {
        total += parseInt(advance);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অগ্রিম</th>
                    <td class="text-end">${advance}</td>
                </tr>
            `);
      }
      if (advance_return != "") {
        total -= parseInt(advance_return);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অগ্রিম সমন্বয়</th>
                    <td class="text-end">${advance_return}</td>
                </tr>
            `);
      }


      if (grace != "") {
        total -= parseInt(grace);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ছাড়</th>
                    <td class="text-end">${grace}</td>
                </tr>
            `);
      }

      $("#total").val(total);
      $(".table-collection-info").append(`
            <tfoot>
            <tr>
                <td class="fw-bolder text-end">সর্বমোট</td>
                <td class="text-dark total fw-bolder text-end p-0">${total}</td>
            </tr>
            </tfoot>
            `);

      $("#modalCollection").modal("show");
    }

    $(".btn-confirm").on("click", function () {
      //$(".spinner").show();
      //$(".btn-confirm").attr('disabled',true);
      var $this = $(".btn-confirm"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "{{ route('dps-collections.store') }}",
        method: "POST",
        data: $("#collectionForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalCollection").modal("hide");
          //$(".datatables-basic").DataTable().destroy();
          ///loadSavingsCollection();
          toastr['success']('Submission has been saved successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });

          $("#info").html("");
          resetForm();
          //bsOffcanvas.hide();
        },
        error: function (data) {
          $("#modalCollection").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Submission failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })

    function resetForm() {
      $("#collectionForm").trigger('reset');
      $("#formCollection").trigger('reset');
      $('#account_no').val(null).trigger('change');
      $(".savings-info-list").empty();
      $(".loan-info-list").empty();
      $("#interestTable").empty();
      $(".loan-list table").empty();
      $("#interest").val("");
      $(".flatpickr-basic").flatpickr({
        defaultDate: "today",
        altInput: true,
        altFormat: 'd/m/Y',
        dateFormat: 'Y-m-d',
      })
    }

    $(document).on("click", ".loan-list table input[type=checkbox]", function () {
      if ($(this).prop("checked") == true) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', false);
        var interest_rate = $(row).find("input[name='taken_interest[]']").val();
        var installments = $(row).find("input[name='interest_installment[]']").val();
        var interest = calculateInterest(interest_rate, installments);
        $(row).find("input[name='taken_total_interest[]']").val(interest);
        sumOfInterest();
      } else if ($(this).prop("checked") == false) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', true);
        $(row).find("input[name='taken_total_interest[]']").val(0);
        sumOfInterest();
      }
    });

    $(document).on("change", ".loan-list table input[name='interest_installment[]']", function () {
      var row = $(this).closest('tr');
      var temp_total = total_interest;
      var temp_taken_total_interest = $(row).find("input[name='taken_total_interest[]']").val();
      var interest_rate = $(row).find("input[name='taken_interest[]']").val();
      var installments = $(this).val();
      var interest = calculateInterest(interest_rate, installments);
      $(row).find("input[name='taken_total_interest[]']").val(interest);
      sumOfInterest();
    });
    $(document).on("change", ".edit-loan-list table input[name='interest_installment[]']", function () {
      var row = $(this).closest('tr');
      var temp_total = total_interest;
      var temp_taken_total_interest = $(row).find("input[name='taken_total_interest[]']").val();
      var interest_rate = $(row).find("input[name='taken_interest[]']").val();
      var installments = $(this).val();
      var interest = calculateInterest(interest_rate, installments);
      $(row).find("input[name='taken_total_interest[]']").val(interest);
      editSumOfInterest();
    });

    $(document).on("change", "#dps_installments", function () {
      var installment = $(this).val();
      var total = totalDpsAmount(dps_amount, installment);
      $("#dps_amount").val(total);

    });

    function totalDpsAmount(amount, installment) {
      return amount * installment;
    }

    function calculateInterest(interest, installments) {
      return interest * installments;
    }

    function sumOfInterest() {
      var sum = 0;
      $('.taken_total_interest').each(function () {
        sum += Number($(this).val());
      });
      $("#interest").val(sum);
    }

    function editSumOfInterest() {
      var sum = 0;
      $('.edit_taken_total_interest').each(function () {
        sum += Number($(this).val());
      });
      $("#edit_interest").val(sum);
    }

    $(document).on("change", "input[name='collection_type[]']", function () {

      let tempDps = dps_amount;
      let temp_installment = dpsInstallments;
      if ($('#dps_installment').is(':checked') == false) {
        $("#dps_installments").val(0);
        //let total = totalDpsAmount(dps_amount, installment);
        $("#dps_amount").val(0);
      } else if ($('#dps_installment').is(':checked') == true) {
        let total = totalDpsAmount(tempDps, temp_installment);
        $("#dps_installments").val(temp_installment);
        $("#dps_amount").val(total);
      }

      if ($('#loan_collection').is(':checked') == false) {
        $("#interest").val(0);
      } else if ($('#loan_collection').is(':checked') == true) {
        sumOfInterest();
      }
    });

    //var myOffcanvas = document.getElementById('offcanvasScroll');
    //var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

    /*myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
      $(".submission-form").addClass("col-xl-12 col-lg-12 col-md-12");
      $(".submission-form").removeClass("col-xl-9 col-lg-9 col-md-9");
    })*/

    $('.btn-dps-info').on('click', function (e) {
      var account_no = $("#account_no option:selected").val();
      var date = $("#date").val();
      total_interest = 0;
      $("#info").html("");
      $(".savings-info-list").empty();
      $(".loan-info-list").empty();
      $("#interestTable").empty();
      $(".loan-list table").empty();
      $("#interest").val("");
      $(".buttons").empty();
      $.ajax({
        url: "{{ url('dps-info') }}",
        dataType: "JSON",
        data: {account: account_no, date: date},
        success: function (data) {
          //console.log(data);
          $("#info").html(`
          <div id="savings-info">
        <div class="info-container">
          <table class="savings-info-list w-100">

          </table>
        </div>
      </div>
      <div id="loan-info">
        <div class="info-container">
          <ul class="list-unstyled loan-info-list">

          </ul>
          <table id="interestTable" class="table table-sm table-bordered">

          </table>

        </div>
      </div>
      <div class="d-flex justify-content-center pt-2 buttons">
      </div>
          `);
          $("#dps_id").val(data.dpsInfo.id);
          var loanInfo = data.loanInfo;
          if (loanInfo != "") {
            $("#interestTable").append(`
                        <thead class="table-dark"> <tr>
                        <th class="p-0 text-center">ঋণের পরিমাণ</th>
                        <th class="p-0 text-center">অবশিষ্ট ঋণ</th>
                        <th class="p-0 text-center">সুদের হার</th>
                        <th class="p-0 text-center">বকেয়া কিস্তি</th>
                        </tr>
                        </thead>
                    `);
            $.each(loanInfo, function (a, b) {
              total_interest += parseInt(b.interest) * parseInt(b.dueInstallment);
              $("#interestTable").append(`
                             <tr>
                            <td class="text-center">${b.loanAmount}<small class="text-danger font-small-2" style="display: block;padding: 0">${b.commencement}</small></td>
                            <td class="text-center">${b.loanRemain}</td>
                            <td class="text-center">${b.interest}</td>
                            <td class="text-center">${b.dueInstallment}</td>
                            </tr>
                        `);
              if (b.dueInstallment > 0) {
                $(".loan-list table").append(`

                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="loan_taken_id[]" id="loan_taken_id_${b.taken_loan_id}" value="${b.taken_loan_id}" checked>
                                                                            <label class="form-check-label" for="loan_taken_id_${b.taken_loan_id}">${b.interest}</label>
                                                                        </div>
                            </td>
                            <td style="width: 15%">
<input type="number" class="form-control form-control-sm" name="interest_installment[]" min="1" step="1" max="${b.dueInstallment}" value="${b.dueInstallment}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control form-control-sm taken_total_interest" name="taken_total_interest[]" value="${b.dueInstallment * b.interest}" disabled></td>
                            </tr>

                            `);
              }
            })
            $("#interest").val(total_interest);
            $("#total_loan_interest").val(total_interest);
          }


          $("#user_id").val(data.user.id);
          $(".ac_holder").text(data.user.name);
          account_holder = data.user.name;
          $("#offcanvasScrollLabel").text(data.user.name);
          $(".phone").text(data.user.phone1).addClass('text-dark');
          $(".acc_no").text(data.dpsInfo.account_no);
          var dps = data.dpsInfo;
          var loan = data.loan;
          dps_amount = dps.package_amount;
          dpsInstallments = data.dpsDue;
          $(".savings-balance h4").text(dps.balance);
          $("#dps_amount").val(dps.package_amount * data.dpsDue);
          $("#dps_installments").val(data.dpsDue);
          $(".buttons").append(`<a href="{{ url('dps') }}/${dps.id}" class="btn btn-sm btn-primary me-1">
                            মাসিক সঞ্চয়
                        </a>`);
          $(".savings-info-list").append(`
<tr>
<td class="fw-bolder">নাম</td><td>:</td><td>${data.user.name}</td> <td rowspan="5" style="width: 110px;text-align: right">
<img src="{{ asset('images') }}/${data.user.image}" alt="" class="img-fluid">
</td>
</tr>
<tr>
<td class="fw-bolder">মোবাইল নং</td><td>:</td><td colspan="2">${data.user.phone1}</td>
</tr>
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">হিসাব নং</td><td>:</td>
                                        <td class="account_no px-1" colspan="2">${dps.account_no}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মাসিক পরিমাণ</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.package_amount}</td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মোট জমা</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.balance}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মাসিক সঞ্চয় বকেয়া</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.package_amount} x ${data.dpsDue} = <span class="text-danger">${dps.package_amount * data.dpsDue}</span></td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">বকেয়া</td><td>:</td>
                                        <td class="total_due px-1" colspan="2">${data.due}</td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">WALLET</td><td>:</td>
                                        <td class="total_due px-1" colspan="2">${data.user.wallet}</td>
                                    </tr>
                    `);
          if (data.loan != "") {
            $(".buttons").append(`
                        <a href="{{ url('dps-loans') }}/${data.loan.id}" class="btn btn-sm btn-outline-sm btn-outline-danger suspend-user">ঋণ </a>
`);
            $("#loan_id").val(data.loan.id);
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">ঋণের পরিমাণ</td><td>:</td>
                                        <td class="account_no px-1">${loan.loan_amount}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">ঋণ ফেরত</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.loan_amount - loan.remain_loan}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">অবশিষ্ট ঋণ</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.remain_loan}</td>
                                    </tr>
                    `);
          }
          if (loan.dueInterest != null) {
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">বকেয়া সুদ</td><td>:</td>
                                        <td class="px-1">${loan.dueInterest}</td>
                                    </tr>
                    `);
          }

          if (data.lastLoanPayment != 'null') {
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">সর্বশেষ ঋণ ফেরত</td><td>:</td>
                                        <td class="account_no px-1">${data.lastLoanPayment.loan_installment}</td>
                                    </tr>

                    `);
          }

          if (data.loan != "") {
            $("#loan-info").show();
            $(".loan-balance").show();
            console.log(data.loan)
            var loan = data.loan;
            $(".loan-balance h4").text(loan.remain_loan);
          } else {
            $("#loan-info").hide();
            $(".loan-balance").hide();
            $(".loan-balance h4").text('');
          }

          if (data.user.image == null) {
            $(".profile-image").attr('src', data.user.profile_photo_url);
          }
        }
      });

      //$("#modals-slide-in").modal("show");
      //var myOffcanvas = document.getElementById('offcanvasScroll');
      // var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
      /*bsOffcanvas.show();
      myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
        $(".submission-form").removeClass("col-xl-12 col-lg-12 col-md-12");
        $(".submission-form").addClass("col-xl-9 col-lg-9 col-md-9");
      })*/
    });

    // var myOffcanvas = document.getElementById('offcanvasScroll');
    //var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);


    var assetPath = $('body').attr('data-asset-path'),
      userView = '{{ url('users') }}/';

    $(document).on("click", ".delete-record", function () {
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
              url: "dps-installments/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                toastr['success']('👋 DPS Installment deleted successfully!', 'Success!', {
                  closeButton: true,
                  tapToDismiss: false,
                });

              }
            });
        }
      });
    })
    $(document).on("click", ".delete-loan-record", function () {
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
              url: "{{ url('dps-installments') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)
                toastr['success']('👋 Installment has been deleted successfully.', 'Success!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
                $(".datatables-loan-collection").DataTable().destroy();
                loadLoanCollection();
              },
              error: function (data) {
                toastr['error']('👋 Installment delete failed.', 'Failed!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
              }
            });
        }
      });
    })
    $(document).on("click", ".item-edit", function () {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "{{ url('getDpsCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          var user = data.user;

          $(".edit_dps_installment_id").val(data.id);
          $("#edit").val(data.id);
          $(".savings_amount").val(data.saving_amount);
          $(".late_fee").val(data.late_fee);
          $(".other_fee").val(data.other_fee);
          $(".balance").val(data.balance);
          $(".type").val(data.type);
          $(".date").val(data.date);
          $(".collector_id").val(data.collector_id);
          $("input[name='id']").val(data.id);
          $(".note").val(data.note);
          $("#edit-saving-collection-modal").modal("show");
        }
      })
    })
    $(document).on("click", ".item-edit-loan", function () {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "{{ url('getLoanCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          var user = data.user;
          $(".edit-name").text(user.name);
          $(".edit-account-no").text(data.account_no);
          $(".loan_installment").val(data.loan_installment);
          $(".installment_no").val(data.installment_no);
          $(".loan_late_fee").val(data.loan_late_fee);
          $(".loan_other_fee").val(data.loan_other_fee);
          $(".loan_balance").val(data.loan_balance);
          $(".date").val(data.date);
          $(".collector_id").val(data.collector_id);
          $("input[name='id']").val(data.id);
          $(".loan_note").val(data.loan_note);
          $("#edit-loan-collection-modal").modal("show");
        }
      })
    })
    $(document).on("click", ".item-details", function () {
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-name');
      var account = $(this).attr('data-account_no');
      var dps = $(this).attr('data-dps');
      var loan = $(this).attr('data-loan');
      var interest = $(this).attr('data-interest');
      var date = $(this).attr('data-date');

      $(".name").text(`${name}`);
      $(".account").text(`${account}`);
      $(".dps").text(`${dps}`);
      $(".loan").text(`${loan}`);
      $(".interest").text(`${interest}`);
      $(".date").text(`${date}`);
      $("#modal-installment-details").modal("show")
    })
    $(document).on("click", ".edit-dps", function () {
      var id = $(this).attr('data-id');
      $("#editDpsInstallmentForm").trigger("reset");
      $.ajax({
        url: "{{ url('getDpsCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          console.log(data);
          let paymentDate = formatDate(new Date(data.dpsInstallment.date));

          editDate.flatpickr({
            altFormat: 'd/m/Y',
            defaultDate: paymentDate
          });
          temp_dps_amount = data.dpsCollection.dps_amount;
          let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
          $(".account_no").text(data.dpsInstallment.account_no);
          $("#editDpsInstallmentForm input[name='id']").val(data.dpsInstallment.id);
          $("#editDpsInstallmentForm input[name='dps_amount']").val(dpsAmount);
          $("#editDpsInstallmentForm input[name='dps_installments']").val(data.dpsInstallment.dps_installments);
          $("#editDpsInstallmentForm input[name='receipt_no']").val(data.dpsInstallment.receipt_no);
          $("#editDpsInstallmentForm input[name='late_fee']").val(data.dpsInstallment.late_fee);
          $("#editDpsInstallmentForm input[name='other_fee']").val(data.dpsInstallment.other_fee);
          $("#editDpsInstallmentForm input[name='due']").val(data.dpsInstallment.due);
          $("#editDpsInstallmentForm input[name='due_return']").val(data.dpsInstallment.due_return);
          $("#editDpsInstallmentForm input[name='advance']").val(data.dpsInstallment.advance);
          $("#editDpsInstallmentForm input[name='advance_return']").val(data.dpsInstallment.advance_return);
          $("#editDpsInstallmentForm input[name='grace']").val(data.dpsInstallment.grace);
          //$("#editDpsInstallmentForm input[name='date']").val(data.date);
          $("#editDpsInstallmentForm input[name='dps_note']").val(data.dpsInstallment.dps_note);
        }
      })
      $("#modalEditDpsInstallment").modal("show");
    })
    $(document).on("click", ".edit-loan", function () {
      var id = $(this).attr('data-id');
      $("#editLoanInstallmentForm").trigger("reset");
      $(".edit-loan-list table").empty();
      total_interest = 0;
      $.ajax({
        url: "{{ url('getDpsLoanCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          console.log(data);
          let paymentDate = formatDate(new Date(data.dpsInstallment.date));

          $(".edit_date").flatpickr({
            altFormat: 'd/m/Y',
            defaultDate: paymentDate
          });
          //temp_dps_amount = data.dpsCollection.dps_amount;
          //let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
          $(".account_no").text(data.dpsInstallment.account_no);
          $("#editLoanInstallmentForm input[name='id']").val(data.dpsInstallment.id);
          $("#editLoanInstallmentForm input[name='user_id']").val(data.dpsInstallment.user_id);
          $("#editLoanInstallmentForm input[name='dps_loan_id']").val(data.dpsInstallment.dps_loan_id);
          $("#editLoanInstallmentForm input[name='loan_installment']").val(data.dpsInstallment.loan_installment);
          $("#editLoanInstallmentForm input[name='interest']").val(data.dpsInstallment.interest);
          $("#editLoanInstallmentForm input[name='due_interest']").val(data.dpsInstallment.due_interest);
          $("#editLoanInstallmentForm input[name='loan_late_fee']").val(data.dpsInstallment.loan_late_fee);
          $("#editLoanInstallmentForm input[name='loan_other_fee']").val(data.dpsInstallment.loan_other_fee);
          $("#editLoanInstallmentForm input[name='loan_grace']").val(data.dpsInstallment.loan_grace);
          $("#editLoanInstallmentForm input[name='loan_note']").val(data.dpsInstallment.loan_note);
          let loanInfo = data.loanInterests;
          $.each(loanInfo, function (a, b) {
            total_interest += parseInt(b.interest) * parseInt(b.installments);
            if (b.installments > 0) {
              $(".edit-loan-list table").append(`
                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="loan_taken_id[]" id="loan_taken_id_${b.taken_loan_id}" value="${b.taken_loan_id}" checked>
                                                                            <label class="form-check-label" for="loan_taken_id_${b.taken_loan_id}">${b.interest}</label>
                                                                        </div>
                            </td>
                            <td style="width: 15%">
<input type="number" class="form-control form-control-sm" name="interest_installment[]" min="1" step="1" value="${b.installments}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control form-control-sm edit_taken_total_interest" name="taken_total_interest[]" value="${b.installments * b.interest}" disabled></td>
                            </tr>

                            `);
            }
          })
          $("#edit_interest").val(total_interest);
          $("#edit_total_loan_interest").val(total_interest);
        }
      })
      $("#modalEditLoanInstallment").modal("show");
    })
    /*  $(".btn-edit").on("click", function () {
          var id = $("input[name='id']").val();
          var $this = $(".edit"); //submit button selector using ID
          var $caption = $this.html();// We store the html content of the submit button
          $.ajax({
              url: "savings-collections/" + id,
              method: "PUT",
              data: $("#edit-form").serialize(),
              beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                  $this.attr('disabled', true).html("Processing...");
              },
              success: function (data) {
                  $this.attr('disabled', false).html($caption);
                  $("#edit-saving-collection-modal").modal("hide");
                  toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
                      closeButton: true,
                      tapToDismiss: false,
                  });
                  $(".datatables-basic").DataTable().destroy();
                  loadSavingsCollection();
                  resetForm();

              },
              error: function (data) {
                  $("#edit-saving-collection-modal").modal("hide");
                  $this.attr('disabled', false).html($caption);
                  toastr['error']('Submission failed. Please try again.', 'Error!', {
                      closeButton: true,
                      tapToDismiss: false,
                  });
              }
          })
      })*/
    /*$(".btn-edit-loan").on("click", function () {
        var id = $("input[name='id']").val();
        var $this = $(".btn-edit-loan"); //submit button selector using ID
        var $caption = $this.html();// We store the html content of the submit button
        $.ajax({
            url: "daily-loan-collections/" + id,
            method: "PUT",
            data: $("#edit-loan-form").serialize(),
            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                $this.attr('disabled', true).html("Processing...");
            },
            success: function (data) {
                $this.attr('disabled', false).html($caption);
                $("#edit-loan-collection-modal").modal("hide");
                toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,
                });
                $(".datatables-loan-collection").DataTable().destroy();
                loadLoanCollection();

                resetForm();

            },
            error: function (data) {
                $("#edit-loan-collection-modal").modal("hide");
                $this.attr('disabled', false).html($caption);
                toastr['error']('Submission failed. Please try again.', 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        })
    })*/
    function filterSavingsData() {
      var account = $("#s_account_no option:selected").val();
      var collector = $("#s_collector option:selected").val();
      var from = $("#s_fromdate").val();
      var to = $("#s_todate").val();
     /* $(".datatables-basic").DataTable().destroy();
      loadSavingsCollection(account, collector, from, to);*/
    }

    function resetFilterSavings() {
      $(".datatables-basic").DataTable().destroy();
      $("#s_fromdate").empty();
      $("#s_todate").empty();
     // loadSavingsCollection();
    }

    function filterLoanData() {
      var account = $("#l_account_no option:selected").val();
      var collector = $("#l_collector option:selected").val();
      var from = $("#l_fromdate").val();
      var to = $("#l_todate").val();
     // $(".datatables-loan-collection").DataTable().destroy();
    //  loadLoanCollection(account, collector, from, to);
    }

    function resetFilterLoan() {
      $(".datatables-loan-collection").DataTable().destroy();
      $("#l_fromdate").val('');
      $("#l_todate").val('');
      //loadLoanCollection();
    }


    function padTo2Digits(num) {
      return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
      return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
      ].join('-');
    }

    $("#edit_dps_installments").on("change", function () {
      let tempDps = temp_dps_amount * $(this).val();
      $("#edit_dps_amount").val(tempDps);

    })

    $(document).on("click", ".btn-update-dps", function () {
      var id = $("#editDpsInstallmentForm input[name='id']").val();
      var $this = $(".btn-update-dps"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "dps-installments/" + id,
        method: "POST",
        data: $("#editDpsInstallmentForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalEditDpsInstallment").modal("hide");
          toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });


        },
        error: function (data) {
          $("#modalEditDpsInstallment").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Submission failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })
    $(document).on("click", ".btn-update-loan", function () {
      var id = $("#editLoanInstallmentForm input[name='id']").val();
      var $this = $(".btn-update-loan"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "dps-installments/" + id,
        method: "POST",
        data: $("#editLoanInstallmentForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalEditLoanInstallment").modal("hide");
          toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });


        },
        error: function (data) {
          $("#modalEditLoanInstallment").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Submission failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })
  </script>
@endsection
