
@extends('layouts/layoutMaster')

@section('title', $dailySavings->account_no.' - দৈনিক সঞ্চয় এডিট ফরম')
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
      <!-- Breadcrumb -->
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('daily-savings.show', $dailySavings->id) }}">দৈনিক সঞ্চয় - {{ $dailySavings->account_no }}</a>
            </li>
            <li class="breadcrumb-item active">দৈনিক সঞ্চয় এডিট ফরম</li>
          </ol>
        </nav>
      </div>
        <div class="row">
            <div class="col-md-8">
                @include('app.partials.alert_danger')
                @include('app.partials.alert_success')
                <div class="card">
                    <div class="card-body">
                        <h4> সঞ্চয় হিসাব </h4>
                        <form id="editForm" action="{{ route('daily-savings.update',$dailySavings->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label for="user_id" class="form-label">সদস্য নাম</label>
                                    <select data-allow-clear="true" data-placeholder="Select User" name="user_id" id="user_id" class="select2 form-select">
                                        <option value="">Select User</option>
                                        @forelse($users as $user)
                                            <option value="{{ $user->id }}" {{ $dailySavings->user_id==$user->id?"selected":"" }}>{{ $user->name }} || {{ $user->father_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="account_no" class="form-label">হিসাব নং</label>
                                    <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $dailySavings->account_no }}" readonly>
                                </div>
                              <div class="col-md-3 mb-2">
                                <label for="deposit" class="form-label">জমা</label>
                                <input type="number" class="form-control" id="deposit" name="deposit" value="{{ $dailySavings->deposit }}">
                              </div>
                              <div class="col-md-3 mb-2">
                                <label for="withdraw" class="form-label">উত্তোলন</label>
                                <input type="number" class="form-control" id="withdraw" name="withdraw" value="{{ $dailySavings->withdraw }}">
                              </div>
                              <div class="col-md-3 mb-2">
                                <label for="profit" class="form-label">লভ্যাংশ</label>
                                <input type="number" class="form-control" id="profit" name="profit" value="{{ $dailySavings->withdraw }}">
                              </div>
                              <div class="col-md-3 mb-2">
                                <label for="total" class="form-label">অবশিষ্ট জমা</label>
                                <input type="number" class="form-control" id="total" name="total" value="{{ $dailySavings->total }}">
                              </div>
                                <div class="col-md-3 mb-2">
                                    <label for="opening_date" class="form-label">তারিখ</label>
                                    <input type="date" class="form-control" id="opening_date" name="opening_date" value="{{ $dailySavings->opening_date }}">
                                </div>

                            </div>

                          <div class="row">
                            <div class="col-md-6">
                              <h4 class="border-bottom">নমিনী - ০১</h4>
                              <div class="form-group mb-1">
                                <select name="nominee_user_id" data-allow-clear="on" id="nominee_user_id" class="form-select" data-placeholder="সিলেক্ট করুণ">
                                  <option value=""></option>
                                  @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ isset($dailySavings->nominee->user_id)? $member->id == $dailySavings->nominee->user_id?"selected":"":"" }}>{{ $member->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="mb-1 form-group">
                                <label class="form-label" for="name">নাম</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="John" value="{{ $dailySavings->nominee->name??"" }}"/>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="phone">মোবাইল নং</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ $dailySavings->nominee->phone??"" }}"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="birthdate">জন্মতারিখ</label>
                                    <input type="date" name="birthdate" id="birthdate" class="form-control flatpickr-basic" value="{{ $dailySavings->nominee->birthdate??"" }}"/>
                                  </div>
                                </div>
                              </div>
                              <div class="mb-1 form-group">
                                <label class="form-label" for="address">ঠিকানা</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ $dailySavings->nominee->address??"" }}"/>
                              </div>
                              <div class="row gx-1">
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="relation">সম্পর্ক</label>
                                    <input type="text" name="relation" id="relation" class="form-control" value="{{ $dailySavings->nominee->relation??"" }}"/>
                                  </div>
                                </div>
                                <div class="mb-1 col-md-6">
                                  <label class="form-label" for="percentage">অংশ</label>
                                  <input type="number" name="percentage" id="percentage" class="form-control" value="{{ $dailySavings->nominee->percentage??"" }}"/>
                                </div>
                              </div>

                              <div class="mb-1 form-group">
                                <label class="form-label" for="image">নমিনীর ছবি</label>
                                <input type="file" name="image" id="image" class="form-control"/>
                                @if($dailySavings->nominee && $dailySavings->nominee->image)
                                  <img class="my-2" height="120" src="{{ asset('storage/nominee_images/' . $dailySavings->nominee->image) }}" alt="Nominee Image">
                                @endif

                              </div>
                            </div>
                            <div class="col-md-6">
                              <h4 class="border-bottom">নমিনী - ০২</h4>
                              <div class="form-group mb-1">
                                <select name="nominee_user_id1" data-allow-clear="on" id="nominee_user_id1" class="form-select" data-placeholder="সিলেক্ট করুণ">
                                  <option value=""></option>
                                  @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ isset($dailySavings->nominee->user_id1)?$member->id == $dailySavings->nominee->user_id1?"selected":"":"" }}>{{ $member->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="mb-1 form-group">
                                <label class="form-label" for="name2">নাম</label>
                                <input type="text" name="name1" id="name1" class="form-control"
                                       placeholder="John" value="{{ $dailySavings->nominee->name1??"" }}"/>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="phone1">মোবাইল নং</label>
                                    <input type="tel" name="phone1" id="phone1" class="form-control" value="{{ $dailySavings->nominee->phone1??"" }}"/>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="birthdate1">জন্মতারিখ</label>
                                    <input type="date" name="birthdate1" id="birthdate1" class="form-control flatpickr-basic" value="{{ $dailySavings->nominee->birthdate1??"" }}"/>
                                  </div>
                                </div>
                              </div>
                              <div class="mb-1 form-group">
                                <label class="form-label" for="address1">ঠিকানা</label>
                                <input type="text" name="address1" id="address1" class="form-control"  value="{{ $dailySavings->nominee->address1??"" }}"/>
                              </div>
                              <div class="row gx-1">
                                <div class="col-md-6">
                                  <div class="mb-1 form-group">
                                    <label class="form-label" for="relation1">সম্পর্ক</label>
                                    <input type="text" name="relation1" id="relation1" class="form-control"  value="{{ $dailySavings->nominee->relation1??"" }}"/>
                                  </div>
                                </div>
                                <div class="mb-1 col-md-6">
                                  <label class="form-label" for="percentage1">অংশ</label>
                                  <input type="number" name="percentage1" id="percentage1" class="form-control"  value="{{ $dailySavings->nominee->percentage1??"" }}"/>
                                </div>
                              </div>

                              <div class="mb-1 form-group">
                                <label class="form-label" for="image1">নমিনীর ছবি</label>
                                <input type="file" name="image1" id="image1" class="form-control"/>
                                @if($dailySavings->nominee && $dailySavings->nominee->image1)
                                  <img  class="my-2" height="120" src="{{ asset('storage/nominee_images/' . $dailySavings->nominee->image1) }}" alt="Nominee Image">
                                @endif

                              </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                              <button class="btn btn-primary " type="submit" id="submit">সাবমিট</button>
                            </div>
                          </div>
                        </form>


                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- /Horizontal Wizard -->

@endsection

@section('page-script')
    <script>

        $("select").select2();
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
              $("#phone").val(data.phone1);
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
