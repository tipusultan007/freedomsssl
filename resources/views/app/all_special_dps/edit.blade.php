@extends('layouts/layoutMaster')

@section('title', $specialDps->account_no.' - বিশেষ সঞ্চয় এডিট ফরম')

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
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('special-dps.show',$specialDps->id) }}">বিশেষ সঞ্চয় - {{ $specialDps->account_no }}</a>
          </li>
          <li class="breadcrumb-item active">বিশেষ সঞ্চয় এডিট ফরম</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-md-8">
        <form action="{{ route('special-dps.update',$specialDps->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <h4 class="bg-primary p-1 text-white">সঞ্চয় হিসাবের তথ্য</h4>
          <div class="row mb-3">
            <div class="col-md-6 mb-2">
              <label for="user_id" class="form-label">সদস্য নাম</label>
              <select name="user_id" id="user_id" class="select2 form-select">
                @forelse($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}
                    || {{ $user->father_name }}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">হিসাব নং</label>
              <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $specialDps->account_no }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="special_dps_package_id" class="form-label">প্যাকেজ</label>
              <select name="special_dps_package_id" id="special_dps_package_id" class="select2 form-select">
                @forelse($specialDpsPackages as $package)
                  <option value="{{ $package->id }}" {{ $package->id === $specialDps->special_dps_package_id?"selected":"" }}>{{ $package->name }}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">প্যাকেজ পরিমাণ</label>
              <input type="number" class="form-control" id="package_amount" name="package_amount" value="{{ $specialDps->package_amount }}">
            </div>
            <div class="col-md-3 mb-2">
              <label for="initial_amount" class="form-label">জমার পরিমাণ</label>
              <input type="number" class="form-control" id="initial_amount" name="initial_amount" value="{{ $specialDps->initial_amount }}">
            </div>

            <div class="col-md-3 mb-2">
              <label for="account_no" class="form-label">মেয়াদ</label>
              <select class="form-select select2" id="duration" name="duration">
                <option value="1" {{ $specialDps->duration== 1 ?"selected":"" }}>1 বছর</option>
                <option value="2" {{ $specialDps->duration== 2 ?"selected":"" }}>2 বছর</option>
                <option value="3" {{ $specialDps->duration== 3 ?"selected":"" }}>3 বছর</option>
                <option value="4" {{ $specialDps->duration== 4 ?"selected":"" }}>4 বছর</option>
                <option value="5" {{ $specialDps->duration== 5 ?"selected":"" }}>5 বছর</option>
                <option value="6" {{ $specialDps->duration== 6 ?"selected":"" }}>6 বছর</option>
                <option value="7" {{ $specialDps->duration== 7 ?"selected":"" }}>7 বছর</option>
                <option value="8" {{ $specialDps->duration== 8 ?"selected":"" }}>8 বছর</option>
                <option value="9" {{ $specialDps->duration== 9 ?"selected":"" }}>9 বছর</option>
                <option value="10" {{ $specialDps->duration== 10 ?"selected":"" }}>10 বছর</option>
              </select>
            </div>
            <div class="col-md-3 mb-2">
              <label for="opening_date" class="form-label">তারিখ</label>
              <input type="date" class="form-control flatpickr-basic" id="opening_date"
                     name="opening_date" aria-label="MM/DD/YYYY" value="{{ $specialDps->opening_date }}">
            </div>

            <div class="col-md-3 mb-2">
              <label for="commencement" class="form-label">হিসাব শুরু</label>
              <input type="date" class="form-control flatpickr-basic" id="commencement"
                     name="commencement" aria-label="MM/DD/YYYY" value="{{ $specialDps->commencement }}">
            </div>

            <div class="col-md-9 mb-2">
              <label for="note" class="form-label">নোট</label>
              <input type="text" class="form-control" id="note"
                     name="note" value="{{ $specialDps->note??"" }}">
            </div>
          </div>
          <h4 class="bg-primary p-1 text-white">মনোনীত ব্যক্তিবর্গ</h4>
          @php
            $nomineeUsers = \App\Models\User::select('name','father_name','id')->get();
           $nominee = isset($specialDps->nominee);
          @endphp
          <div class="row g-1">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12 mb-1">
                  <select name="nominee_user_id" id="nominee_user_id" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                      <option value="{{ $item->id }}" {{ isset($specialDps->nominee->user_id)? $item->id == $specialDps->nominee->user_id?"selected":"":"" }}>{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="name">নাম</label>
                  <input type="text" id="name" class="form-control " name="name" placeholder="Name" value="{{ $nominee? $specialDps->nominee->name :"" }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="phone">মোবাইল নং</label>
                  <input type="text" id="phone" class="form-control  dt-salary" name="phone" placeholder="Phone" value="{{ $nominee? $specialDps->nominee->phone :"" }}">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="address">ঠিকানা</label>
                  <input type="text" class="form-control " id="address" name="address" placeholder="Address" value="{{ $nominee? $specialDps->nominee->address :"" }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="relation">সম্পর্ক</label>
                  <input type="text" id="relation" class="form-control " name="relation" placeholder="Relation" value="{{ $nominee? $specialDps->nominee->relation :"" }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="pecentage">অংশ</label>
                  <input type="number" id="percentage" class="form-control " name="percentage" placeholder="Percentage" value="{{ $nominee? $specialDps->nominee->percentage :"" }}">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="image">ছবি</label>
                  <input type="file" id="image" class="form-control" name="image">
                  @if(isset($specialDps->nominee->image))
                    <img src="{{ asset('storage'.'/'.$specialDps->nominee->image) }}" class="img-fluid mt-2" height="120" alt="">
                  @endif
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12 mb-1">
                  <select name="nominee_user_id1" id="nominee_user_id1" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                      <option value="{{ $item->id }}" {{ isset($specialDps->nominee->user_id1)? $item->id == $specialDps->nominee->user_id1?"selected":"":"" }}>{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="name1">নাম</label>
                  <input type="text" id="name1" class="form-control " name="name1" placeholder="Name" value="{{ $nominee?$specialDps->nominee->name1:'' }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="phone1">মোবাইল নং</label>
                  <input type="text" id="phone1" class="form-control  dt-salary" name="phone1" placeholder="Phone" value="{{ $nominee?$specialDps->nominee->phone1:'' }}">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="address1">ঠিকানা</label>
                  <input type="text" class="form-control " id="address1" name="address1" placeholder="Address" value="{{ $nominee?$specialDps->nominee->address1:'' }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="relation1">সম্পর্ক</label>
                  <input type="text" id="relation1" class="form-control " name="relation1" placeholder="Relation" value="{{ $nominee?$specialDps->nominee->relation1:'' }}">
                </div>
                <div class="col-md-6 mb-1">
                  <label class="form-label" for="pecentage1">অংশ</label>
                  <input type="number" id="percentage1" class="form-control " name="percentage1"placeholder="Percentage" value="{{ $nominee?$specialDps->nominee->percentage1:'' }}">
                </div>
                <div class="col-md-12 mb-1">
                  <label class="form-label" for="image1">ছবি</label>
                  <input type="file" id="image1" class="form-control" name="image1">
                  @if(isset($specialDps->nominee->image1))
                    <img src="{{ asset('storage'.'/'.$specialDps->nominee->image1) }}" class="img-fluid mt-2" height="120" alt="">
                  @endif
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="status" value="active">
          <input type="hidden" name="created_by" value="{{ auth()->id() }}">
          <div class="d-flex justify-content-center mt-2">
            <button type="submit" class="btn rounded-pill btn-google-plus waves-effect waves-light w-25">
              সাবমিট
            </button>
          </div>
        </form>
      </div>
      <div class="col-md-4">
        <div class="card">

          <div class="divider">
            <div class="divider-text">সদস্য তথ্য</div>
          </div>
          @php
            $user = $specialDps->user;
          @endphp
          <div class="card-body">
            <div class="user-data">
              <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                  <img class="img-fluid rounded mb-2" src="http://127.0.0.1:8000/images/user.png" height="110" width="110" alt="User avatar">
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
      </div>
    </div>
  </div>
@endsection


@section('page-script')

  <script>
    $(".select2").select2();
    $('#user_id').on('select2:select', function(e) {
      $(".user-data").empty();
      var data = e.params.data;
      $.ajax({
        url: "{{ url('userInfo') }}/"+data.id,
        dataType: "json",
        type: "get",
        success: function (data) {
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
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Father:</span>
                                        <span>${data.user.father_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Mother:</span>
                                        <span>${data.user.mother_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Spouse:</span>
                                        <span class="badge bg-light-success">${data.user.spouse_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Present Address:</span>
                                        <span>${data.user.present_address}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Join Date:</span>
                                        <span>${data.user.join_date}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Savings:</span>
                                        <span>${data.daily_savings}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total DPS:</span>
                                        <span>${data.dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Special DPS:</span>
                                        <span>${data.special_dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Daily Loans:</span>
                                        <span>${data.daily_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">DPS Loans:</span>
                                        <span>${data.dps_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Special DPS Loan:</span>
                                        <span>${data.special_dps_loans}</span>
                                    </li>
                                </ul>
                            </div>
                    `);
        }
      })
    });
  </script>
  <script>
    $(document).on("change","#nominee_user_id",function (){
      var id = $("#nominee_user_id option:selected").val();
      $("#name").val("");
      $("#address").val("");
      $("#phone").val("");
      $("#birthdate").empty();
      $.ajax({
        url: "{{ url('userProfile') }}/"+id,
        dataType: "JSON",
        success: function (data) {
          console.log(data)
          $("#name").val(data.name);
          $("#address").val(data.permanent_address);
          $("#phone").val(data.phone);
          $("#birthdate").val(data.birthdate);
        }
      })
    })
    $(document).on("change","#nominee_user_id1",function (){
      var id = $("#nominee_user_id1 option:selected").val();
      $("#name1").val("");
      $("#address1").val("");
      $("#phone1").val("");
      $("#birthdate1").empty();
      $.ajax({
        url: "{{ url('userProfile') }}/"+id,
        dataType: "JSON",
        success: function (data) {
          console.log(data)
          $("#name1").val(data.name);
          $("#address1").val(data.permanent_address);
          $("#phone1").val(data.phone1);
          $("#birthdate1").val(data.birthdate);
        }
      })
    })
  </script>
@endsection
