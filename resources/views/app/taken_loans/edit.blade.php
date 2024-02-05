@extends('layouts/layoutMaster')

@section('title', 'ঋণ বিতরণ ফরম আপডেট')

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
  <div class="d-flex justify-content-between mb-3">
    <nav aria-label="breadcrumb" class="d-flex align-items-center">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ url('taken-loans') }}">ঋনের তালিকা</a></li>
        <li class="breadcrumb-item"><a href="{{ route('taken-loans.show', $loan->id) }}">হিসাব নং - {{ $loan->account_no }}</a></li>
        <li class="breadcrumb-item active">ঋণ ফরম আপডেট</li>
      </ol>
    </nav>
    <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('dps-loans.create') }}" target="_blank">নতুন ঋণ প্রদান</a>
  </div>
  <div class="row">
    <div class="col-md-8">
      <form action="{{ route('taken-loans.update',$loan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div id="account-details">
          <h4 class="bg-primary p-1 text-white">ঋণের তথ্য</h4>
          <div class="row mb-3">
            @php
              $accounts = \App\Models\Dps::with('user')->where('status','active')->get();
            @endphp
            <div class="col-md-6 mb-2">
              <label for="account_no" class="form-label">হিসাব নং </label>
              <input type="text" class="form-control" name="account_no" value="{{ $loan->account_no }}" readonly>
            </div>

            <div class="col-md-3 mb-2">
              <label for="loan_amount" class="form-label">ঋণের পরিমাণ</label>
              <input type="text" class="form-control" id="loan_amount" name="loan_amount" value="{{ $loan->loan_amount }}">
            </div>

            <div class="col-md-3 mb-2">
              <label for="interest1" class="form-label">সুদের হার (%)</label>
              <input type="number" class="form-control" value="2" id="interest1" name="interest1" value="{{ $loan->interest1??'' }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="interest2" class="form-label">স্পেশাল সুদের হার (%)</label>
              <input type="number" class="form-control" id="interest2" name="interest2" value="{{ $loan->interest2??'' }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="upto_amount" class="form-label">Upto Amount</label>
              <input type="text" class="form-control" id="upto_amount" name="upto_amount" value="{{ $loan->upto_amount??'' }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">ঋণের তারিখ</label>
              <input type="date" class="form-control flatpickr-basic" id="opening_date"
                     name="opening_date" aria-label="MM/DD/YYYY" value="{{ $loan->date }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">হিসাব শুরু</label>
              <input type="date" class="form-control flatpickr-basic" id="commencement"
                     name="commencement" aria-label="MM/DD/YYYY" value="{{ $loan->commencement??'' }}">
            </div>


            <div class="col-md-12 mb-2">
              <label for="account_no" class="form-label">নোট</label>
              <input type="text" class="form-control" id="note" name="note" value="{{ $loan->note??'' }}">
            </div>
          </div>
        </div>
        <div id="document-details">
          <h4 class="bg-primary p-1 text-white">ঋণের ডকুমেন্টস</h4>
          <div class="row mb-3">

            <div class="col-md-4 mb-2">
              <label for="bank_name" class="form-label">ব্যাংকের নাম</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $loan->bank_name??"" }}">
            </div>

            <div class="col-md-4 mb-2">
              <label for="branch_name" class="form-label">শাখা</label>
              <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ $loan->branch_name??"" }}">
            </div>
            <div class="col-md-4 mb-2">
              <label for="cheque_no" class="form-label">চেক নং</label>
              <input type="text" class="form-control" id="cheque_no" name="cheque_no" value="{{ $loan->cheque_no??"" }}">
            </div>
            <div class="col-lg-6 col-md-12">
              <label for="document_name" class="form-label">ডকুমেন্টস</label>
              <input class="form-control" type="file" name="documents[]" id="documents" multiple />
            </div>

            <div class="col-md-6 mb-2">
              <label for="documents_note" class="form-label">নোট</label>
              <input type="text" class="form-control" id="documents_note"
                     name="documents_note" value="{{ $loan->documents_note??"" }}">
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
                  <option value="{{ $user->id }}" {{ isset($loan->guarantor)?$user->id === $loan->guarantor->user_id?"selected":"":"" }}>{{ $user->name }} || {{ $user->father_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="name">নাম</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $loan->guarantor->name??"" }}">
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="phone">মোবাইল</label>
              <input type="text" name="phone" id="phone" class="form-control" value="{{ $loan->guarantor->phone??"" }}">
            </div>

            <div class="mb-1 col-md-6">
              <label class="form-label" for="address">ঠিকানা</label>
              <input type="text" name="address" id="address" class="form-control" value="{{ $loan->guarantor->address??"" }}">
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="percentage">হিসাব নং</label>
              <input type="text" name="exist_ac_no" id="exist_ac_no" class="form-control"/>
            </div>
          </div>

        </div>
        <div class="d-flex justify-content-center">
          <button class="btn btn-success rounded-pill  mt-4 w-25" type="submit"> আপডেট </button>
        </div>
      </form>
    </div>
    <div class="col-md-4">
      <div class="card">

        <div class="divider">
          <div class="divider-text">সদস্য তথ্য</div>
        </div>
        @php
        $user = $loan->user;
        @endphp
        <div class="card-body">
          <div class="user-data">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img class="img-fluid rounded user-avatar mb-2" src="{{ asset('storage/images/profile/'.$loan->user->image) }}" height="110" width="110" alt="User avatar">
                <div class="user-info text-center">
                  <h4>{{ $user->name }}</h4>
                 মোবাইল নং- <span class="text-success">{{ $user->phone1 }}</span>
                </div>
              </div>
            </div>

            <div class="info-container mt-2">
              <table class="table table-sm table-bordered">
                <tbody><tr class="mb-75">
                  <th class="py-1 fw-bolder">পিতার নাম</th>
                  <td>{{ $user->father_name }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">মাতার নাম</th>
                  <td>{{ $user->mother_name }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">নিবন্ধন তারিখ</th>
                  <td>{{ $user->join_date?date('d/m/Y',strtotime($user->join_date)):"-" }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder"> দৈনিক সঞ্চয়</th>
                  <td>{{ $user->dailySavings->sum('total') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">মাসিক সঞ্চয়</th>
                  <td>{{ $user->dpsSavings->sum('balance') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">বিশেষ সঞ্চয়</th>
                  <td>{{ $user->specialDpsSavings->sum('balance') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">দৈনিক ঋণ</th>
                  <td>{{ $user->dailyLoans->sum('balance') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">মাসিক ঋণ</th>
                  <td>{{ $user->dpsLoans->sum('remain_loan') }}</td>
                </tr>
                <tr class="mb-75">
                  <th class="py-1 fw-bolder">বিশেষ ঋণ</th>
                  <td>{{ $user->specialLoans->sum('remain_loan') }}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-2">

        <div class="divider">
          <div class="divider-text">জামিনদারের তথ্য</div>
        </div>


        @if(isset($loan->guarantor))
          @php
            $guarantor = $loan->guarantor;
          @endphp
          <div class="card-body">
            @if($loan->guarantor->guarantor_user_id!="")
              <div class="guarantor-data">
                <div class="user-avatar-section">
                  <div class="d-flex align-items-center flex-column">
                    @if($guarantor->image != "")
                    <img class="img-fluid rounded mt-3 mb-2" src="{{ asset('storage/images/profile/'.$guarantor->image) }}" height="110" width="110" alt="User avatar">
                    @endif
                    <div class="user-info text-center mb-2">
                      <h4>{{ $guarantor->user->name??"" }}</h4>
                      মোবাইল নং- <span class="text-success">8.80185E+12</span>
                    </div>
                  </div>
                </div>

                <div class="info-container">
                  <table class="table table-sm table-bordered">
                    <tbody><tr>
                      <th class="py-1 fw-bolder">পিতার নাম</th>
                      <td>{{ $guarantor->user->father_name??"" }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">মাতার নাম</th>
                      <td>{{ $guarantor->user->mother_name??"" }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">নিবন্ধন তারিখ</th>
                      <td>{{ $guarantor->user->join_date?date('d/m/Y',strtotime($guarantor->user->join_date)):"-" }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder"> দৈনিক সঞ্চয়</th>
                      <td>{{ $guarantor->user->dailySavings->sum('total') }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">মাসিক সঞ্চয়</th>
                      <td>{{ $guarantor->user->dpsSavings->sum('balance') }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">বিশেষ সঞ্চয়</th>
                      <td>{{ $guarantor->user->specialDpsSavings->sum('balance') }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">দৈনিক ঋণ</th>
                      <td>{{ $guarantor->user->dailyLoans->sum('balance') }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">মাসিক ঋণ</th>
                      <td>{{ $guarantor->user->dpsLoans->sum('remain_loan') }}</td>
                    </tr>
                    <tr class="mb-75">
                      <th class="py-1 fw-bolder">বিশেষ ঋণ</th>
                      <td>{{ $guarantor->user->specialLoans->sum('remain_loan') }}</td>
                    </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            @else
              <div class="guarantor-data"></div>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection


@section('page-script')
  <!-- Page js files -->
  {{-- <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>--}}


  <script>

    $("select").select2();
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
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-2" src="{{ asset('images') }}/${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-container mt-2">
                                <table class="table table-sm table-bordered">
                                    <tr class="mb-75">
                                        <th class="py-1">পিতার নাম:</th>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">মাতার নাম:</th>
                                        <td>${data.user.mother_name}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">নিবন্ধন তারিখ:</th>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1"> দৈনিক সঞ্চয়:</th>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">মাসিক সঞ্চয়:</th>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">বিশেষ সঞ্চয়:</th>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">দৈনিক ঋণ:</th>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">মাসিক ঋণ:</th>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr class="mb-75">
                                        <th class="py-1">বিশেষ ঋণ:</th>
                                        <td>${data.special_dps_loans}</td>
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
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-container">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <td class="py-1">পিতা</td>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">মাতা</td>
                                        <td>${data.user.mother_name}</td>
                                    </tr>

                                    <tr>
                                        <td class="py-1">নিবন্ধন তারিখ</td>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                   <tr>
                                        <th class="py-1"> দৈনিক সঞ্চয়:</th>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">মাসিক সঞ্চয়:</th>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">বিশেষ সঞ্চয়:</th>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">দৈনিক ঋণ:</th>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">মাসিক ঋণ:</th>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">বিশেষ ঋণ:</th>
                                        <td>${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <th class="py-1">FDR:</th>
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

