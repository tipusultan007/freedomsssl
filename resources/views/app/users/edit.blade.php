@extends('layouts/layoutMaster')

@section('title', $user->namr.' - সদস্য তথ্য আপডেট ফরম')
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
            <a href="{{ route('users.show',$user->id) }}"> {{$user->name}}</a>
          </li>
          <li class="breadcrumb-item active">সদস্য তথ্য আপডেট ফরম</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('users.show',$user->id) }}">প্রোফাইল</a>
    </div>
    <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data" class="form">
      @csrf
      @method('PATCH')
      <h4 class="bg-primary p-1 text-white text-center">আবেদনকারীর তথ্য আপডেট করুন</h4>
      <div class="card">
        <div class="card-body">
          <div class="row mt-2">
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="name">আবেদনকারীর নাম</label>
                <input type="text" name="name" id="name" class="form-control"
                       placeholder="Applicant's Name" value="{{ $user->name }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="father_name">পিতার নাম</label>
                <input type="text" name="father_name" id="father_name" class="form-control"
                       placeholder="Father's Name" value="{{ $user->father_name }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="mother_name">মাতার নাম</label>
                <input type="text" name="mother_name" id="mother_name" class="form-control"
                       placeholder="Father's Name" value="{{ $user->mother_name }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <label class="form-label">লিঙ্গ</label>
              <select name="gender" id="gender" class="form-select select2" data-allow-clear="on" data-placeholder="Gender">
                <option value=""></option>
                <option value="male" {{ $user->gender == 'male'?"selected":"" }}>পুরুষ</option>
                <option value="female" {{ $user->gender == 'female'?"selected":"" }}>মহিলা</option>
                <option value="Other">অন্যান্য</option>
              </select>
            </div>
            <div class="mb-2 col-md-6">
              <div class="form-group">
                <label class="form-label" for="present_address">বর্তমান ঠিকানা</label>
                <input type="text" name="present_address" id="present_address" class="form-control"
                       placeholder="Present Address" value="{{ $user->present_address??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-6">
              <div class="form-group">
                <label class="form-label" for="permanent_address">স্থায়ী ঠিকানা</label>
                <input type="text" name="permanent_address" id="permanent_address" class="form-control"
                       placeholder="Permanent Address" value="{{ $user->present_address??'' }}"/>

              </div>
            </div>
            <div class="col-md-3 mb-2">
              <div class="form-group">
                <label class="form-label">জন্ম তারিখ</label>
                <input type="text" id="birthdate" name="birthdate" class="form-control datepicker" placeholder="Date of Birth" value="{{ $user->birthdate??'' }}"/>
              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone1">মোবাইল - ০১</label>
                <input type="text" name="phone1" class="form-control phone-number-mask" placeholder="Mobile" id="phone1" value="{{ $user->phone1??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone2">মোবাইল - ০২</label>
                <input type="text" name="phone2" class="form-control phone-number-mask" placeholder="Mobile" id="phone2" value="{{ $user->phone2??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="phone3">মোবাইল - ০৩</label>
                <input type="text" name="phone3" class="form-control phone-number-mask" placeholder="Mobile" id="phone3" value="{{ $user->phone3??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="occupation">পেশা</label>
                <input type="text" name="occupation" id="occupation" class="form-control"
                       placeholder="Occupation" value="{{ $user->occupation??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label class="form-label" for="workplace">কর্মস্থল</label>
                <input type="text" name="workplace" id="workplace" class="form-control"
                       placeholder="Workplace" value="{{ $user->workplace??'' }}"/>

              </div>
            </div>
            <div class="mb-2 col-md-3">
              <div class="form-group">
                <label for="" class="form-label">বৈবাহিক অবস্থা</label>
                <select name="marital_status" id="marital_status" class="form-select select2" data-allow-clear="on" data-placeholder="Marital Status">
                  <option value=""></option>
                  <option value="married" {{ $user->marital_status == 'married'?"selected":"" }}>বিবাহিত</option>
                  <option value="unmarried" {{ $user->marital_status == 'unmarried'?"selected":"" }}>অবিবাহিত</option>
                </select>
              </div>
            </div>
            <div class="mb-2 col-md-3 spouse-name">
              <div class="form-group">
                <label class="form-label" for="spouse_name">স্বামী/স্ত্রীর নাম</label>
                <input type="text" name="spouse_name" id="spouse_name" class="form-control"
                       placeholder="Spouse Name" value="{{ $user->spouse_name??'' }}"/>

              </div>
            </div>
            <div class="col-md-4 mb-2">
              <label for="national_id" class="form-label">জাতীয় পরিচয়পত্র</label>
              <input class="form-control" name="national_id" type="file" id="national_id">
              @if($user->national_id)
                <img class="my-2" height="120" src="{{ asset('storage/images/nid/' . $user->national_id) }}" alt="{{ $user->name }}">
              @endif
            </div>
            <div class="col-md-4 mb-2">
              <label for="birth_id" class="form-label">জন্ম নিবন্ধন</label>
              <input class="form-control" name="birth_id" type="file" id="birth_id">
              @if($user->birth_id)
                <img class="my-2" height="120" src="{{ asset('storage/images/birth_id/' . $user->birth_id) }}" alt="{{ $user->name }}">
              @endif
            </div>
            <div class="col-md-4 mb-2">
              <label for="image" class="form-label">আবেদনকারীর ছবি</label>
              <input class="form-control" name="image" type="file" id="image">
              @if($user->image)
                <img class="my-2" height="120" src="{{ asset('storage/images/profile/' . $user->image) }}" alt="{{ $user->name }}">
              @endif
            </div>

            <div class="col-md-3 mb-2">
              <div class="form-group">
                <label for="" class="form-label">ভর্তির তারিখ</label>
                <input type="text" id="join_date" name="join_date" class="form-control datepicker" value="{{ $user->join_date }}" placeholder="Join Date" />
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-success w-25">আপডেট করুন</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('page-script')
  <!-- Page js files -->

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
