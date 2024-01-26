@extends('layouts/layoutMaster')

@section('title', 'মাসিক সঞ্চয় আবেদন ফরম')

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
      <!-- Breadcrumb -->
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li><li class="breadcrumb-item">
              <a href="{{ url('dps') }}">মাসিক সঞ্চয় তালিকা</a>
            </li>
            <li class="breadcrumb-item active">মাসিক সঞ্চয় আবেদন ফরম</li>
          </ol>
        </nav>
      </div>
      @include('app.partials.alert_danger')
      @include('app.partials.alert_success')
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <form id="createForm" action="{{ route('dps.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="bg-primary p-1 text-white">সঞ্চয় হিসাবের তথ্য</h4>
                <div class="row mb-2">
                  <div class="col-md-6 mb-2">
                    <label for="user_id" class="form-label">সদস্য নাম</label>
                    <select name="user_id" id="user_id" class="select2 form-select" data-placeholder="সদস্য সিলেক্ট করুণ" data-allow-clear="on">
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
                    <label for="account_no" class="form-label">প্যাকেজ</label>
                    <select name="dps_package_id" id="dps_package_id" class="select2 form-select" data-placeholder="প্যাকেজ" >
                      <option value=""></option>
                      @forelse($dpsPackages as $package)
                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">DPS পরিমাণ</label>
                    <input type="number" class="form-control" id="package_amount" name="package_amount" required>
                  </div>

                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">মেয়াদ (বছর)</label>
                    <select class="form-select select2" id="duration" name="duration" data-placeholder="মেয়াদ" required>
                      <option value=""></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">তারিখ</label>
                    <input type="date" class="form-control" id="opening_date"
                           name="opening_date" aria-label="MM/DD/YYYY" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="account_no" class="form-label">হিসাব শুরু</label>
                    <input type="date" class="form-control" id="commencement"
                           name="commencement" aria-label="MM/DD/YYYY" value="{{ date('Y-m-d') }}" required>
                  </div>

                  <div class="col-md-12">
                    <label for="account_no" class="form-label">মন্তব্য</label>
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
                <div class="d-flex justify-content-end">
                  <button type="submit" id="submit" class="btn btn-danger">সাবমিট</button>
                </div>
              </form>
            </div>
          </div>
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

        $("select").select2();
        /*$('#submit').click(function() {
            var formData = new FormData($('#createForm')[0]);

            $.ajax({
                url: '{{ route('dps.store') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    toastr['success'](response.message, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    // Reset the form after successful submission
                    $('#createForm')[0].reset();
                    $("select").val("").trigger("change");

                    // Fill the account_no field with the generated account number
                    $('#account_no').val(response.accountNumber);

                    // You can optionally redirect or perform other actions here
                },
                error: function(xhr) {
                    toastr['error']('There is something wrong', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                }
            });
        });*/
        $('#user_id').on('select2:select', function (e) {
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
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-2" src="{{ asset('storage/images/profile') }}/${image}" height="110" width="110" alt="User avatar">
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
