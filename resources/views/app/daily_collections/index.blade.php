@extends('layouts/layoutMaster')

@section('title', 'দৈনিক সঞ্চয় আদায়')

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


@section('page-style')
  {{-- Page Css files --}}

  <style>
    .inline-spacing > * {
      margin-top: 14px;
      margin-right: 15px;
    }
  </style>
@endsection

@section('content')
  @php
    $collectors = \App\Models\User::role('super-admin')->get();
  @endphp
  <section class="container-fluid">
    {{--<div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item active">দৈনিক সঞ্চয় আদায়</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="javascript:;">Excel আপলোড</a>
    </div>--}}
    <h3 class="fw-bolder text-success text-center">দৈনিক সঞ্চয় - সঞ্চয়/ঋণ আদায়</h3>
    <hr>
    <div class="row my-3">
      <!-- User Content -->
      <div class="col-xl-9 col-lg-9 col-md-9 submission-form">
        <form id="collectionForm">
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-12">
                  @php
                    $accounts = \App\Models\DailySavings::with('user')->where('status','active')->get();
                  @endphp
                  <div class="mb-1">
                    <label class="form-label" for="basicInput">হিসাব নং</label>
                    <select class="select2 form-select" name="account_no" id="account_no"
                            data-placeholder="Select Account" data-allow-clear="on">
                      <option value=""></option>
                      @foreach($accounts as $account)
                        <option value="{{$account->account_no}}"> {{$account->account_no}}
                          || {{$account->user->name??''}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                  <div class="mb-1">
                    <label class="form-label" for="date">তারিখ</label>
                    <input type="date" id="date" name="date" class="form-control"
                           value="{{date('Y-m-d')}}">
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                  <div class="mb-1">
                    <label class="form-label" for="collection_date">সংগ্রহের তারিখ</label>
                    <input type="date" class="form-control " name="collection_date"
                           id="collection_date" value="{{date('Y-m-d')}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card collection-form p-0">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-7 bg-light py-2">
                  <div class="row">
                    <h4 class="text-center ">সঞ্চয় আদায়</h4>
                    <div class="col-lg-6 my-1">
                      <label for="saving_amount">পরিমাণ</label>
                      <input type="number" class="form-control" id="saving_amount"
                             placeholder="Amount">

                    </div>
                    <div class="col-lg-6 my-1">
                      <label for="">সঞ্চয়ের ধরন</label>
                      <select id="saving_type" class="form-control select2">
                        <option value="deposit">জমা</option>
                        <option value="withdraw">উত্তোলন</option>
                      </select>
                    </div>

                    <div class="col-lg-6 my-1">
                      <label for="late_fee">বিলম্ব ফি</label>
                      <input type="number" class="form-control" name="late_fee" id="late_fee"
                             placeholder="Late Fee">

                    </div>

                    <div class="col-lg-6 my-1">
                      <label for="other_fee">অন্যান্য ফি</label>
                      <input type="number" class="form-control" name="other_fee" id="other_fee"
                             placeholder="Other Fee">

                    </div>

                    <div class="col-lg-12 my-1">
                      <label for="saving_note">মন্তব্য</label>
                      <input type="text" class="form-control" id="saving_note"
                             placeholder="Note">

                    </div>
                  </div>

                </div>

                <div class="col-lg-5 bg-success py-2">
                    <div class="row">
                        <h4 class="text-center text-white">ঋন ফেরত</h4>
                        <div class="col-lg-6 my-1">
                          <label for="loan_installment" class="text-white">পরিমাণ</label>
                          <input type="number" class="form-control" id="loan_installment"
                                 placeholder="Installment">

                        </div>
                        <div class="col-lg-6 my-1">
                          <label for="installment_no" class="text-white">কিস্তি নং</label>
                          <input type="number" class="form-control" id="installment_no"
                                 placeholder="Installment No">

                        </div>
                        <div class="col-lg-6 my-1">
                          <label for="loan_late_fee" class="text-white">বিলম্ব ফি</label>
                          <input type="number" class="form-control" name="loan_late_fee" id="loan_late_fee"
                                 placeholder="Late Fee">
                      </div>
                        <div class="col-lg-6 my-1">
                          <label for="loan_other_fee" class="text-white">অন্যান্য ফি</label>
                          <input type="number" class="form-control" name="loan_other_fee" id="loan_other_fee"
                                 placeholder="Other Fee">

                        </div>
                        <div class="col-lg-12 my-1">
                          <label for="loan_note" class="text-white">মন্তব্য</label>
                          <input type="text" class="form-control" id="loan_note"
                                 placeholder="Note">
                        </div>
                    </div>
                      <input type="hidden" id="user_id">
                      <input type="hidden" id="daily_savings_id">
                      <input type="hidden" id="daily_loan_id">

                </div>
                <div class="col-md-12 my-3">
                  <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary btn-submit w-25" onclick="modalData()">
                      সাবমিট
                    </button>
                  </div>
                </div>
          </div>
      </div>
          </div>
      </form>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-header pb-0">
          <h4 class="fw-bolder mb-1">সঞ্চয় হিসাব</h4>
        </div>
        <div class="card-body">
          <div id="savings-info">
            <div class="info-container">
              <table class="table table-sm table-bordered savings-info-list">

              </table>
            </div>
          </div>
          <div id="loan-info" style="display: none">
            <h4 class="fw-bolder border-bottom pb-50 mb-1">ঋন তথ্য</h4>
            <div class="info-container">
              <table class="table table-sm table-bordered loan-info-list">

              </table>

            </div>
          </div>
          <div class="d-flex justify-content-center pt-2 buttons">

          </div>
        </div>
      </div>

    </div>
    <!--/ User Content -->
    <!--/ User Sidebar -->
    </div>
  </section>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
    <li class="nav-item">
      <a
        class="nav-link active fs-3"
        id="home-tab-fill"
        data-bs-toggle="tab"
        href="#home-fill"
        role="tab"
        aria-controls="home-fill"
        aria-selected="true"
      >সঞ্চয় জমা/উত্তোলন</a
      >
    </li>
    <li class="nav-item">
      <a
        class="nav-link fs-3"
        id="profile-tab-fill"
        data-bs-toggle="tab"
        href="#profile-fill"
        role="tab"
        aria-controls="profile-fill"
        aria-selected="false"
      >ঋণ আদায়</a
      >
    </li>

  </ul>
  <!-- Tab panes -->
  <div class="tab-content pt-3 px-0">
    <div class="tab-pane active" id="home-fill" role="tabpanel"
         aria-labelledby="home-tab-fill">
      <div class="row mx-auto">
        <div class="col-xl-3 col-md-6 col-12">
          <div class="mb-1">

            <select class="select2 form-select" name="s_account_no"
                    id="s_account_no"
                    data-placeholder="Select Account" data-allow-clear="on">
              <option value=""></option>
              @foreach($accounts as $account)
                <option
                  value="{{$account->account_no}}"> {{$account->account_no}}
                  || {{$account->user->name??''}} </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">

            <select name="s_collector" id="s_collector" class="form-select select2"
                    data-placeholder="Collector">
              <option value=""></option>
              @foreach($collectors as $collector)
                <option
                  value="{{ $collector->id }}">{{ $collector->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">
            <input type="date" id="s_fromdate" name="s_fromdate"
                   class="form-control flatpickr-basic"
                   placeholder="From" />
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">
            <input type="date" class="form-control flatpickr-basic" name="s_todate"
                   id="s_todate" placeholder="To">
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
          <button type="button" class="btn btn-info btn-savings-collection"
                  onclick="filterSavingsData()">
            সার্চ
          </button>
          <button type="button"
                  class="btn btn-danger btn-savings-collection-reset"
                  onclick="resetFilterSavings()">রিসেট
          </button>
        </div>

      </div>
      <div class="table-responsive">
        <table class="datatables-basic table table-sm table-bordered table-secondary">
          <thead class="table-light">
          <tr>
            <th class="fw-bolder py-2">নাম </th>
            <th class="fw-bolder py-2">হিসাব নং</th>
            <th class="fw-bolder py-2">ধরন</th>
            <th class="fw-bolder py-2">পরিমাণ</th>
            <th class="fw-bolder py-2">বিলম্ব ফি</th>
            <th class="fw-bolder py-2">অন্যান্য ফি</th>
            <th class="fw-bolder py-2">ব্যালেন্স</th>
            <th class="fw-bolder py-2">তারিখ</th>
            <th class="fw-bolder py-2">আদায়কারী</th>
            <th class="fw-bolder py-2">#</th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
    <div class="tab-pane" id="profile-fill" role="tabpanel"
         aria-labelledby="profile-tab-fill">
      <div class="row mx-auto">
        <div class="col-xl-3 col-md-6 col-12">
          <div class="mb-1">

            <select class="select2 form-select" name="l_account_no"
                    id="l_account_no"
                    data-placeholder="Select Account" data-allow-clear="on">
              <option value=""></option>
              @foreach($accounts as $account)
                <option
                  value="{{$account->account_no}}"> {{$account->account_no??''}}
                  || {{$account->user->name??''}} </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">

            <select name="l_collector" id="l_collector" class="form-control select2"
                    data-placeholder="Collector">
              <option value=""></option>
              @foreach($collectors as $collector)
                <option
                  value="{{ $collector->id }}">{{ $collector->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">
            <input type="date" id="l_fromdate" name="l_fromdate"
                   class="form-control flatpickr-basic"
                   placeholder="From" />
          </div>
        </div>
        <div class="col-xl-2 col-md-6 col-12">
          <div class="mb-1">
            <input type="date" class="form-control flatpickr-basic" name="l_todate"
                   id="l_todate" placeholder="To">
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
          <button type="button" class="btn btn-primary btn-loan-collection"
                  onclick="filterLoanData()">
            সার্চ
          </button>
          <button type="button"
                  class="btn btn-danger btn-loan-collection-reset"
                  onclick="resetFilterLoan()"> রিসেট
          </button>
        </div>
      </div>

      <table class="datatables-loan-collection table table-sm table-bordered  table-success">
        <thead class="table-light">
        <tr>
          <th class="fw-bolder py-2">নাম</th>
          <th class="fw-bolder py-2">হিসাব নং </th>
          <th class="fw-bolder py-2">পরিমাণ</th>
          <th class="fw-bolder py-2">বিলম্ব ফি</th>
          <th class="fw-bolder py-2">অন্যান্য ফি </th>
          <th class="fw-bolder py-2">ব্যালেন্স</th>
          <th class="fw-bolder py-2">তারিখ</th>
          <th class="fw-bolder py-2">মন্তব্য</th>
          <th class="fw-bolder py-2">আদায়কারী</th>
          <th class="fw-bolder py-2">#</th>
        </tr>
        </thead>
      </table>

    </div>
  </div>

  <div class="modal fade" id="modalCollection" tabindex="-1" aria-labelledby="modalCollectionTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCollectionTitle">দৈনিক সঞ্চয় জমা/উত্তোলন/ঋন ফেরত</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formCollection">
          @csrf
          <div class="modal-body">
            <p>তারিখঃ <span class="date"></span></p>
            <table class="table table-sm table-user-info">
              <tr>
                <th class="py-1">নামঃ</th>
                <td class="ac_holder"></td>
              </tr>
              <tr>
                <th class="py-1">হিসাব নংঃ</th>
                <td class="acc_no"></td>
              </tr>
            </table>

            <table class="table table-sm table-collection-info table-bordered">


            </table>
            <input type="hidden" name="account_no">
            <input type="hidden" name="user_id">
            <input type="hidden" name="collector_id">
            <input type="hidden" name="saving_amount">
            <input type="hidden" name="saving_type">
            <input type="hidden" name="late_fee">
            <input type="hidden" name="other_fee">
            <input type="hidden" name="loan_installment">
            <input type="hidden" name="installment_no">
            <input type="hidden" name="loan_late_fee">
            <input type="hidden" name="loan_other_fee">
            <input type="hidden" name="saving_note">
            <input type="hidden" name="loan_note">
            <input type="hidden" name="daily_savings_id">
            <input type="hidden" name="daily_loan_id">
            <input type="hidden" name="date">
            <input type="hidden" name="collection_date">
            <input type="hidden" name="created_by" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">বাতিল</button>
            <button type="button" class="btn btn-primary btn-confirm">সাবমিট</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="edit-saving-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">সঞ্চয় জমা/উত্তোলন এডিট</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-form">
            @csrf
            <div class="row">
              <input type="hidden" name="id">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">নাম</label>: <span
                    class="edit-name text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">হিসাব নং</label>: <span
                    class="edit-account-no text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">পরিমান</label>
                  <input type="number" class="form-control savings_amount" name="saving_amount">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">তারিখ</label>
                  <input type="date" class="form-control date flatpickr-basic" name="date">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">বিলম্ব ফি</label>
                  <input type="number" class="form-control late_fee" name="late_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">অন্যান্য ফি</label>
                  <input type="number" class="form-control other_fee" name="other_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">ধরন</label>
                  <select name="type" class="type form-control">
                    <option value="">- Select Type -</option>
                    <option value="deposit">জমা</option>
                    <option value="withdraw">উত্তোলন</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">ব্যালেন্স</label>
                  <input type="number" class="form-control balance" name="balance">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">আদায়কারী</label>
                  <select name="collector_id" class="collector_id form-control">
                    <option value="">Select Collector</option>
                    @foreach($collectors as $collector)
                      <option
                        value="{{ $collector->id }}">{{ $collector->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">মন্তব্য</label>
                  <input type="text" class="form-control note" name="note">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-edit" data-bs-dismiss="modal">আপডেট</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit-loan-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">ঋন আদায় এডিট</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-loan-form">
            @csrf
            <div class="row">
              <input type="hidden" name="id">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">নাম</label>: <span
                    class="edit-name text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">হিসাব নং</label>: <span
                    class="edit-account-no text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">পরিমান</label>
                  <input type="number" class="form-control loan_installment" name="loan_installment">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">কিস্তি নং</label>
                  <input type="number" class="form-control installment_no" name="installment_no">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">তারিখ</label>
                  <input type="date" class="form-control date flatpickr-basic" name="date">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">বিলম্ব ফি</label>
                  <input type="number" class="form-control loan_late_fee" name="loan_late_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">অন্যান্য ফি</label>
                  <input type="number" class="form-control loan_other_fee" name="loan_other_fee">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label">ব্যালেন্স</label>
                  <input type="number" class="form-control loan_balance" name="loan_balance">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">আদায়কারী</label>
                  <select name="collector_id" class="collector_id form-control">
                    <option value="">Select Collector</option>
                    @foreach($collectors as $collector)
                      <option
                        value="{{ $collector->id }}">{{ $collector->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">মন্তব্য</label>
                  <input type="text" class="form-control loan_note" name="loan_note">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-edit-loan" data-bs-dismiss="modal">আপডেট</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Import / Export -->
  <div class="modal fade text-start" id="savingsImportModal" tabindex="-1" aria-labelledby="myModalLabel4"
       data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
          <h4 class="modal-title text-white" id="myModalLabel4">Import Savings Collections</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('savings-collection-import') }}" method="POST"
              enctype="multipart/form-data">
          @csrf

          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                <label for="formFile" class="form-label">Select Excel File</label>
                <input class="form-control" name="file" type="file" id="formFile">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade text-start" id="loanCollectionImportModal" tabindex="-1" aria-labelledby="myModalLabel4"
       data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
          <h4 class="modal-title text-white" id="myModalLabel4">Import Daily Loan Collections</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('daily-loan-collection-import') }}" method="POST"
              enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-1 mb-sm-0">
                <label for="formFile" class="form-label">Select Excel File</label>
                <input class="form-control" name="file" type="file" id="formFile">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('page-script')
  <script>
    $(".select2").select2();

    function resetForm() {
      $("#collectionForm").trigger("reset");
      $("#formCollection").trigger("reset");
      $("#account_no").val("").trigger("change");
      $("#saving_amount").val("");
      $("#loan_installment").val("");

      $("#saving_type").val("deposit").trigger("change");
    }

    $("#account_no").on("select2:select", function(e) {
      var account_no = e.params.data.id;
      $(".savings-info-list").empty();
      $(".loan-info-list").empty();
      $(".buttons").empty();
      $.ajax({
        url: "{{ url('dataByAccount') }}/" + account_no,
        dataType: "JSON",
        success: function(data) {
          $("#user_id").val(data.savings.user.id);
          $(".ac_holder").text(data.savings.user.name);
          $("#offcanvasScrollLabel").text(data.savings.user.name);
          $(".phone").text(data.savings.user.phone1);
          $(".acc_no").text(data.savings.account_no);
          $("#daily_savings_id").val(data.savings.id);
          var saving = data.savings;
          $(".savings-balance h5").text(saving.total);
          $(".buttons").append(`<a href="{{ url('daily-savings') }}/${data.savings.id}" class="btn btn-sm btn-primary me-1">
                            Savings InFo
                        </a>`);
          $(".savings-info-list").append(`
                    <tr>
                                        <th class="fw-bolder py-0">হিসাব নং</th>
                                        <td class="account_no">${saving.account_no}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">জমা</th>
                                        <td class="total_deposit">${saving.deposit}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">উত্তোলন</th>
                                        <td class="total_withdraw">${saving.withdraw}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">লভ্যাংশ</th>
                                        <td class="profit">${saving.profit}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder py-0">অবশিষ্ট জমা</th>
                                        <td class="balance">${saving.total}</td>
                                    </tr>
                    `);

          if (data.loans != null) {
            $(".buttons").append(`
                        <a href="{{ url('daily-loans') }}/${data.loans.id}" class="btn btn-sm btn-outline-sm btn-outline-danger suspend-user">Loan InFo</a>
`);
            $("#loan-info").show();
            $(".loan-balance").show();

            var loans = data.loans;
            var loan_return = loans.total - loans.balance;
            $(".loan-balance h5").text(loans.balance);
            $("#daily_loan_id").val(data.loans.id);
            $(".loan-info-list").append(`
                    <tr>
                                        <th class="fw-bolder me-25 py-0">ঋণের পরিমাণ</th>
                                        <td>${loans.loan_amount}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder me-25 py-0">হিসাব শুরু</th>
                                        <td>${formatDate(loans.commencement)}</td>
                                    </tr>
                                    <tr>
                                        <th class="fw-bolder me-25 py-0">ঋন ফেরত</th>
                                        <td>${loan_return}</td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bolder me-25 py-0">অবশিষ্ট ঋন</th>
                                        <td>${loans.balance}</td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bolder me-25 py-0">সর্বশেষ লেনদেন</th>
                                        <td></td>
                                    </tr>
                    `);
          } else {
            $("#loan-info").hide();
            $(".loan-balance").hide();
            $(".loan-balance h4").text("");
          }

          if (data.savings.user.image == null) {
            var path = "{{ asset('storage/images/profile') }}/"+data.savings.user.image;
            $(".profile-image").attr("src", path);
          }
        }
      });
    });
    function formatDate(inputDate) {
      const date = new Date(inputDate);
      const day = date.getDate().toString().padStart(2, '0');
      const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Note: Month is 0-indexed
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }
    $(".btn-submit").on("click", function() {
      var account_no = $("#account_no option:selected").val();
      var user_id = $("#user_id").val();
      var collector_id = $("#collector_id option:selected").val();
      var saving_amount = $("#saving_amount").val();
      var saving_type = $("#saving_type option:selected").val();
      var late_fee = $("#late_fee").val();
      var other_fee = $("#other_fee").val();
      var loan_installment = $("#loan_installment").val();
      var installment_no = $("#installment_no").val();
      var loan_late_fee = $("#loan_late_fee").val();
      var loan_other_fee = $("#loan_other_fee").val();
      var saving_note = $("#saving_note").val();
      var loan_note = $("#loan_note").val();
      var daily_savings_id = $("#daily_savings_id").val();
      var daily_loan_id = $("#daily_loan_id").val();
      var date = $("#date").val();
      var collection_date = $("#collection_date").val();
      $(".table-collection-info").empty();
      var total = 0;
      $(".date").text(date);
      $(".ac_holder").text();
      if (saving_type == "deposit" && saving_amount != "") {
        $(".table-collection-info").append(`
            <tr>
                                <th class="py-0">সঞ্চয় ধরন</th>
                                <td><span class="text-success">জমা</span></td>
                            </tr>
            `);
      } else if (saving_type == "withdraw" && saving_amount != "") {
        $(".table-collection-info").append(`
            <tr>
                                <th class="py-0">সঞ্চয় ধরন</th>
                                <td><span class="text-danger">উত্তোলন</span></td>
                            </tr>
            `);
      }
      if (saving_amount != "") {
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">পরিমান</th>
                    <td>${saving_amount}</td>
                </tr>
            `);
      }


      if (late_fee != "") {
        total += parseInt(late_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">বিলম্ব ফি</th>
                    <td>${late_fee}</td>
                </tr>
            `);
      }

      if (other_fee != "") {
        total += parseInt(other_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">অন্যান্য ফি</th>
                    <td>${other_fee}</td>
                </tr>
            `);
      }
      if (loan_installment != "") {
        total += parseInt(loan_installment);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">ঋণ আদায়</th>
                    <td>${loan_installment}</td>
                </tr>
            `);
      }
      if (loan_late_fee != "") {
        total += parseInt(loan_late_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">ঋণের বিলম্ব ফি</th>
                    <td>${loan_late_fee}</td>
                </tr>
            `);
      }

      if (loan_other_fee != "") {
        total += parseInt(loan_other_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-0">ঋণের অন্যান্য ফি</th>
                    <td>${loan_other_fee}</td>
                </tr>
            `);
      }

      if (saving_type == "deposit" && saving_amount != "") {
        total += parseInt(saving_amount);
      } else if (saving_type == "withdraw" && saving_amount != "") {
        total -= parseInt(saving_amount);
      }
      $(".table-collection-info").append(`
            <tfoot>
            <tr>
                <th class="py-0">সর্বমোট</th>
                <td class="bg-success text-white"><span class="total">${total}</span></td>
            </tr>
            </tfoot>
            `);


      $("input[name=account_no]").val(account_no);
      $("input[name=user_id]").val(user_id);
      $("input[name=collector_id]").val(collector_id);
      $("input[name=saving_amount]").val(saving_amount);
      $("input[name=saving_type]").val(saving_type);
      $("input[name=late_fee]").val(late_fee);
      $("input[name=other_fee]").val(other_fee);
      $("input[name=loan_installment]").val(loan_installment);
      $("input[name=installment_no]").val(installment_no);
      $("input[name=loan_late_fee]").val(loan_late_fee);
      $("input[name=loan_other_fee]").val(loan_other_fee);
      $("input[name=saving_note]").val(saving_note);
      $("input[name=loan_note]").val(loan_note);
      $("input[name=daily_savings_id]").val(daily_savings_id);
      $("input[name=daily_loan_id]").val(daily_loan_id);
      $("input[name=date]").val(date);
      $("input[name=collection_date]").val(collection_date);
      $(".btn-confirm").attr("disabled", false);
      $(".spinner").hide();
      $("#modalCollection").modal("show");
    });

    $(".btn-confirm").on("click", function() {
      //$(".spinner").show();
      //$(".btn-confirm").attr('disabled',true);
      var $this = $(".btn-confirm"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "{{ route('daily-collections.store') }}",
        method: "POST",
        data: $("#formCollection").serialize(),
        beforeSend: function() {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr("disabled", true).html("Processing...");
        },
        success: function(data) {
          $this.attr("disabled", false).html($caption);
          $("#modalCollection").modal("hide");
          toastr["success"]("👋 Submission has been saved successfully.", "Success!", {
            closeButton: true,
            tapToDismiss: false
          });

          resetForm();

          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          $(".datatables-loan-collection").DataTable().destroy();
          loadLoanCollection();

        },
        error: function(data) {
          $("#modalCollection").modal("hide");
          $this.attr("disabled", false).html($caption);
          toastr["error"]("Submission failed. Please try again.", "Error!", {
            closeButton: true,
            tapToDismiss: false
          });
        }
      });
    });


    loadSavingsCollection();
    loadLoanCollection();
    var assetPath = $("body").attr("data-asset-path"),
      userView = '{{ url('users') }}/';

    function loadSavingsCollection(account = "", collector = "", from = "", to = "") {
      $(".datatables-basic").DataTable({
        "proccessing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
          "url": "{{ url('dataSavingsCollection') }}",
          type: "GET",
          data: { account: account, collector: collector, from: from, to: to }
        },
        "columns": [

          { "data": "name" },
          { "data": "account_no" },
          { "data": "type" },
          { "data": "amount" },
          { "data": "late_fee" },
          { "data": "other_fee" },
          { "data": "balance" },
          { "data": "date" },
          { "data": "collector" },
          { "data": "action" }
        ],
        columnDefs: [

          {
            // Actions
            targets: 9,
            title: "Actions",
            orderable: false,
            render: function(data, type, full, meta) {
              return (
                "<div class=\"d-inline-flex\">" +
                "<a class=\"pe-1 dropdown-toggle hide-arrow text-primary\" data-bs-toggle=\"dropdown\">" +
                '<i class="ti ti-dots"></i></a>' +
                "</a>" +
                "<div class=\"dropdown-menu dropdown-menu-end\">" +
                '<a href="{{url('daily-savings')}}/' + full["id"] + "\" class=\"dropdown-item\">" +
                "বিস্তারিত</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item text-danger fw-bolder delete-record\">" +
                "ডিলেট</a>" +
                "</div>" +
                "</div>" +
                "<a href=\"javascript:;\" class=\"item-edit\" data-id=\"" + full["id"] + "\">" +
                '<i class="ti ti-edit"></i></a>' +
                "</a>"
              );
            }
          }
        ],
        dom:
          "<\"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75\"" +
          "<\"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start\" l>" +
          "<\"col-sm-12 col-lg-8 ps-xl-75 ps-0\"<\"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap\"<\"me-1\"f>B>>" +
          ">t" +
          "<\"d-flex justify-content-between mx-2 row mb-1\"" +
          "<\"col-sm-12 col-md-6\"i>" +
          "<\"col-sm-12 col-md-6\"p>" +
          ">",
        language: {
          sLengthMenu: "Show _MENU_",
          search: "Search",
          searchPlaceholder: "Search.."
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: "collection",
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              }
            ],
            init: function(api, node, config) {
              $(node).removeClass("btn-secondary");
              $(node).parent().removeClass("btn-group");
              setTimeout(function() {
                $(node).closest(".dt-buttons").removeClass("btn-group").addClass("d-inline-flex mt-50");
              }, 50);
            }
          }
        ]

      });
    }


    function loadLoanCollection(account = "", collector = "", from = "", to = "") {
      $(".datatables-loan-collection").DataTable({
        "proccessing": true,
        "serverSide": true,
        "ajax": {
          "url": "{{ url('dataDailyLoanCollection') }}",
          type: "GET",
          data: { account: account, collector: collector, from: from, to: to }
        },
        "columns": [

          { "data": "name" },
          { "data": "account_no" },
          { "data": "amount" },
          { "data": "late_fee" },
          { "data": "other_fee" },
          { "data": "balance" },
          { "data": "date" },
          { "data": "note" },
          { "data": "collector" },
          { "data": "action" }
        ],
        columnDefs: [
          {
            // Actions
            targets: 9,
            title: "Actions",
            orderable: false,
            render: function(data, type, full, meta) {
              return (
                "<div class=\"d-inline-flex\">" +
                "<a class=\"pe-1 dropdown-toggle hide-arrow text-primary\" data-bs-toggle=\"dropdown\">" +
                '<i class="ti ti-dots"></i></a>' +
                "</a>" +
                "<div class=\"dropdown-menu dropdown-menu-end\">" +
                '<a href="{{url('daily-loan-collections')}}/' + full["id"] + "\" class=\"dropdown-item\">" +
                "বিস্তারিত</a>" +
                "<a href=\"javascript:;\" data-id=\"" + full["id"] + "\" class=\"dropdown-item text-danger fw-bolder delete-loan-record\">" +
                "ডিলেট</a>" +
                "</div>" +
                "</div>" +
                "<a href=\"javascript:;\" class=\"item-edit-loan\" data-id=\"" + full["id"] + "\">" +
                '<i class="ti ti-edit"></i></a>' +
                "</a>"
              );
            }
          }
        ],
        dom:
          "<\"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75\"" +
          "<\"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start\" l>" +
          "<\"col-sm-12 col-lg-8 ps-xl-75 ps-0\"<\"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap\"<\"me-1\"f>B>>" +
          ">t" +
          "<\"d-flex justify-content-between mx-2 row mb-1\"" +
          "<\"col-sm-12 col-md-6\"i>" +
          "<\"col-sm-12 col-md-6\"p>" +
          ">",
        language: {
          sLengthMenu: "Show _MENU_",
          search: "Search",
          searchPlaceholder: "Search.."
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: "collection",
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5,6,7,8]}
              }
            ],
            init: function(api, node, config) {
              $(node).removeClass("btn-secondary");
              $(node).parent().removeClass("btn-group");
              setTimeout(function() {
                $(node).closest(".dt-buttons").removeClass("btn-group").addClass("d-inline-flex mt-50");
              }, 50);
            }
          }
        ]

      });
    }

    $(document).on("click", ".delete-record", function() {
      var id = $(this).attr("data-id");
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ms-1"
        },
        buttonsStyling: false
      }).then(function(result) {
        if (result.value) {
          $.ajax(
            {
              url: "{{ url('savings-collections') }}/" + id,
              type: "DELETE",
              data: {
                _token: token,
                id: id
              },
              success: function(response) {

                //$("#success").html(response.message)

                Swal.fire(
                  "Deleted!",
                  "Data deleted successfully!",
                  "success"
                );
                $(".datatables-basic").DataTable().destroy();
                loadSavingsCollection();
              }
            });
        }
      });
    });
    $(document).on("click", ".delete-loan-record", function() {
      var id = $(this).attr("data-id");
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ms-1"
        },
        buttonsStyling: false
      }).then(function(result) {
        if (result.value) {
          $.ajax(
            {
              url: "{{ url('daily-loan-collections') }}/" + id, //or you can use url: "company/"+id,
              type: "DELETE",
              data: {
                _token: token,
                id: id
              },
              success: function(response) {

                //$("#success").html(response.message)

                Swal.fire(
                  "Deleted!",
                  "Data deleted successfully!",
                  "success"
                );
                $(".datatables-loan-collection").DataTable().destroy();
                loadLoanCollection();
              }
            });
        }
      });
    });
    $(document).on("click", ".item-edit", function() {
      var id = $(this).attr("data-id");
      $.ajax({
        url: "{{ url('getSavingsCollectionData') }}/" + id,
        dataType: "JSON",
        success: function(data) {
          var user = data.user;
          $(".edit-name").text(user.name);
          $(".edit-account-no").text(data.account_no);
          $(".savings_amount").val(data.saving_amount);
          $(".late_fee").val(data.late_fee);
          $(".other_fee").val(data.other_fee);
          $(".balance").val(data.balance);
          $(".type").val(data.type);
          $(".date").val(data.date);
          $(".collector_id").val(data.collector_id);
          $("input[name='id']").val(data.id);
          $(".note").val(data.note);
          $("#edit-saving-collection-modal").modal("show");
        }
      });
    });
    $(document).on("click", ".item-edit-loan", function() {
      var id = $(this).attr("data-id");
      $.ajax({
        url: "{{ url('getLoanCollectionData') }}/" + id,
        dataType: "JSON",
        success: function(data) {
          var user = data.user;
          $(".edit-name").text(user.name);
          $(".edit-account-no").text(data.account_no);
          $(".loan_installment").val(data.loan_installment);
          $(".installment_no").val(data.installment_no);
          $(".loan_late_fee").val(data.loan_late_fee);
          $(".loan_other_fee").val(data.loan_other_fee);
          $(".loan_balance").val(data.loan_balance);
          $(".date").val(data.date);
          $(".collector_id").val(data.collector_id);
          $("input[name='id']").val(data.id);
          $(".loan_note").val(data.loan_note);
          $("#edit-loan-collection-modal").modal("show");
        }
      });
    });
    $(".btn-edit").on("click", function() {
      var id = $("input[name='id']").val();
      var $this = $(".edit"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "savings-collections/" + id,
        method: "PUT",
        data: $("#edit-form").serialize(),
        beforeSend: function() {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr("disabled", true).html("Processing...");
        },
        success: function(data) {
          $this.attr("disabled", false).html($caption);
          $("#edit-saving-collection-modal").modal("hide");
          toastr["success"]("👋 Submission has been updated successfully.", "Success!", {
            closeButton: true,
            tapToDismiss: false
          });
          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          resetForm();

        },
        error: function(data) {
          $("#edit-saving-collection-modal").modal("hide");
          $this.attr("disabled", false).html($caption);
          toastr["error"]("Submission failed. Please try again.", "Error!", {
            closeButton: true,
            tapToDismiss: false
          });
        }
      });
    });

    $(".btn-edit-loan").on("click", function() {
      var id = $("input[name='id']").val();
      var $this = $(".btn-edit-loan"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "daily-loan-collections/" + id,
        method: "PUT",
        data: $("#edit-loan-form").serialize(),
        beforeSend: function() {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr("disabled", true).html("Processing...");
        },
        success: function(data) {
          $this.attr("disabled", false).html($caption);
          $("#edit-loan-collection-modal").modal("hide");
          toastr["success"]("👋 Submission has been updated successfully.", "Success!", {
            closeButton: true,
            tapToDismiss: false
          });
          $(".datatables-loan-collection").DataTable().destroy();
          loadLoanCollection();

          resetForm();

        },
        error: function(data) {
          $("#edit-loan-collection-modal").modal("hide");
          $this.attr("disabled", false).html($caption);
          toastr["error"]("Submission failed. Please try again.", "Error!", {
            closeButton: true,
            tapToDismiss: false
          });
        }
      });
    });

    function filterSavingsData() {
      var account = $("#s_account_no option:selected").val();
      var collector = $("#s_collector option:selected").val();
      var from = $("#s_fromdate").val();
      var to = $("#s_todate").val();
      $(".datatables-basic").DataTable().destroy();
      loadSavingsCollection(account, collector, from, to);
    }

    function resetFilterSavings() {
      $(".datatables-basic").DataTable().destroy();
      $("#s_fromdate").val("");
      $("#s_todate").val("");
      loadSavingsCollection();
    }

    function filterLoanData() {
      var account = $("#l_account_no option:selected").val();
      var collector = $("#l_collector option:selected").val();
      var from = $("#l_fromdate").val();
      var to = $("#l_todate").val();
      $(".datatables-loan-collection").DataTable().destroy();
      loadLoanCollection(account, collector, from, to);
    }

    function resetFilterLoan() {
      $(".datatables-loan-collection").DataTable().destroy();
      $("#l_fromdate").val("");
      $("#l_todate").val("");
      loadLoanCollection();
    }
  </script>
@endsection
