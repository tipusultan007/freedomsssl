@extends('layouts/layoutMaster')

@section('title', 'দৈনিক ঋণ আবেদন ফরম')
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
    @include('app.partials.alert_danger')
    <div class="row">
      <div class="col-md-8">
        <form action="{{ route('daily-loans.store') }}" method="POST">
          @csrf
          <h3 class="px-2 py-1 bg-primary text-white">ঋণ তথ্য</h3>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row mb-3">
                @php
                  $accounts = \App\Models\DailySavings::with('user')->where('status','active')->orderBy('account_no','asc')->get();
                @endphp
                <div class="col-md-6 mb-2">
                  <label for="account_no" class="form-label">হিসাব নং</label>
                  <select data-allow-clear="true" name="account_no" id="account_no" data-placeholder="-- Select A/C --" class="select2 form-select">
                    <option value=""></option>
                    @forelse($accounts as $account)
                      <option value="{{ $account->account_no }}">{{ $account->account_no }}
                        || {{ $account->user->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>

                <div class="col-md-3 mb-2">
                  <label for="loan_amount" class="form-label">ঋণের পরিমাণ</label>
                  <input type="number" class="form-control" id="loan_amount" name="loan_amount">
                </div>
                <div class="col-md-3 mb-2">
                  <label for="package_id" class="form-label">প্যাকেজ</label>
                  <select name="package_id" id="package_id" data-placeholder="-- Select Package --" data-allow-clear="true" class="select2 form-select">
                    <option value=""></option>
                    @forelse($dailyLoanPackages as $package)
                      <option value="{{ $package->id }}">{{ $package->months }} || {{ $package->interest }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <input type="hidden" name="user_id" id="user_id">
                <div class="col-md-3 mb-2">
                  <label for="interest" class="form-label">সুদের পরিমাণ</label>
                  <input type="number" class="form-control" id="interest" name="interest">
                </div>
                <input type="hidden" name="balance" id="loan_balance">
                <div class="col-md-3 mb-2">
                  <label for="per_installment" class="form-label">কিস্তির পরিমাণ</label>
                  <input type="number" class="form-control" id="per_installment" name="per_installment">
                </div>
                <div class="col-md-3 mb-2">
                  <label for="account_no" class="form-label">তারিখ</label>
                  <input type="date" class="form-control" id="opening_date"
                         name="opening_date">
                </div>
                <div class="col-md-3 mb-2">
                  <label for="account_no" class="form-label">হিসাব শুরু</label>
                  <input type="date" class="form-control" id="commencement"
                         name="commencement">
                </div>


                <div class="col-md-12 mb-2">
                  <label for="account_no" class="form-label">মন্তব্য</label>
                  <input type="text" class="form-control" id="note"
                         name="note">
                </div>
              </div>
            </div>
          </div>
          <h3 class="px-2 py-1 bg-primary text-white">জামিনদারের তথ্য</h3>
          <div class="card">
            <div class="card-body">
              <div class="row">
                @php
                  $users = \App\Models\User::all();
                @endphp
                <div class="mb-1 col-md-12">
                  <label class="form-label" for="name">সদস্য</label>
                  <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-placeholder="-- Select User --">
                    <option value=""></option>
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
                  <label class="form-label" for="phone">মোবাইল নং</label>
                  <input type="text" name="phone" id="phone" class="form-control"/>
                </div>

                <div class="mb-1 col-md-12">
                  <label class="form-label" for="address">ঠিকানা</label>
                  <input type="text" name="address" id="address" class="form-control"/>
                </div>

              </div>
            </div>
          </div>
          <input type="hidden" name="status" value="active">
          <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-success w-20" id="submitBtn">সাবমিট</button>
          </div>
        </form>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="px-2 py-1 mb-0 bg-primary text-white">সদস্য তথ্য</h3>
          <div class="card-body pt-3">
            <div class="user-data">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    function preventDoubleSubmit() {
      // Disable the submit button to prevent double submission
      document.getElementById('submitBtn').disabled = true;
      return true; // Allow the form to be submitted
    }
  </script>
    <script>

      $("#account_no").select2();
      $("#package_id").select2();
      $("#guarantor_user_id").select2();

      $('#account_no').on('select2:select', function (e) {
            $(".user-data").empty();
            var data = e.params.data;
            $.ajax({
                url: "{{ url('savingsInfoByAccount') }}/"+data.id,
                dataType: "json",
                type: "get",
                success: function (data) {
                    $("#user_id").val(data.user.id);
                    var image = '';
                    if (data.user.image == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = "{{ asset('storage/images/profile') }}/"+data.user.image;
                    }
                    $(".user-data").append(`
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h5>${data.user.name}</h5>

                                    </div>
                                </div>
                            </div>

                            <div class="info-container">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">মোবাইল নং</th>
                                        <td style="font-size: 14px">${data.user.phone1}</td>
                                    </tr>
<tr>
                                        <th style="width: 130px" class="fw-bolder py-0">পিতা</th>
                                        <td style="font-size: 14px">${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">মাতা</th>
                                        <td style="font-size: 14px">${data.user.mother_name}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">স্বামী/স্ত্রী</th>
                                        <td style="font-size: 14px" >${data.user.spouse_name}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">বর্তমান ঠিকানা</th>
                                        <td style="font-size: 14px">${data.user.present_address}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">নিয়োগ তারিখ</th>
                                        <td style="font-size: 14px">${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">দৈনিক সঞ্চয়</th>
                                        <td style="font-size: 14px">${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">মাসিক সঞ্চয়</th>
                                        <td style="font-size: 14px">${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">বিশেষ সঞ্চয়</th>
                                        <td style="font-size: 14px">${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">দৈনিক ঋন</th>
                                        <td style="font-size: 14px">${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">মাসিক ঋন</th>
                                        <td style="font-size: 14px">${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 130px" class="fw-bolder py-0">বিশেষ ঋন</th>
                                        <td style="font-size: 14px">${data.special_dps_loans}</td>
                                    </tr>
                                </table>
                            </div>
                    `);
                }
            })
        });


        $("#package_id").on('select2:select',function(e) {
            var principal = $("#loan_amount").val();
            console.log(principal);
            var packageId = e.params.data.id;
            $('#per_installment').empty();
            $("#interest").empty();
            $("#loan_balance").val('');
            $.ajax({
                url : "{{ url('getPackageInfo') }}/" +packageId,
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    console.log(data);
                    if (data)
                    {
                        var interest = principal*(data.interest/100)*1;
                        var principalWithInterest = parseFloat(principal) + parseFloat(interest);
                        var installment = principalWithInterest/data.months;

                        $("#loan_balance").val(principalWithInterest);

                        $("#interest").val(interest);

                        $('#per_installment').empty();
                        $('#per_installment').focus();
                        $('#per_installment').val(Math.round(installment));

                    }else {
                        $('#per_installment').empty();
                        $("#interest").empty();

                    }
                }
            });
        });

        $("#guarantor_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#name").val('');
            $("#address").val('');
            $("#phone").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //console.log(data)
                    $("#name").val(data.name);
                    $("#address").val(data.present_address);
                    $("#phone").val(data.phone1);
                }
            })
        })
    </script>
@endsection
