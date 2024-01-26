@extends('layouts/layoutMaster')

@section('title', $user->name.' - সদস্য তথ্য')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
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
  <section class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}"> সদস্য তালিকা</a>
          </li>
          <li class="breadcrumb-item active">{{$user->name}} - নিবন্ধন তথ্য</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('users.edit',$user->id) }}">এডিট
        করুণ</a>
    </div>
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
        <!-- User Card -->
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="user-avatar-section">
                  <div class="d-flex align-items-center flex-column">
                    <img
                      class="img-fluid rounded mt-3 mb-2"
                      src="{{ asset('storage/images/profile') }}/{{ $user->image??'' }}"
                      height="110"
                      width="110"
                      alt="User avatar"
                    />
                    <div class="user-info text-center">
                      <h6><strong>{{ $user->name }}</strong></h6>
                      <span>{{ $user->phone1 }}</span>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered text-center table-sm mt-2">
                  <tr>
                    <th class="py-1 fw-bolder">জমা</th>
                    <th class="py-1 fw-bolder">অবশিষ্ট ঋণ</th>
                  </tr>
                  <tr>
                    <td class="py-1">{{ $totalSavings }}</td>
                    <td class="py-1">{{ $totalLoans }}</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-9">
                <table class="table table table-bordered">
                  <tr>
                    <th class="py-1 fw-bolder">নাম</th>
                    <td class="py-1">{{ $user->name }}</td>
                    <th class="py-1 fw-bolder">পিতার নাম</th>
                    <td class="py-1">{{ $user->father_name }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">মাতার নাম</th>
                    <td class="py-1">{{ $user->mother_name }}</td>
                    <th class="py-1 fw-bolder">স্বামীর নাম</th>
                    <td class="py-1">{{ $user->spouse_name }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">জন্ম তারিখ</th>
                    <td class="py-1">{{ date('d/m/Y',strtotime($user->birthdate)) }}</td>
                    <th class="py-1 fw-bolder">লিঙ্গ</th>
                    <td class="py-1">{{ $user->gender=='male'?"পুরুষ": "মহিলা" }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">স্থায়ী ঠিকানা</th>
                    <td class="py-1" colspan="3">{{ $user->permanent_address }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">বর্তমান ঠিকানা</th>
                    <td class="py-1" colspan="3">{{ $user->present_address }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">পেশা</th>
                    <td class="py-1">{{ $user->occupation }}</td>
                    <th class="py-1 fw-bolder">কর্মস্থল</th>
                    <td class="py-1">{{ $user->workplace }}</td>
                  </tr>
                </table>
              </div>
              {{--<div class="col-md-4">
                  <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                  <div class="info-container">
                      <ul class="list-unstyled">
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Name:</span>
                              <span>{{ $user->name }}</span>
                          </li>
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Gender:</span>
                              <span>{{ ucfirst($user->gender) }}</span>
                          </li>
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Father:</span>
                              <span>{{ $user->father_name??'' }}</span>
                          </li>
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Mother:</span>
                              <span>{{ $user->mother_name??'' }}</span>
                          </li>
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Marital Status:</span>
                              <span>{{ ucfirst($user->marital_status) }}</span>
                          </li>
                          @if($user->marital_status=="married")
                              <li class="mb-75">
                                  <span class="fw-bolder me-25">Spouse Name:</span>
                                  <span>{{ ucfirst($user->spouse_name) }}</span>
                              </li>
                          @endif
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Email:</span>
                              <span>{{ $user->email??'' }}</span>
                          </li>
                          <li class="mb-75">
                              <span class="fw-bolder me-25">Status:</span>
                              <span class="badge bg-light-success">{{ ucfirst($user->status) }}</span>
                          </li>
                      </ul>
                  </div>
              </div>
              <div class="col-md-4">
                  <ul class="list-unstyled">

                      <li class="mb-75">
                          <span class="fw-bolder me-25">Present Address:</span>
                          <span>{{ $user->present_address??'' }}</span>
                      </li>
                      <li class="mb-75">
                          <span class="fw-bolder me-25">Permanent Address:</span>
                          <span>{{ $user->permanent_address??'' }}</span>
                      </li>
                      <li class="mb-75">
                          <span class="fw-bolder me-25">Contact:</span>
                          @if($user->phone1 !='NULL')
                              <span>{{ $user->phone1 }}</span>
                          @endif
                          @if($user->phone2 !='NULL')
                              <span>, {{ $user->phone2 }}</span>
                          @endif
                          @if($user->phone3 !='NULL')
                              <span>, {{ $user->phone3 }}</span>
                          @endif
                      </li>
                      <li class="mb-75">
                          <span class="fw-bolder me-25">Occupation:</span>
                          <span>{{ $user->occupation??'' }}</span>
                      </li>
                      <li class="mb-75">
                          <span class="fw-bolder me-25">Workplace:</span>
                          <span>{{ $user->workplace??'' }}</span>
                      </li>
                      <li class="mb-75">
                          <span class="fw-bolder me-25">Join Date:</span>
                          <span>{{ $user->join_date??'' }}</span>
                      </li>
                  </ul>
              </div>--}}
            </div>


          </div>
        </div>
        <!-- /User Card -->
      </div>
      <!--/ User Sidebar -->
    </div>
    <div class="row gx-1 my-4">
      <div class="col-lg-3">
        <div class="nav-align-left bg-white">
          <ul class="nav nav-pills w-100 nav-fill" role="tablist">
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom active" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-daily-savings" aria-controls="navs-left-daily-savings"
                 aria-selected="true">দৈনিক
                সঞ্চয় <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->dailySavings->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-dps"
                 aria-controls="navs-left-dps" aria-selected="false">মাসিক সঞ্চয় (DPS) <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->dpsSavings->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-special-dps" aria-controls="navs-left-special-dps" aria-selected="false">
                বিশেষ সঞ্চয় (Special DPS) <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->specialDpsSavings->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-fdr"
                 aria-controls="navs-left-fdr" aria-selected="false">স্থায়ী সঞ্চয় (FDR) <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->fdrs->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-daily-loans" aria-controls="navs-left-daily-loans" aria-selected="false">
                দৈনিক ঋণ <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->dailyLoans->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-dps-loans"
                 aria-controls="navs-left-dps-loans" aria-selected="false">মাসিক সঞ্চয় ঋণ <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->dpsLoans->count() }}</span>
              </a>
            </li>
            <li class="nav-item w-100">
              <a href="javascript:;" class="nav-link rounded-0 border-bottom" role="tab" data-bs-toggle="tab"
                 data-bs-target="#navs-left-special-loans" aria-controls="navs-left-special-loans"
                 aria-selected="false">বিশেষ সঞ্চয় ঋণ <span
                  class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $user->specialLoans->count() }}</span>
              </a>
            </li>

          </ul>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-left-daily-savings">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">দৈনিক সঞ্চয় তালিকা</h5>
                <hr>
              </div>
              <div class="card-body pt-2">
                <table class="table datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">জমা</th>
                    <th class="py-2 fw-bolder">উত্তোলন</th>
                    <th class="py-2 fw-bolder">লভ্যাংশ</th>
                    <th class="py-2 fw-bolder">অবশিষ্ট জমা</th>
                    <th class="py-2 fw-bolder">স্ট্যাটাস</th>
                    <th class="py-2 fw-bolder">#</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->dailySavings as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ $item->opening_date }}</td>
                      <td>{{ $item->deposit }}</td>
                      <td>{{ $item->withdraw }}</td>
                      <td>{{ $item->profit }}</td>
                      <td>{{ $item->total }}</td>
                      <td>
                        @if($item->status=='active')
                          <span class="badge rounded-pill bg-success ms-1">সক্রিয়</span>
                        @else
                          <span class="badge rounded-pill  bg-danger ms-1">বন্ধ</span>
                        @endif
                      </td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('daily-savings.show',$item->id) }}">বিস্তারিত
                              দেখুন</a>
                            <a class="dropdown-item" href="{{ route('daily-savings.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-daily" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-daily" data-id="{{ $item->id }}"
                               href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-dps">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">মাসিক সঞ্চয় তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">হিসাব শুরুর তারিখ</th>
                    <th class="py-2 fw-bolder">প্যাকেজ</th>
                    <th class="py-2 fw-bolder">মোট জমা</th>
                    <th class="py-2 fw-bolder">লভ্যাংশ</th>
                    <th class="py-2 fw-bolder">স্ট্যাটাস</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->dpsSavings as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->commencement)) }}</td>
                      <td>{{ $item->package_amount }}</td>
                      <td>{{ $item->total }}</td>
                      <td>{{ $item->profit }}</td>
                      <td>
                        @if($item->status=='active')
                          <span class="badge rounded-pill bg-label-success ms-1">Active</span>
                        @else
                          <span class="badge rounded-pill  bg-label-success ms-1">Active</span>
                        @endif
                      </td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('dps.show',$item->id) }}">বিস্তারিত দেখুন</a>
                            <a class="dropdown-item" href="{{ route('dps.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-dps" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-dps" data-id="{{ $item->id }}" href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-special-dps">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">বিশেষ সঞ্চয় তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">হিসাব শুরুর তারিখ</th>
                    <th class="py-2 fw-bolder">প্যাকেজ</th>
                    <th class="py-2 fw-bolder">অগ্রিম জমা</th>
                    <th class="py-2 fw-bolder">মোট জমা</th>
                    <th class="py-2 fw-bolder">স্ট্যাটাস</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->specialDpsSavings as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->commencement)) }}</td>
                      <td>{{ $item->package_amount }}</td>
                      <td>{{ $item->initial_amount }}</td>
                      <td>{{ $item->balance }}</td>
                      <td>
                        @if($item->status=='active')
                          <span class="badge rounded-pill bg-label-success ms-1">Active</span>
                        @else
                          <span class="badge rounded-pill  bg-label-success ms-1">Active</span>
                        @endif
                      </td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('special-dps.show',$item->id) }}">বিস্তারিত
                              দেখুন</a>
                            <a class="dropdown-item" href="{{ route('special-dps.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-special" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-special" data-id="{{ $item->id }}"
                               href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-fdr">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">স্থায়ী সঞ্চয় তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">মোট জমা</th>
                    <th class="py-2 fw-bolder">মুনাফা উত্তোলন</th>
                    <th class="py-2 fw-bolder">স্ট্যাটাস</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->fdrs as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ $item->balance }}</td>
                      <td>{{ $item->profit }}</td>
                      <td>
                        @if($item->status=='active')
                          <span class="badge rounded-pill bg-label-success ms-1">Active</span>
                        @else
                          <span class="badge rounded-pill  bg-label-success ms-1">Active</span>
                        @endif
                      </td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('fdrs.show',$item->id) }}">বিস্তারিত দেখুন</a>
                            <a class="dropdown-item" href="{{ route('fdrs.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-fdr" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-fdr" data-id="{{ $item->id }}" href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-daily-loans">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">দৈনিক ঋণ তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">ঋণের পরিমাণ</th>
                    <th class="py-2 fw-bolder">সুদ</th>
                    <th class="py-2 fw-bolder">মোট ঋণ</th>
                    <th class="py-2 fw-bolder">অবশিষ্ট ঋণ</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->dailyLoans as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ $item->loan_amount }}</td>
                      <td>{{ $item->interest }}</td>
                      <td>{{ $item->total }}</td>
                      <td>{{ $item->balance }}</td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('daily-loans.show',$item->id) }}">বিস্তারিত
                              দেখুন</a>
                            <a class="dropdown-item" href="{{ route('daily-loans.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-daily-loan" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-daily-loan" data-id="{{ $item->id }}" href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-dps-loans">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">মাসিক ঋণ তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">মোট ঋণ</th>
                    <th class="py-2 fw-bolder">সুদের হার(%)</th>
                    <th class="py-2 fw-bolder">Upto Amount</th>
                    <th class="py-2 fw-bolder">অবশিষ্ট ঋণ</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->dpsLoans as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ $item->loan_amount }}</td>
                      <td>{{ $item->interest1 }}{{ $item->interest2>0?'/'.$item->interest2:"" }}</td>
                      <td>{{ $item->upto_amount }}</td>
                      <td>{{ $item->remain_loan }}</td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('dps-loans.show',$item->id) }}">বিস্তারিত দেখুন</a>
                            <a class="dropdown-item" href="{{ route('dps-loans.edit',$item->id) }}">এডিট করুন </a>
                            <a class="dropdown-item reset-dps-loan" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-dps-loan" data-id="{{ $item->id }}"
                               href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-left-special-loans">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="card-title">বিশেষ ঋণ তালিকা</h5>
                <hr>
              </div>
              <div class="card-body">
                <table class="table table-sm datatables">
                  <thead class="table-light py-0">
                  <tr>
                    <th class="py-2 fw-bolder">হিসাব নং</th>
                    <th class="py-2 fw-bolder">তারিখ</th>
                    <th class="py-2 fw-bolder">মোট ঋণ</th>
                    <th class="py-2 fw-bolder">সুদের হার(%)</th>
                    <th class="py-2 fw-bolder">Upto Amount</th>
                    <th class="py-2 fw-bolder">অবশিষ্ট ঋণ</th>
                    <th class="py-2 fw-bolder">একশন</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($user->specialLoans as $item)
                    <tr>
                      <td>{{ $item->account_no }}</td>
                      <td>{{ date('d/m/Y',strtotime($item->opening_date)) }}</td>
                      <td>{{ $item->loan_amount }}</td>
                      <td>{{ $item->interest1 }}{{ $item->interest2>0?'/'.$item->interest2:"" }}</td>
                      <td>{{ $item->upto_amount }}</td>
                      <td>{{ $item->remain_loan }}</td>
                      <td>
                        <div class="dropdown chart-dropdown">
                          <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer"
                             data-bs-toggle="dropdown"></i>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('special-dps-loans.show',$item->id) }}">বিস্তারিত
                              দেখুন</a>
                            <a class="dropdown-item" href="{{ route('special-dps-loans.edit',$item->id) }}">এডিট
                              করুন </a>
                            <a class="dropdown-item reset-special-loan" data-id="{{ $item->id }}" href="javascript:;">রিসেট
                              করুণ</a>
                            <a class="dropdown-item delete-special-loan" data-id="{{ $item->id }}" href="javascript:;">ডিলেট</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-edit-user">
      <div class="modal-content">
        <div class="modal-header bg-transparent">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pb-5 px-sm-5 pt-50">
          <div class="text-center mb-2">
            <h1 class="mb-1">Edit User Information</h1>
            <p>Updating user details will receive a privacy audit.</p>
          </div>
          <form id="editUserForm" action="{{ route("users.update",$user->id) }}" method="POST"
                class="row gy-1 pt-75">
            @csrf
            @method("PATCH")
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditName">Name</label>
              <input
                type="text"
                id="modalEditName"
                name="name"
                class="form-control"
                value="{{ $user->name??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditEmail">Email</label>
              <input
                type="email"
                id="modalEditEmail"
                name="email"
                class="form-control"
                value="{{ $user->email??'' }}"
              />
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label" for="modalEditPhone1">Phone 1</label>
              <input
                type="text"
                id="modalEditPhone1"
                name="phone1"
                class="form-control phone-number-mask"
                value="{{ $user->phone1??'' }}"
              />
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label" for="modalEditPhone2">Phone 2</label>
              <input
                type="text"
                id="modalEditPhone2"
                name="phone2"
                class="form-control phone-number-mask"
                value="{{ $user->phone2??'' }}"
              />
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label" for="modalEditPhone3">Phone 3</label>
              <input
                type="text"
                id="modalEditPhone3"
                name="phone3"
                class="form-control phone-number-mask"
                value="{{ $user->phone3??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditFatherName">Father Name</label>
              <input
                type="text"
                id="modalEditFatherName"
                name="father_name"
                class="form-control"
                value="{{ $user->father_name??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditMotherName">Mother Name</label>
              <input
                type="text"
                id="modalEditMotherName"
                name="mother_name"
                class="form-control"
                value="{{ $user->mother_name??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <div class="demo-inline-spacing">
                <label class="form-label">Gender:</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="modalEditGenderMale"
                         value="male" @if($user->gender=='male') checked @endif>
                  <label class="form-check-label" for="modalEditGenderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender"
                         id="modalEditGenderFemale"
                         value="female" @if($user->gender=='female') checked @endif>
                  <label class="form-check-label" for="modalEditGenderFemale">Female</label>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="demo-inline-spacing">
                <label class="form-label" for="modalEditMarital">Marital Status:</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="marital_status"
                         id="modalEditMaritalMarried"
                         value="married" @if($user->marital_status=='married') checked @endif>
                  <label class="form-check-label" for="modalEditMaritalMarried">Married</label>
                </div>
                <div class="form-check form-check-inline me-0">
                  <input class="form-check-input" type="radio" name="marital_status"
                         id="modalEditMaritalUnmarried" value="unmarried"
                         @if($user->marital_status=='unmarried') checked @endif>
                  <label class="form-check-label" for="modalEditMaritalUnmarried">Unmarried</label>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditSpouseName">Spouse Name</label>
              <input
                type="text"
                id="modalEditSpouseName"
                name="spouse_name"
                class="form-control"
                value="{{ $user->spouse_name??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditPermanentAddress">Permanent Address</label>
              <input
                type="text"
                id="modalEditPermanentAddress"
                name="permanent_address"
                class="form-control"
                value="{{ $user->permanent_address??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditPresentAddress">Present Address</label>
              <input
                type="text"
                id="modalEditPresentAddress"
                name="present_address"
                class="form-control"
                value="{{ $user->present_address??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditOccupation">Occupation</label>
              <input
                type="text"
                id="modalEditOccupation"
                name="occupation"
                class="form-control"
                value="{{ $user->occupation??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditWorkplace">Work Place</label>
              <input
                type="text"
                id="modalEditWorkplace"
                name="workplace"
                class="form-control modal-edit-tax-id"
                value="{{ $user->workplace??'' }}"
              />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditNid">NID</label>
              <input class="form-control" name="national_id" type="file" id="modalEditNid">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditBirthId">Birth ID</label>
              <input class="form-control" name="birth_id" type="file" id="modalEditBirthId">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditPhoto">Photo</label>
              <input class="form-control" type="file" id="formFile">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditTaxID">Status</label>
              <select name="status" id="" class="form-control form-select">
                <option value="active" @if($user->status=="active") selected @endif>Active</option>
                <option value="inactive" @if($user->status=="inactive") selected @endif>Inactive
                </option>
                <option value="closed" @if($user->status=="closed") selected @endif>Closed</option>
              </select>
            </div>
            <div class="col-12 text-center mt-2 pt-50">
              <button type="submit" class="btn btn-primary me-1 btn-update">Update</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                      aria-label="Close">
                Discard
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Edit User Modal -->

  {{--@include('content/_partials/_modals/modal-edit-user')--}}

@endsection


@section('page-script')
  {{-- Page js files --}}
  {{--<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>--}}

  <script>
    // Variable declaration for table
    var dtAccountsTable = $('.datatable-accounts'),
      dtLoansTable = $('.datatable-loans'),
      invoicePreview = 'app-invoice-preview.html',
      assetPath = '../../../app-assets/';

    if ($('body').attr('data-framework') === 'laravel') {
      assetPath = $('body').attr('data-asset-path');
      invoicePreview = assetPath + 'app/invoice/preview';
    }

    // Invoice datatable
    // --------------------------------------------------------------------
    if (dtAccountsTable.length) {
      var dtAccounts = dtAccountsTable.DataTable({
        ajax: "{{ url('userAccounts') }}/" + {{ $user->id }}, // JSON file to add data
        processing: true,
        serverSide: true,
        autoWidth: true,
        columns: [
          // columns according to JSON
          {data: 'account_no'},
          {data: 'type'},
          {data: 'opening_date'},
          {data: 'balance'},
          {data: 'status'},
          {data: 'action'}
        ],
        columnDefs: [
          {
            // Actions
            targets: 5,
            title: 'Actions',
            width: '80px',
            orderable: false,
            render: function (data, type, full, meta) {
              var link = "";
              var id = full['id'];
              if (full['type'] == "DPS") {
                link = "{{url('dps')}}";
              } else if (full['type'] == "Daily Savings") {
                link = "{{ url('daily-savings') }}";
              }
              return (
                '<div class="d-flex align-items-center col-actions">' +
                '<a class="me-1" href="' + link + '/' + id + '">' +
                feather.icons['eye'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>' +
                '<a class="me-1" href="' +
                invoicePreview +
                '" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview Invoice">' +
                feather.icons['edit'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>' +
                '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">' +
                feather.icons['download'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>'
              );
            }
          }
        ],
        order: [[1, 'desc']],
        dom: '<"card-header pt-1 pb-25"<"head-label"><"dt-action-buttons text-end"B>>t',
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-outline-secondary dropdown-toggle',
            text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              }
            ],
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
              $(node).parent().removeClass('btn-group');
              setTimeout(function () {
                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
              }, 50);
            }
          }
        ]
      });
      $('div.head-label').html('<h4 class="card-title">Accounts</h4>');
    }
    if (dtLoansTable.length) {
      var dtLoans = dtLoansTable.DataTable({
        serverSide: true,
        ajax: "{{ url('userLoans') }}/" + {{ $user->id }}, // JSON file to add data
        columns: [
          // columns according to JSON
          {data: 'account_no'},
          {data: 'type'},
          {data: 'loan_amount'},
          {data: 'remain'},
          {data: 'date'},
          {data: 'action'}
        ],
        columnDefs: [
          {
            // Actions
            targets: 5,
            title: 'Actions',
            width: '80px',
            orderable: false,
            render: function (data, type, full, meta) {
              var link = "";
              var id = full['id'];
              if (full['type'] == "DPS Loan") {
                link = "{{ url('dps-loans') }}";
              } else if (full['type'] == "Special Loan") {
                link = "{{ url('special-dps-loans') }}";
              } else if (full['type'] == "Daily Loan") {
                link = "{{ url('daily-loans') }}";
              }
              return (
                '<div class="d-flex align-items-center col-actions">' +
                '<a class="me-1" href="' + link + '/' + id + '">' +
                feather.icons['eye'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>' +
                '<a class="me-1" href="' +
                invoicePreview +
                '" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview Invoice">' +
                feather.icons['edit'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>' +
                '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">' +
                feather.icons['download'].toSvg({class: 'font-medium-2 text-body'}) +
                '</a>'
              );
            }
          }
        ],
        order: [[1, 'desc']],
        dom: '<"card-header pt-1 pb-25"<"head-label"><"dt-action-buttons text-end"B>>t',
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-outline-secondary dropdown-toggle',
            text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4]}
              }
            ],
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
              $(node).parent().removeClass('btn-group');
              setTimeout(function () {
                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
              }, 50);
            }
          }
        ]
      });
      $('#loanAccount .head-label').html('<h4 class="card-title">Loans</h4>');
    }
    /*
            $(".btn-update").on("click",function () {
                $.ajax({
                    url: "{{ route("users.update",$user->id) }}",
                method: "POST",
                data: $("#editUserForm").serialize(),
                success: function (data) {
                    console.log(data)
                }
            })
        })*/

    function resetDaily(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-daily-savings') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-daily', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetDaily(id)
            .catch(() => {
              Swal.showValidationMessage('দৈনিক সঞ্চয় রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('দৈনিক সঞ্চয় রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function resetDps(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-monthly-dps') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-dps', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetDps(id)
            .catch(() => {
              Swal.showValidationMessage('মাসিক সঞ্চয় (ডিপিএস) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('মাসিক সঞ্চয় (ডিপিএস) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function resetSpecial(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-special-dps') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-special', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetSpecial(id)
            .catch(() => {
              Swal.showValidationMessage('বিশেষ সঞ্চয় (স্পেশাল) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('বিশেষ সঞ্চয় (স্পেশাল) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function resetFdr(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-fdr') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-fdr', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetFdr(id)
            .catch(() => {
              Swal.showValidationMessage('স্থায়ী সঞ্চয় (FDR) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('স্থায়ী সঞ্চয় (FDR) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function resetDailyLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-daily-loan') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-daily-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetDailyLoan(id)
            .catch(() => {
              Swal.showValidationMessage('দৈনিক ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('দৈনিক ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });

    function resetDpsLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-dps-loan') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-dps-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetDpsLoan(id)
            .catch(() => {
              Swal.showValidationMessage('মাসিক (DPS) ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('মাসিক (DPS) ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });

    function resetSpecialLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-special-loan') }}/" + id, //or you can use url: "company/"+id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.reset-special-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return resetSpecialLoan(id)
            .catch(() => {
              Swal.showValidationMessage('বিশেষ (Special) ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('বিশেষ (Special) ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });


    /* Delete Scipts*/
    function deleteDaily(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('daily-savings') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-daily', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteDaily(id)
            .catch(() => {
              Swal.showValidationMessage('দৈনিক সঞ্চয় রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('দৈনিক সঞ্চয় রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function deleteDps(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('dps') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-dps', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteDps(id)
            .catch(() => {
              Swal.showValidationMessage('মাসিক সঞ্চয় (ডিপিএস) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('মাসিক সঞ্চয় (ডিপিএস) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function deleteSpecial(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('special-dps') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-special', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteSpecial(id)
            .catch(() => {
              Swal.showValidationMessage('বিশেষ সঞ্চয় (স্পেশাল) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('বিশেষ সঞ্চয় (স্পেশাল) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function deleteFdr(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('fdrs') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-fdr', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteFdr(id)
            .catch(() => {
              Swal.showValidationMessage('স্থায়ী সঞ্চয় (FDR) রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('স্থায়ী সঞ্চয় (FDR) রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    function deleteDailyLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('daily-loans') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-daily-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteDailyLoan(id)
            .catch(() => {
              Swal.showValidationMessage('দৈনিক ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('দৈনিক ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });

    function deleteDpsLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('dps-loans') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-dps-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteDpsLoan(id)
            .catch(() => {
              Swal.showValidationMessage('মাসিক (DPS) ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('মাসিক (DPS) ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });

    function deleteSpecialLoan(id) {
      var token = $("meta[name='csrf-token']").attr("content");
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('special-dps-loans') }}/" + id, //or you can use url: "company/"+id,
          type: 'DELETE',
          data: {
            _token: token
          },
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }

    $(document).on('click', '.delete-special-loan', function () {
      var id = $(this).data("id");
      Swal.fire({
        title: 'আপনি কি নিশ্চিত?',
        text: 'এটি আপনি পুনরায় পাবেন না!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'হ্যাঁ, এটি রিসেট করুন!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading(),
        showLoaderOnConfirm: true,
        preConfirm: () => {
          // Return the promise from the AJAX request function
          return deleteSpecialLoan(id)
            .catch(() => {
              Swal.showValidationMessage('বিশেষ (Special) ঋণ রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('বিশেষ (Special) ঋণ রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });
          window.location.reload();
        }
      });
    });
  </script>
@endsection
