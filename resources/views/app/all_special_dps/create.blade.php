@extends('layouts/layoutMaster')

@section('title', 'বিশেষ সঞ্চয় আবেদন ফরম')

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
          <a href="{{ url('special-dps') }}">বিশেষ সঞ্চয় তালিকা</a>
        </li>
        <li class="breadcrumb-item active">বিশেষ সঞ্চয় আবেদন ফরম</li>
      </ol>
    </nav>
  </div>
  @include('app.partials.alert_danger')
  @include('app.partials.alert_success')
  <div class="row">
    <div class="col-md-8">
      <form action="{{ route('special-dps.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h4 class="bg-primary p-1 text-white">সঞ্চয় হিসাবের তথ্য</h4>
        <div class="row mb-3">
          <div class="col-md-6 mb-2">
            <label for="user_id" class="form-label">সদস্য নাম</label>
            <select name="user_id" id="user_id" class="select2 form-select" data-placeholder="সিলেক্ট সদস্য" required>
              <option value=""></option>
              @forelse($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}
                  || {{ $user->father_name }}</option>
              @empty
              @endforelse
            </select>
          </div>
          <div class="col-md-3 mb-2">
            <label for="account_no" class="form-label">হিসাব নং</label>
            <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $new_account }}" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label for="special_dps_package_id" class="form-label">প্যাকেজ</label>
            <select name="special_dps_package_id" id="special_dps_package_id" class="select2 form-select" required>
              @forelse($dpsPackages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
              @empty
              @endforelse
            </select>
          </div>
          <div class="col-md-3 mb-2">
            <label for="account_no" class="form-label">প্যাকেজ পরিমাণ</label>
            <input type="number" class="form-control" id="package_amount" name="package_amount" required>
          </div>
          <div class="col-md-3 mb-2">
            <label for="initial_amount" class="form-label">জমার পরিমাণ</label>
            <input type="number" class="form-control" id="initial_amount" name="initial_amount" required>
          </div>

          <div class="col-md-3 mb-2">
            <label for="account_no" class="form-label">মেয়াদ</label>
            <select class="form-select select2" id="duration" name="duration" required>
              <option value="1">1 বছর</option>
              <option value="2">2 বছর</option>
              <option value="3">3 বছর</option>
              <option value="4">4 বছর</option>
              <option value="5">5 বছর</option>
              <option value="6">6 বছর</option>
              <option value="7">7 বছর</option>
              <option value="8">8 বছর</option>
              <option value="9">9 বছর</option>
              <option value="10">10 বছর</option>
            </select>
          </div>
          <div class="col-md-3 mb-2">
            <label for="account_no" class="form-label">তারিখ</label>
            <input type="text" class="form-control datepicker" id="opening_date"
                   name="opening_date" aria-label="MM/DD/YYYY" required>
          </div>
          <div class="col-md-3 mb-2">
            <label for="account_no" class="form-label">হিসাব শুরু</label>
            <input type="text" class="form-control datepicker" id="commencement"
                   name="commencement" aria-label="MM/DD/YYYY" required>
          </div>

          <div class="col-md-9 mb-2">
            <label for="account_no" class="form-label">নোট</label>
            <input type="text" class="form-control" id="note"
                   name="note">
          </div>
        </div>
        <h4 class="bg-primary p-1 text-white">মনোনীত ব্যক্তিবর্গ</h4>
        @php
          $nomineeUsers = \App\Models\User::select('name','father_name','id')->get();
        @endphp
        <div class="row g-1">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 mb-1">
                <select name="nominee_user_id" id="nominee_user_id" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                  <option value=""></option>
                  @foreach($nomineeUsers as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="name">নাম</label>
                <input type="text" id="name" class="form-control " name="name" placeholder="Name">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="phone">মোবাইল নং</label>
                <input type="text" id="phone" class="form-control  dt-salary" name="phone" placeholder="Phone">
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="address">ঠিকানা</label>
                <input type="text" class="form-control " id="address" name="address" placeholder="Address">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="relation">সম্পর্ক</label>
                <input type="text" id="relation" class="form-control " name="relation" placeholder="Relation">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="pecentage">অংশ</label>
                <input type="number" id="percentage" class="form-control " name="percentage" value="100" placeholder="Percentage">
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="image">ছবি</label>
                <input type="file" id="image" class="form-control" name="image">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 mb-1">
                <select name="nominee_user_id1" id="nominee_user_id1" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                  <option value=""></option>
                  @foreach($nomineeUsers as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="name1">নাম</label>
                <input type="text" id="name1" class="form-control " name="name1" placeholder="Name">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="phone1">মোবাইল নং</label>
                <input type="text" id="phone1" class="form-control  dt-salary" name="phone1" placeholder="Phone">
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="address1">ঠিকানা</label>
                <input type="text" class="form-control " id="address1" name="address1" placeholder="Address">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="relation1">সম্পর্ক</label>
                <input type="text" id="relation1" class="form-control " name="relation1" placeholder="Relation">
              </div>
              <div class="col-md-6 mb-1">
                <label class="form-label" for="pecentage1">অংশ</label>
                <input type="number" id="percentage1" class="form-control " name="percentage1" value="100" placeholder="Percentage">
              </div>
              <div class="col-md-12 mb-1">
                <label class="form-label" for="image1">ছবি</label>
                <input type="file" id="image1" class="form-control" name="image1">
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

        <div class="card-body">
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
                        image = "{{ asset('storage/images/profile') }}/"+data.user.image;
                    }
                    $(".user-data").append(`

                           <div class="info-container mt-0">
                                <table class="table table-bordered">
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
                                </table>
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
