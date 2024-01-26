@extends('layouts/layoutMaster')

@section('title', $dps->account_no.' - মাসিক সঞ্চয়')

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
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('dps.show',$dps->id) }}">মাসিক সঞ্চয় - {{ $dps->account_no }}</a>
          </li>
          <li class="breadcrumb-item active">মাসিক সঞ্চয় এডিট ফরম</li>
        </ol>
      </nav>
    </div>
    @include('app.partials.alert_danger')
    @include('app.partials.alert_success')
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="createForm" action="{{ route('dps.update',$dps->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <h4 class="bg-primary p-1 text-white">সঞ্চয় হিসাবের তথ্য</h4>
              <div class="row mb-2">
                <div class="col-md-6 mb-2">
                  <label for="user_id" class="form-label">সদস্য নাম</label>
                  <select name="user_id" id="user_id" class="select2 form-select" data-placeholder="সদস্য সিলেক্ট করুণ" data-allow-clear="on">
                    <option value=""></option>
                    @forelse($users as $user)
                      <option value="{{ $user->id}}" {{ $user->id==$dps->user_id?"selected": "" }}>{{ $user->name }}
                        || {{ $user->father_name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="account_no" class="form-label">হিসাব নং</label>
                  <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $dps->account_no }}" readonly>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="account_no" class="form-label">প্যাকেজ</label>
                  <select name="dps_package_id" id="dps_package_id" class="select2 form-select">
                    @forelse($dpsPackages as $package)
                      <option value="{{ $package->id }}" {{ $dps->dps_package_id==$package->id?"select":"" }}>{{ $package->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="account_no" class="form-label">DPS পরিমাণ</label>
                  <input type="number" class="form-control" id="package_amount" name="package_amount" value="{{ $dps->package_amount }}">
                </div>

                <div class="col-md-4 mb-2">
                  <label for="account_no" class="form-label">মেয়াদ (বছর)</label>
                  <select class="form-select select2" id="duration" name="duration">
                    <option value="1" {{ $dps->duration== 1?"selected": "" }}>1</option>
                    <option value="2" {{ $dps->duration==2 ?"selected": "" }}>2</option>
                    <option value="3" {{ $dps->duration== 3?"selected": "" }}>3</option>
                    <option value="4" {{ $dps->duration== 4?"selected": "" }}>4</option>
                    <option value="5" {{ $dps->duration== 5?"selected": "" }}>5</option>
                    <option value="6" {{ $dps->duration== 6?"selected": "" }}>6</option>
                    <option value="7" {{ $dps->duration== 7?"selected": "" }}>7</option>
                    <option value="8" {{ $dps->duration== 8?"selected": "" }}>8</option>
                    <option value="9" {{ $dps->duration== 9?"selected": "" }}>9</option>
                    <option value="10" {{ $dps->duration== 10?"selected": "" }}>10</option>
                  </select>
                </div>
                <div class="col-md-4 mb-2">
                  <label for="account_no" class="form-label">তারিখ</label>
                  <input type="date" class="form-control" id="opening_date"
                         name="opening_date" aria-label="MM/DD/YYYY" value="{{ $dps->opening_date }}">
                </div>
                <div class="col-md-4 mb-2">
                  <label for="account_no" class="form-label">হিসাব শুরু</label>
                  <input type="date" class="form-control" id="commencement"
                         name="commencement" aria-label="MM/DD/YYYY" value="{{ $dps->commencement }}">
                </div>

                <div class="col-md-4">
                  <label for="account_no" class="form-label">মন্তব্য</label>
                  <input type="text" class="form-control" id="note"
                         name="note" value="{{ $dps->note }}">
                </div>
              </div>

              @php
                $nomineeUsers = \App\Models\User::select('name','father_name','id')->get();
               $nominee = isset($dps->nominee);
              @endphp
              <h4 class="bg-primary p-1 text-white">মনোনীত ব্যক্তিবর্গ</h4>
              <div class="row g-1">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12 mb-1">
                      <select name="nominee_user_id" id="nominee_user_id" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                        <option value=""></option>
                        @foreach($nomineeUsers as $item)
                          <option value="{{ $item->id }}" {{ isset($dps->nominee->user_id)? $item->id == $dps->nominee->user_id?"selected":"":"" }}>{{ $item->name }} || {{ $item->father_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="name">নাম</label>
                      <input type="text" id="name" class="form-control " name="name" placeholder="Name" value="{{ $nominee? $dps->nominee->name :"" }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="phone">মোবাইল নং</label>
                      <input type="text" id="phone" class="form-control  dt-salary" name="phone" placeholder="Phone" value="{{ $nominee? $dps->nominee->phone :"" }}">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label class="form-label" for="address">ঠিকানা</label>
                      <input type="text" class="form-control " id="address" name="address" placeholder="Address" value="{{ $nominee? $dps->nominee->address :"" }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="relation">সম্পর্ক</label>
                      <input type="text" id="relation" class="form-control " name="relation" placeholder="Relation" value="{{ $nominee? $dps->nominee->relation :"" }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="pecentage">অংশ</label>
                      <input type="number" id="percentage" class="form-control " name="percentage" placeholder="Percentage" value="{{ $nominee? $dps->nominee->percentage :"" }}">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label class="form-label" for="image">ছবি</label>
                      <input type="file" id="image" class="form-control" name="image">
                      @if(isset($dps->nominee->image))
                        <img src="{{ asset('storage/nominee_images'.'/'.$dps->nominee->image) }}" class="img-fluid mt-2" height="120" alt="">
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
                          <option value="{{ $item->id }}" {{ isset($dps->nominee->user_id1)? $item->id == $dps->nominee->user_id1?"selected":"":"" }}>{{ $item->name }} || {{ $item->father_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="name1">নাম</label>
                      <input type="text" id="name1" class="form-control " name="name1" placeholder="Name" value="{{ $nominee?$dps->nominee->name1:'' }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="phone1">মোবাইল নং</label>
                      <input type="text" id="phone1" class="form-control  dt-salary" name="phone1" placeholder="Phone" value="{{ $nominee?$dps->nominee->phone1:'' }}">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label class="form-label" for="address1">ঠিকানা</label>
                      <input type="text" class="form-control " id="address1" name="address1" placeholder="Address" value="{{ $nominee?$dps->nominee->address1:'' }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="relation1">সম্পর্ক</label>
                      <input type="text" id="relation1" class="form-control " name="relation1" placeholder="Relation" value="{{ $nominee?$dps->nominee->relation1:'' }}">
                    </div>
                    <div class="col-md-6 mb-1">
                      <label class="form-label" for="pecentage1">অংশ</label>
                      <input type="number" id="percentage1" class="form-control " name="percentage1"placeholder="Percentage" value="{{ $nominee?$dps->nominee->percentage1:'' }}">
                    </div>
                    <div class="col-md-12 mb-1">
                      <label class="form-label" for="image1">ছবি</label>
                      <input type="file" id="image1" class="form-control" name="image1">
                      @if(isset($dps->nominee->image1))
                        <img src="{{ asset('storage/nominee_images/'.'/'.$dps->nominee->image1) }}" class="img-fluid mt-2" height="120" alt="">
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" id="submit" class="btn btn-primary">সাবমিট</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    $(document).ready(function() {
      $("select").select2();
    })
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
