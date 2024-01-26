@extends('layouts/layoutMaster')

@section('title', $dailyLoan->account_no.' - দৈনিক ঋণ এডিট ফরম')

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
    <!-- Horizontal Wizard -->
    <section class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('daily-loans.show',$dailyLoan->id) }}">দৈনিক ঋণ - {{ $dailyLoan->account_no }}</a>
            </li>
            <li class="breadcrumb-item active">দৈনিক ঋণ এডিট ফরম</li>
          </ol>
        </nav>
      </div>
        <div class="row">
            <div class="col-md-8">
              <form action="{{ route('daily-loans.update',$dailyLoan) }}" method="POST">
                @csrf
                @method('PATCH')
                <h3 class="px-2 py-1 bg-primary text-white">ঋণ তথ্য</h3>
                <div class="row mb-3">
                  @php
                    $accounts = \App\Models\DailySavings::with('user')->where('status','active')->orderBy('account_no','asc')->get();
                  @endphp
                  <div class="col-md-6 mb-2">
                    <label for="account_no" class="form-label">হিসাব নং</label>
                    <input name="account_no" class="form-control" value="{{ $dailyLoan->account_no }}" readonly>
                  </div>

                  <div class="col-md-3 mb-2">
                    <label for="loan_amount" class="form-label">ঋণের পরিমাণ</label>
                    <input type="number" class="form-control" id="loan_amount" name="loan_amount" value="{{ $dailyLoan->loan_amount }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="package_id" class="form-label">প্যাকেজ</label>
                    <select name="package_id" id="package_id" data-placeholder="-- Select Package --" data-allow-clear="true" class="select2 form-select">
                      <option value=""></option>
                      @forelse($dailyLoanPackages as $package)
                        <option value="{{ $package->id }}" @if($package->id==$dailyLoan->package_id) selected @endif>{{ $package->months }} || {{ $package->interest }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                  <input type="hidden" name="user_id" id="user_id" value="{{ $dailyLoan->user_id }}">
                  <div class="col-md-3 mb-2">
                    <label for="interest" class="form-label">সুদ</label>
                    <input type="number" class="form-control" id="interest" name="interest" value="{{ $dailyLoan->interest }}">
                  </div>

                  <div class="col-md-3 mb-2">
                    <label for="per_installment" class="form-label">প্রতি কিস্তির পরিমাণ</label>
                    <input type="number" class="form-control" id="per_installment" name="per_installment" value="{{ $dailyLoan->per_installment }}">
                  </div>



                  <div class="col-md-3 mb-2">
                    <label for="adjusted_amount" class="form-label">সমন্বিত ঋণের পরিমাণ</label>
                    <input type="number" class="form-control" id="adjusted_amount" name="adjusted_amount" value="{{ $dailyLoan->adjusted_amount }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="grace" class="form-label">ঋণ মওকুফ</label>
                    <input type="number" class="form-control" id="grace" name="grace" value="{{ $dailyLoan->grace }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="total" class="form-label">সর্বমোট ঋণ</label>
                    <input type="number" class="form-control" id="total" name="total" value="{{ $dailyLoan->total }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="balance" class="form-label">ব্যালেন্স</label>
                    <input type="number" class="form-control" id="balance" name="balance" value="{{ $dailyLoan->balance }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">তারিখ</label>
                    <input type="date" class="form-control" id="opening_date"
                           name="opening_date" aria-label="MM/DD/YYYY" value="{{ date('Y-m-d',strtotime($dailyLoan->opening_date)) }}">
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">হিসাব শুরু</label>
                    <input type="date" class="form-control flatpickr-basic" id="commencement"
                           name="commencement" aria-label="MM/DD/YYYY" value="{{ date('Y-m-d',strtotime($dailyLoan->commencement)) }}">
                  </div>


                  <div class="col-md-12 mb-2">
                    <label for="account_no" class="form-label">মন্তব্য</label>
                    <input type="text" class="form-control" id="note"
                           name="note" value="{{ $dailyLoan->note??'' }}">
                  </div>
                </div>
                <h3 class="px-2 py-1 bg-primary text-white">জামিনদারের তথ্য</h3>
                <div class="row">
                  @php
                    $users = \App\Models\User::select('id','name','father_name')->get();
                  @endphp
                  <div class="mb-1 col-md-12">
                    <label class="form-label" for="name">সদস্য</label>
                    <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-placeholder="-- Select User --">
                      <option value=""></option>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $dailyLoan->guarantor!=""?$user->id==$dailyLoan->guarantor->guarantor_user_id?"selected":"":"" }}>{{ $user->name }} || {{ $user->father_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="name">নাম</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $dailyLoan->guarantor->name??"" }}">
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="phone">মোবাইল নং</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $dailyLoan->guarantor->phone??"" }}">
                  </div>

                  <div class="mb-1 col-md-12">
                    <label class="form-label" for="address">ঠিকানা</label>
                    <input type="text" name="address" id="address" class="form-control"value="{{ $dailyLoan->guarantor->address??"" }}">
                  </div>

                </div>

                <div class="d-flex justify-content-center mt-3">
                  <button type="submit" class="btn btn-success w-20">আপডেট</button>
                </div>
              </form>
            </div>
          <div class="col-md-4">
            <div class="card">
              <h3 class="px-2 py-1 mb-0 bg-primary text-white">সদস্য তথ্য</h3>
              <div class="card-body pt-3">
                <div class="user-data">
                  <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                      <img class="img-fluid rounded mb-2" src="{{ asset('storage/images/profile/'.$dailyLoan->user->image) }}" height="110" width="110" alt="User avatar">
                      <div class="user-info text-center">
                        <h5>{{ $dailyLoan->user->name }}</h5>

                      </div>
                    </div>
                  </div>

                  <div class="info-container">
                    <table class="table table-sm table-bordered">
                      <tbody><tr>
                        <th style="width: 130px" class="fw-bolder py-0">মোবাইল নং</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->phone1 }}</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">পিতা</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->father_name }}</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">মাতা</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->mother_name }}</td>
                      </tr>

                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">বর্তমান ঠিকানা</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->present_address }}</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">নিয়োগ তারিখ</th>
                        <td style="font-size: 14px">{{ date('d/m/Y',strtotime($dailyLoan->user->join_date)) }}</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">দৈনিক সঞ্চয়</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->dailySavings->count() }} - জমাঃ {{ $dailyLoan->user->dailySavings->sum('total') }}/=</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">মাসিক সঞ্চয়</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->dpsSavings->count() }} - জমাঃ {{ $dailyLoan->user->dpsSavings->sum('balance') }}/=</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">বিশেষ সঞ্চয়</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->specialDpsSavings->count() }} - জমাঃ {{ $dailyLoan->user->specialDpsSavings->sum('balance') }}/=</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">দৈনিক ঋন</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->dailyLoans->count() }} - অবশিষ্টঃ {{ $dailyLoan->user->dailyLoans->sum('balance') }}/=</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">মাসিক ঋন</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->dpsLoans->count() }} - অবশিষ্টঃ {{ $dailyLoan->user->dpsLoans->sum('remain_loan') }}/=</td>
                      </tr>
                      <tr>
                        <th style="width: 130px" class="fw-bolder py-0">বিশেষ ঋন</th>
                        <td style="font-size: 14px">{{ $dailyLoan->user->specialLoans->count() }} - অবশিষ্টঃ {{ $dailyLoan->user->specialLoans->sum('remain_loan') }}/=</td>
                      </tr>
                      </tbody></table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    </section>
    <!-- /Horizontal Wizard -->

@endsection

@section('page-script')

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
                        image = data.user.image;
                    }
                    $(".user-data").append(`
                     <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-2" src="/images/${image}" height="110" width="110" alt="User avatar">
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
