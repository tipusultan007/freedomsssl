@extends('layouts/layoutMaster')

@section('title', 'FDR জমা আপডেট ফরম')
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
  <section class="horizontal-wizard">
    <div class="row">
      <div class="col-md-8">
        <form action="{{ route('fdr-deposits.update',$fdr->id) }}" method="POST">
          @csrf
          @method('PATCH')
          <h4 class="bg-primary p-1 text-white">FDR সঞ্চয় হিসাবের তথ্য</h4>
          <div class="row mb-3">
            <div class="col-md-6 mb-2">
              <label for="user_id" class="form-label">সদস্য নাম</label>
              <select name="user_id" id="user_id" class="select2 form-select" data-placeholder="সদস্য সিলেক্ট করুন">
                <option value=""></option>
                @forelse($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}
                    || {{ $user->father_name }}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-6 mb-2">
              <label for="account_no" class="form-label">হিসাব নং</label>
              <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $new_account }}">
            </div>

          </div>

          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="name">প্যাকেজ</label>
              <select class="form-select select2" name="fdr_package_id" id="fdr_package_id">
                @forelse($fdrPackages as $package)
                  <option value="{{ $package->id }}"> {{ $package->name }} </option>
                @empty
                @endforelse
              </select>


            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="phone">মেয়াদ <small class="text-danger">(Years)</small></label>
              <input type="text" name="duration" id="duration" class="form-control"/>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="amount">FDR পরিমাণ </label>
              <input type="number" name="amount" id="amount" class="form-control"/>
            </div>

            <div class="col-md-6 mb-2">
              <label for="date" class="form-label">তারিখ</label>
              <input type="date" value="{{ date('Y-m-d') }}" placeholder="DD-MM-YYYY"
                     class="form-control flatpickr-basic" id="date"
                     name="date" aria-label="MM/DD/YYYY">
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="percentage">হিসাব শুরু </label>
              <input type="date" value="{{ date('Y-m-d') }}" placeholder="DD-MM-YYYY"
                     name="commencement" id="commencement"
                     class="form-control flatpickr-basic"/>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="note">নোট</label>
              <input type="text" name="note" id="note" class="form-control"/>
            </div>
          </div>
          <h4 class="bg-primary p-1 text-white mt-3">মনোনীত ব্যক্তিবর্গ</h4>
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
                <div class="col-md-11 mb-1">
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
                <div class="col-md-11 mb-1">
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
            <div class="divider-text">User Information</div>
          </div>

          <div class="card-body">
            <div class="user-data">

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

    $(".select2").select2();

    $('#user_id').on('select2:select', function (e) {
      $(".user-data").empty();
      var data = e.params.data;
      $.ajax({
        url: "{{ url('userInfo') }}/" + data.id,
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
                                    <img class="img-fluid rounded mb-2" src="{{ asset('images') }}/${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-container mt-2">
                                <ul class="list-unstyled">
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">পিতার নাম:</span>
                                        <span>${data.user.father_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">মাতার নাম:</span>
                                        <span>${data.user.mother_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">নিবন্ধন তারিখ:</span>
                                        <span>${data.user.join_date}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25"> দৈনিক সঞ্চয়:</span>
                                        <span>${data.daily_savings}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">মাসিক সঞ্চয়:</span>
                                        <span>${data.dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">বিশেষ সঞ্চয়:</span>
                                        <span>${data.special_dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">দৈনিক ঋণ:</span>
                                        <span>${data.daily_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">মাসিক ঋণ:</span>
                                        <span>${data.dps_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">বিশেষ ঋণ:</span>
                                        <span>${data.special_dps_loans}</span>
                                    </li>
                                </ul>
                            </div>
                    `);
        }
      })
    });
  </script>
@endsection
