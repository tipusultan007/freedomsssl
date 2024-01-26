@extends('layouts/layoutMaster')

@section('title', 'নতুন সদস্য আবেদন ফরম')
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
          </li>
          <li class="breadcrumb-item">
            <a href="{{ url('users') }}">সদস্য তালিকা</a>
          </li>
          <li class="breadcrumb-item active">নতুন সদস্য আবেদন ফরম</li>
        </ol>
      </nav>
    </div>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="form">
      @csrf
      <h4 class="bg-primary p-1 text-white text-center">আবেদনকারীর তথ্য</h4>
      <div class="card">
        <div class="card-body">
          <div class="row mt-2">
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="name">আবেদনকারীর নাম</label>
                <input type="text" name="name" id="name" class="form-control"
                       placeholder="Applicant's Name"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="father_name">পিতার নাম</label>
                <input type="text" name="father_name" id="father_name" class="form-control"
                       placeholder="Father's Name"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="mother_name">মাতার নাম</label>
                <input type="text" name="mother_name" id="mother_name" class="form-control"
                       placeholder="Father's Name"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <label class="form-label">লিঙ্গ</label>
              <select name="gender" id="gender" class="form-select select2" data-allow-clear="on" data-placeholder="Gender">
                <option value=""></option>
                <option value="male">পুরুষ</option>
                <option value="female">মহিলা</option>
                <option value="Other">অন্যান্য</option>
              </select>
            </div>
            <div class="mb-2 col-md-6">
              <div class="form-group">
                <label class="form-label" for="present_address">বর্তমান ঠিকানা</label>
                <input type="text" name="present_address" id="present_address" class="form-control"
                       placeholder="Present Address"/>

              </div>
            </div>
            <div class="mb-2 col-md-6">
              <div class="form-group">
                <label class="form-label" for="permanent_address">স্থায়ী ঠিকানা</label>
                <input type="text" name="permanent_address" id="permanent_address" class="form-control"
                       placeholder="Permanent Address"/>

              </div>
            </div>
            <div class="col-md-3 mb-2">
              <div class="form-group">
                <label class="form-label">জন্ম তারিখ</label>
                <input type="text" id="birthdate" name="birthdate" class="form-control datepicker" placeholder="Date of Birth" />
              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone1">মোবাইল - ০১</label>
                <input type="text" name="phone1" class="form-control phone-number-mask" placeholder="Mobile" id="phone1" />

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone2">মোবাইল - ০২</label>
                <input type="text" name="phone2" class="form-control phone-number-mask" placeholder="Mobile" id="phone2" />

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone3">মোবাইল - ০৩</label>
                <input type="text" name="phone3" class="form-control phone-number-mask" placeholder="Mobile" id="phone3" />

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="occupation">পেশা</label>
                <input type="text" name="occupation" id="occupation" class="form-control"
                       placeholder="Occupation"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="workplace">কর্মস্থল</label>
                <input type="text" name="workplace" id="workplace" class="form-control"
                       placeholder="Workplace"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label for="" class="form-label">বৈবাহিক অবস্থা</label>
                <select name="marital_status" id="marital_status" class="form-select select2" data-allow-clear="on" data-placeholder="Marital Status">
                  <option value=""></option>
                  <option value="Married">বিবাহিত</option>
                  <option value="Unmarried">অবিবাহিত</option>
                </select>
              </div>
            </div>
            <div class="mb-2 col-md-3 spouse-name">
              <div class="form-group">
                <label class="form-label" for="spouse_name">স্বামী/স্ত্রীর নাম</label>
                <input type="text" name="spouse_name" id="spouse_name" class="form-control"
                       placeholder="Spouse Name"/>

              </div>
            </div>
            <div class="col-md-4 mb-2">
              <label for="national_id" class="form-label">জাতীয় পরিচয়পত্র</label>
              <input class="form-control" name="national_id" type="file" id="national_id">
            </div>
            <div class="col-md-4 mb-2">
              <label for="birth_id" class="form-label">জন্ম নিবন্ধন</label>
              <input class="form-control" name="birth_id" type="file" id="birth_id">
            </div>
            <div class="col-md-4 mb-2">
              <label for="image" class="form-label">আবেদনকারীর ছবি</label>
              <input class="form-control" name="image" type="file" id="image">
            </div>

            <div class="col-md-3 mb-2">
              <div class="form-group">
                <label for="" class="form-label">ভর্তির তারিখ</label>
                <input type="text" id="join_date" name="join_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" placeholder="Join Date" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <h4 class="bg-primary p-1 text-white my-3 text-center">সঞ্চয় হিসাব তথ্য</h4>
      <div class="card">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md mb-md-0 mb-2">
              <div class="form-check custom-option custom-option-basic">
                <label class="form-check-label custom-option-content" for="type_daily_savings">
                  <input class="form-check-input mt-2" type="radio" name="account_type"
                         id="type_daily_savings"
                         value="daily_savings" checked />
                  <span class="custom-option-header">
                  <span class="h6 mb-0 mt-2">দৈনিক সঞ্চয়</span>
                </span>

                </label>
              </div>
            </div>
            <div class="col-md">
              <div class="form-check custom-option custom-option-basic">
                <label class="form-check-label custom-option-content" for="type_dps">
                  <input class="form-check-input mt-2" type="radio" name="account_type"
                         id="type_dps"
                         value="dps" />
                  <span class="custom-option-header">
                  <span class="h6 mb-0 mt-2">মাসিক সঞ্চয়(DPS)</span>

                </span>

                </label>
              </div>
            </div>
            <div class="col-md">
              <div class="form-check custom-option custom-option-basic">
                <label class="form-check-label custom-option-content" for="type_special_dps">
                  <input class="form-check-input mt-2" type="radio" name="account_type"
                         id="type_special_dps"
                         value="special_dps" />
                  <span class="custom-option-header">
                  <span class="h6 mb-0 mt-2">মাসিক সঞ্চয়(স্পেশাল সঞ্চয়)</span>
                </span>

                </label>
              </div>
            </div>
            <div class="col-md">
              <div class="form-check custom-option custom-option-basic">
                <label class="form-check-label custom-option-content" for="type_fdr">
                  <input class="form-check-input mt-2" type="radio"  name="account_type"
                         id="type_fdr"
                         value="fdr" />
                  <span class="custom-option-header">
                  <span class="h6 mb-0 mt-2">স্থায়ী সঞ্চয়</span>
                </span>

                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">হিসাব নং</label>
              <input type="text" class="form-control" name="account_no"
                     id="account_no" value="{{ $dailyAccount }}">
              <span id="result" class="font-small-3"></span>
            </div>


            <div class="col-md-3 mb-2 dps-package dps d-none">
              @php
                $packages = \App\Models\DpsPackage::all();
              @endphp
              <label for="dps_package_id" class="form-label">প্যাকেজ</label>
              <select name="dps_package_id" id="dps_package_id"
                      class="select2 form-select" data-placeholder="Select Package">
                <option value=""></option>
                @forelse($packages as $package)
                  <option value="{{ $package->id }}">{{ $package->name }}
                    - {{ $package->amount }}</option>
                @empty
                @endforelse
              </select>
            </div>

            <div class="col-md-3 mb-2 special-dps-package special-dps d-none">
              @php
                $specialPackage = \App\Models\SpecialDpsPackage::all();
              @endphp
              <label for="special_dps_package_id" class="form-label">প্যাকেজ</label>
              <select name="special_dps_package_id" id="special_dps_package_id"
                      class="select2 form-select" data-placeholder="Select Package">
                <option value=""></option>
                @forelse($specialPackage as $package)
                  <option value="{{ $package->id }}">{{ $package->name }}
                    - {{ $package->amount }}</option>
                @empty
                @endforelse
              </select>
            </div>


            <div class="mb-1 col-md-3 fdr-package fdr d-none">
              <?php
              $fdrPackages = \App\Models\FdrPackage::all();
              ?>
              <label class="form-label" for="name">প্যাকেজ</label>
              <select class="form-select select2" name="fdr_package_id"
                      id="fdr_package_id"
                      data-placeholder="-- Select Package --">
                <option value=""></option>
                @forelse($fdrPackages as $package)
                  <option value="{{ $package->id }}"> {{ $package->name }} </option>
                @empty
                @endforelse
              </select>


            </div>

            <div class="col-md-3 mb-2 package-amount dps d-none">
              <label class="form-label" for="package_amount">মাসিক জমা</label>
              <input
                type="number"
                class="form-control dt-initial_amount"
                id="package_amount"
                name="package_amount"
              />
            </div>
            <div class="col-md-3 mb-2 fdr-amount fdr d-none">
              <label class="form-label" for="fdr_amount">FDR জমা</label>
              <input
                type="number"
                class="form-control dt-initial_amount"
                id="fdr_amount"
                name="fdr_amount"
              />
            </div>
            <div class="col-md-3 mb-2 duration d-none">
              <label class="form-label" for="duration">মেয়াদ</label>
              <input
                type="number"
                class="form-control dt-initial_amount"
                id="duration"
                name="duration"

              />
            </div>
            <div class="col-md-3 mb-2 initial-amount special-dps d-none">
              <label class="form-label" for="initial_amount">প্রাথমিক জমা</label>
              <input
                type="number"
                class="form-control dt-initial_amount"
                id="initial_amount"
                name="initial_amount"

              />
            </div>
@php
  // Get the current date
  $currentDate = \Carbon\Carbon::now();

  // Get the 1st day of the next month
  $firstDayOfNextMonth = $currentDate->addMonth()->startOfMonth();

  // Format the date as needed
  $formattedDate = $firstDayOfNextMonth->format('Y-m-d');

            @endphp

            <div class="col-md-3 opening_date mb-2">
              <label class="form-label">তারিখ</label>
              <input type="text" id="opening_date" name="opening_date" class="form-control datepicker" value="{{ date('Y-m-d') }}"  />
            </div>
            <div class="col-md-3 deposit-date mb-2 d-none">
              <label class="form-label">জমার তারিখ</label>
              <input type="text" id="deposit_date" name="date" class="form-control datepicker" value="{{ date('Y-m-d') }}"  />
            </div>
            <div class="mb-2 col-md-3">
              <label class="form-label" for="commencement">হিসাব শুরু</label>
              <input type="text" id="commencement" name="commencement"
                     class="form-control datepicker"
                     value="{{ $formattedDate }}"
                     placeholder="DD/MM/YYYY"
              >
            </div>
            <div class="col-md-3 mb-2 introducer">
              @php
                $introducers = \App\Models\User::all();
              @endphp
              <label for="" class="form-label">পরিচয়দানকারী</label>
              <select name="introducer_id" class="form-select select2" id="introducer_id" data-placeholder="Select Introducer">
                <option value=""></option>
                @foreach($introducers as $introducer)
                  <option value="{{ $introducer->id }}">{{ $introducer->name }}</option>
                @endforeach
              </select>
            </div>

          </div>
        </div>
      </div>
      <h4 class="bg-primary p-1 my-3 text-white text-center">মনোনীত ব্যক্তিবর্গ</h4>
      @php
        $nomineeUsers = \App\Models\User::select('name','father_name','id')->get();
      @endphp
      <div class="row g-4">
        <div class="col-md-6">
          <h5 class="text-center">নমিনী - ০১</h5>
          <div class="card">
            <div class="card-body">
              <div class="row g-1">
                <div class="col-md-12 mb-1">
                  <select name="nominee_user_id" id="nominee_user_id" class="form-control select2" data-allow-clear="on" data-placeholder="সবিদ্যমান সদস্য">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                      <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_name">নাম</label>
                  <input type="text"  class="form-control " name="nominee_name" placeholder="Name">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_phone">মোবাইল নং</label>
                  <input type="text" class="form-control  dt-salary" name="nominee_phone" placeholder="Phone">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="nominee_address">ঠিকানা</label>
                  <input type="text" class="form-control " name="nominee_address" placeholder="Address">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_relation">সম্পর্ক</label>
                  <input type="text" class="form-control " name="nominee_relation" placeholder="Relation">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_percentage">অংশ</label>
                  <input type="number" class="form-control " name="nominee_percentage" value="100" placeholder="Percentage">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_birthdate">জন্মতারিখ</label>
                  <input type="text" class="form-control datepicker" name="nominee_birthdate">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_image">ছবি</label>
                  <input type="file" class="form-control" name="nominee_image">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <h5 class="text-center">নমিনী - ০২</h5>
          <div class="card">
            <div class="card-body">
              <div class="row g-1">
                <div class="col-md-12 mb-1">
                  <select name="nominee_user_id1" id="nominee_user_id1" class="form-control select2" data-allow-clear="on" data-placeholder="বিদ্যমান সদস্য">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                      <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_name1">নাম</label>
                  <input type="text"  class="form-control " name="nominee_name1" placeholder="Name">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_phone1">মোবাইল নং</label>
                  <input type="text"  class="form-control  dt-salary" name="nominee_phone1" placeholder="Phone">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="nominee_address1">ঠিকানা</label>
                  <input type="text" class="form-control " name="nominee_address1" placeholder="Address">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_relation1">সম্পর্ক</label>
                  <input type="text"  class="form-control " name="nominee_relation1" placeholder="Relation">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_pecentage1">অংশ</label>
                  <input type="number"  class="form-control " name="nominee_percentage1" value="100" placeholder="Percentage">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_birthdate1">জন্মতারিখ</label>
                  <input type="text" class="form-control datepicker" name="nominee_birthdate1">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="nominee_image1">ছবি</label>
                  <input type="file"  class="form-control" name="image1">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
          <button class="btn btn-success w-25">সাবমিট করুন</button>
        </div>
      </div>

    </form>
  </div>
@endsection

@section('page-script')
    <!-- Page js files -->


    <script>
      const daily_account = '{{ $dailyAccount }}';
      const dps_account = '{{ $dpsAccount }}';
      const special_account = '{{ $specialAccount }}';
      const fdr_account = '{{ $fdrAccount }}';

      $(".select2").select2();
        $("input[name='account_type']").on("change",function () {
            var selected = $(this).val();
            if (selected == 'dps')
            {
                //$("#account-prefix").text('DPS');
              $("#account_no").val(dps_account);
                $(".dps-package, .package-amount, .duration, .opening_date").removeClass('d-none');
                $(".special-dps-package, .initial-amount, .fdr-amount, .fdr-package, .deposit-date").addClass('d-none');
            }else if(selected == 'special_dps')
            {
              $("#account_no").val(special_account);
                //$("#account-prefix").text('ML');
                $(".dps-package, .fdr-amount, .fdr-package, .deposit-date").addClass('d-none');
                $(".special-dps-package, .package-amount, .duration, .initial-amount,.opening_date").removeClass('d-none');
            }else if(selected == 'fdr')
            {
              $("#account_no").val(fdr_account);
                //$("#account-prefix").text('FDR');
                $(".fdr-amount, .fdr-package, .deposit-date,.duration").removeClass('d-none');
                $(".special-dps-package, .package-amount, .initial-amount,.dps-package, .opening_date").addClass('d-none');
            }else {
              $("#account_no").val(daily_account);
                //$("#account-prefix").text('DS');
                $(".opening_date").removeClass('d-none');
                $(".special-dps-package, .package-amount, .initial-amount,.dps-package,.fdr-amount,.deposit-date, .fdr-package, .duration").addClass('d-none');
            }
        })

        $("#account_no").on("input", function () {
            // Print entered value in a div box
            let type = $("input[name='account_type']:checked").val();
            let prefix = $("#account-prefix").text();
            let account_digit = $(this).val();
            let account_no = account_digit.padStart(4,'0');
            if ($(this).val() != "") {
                let ac = account_no;
                console.log(ac)
                $("#result").empty();
               if (type=="daily_savings")
               {
                   isDailyExist(ac);
               }else if (type=="dps")
               {
                   isDpsExist(ac);
               }else if (type=="special_dps")
               {
                   isSpecialDpsExist(ac);
               }else if (type=="fdr")
               {
                   isFdrExist(ac);
               }
            } else {
                $("#result").removeClass("text-success");
                $("#result").addClass("text-danger");
                $("#result").text("Enter Valid A/C number.");
                $(".btn-next").prop('disabled',true);
            }
        });

        function isDailyExist(ac) {
            $.ajax({
                url: "{{ url('isSavingsExist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.")
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isDpsExist(ac) {
            $.ajax({
                url: "{{ url('dps-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isSpecialDpsExist(ac) {
            $.ajax({
                url: "{{ url('special-dps-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isFdrExist(ac) {
            $.ajax({
                url: "{{ url('is-fdr-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }
        $("#nominee_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#nominee_name").val('');
            $("#nominee_address").val('');
            $("#nominee_phone").val('');
            $("#nominee_birthdate").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data)
                    $("#nominee_name").val(data.name);
                    $("#nominee_address").val(data.present_address);
                    $("#nominee_phone").val(data.phone1);
                    $("#nominee_birthdate").val(data.birthdate);
                }
            })
        })
    </script>

    <script>
      $(document).on("change","#nominee_user_id",function (){
        var id = $("#nominee_user_id option:selected").val();
        $("input[name='nominee_name']").val("");
        $("input[name='nominee_address']").val("");
        $("input[name='nominee_phone']").val("");
        $("input[name='nominee_birthdate']").empty();
        $.ajax({
          url: "{{ url('userProfile') }}/"+id,
          dataType: "JSON",
          success: function (data) {
            console.log(data)
            $("input[name='nominee_name']").val(data.name);
            $("input[name='nominee_address']").val(data.permanent_address);
            $("input[name='nominee_phone']").val(data.phone1);
            $("input[name='nominee_birthdate']").val(data.birthdate);
          }
        })
      })
      $(document).on("change","#nominee_user_id1",function ()    {
        var id = $("#nominee_user_id1 option:selected").val();
        $("input[name='nominee_name1']").val("");
        $("input[name='nominee_address1']").val("");
        $("input[name='nominee_phone1']").val("");
        $("input[name='nominee_birthdate1']").empty();
        $.ajax({
          url: "{{ url('userProfile') }}/"+id,
          dataType: "JSON",
          success: function (data) {
            $("input[name='nominee_name1']").val(data.name);
            $("input[name='nominee_address1']").val(data.permanent_address);
            $("input[name='nominee_phone1']").val(data.phone1);
            $("input[name='nominee_birthdate1']").val(data.birthdate);
          }
        })
      })
    </script>
@endsection

{{--
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('users.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.users.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('users.store') }}"
                class="mt-4"
            >
                @include('app.users.form-inputs')

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
--}}
