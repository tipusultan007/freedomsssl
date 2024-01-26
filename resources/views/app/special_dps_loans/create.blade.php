@extends('layouts/layoutMaster')

@section('title', 'ঋণ বিতরণ ফরম')

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
 <div class="container-fluid">
   <div class="d-flex justify-content-between mb-3">
     <nav aria-label="breadcrumb" class="d-flex align-items-center">
       <ol class="breadcrumb mb-0">
         <li class="breadcrumb-item">
           <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
         </li><li class="breadcrumb-item">
           <a href="{{ url('special-dps-loans') }}">বিশেষ ঋণ তালিকা</a>
         </li>
         <li class="breadcrumb-item active">বিশেষ ঋণ প্রদান ফরম</li>
       </ol>
     </nav>
   </div>
   @include('app.partials.alert_danger')
   @include('app.partials.alert_success')
   <div class="row">
     <div class="col-md-8">
       <form action="{{ route('special-dps-loans.store') }}" method="POST" enctype="multipart/form-data">
         @csrf
         <div id="account-details">
           <h4 class="bg-primary p-1 text-white">ঋণের তথ্য</h4>
           <div class="row mb-3">
             @php
               $accounts = \App\Models\SpecialDps::with('user')->where('status','active')->get();
             @endphp
             <div class="col-md-9 mb-2">
               <label for="account_no" class="form-label">হিসাব নং </label>
               <select data-allow-clear="true" name="account_no" id="account_no" class="select2 form-select" data-placeholder="Select Account">

                 <option value="">Select Account</option>
                 @forelse($accounts as $account)
                   <option value="{{ $account->account_no }}">{{ $account->account_no }}
                     || {{ $account->user->name }} || {{ $account->user->father_name }}</option>
                 @empty
                 @endforelse
               </select>
             </div>

             <div class="col-md-3 mb-2">
               <label for="loan_amount" class="form-label">ঋণের পরিমাণ</label>
               <input type="number" class="form-control" id="loan_amount" name="loan_amount">
             </div>

             <div class="col-md-3 mb-2">
               <label for="interest1" class="form-label">সুদের হার (%)</label>
               <input type="number" class="form-control" value="2" id="interest1" name="interest1">
             </div>
             <div class="col-md-3 mb-2">
               <label for="interest2" class="form-label">স্পেশাল সুদের হার (%)</label>
               <input type="number" class="form-control" id="interest2" name="interest2">
             </div>
             <div class="col-md-3 mb-2">
               <label for="upto_amount" class="form-label">Upto Amount</label>
               <input type="number" class="form-control" id="upto_amount" name="upto_amount">
             </div>
             <div class="col-md-3 mb-2">
               <label for="account_no" class="form-label">ঋণের তারিখ</label>
               <input type="date" class="form-control flatpickr-basic" id="opening_date"
                      name="opening_date" aria-label="MM/DD/YYYY">
             </div>
             <div class="col-md-3 mb-2">
               <label for="account_no" class="form-label">হিসাব শুরু</label>
               <input type="date" class="form-control flatpickr-basic" id="commencement"
                      name="commencement" aria-label="MM/DD/YYYY">
             </div>


             <div class="col-md-6 mb-2">
               <label for="note" class="form-label">নোট</label>
               <input type="text" class="form-control" id="note"
                      name="note">
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
           <div class="divider-text fs-4 fw-bolder">সদস্য তথ্য</div>
         </div>

         <div class="card-body">
           <div class="user-data">

           </div>
         </div>
       </div>

       <div class="card mt-2">

         <div class="divider">
           <div class="divider-text fw-bolder fs-4">জামিনদারের তথ্য</div>
         </div>
         <div class="card-body">
           <div class="guarantor-data">

           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
@endsection

@section('page-script')

  <script>

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

                            <div class="info-container">
                                <table class="table table-sm table-striped table-bordered">
                                    <tr>
                                        <td class="py-0" colspan="2"><img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar"></td>
                                    </tr>
<tr>
                                        <th class="fw-bolder py-0">নাম:</th>
                                        <td class="py-0">${data.user.name}</td>
                                    </tr>
<tr>
                                        <th class="fw-bolder py-0">মোবাইল:</th>
                                        <td class="py-0">${data.user.phone1}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">পিতার নাম:</th>
                                        <td class="py-0">${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাতার নাম:</th>
                                        <td class="py-0">${data.user.mother_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">নিবন্ধন তারিখ:</th>
                                        <td class="py-0">${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0"> দৈনিক সঞ্চয়:</th>
                                        <td class="py-0">${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাসিক সঞ্চয়:</th>
                                        <td class="py-0">${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">বিশেষ সঞ্চয়:</th>
                                        <td class="py-0">${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">দৈনিক ঋণ:</th>
                                        <td class="py-0">${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাসিক ঋণ:</th>
                                        <td class="py-0">${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">বিশেষ ঋণ:</th>
                                        <td class="py-0">${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">স্থায়ী সঞ্চয়:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">জামিনদার:</td>
                                        <td class="gtable"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
          if (data.guarantors != null) {
            $.each(data.guarantors, function(a, b) {
              $(".gtable").append(`
                            <span class="badge bg-danger m-1">${b}</span>
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
            image = "{{ asset('storage/images/profile') }}/"+data.user.image;
          }
          $(".guarantor-data").append(`

                            <div class="info-container">
                                <table class="table table-sm table-striped table-bordered">
                                    <tr>
                                        <td class="py-0" colspan="2"><img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar"></td>
                                    </tr>
<tr>
                                        <th class="fw-bolder py-0">নাম:</th>
                                        <td class="py-0">${data.user.name}</td>
                                    </tr>
<tr>
                                        <th class="fw-bolder py-0">মোবাইল:</th>
                                        <td class="py-0">${data.user.phone1}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">পিতার নাম:</th>
                                        <td class="py-0">${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাতার নাম:</th>
                                        <td class="py-0">${data.user.mother_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">নিবন্ধন তারিখ:</th>
                                        <td class="py-0">${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0"> দৈনিক সঞ্চয়:</th>
                                        <td class="py-0">${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাসিক সঞ্চয়:</th>
                                        <td class="py-0">${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">বিশেষ সঞ্চয়:</th>
                                        <td class="py-0">${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">দৈনিক ঋণ:</th>
                                        <td class="py-0">${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">মাসিক ঋণ:</th>
                                        <td class="py-0">${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">বিশেষ ঋণ:</th>
                                        <td class="py-0">${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">স্থায়ী সঞ্চয়:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">জামিনদার:</td>
                                        <td class="gtable2"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
          if (data.guarantors != null) {
            $.each(data.guarantors, function(a, b) {
              $(".gtable2").append(`
                            <span class="badge bg-primary m-1">${b}</span>
                            `);
            });
          }
        }
      });
    });

  </script>
@endsection
