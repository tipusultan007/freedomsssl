@extends('layouts.layoutMaster')
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
    {{--<div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item active">বিশেষ (Special) সঞ্চয়/ঋণ আদায়</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="javascript:;">Excel আপলোড</a>
    </div>--}}
    <h3 class="fw-bolder text-success text-center">বিশেষ সঞ্চয় (Special) - সঞ্চয়/ঋণ আদায়</h3>
    <hr>
    <div class="row">
      <!-- User Content -->
      <div class="col-xl-9 col-lg-9 col-md-9 submission-form">
        <form id="collectionForm" method="POST" action="{{ route('special-installments.store') }}">
          @csrf
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-12">
                  @php
                    $accounts = \App\Models\SpecialDps::with('user')->where('status','active')->get();
                  @endphp
                  <div class="mb-1">
                    <select class="select2 form-select" name="account_no" id="account_no"
                            data-placeholder="Select A/C No" data-allow-clear="on">
                      <option value=""></option>
                      @foreach($accounts as $account)
                        <option value="{{$account->account_no}}"> {{$account->account_no}}
                          || {{$account->user->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                  <div class="mb-1">
                    <input type="date" id="date" class="form-control check-date flatpickr-basic"
                           value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY"/>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                  <div class="mb-1">
                    <button type="button" class="btn rounded-pill btn-warning waves-effect waves-light btn-dps-info w-50">
                      সার্চ
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card collection-form">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-7">
                  <div class="row gx-1">
                    <div class="col-lg-12 my-1">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="collection_type[]"
                               id="dps_installment" value="dps_installment" checked>
                        <label class="form-check-label" for="dps_installment">বিশেষ সঞ্চয় </label>
                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="dps_amount">পরিমাণ</label>
                        <input type="number" class="form-control"
                               name="dps_amount" id="dps_amount"
                               placeholder="DPS AMOUNT" readonly>

                      </div>
                    </div>

                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="dps_installments">#কিস্তি সংখ্যা</label>
                        <input type="number" class="form-control "
                               name="dps_installments" id="dps_installments"
                               placeholder="# INSTALLMENTS">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="receipt_no">রিসিপ্ট নং</label>
                        <input type="text" class="form-control" name="receipt_no"
                               id="receipt_no"
                               placeholder="Note">

                      </div>
                    </div>

                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="late_fee">বিলম্ব ফি</label>
                        <input type="number" class="form-control" name="late_fee" id="late_fee"
                               placeholder="Late Fee">

                      </div>
                    </div>

                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="other_fee">অন্যান্য ফি</label>
                        <input type="number" class="form-control" name="other_fee"
                               id="other_fee"
                               placeholder="OTHER FEE">

                      </div>
                    </div>

                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="due">বকেয়া</label>
                        <input type="number" class="form-control" name="due" id="due"
                               placeholder="DUE">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="due_return">বকেয়া ফেরত</label>
                        <input type="number" class="form-control" name="due_return"
                               id="due_return"
                               placeholder="DUE RETURN">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="advance"> অগ্রিম</label>
                        <input type="number" class="form-control" name="advance" id="advance"
                               placeholder="ADVANCE">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="advance_return">অগ্রিম সমন্বয়  </label>
                        <input type="number" class="form-control" name="advance_return"
                               id="advance_return"
                               placeholder="ADVANCE">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="grace">ছাড়</label>
                        <input type="number" class="form-control" name="grace"
                               id="grace"
                               placeholder="GRACE">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="date">তারিখ</label>
                        <input type="date" class="form-control flatpickr-basic" name="date"
                               value="{{ date('Y-m-d') }}" id="date2">

                      </div>
                    </div>
                    <div class="col-lg-4 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="dps_note">নোট</label>
                        <input type="text" class="form-control" name="dps_note" id="dps_note"
                               placeholder="Note">

                      </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-12">
                      <div class="mb-1">
                        <select class="select2 form-select" name="deposited_via" id="deposited_via">
                          <option value="cash">ক্যাশ</option>
                          <option value="bkash"> বিকাশ</option>
                          <option value="nagad">নগদ</option>
                          <option value="bank">ব্যাংক</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-8 deposited_via_details">
                      <div class="mb-1">
                        <input type="text" class="form-control" name="deposited_via_details" id="deposited_via_details"
                               placeholder="ব্যাংক / বিকাশ/ নগদ তথ্য ">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-5">
                  <div class="row gx-1">
                    <div class="col-lg-12 my-1">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="collection_type[]"
                               id="loan_collection" value="loan_installment" checked>
                        <label class="form-check-label" for="loan_collection">বিশেষ ঋণ</label>
                      </div>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="loan_installment">ঋণ ফেরত</label>
                        <input type="number" class="form-control" name="loan_installment"
                               id="loan_installment"
                               placeholder="Installment">

                      </div>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="interest">লভ্যাংশ</label>
                        <input type="number" class="form-control" name="interest" id="interest"
                               placeholder=" " readonly>

                      </div>
                    </div>
                    <div class="col-lg-12 loan-list">
                      <table class="table table-sm"></table>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="due_interest">বকেয়া লভ্যাংশ</label>
                        <input type="number" class="form-control" name="due_interest"
                               id="due_interest"
                               placeholder=" ">

                      </div>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="loan_late_fee">বিলম্ব ফি</label>
                        <input type="number" class="form-control" name="loan_late_fee"
                               id="loan_late_fee"
                               placeholder="Late Fee">

                      </div>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="loan_other_fee">অন্যান্য ফি</label>
                        <input type="number" class="form-control" name="loan_other_fee"
                               id="loan_other_fee"
                               placeholder="Other Fee">

                      </div>
                    </div>
                    <div class="col-lg-6 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="loan_grace">ছাড়</label>
                        <input type="number" class="form-control" name="loan_grace"
                               id="loan_grace"
                               placeholder="GRACE">

                      </div>
                    </div>

                    <input type="hidden" id="user_id" name="user_id">
                    <input type="hidden" id="total_loan_interest" name="total_loan_interest">
                    <input type="hidden" id="dps_id" name="special_dps_id">
                    <input type="hidden" id="loan_id" name="special_dps_loan_id">
                    <input type="hidden" id="total" name="total">



                    <div class="col-lg-12 my-1">
                      <div class="form-group">
                        <label class="font-small-2 fw-bold" for="loan_note">নোট</label>
                        <input type="text" class="form-control" name="loan_note" id="loan_note"
                               placeholder="Note">

                      </div>
                    </div>

                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="button" class="btn rounded-pill btn-primary waves-effect waves-light btn-submit w-25" onclick="modalData()">
                    সাবমিট
                  </button>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
      <!--/ User Content -->
      <div class="col-md-3">
        <h6 class="bg-dark text-center text-white fw-bolder">সদস্যের সংক্ষিপ্ত বিবরণী</h6>
        <div id="info">

        </div>
      </div>
    </div>
    <div class="card my-3">
      <div class="card-body">
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
                    || {{$account->user->name}} </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xl-2 col-md-6 col-12">
            <div class="mb-1">

              <select name="s_collector" id="s_collector" class="form-control select2"
                      data-placeholder="Collector">
                <option value=""></option>

              </select>
            </div>
          </div>
          <div class="col-xl-2 col-md-6 col-12">
            <div class="mb-1">
              <input type="date" id="s_fromdate" name="s_fromdate"
                     class="form-control flatpickr-basic"
                     placeholder="From"/>
            </div>
          </div>
          <div class="col-xl-2 col-md-6 col-12">
            <div class="mb-1">
              <input type="date" class="form-control flatpickr-basic" name="s_todate"
                     id="s_todate" placeholder="To">
            </div>
          </div>

          <div class="col-xl-3 col-md-6 col-12">
            <button type="button" class="btn btn-gradient-info btn-savings-collection"
                    onclick="filterSavingsData()">
              Filter
            </button>
            <button type="button"
                    class="btn btn-gradient-danger btn-savings-collection-reset"
                    onclick="resetFilterSavings()">Reset
            </button>
          </div>

        </div>
      </div>
    </div>
    <div class="card my-3">
      <table class="datatables-basic table table-bordered table-sm">
        <thead class="table-light">
        <tr>
          <th class="fw-bolder py-2">নাম</th>
          <th class="fw-bolder py-2">হিসাব নং</th>
          <th class="fw-bolder py-2">জমা</th>
          <th class="fw-bolder py-2">ঋণ ফেরত</th>
          <th class="fw-bolder py-2">ঋণের লভ্যাংশ</th>
          <th class="fw-bolder py-2">সর্বমোট</th>
          <th class="fw-bolder py-2">তারিখ</th>
          <th class="fw-bolder py-2">এসএমএস </th>
          <th class="fw-bolder py-2">আদায়কারী</th>
          <th class="fw-bolder py-2"></th>
        </tr>
        </thead>
      </table>
    </div>
  </section>
  <div class="modal fade" id="modalCollection" tabindex="-1" aria-labelledby="modalCollectionTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-primary py-1">
          <h5 class="modal-title text-white" id="modalCollectionTitle">মাসিক সঞ্চয় জমা</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formCollection">
          @csrf
          <div class="modal-body">
            <table class="table table-sm table-collection-info">

            </table>
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
          <h5 class="modal-title" id="exampleModalCenterTitle">Edit Savings Collection</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-form">
            @csrf
            <div class="row">
              <input type="hidden" name="id">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">Name</label>: <span
                    class="edit-name text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">A/C No</label>: <span
                    class="edit-account-no text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">Savings Amount</label>
                  <input type="number" class="form-control savings_amount" name="saving_amount">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Date</label>
                  <input type="text" class="form-control date flatpickr-basic" name="date">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Late Fee</label>
                  <input type="number" class="form-control late_fee" name="late_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Other Fee</label>
                  <input type="number" class="form-control other_fee" name="other_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Savings Type</label>
                  <select name="type" class="type form-control">
                    <option value="">- Select Type -</option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Balance</label>
                  <input type="number" class="form-control balance" name="balance">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Collector</label>
                  <select name="collector_id" class="collector_id form-control">
                    <option value="">Select Collector</option>

                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Note</label>
                  <input type="text" class="form-control note" name="note">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-edit" data-bs-dismiss="modal">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit-loan-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Edit Loan Collection</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-loan-form">
            @csrf
            <div class="row">
              <input type="hidden" name="id">
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="first-name-column">Name</label>: <span
                    class="edit-name text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="last-name-column">A/C No</label>: <span
                    class="edit-account-no text-success"></span>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">Loan Installment</label>
                  <input type="number" class="form-control loan_installment" name="loan_installment">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="city-column">Installment No</label>
                  <input type="number" class="form-control installment_no" name="installment_no">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">Date</label>
                  <input type="text" class="form-control date flatpickr-basic" name="date">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Late Fee</label>
                  <input type="number" class="form-control loan_late_fee" name="loan_late_fee">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Other Fee</label>
                  <input type="number" class="form-control loan_other_fee" name="loan_other_fee">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label">Balance</label>
                  <input type="number" class="form-control loan_balance" name="loan_balance">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="company-column">Collector</label>
                  <select name="collector_id" class="collector_id form-control">
                    <option value="">Select Collector</option>

                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">Note</label>
                  <input type="text" class="form-control loan_note" name="loan_note">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-edit-loan" data-bs-dismiss="modal">Submit</button>
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
        <form action="{{ url('special-installment-import') }}" method="POST"
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

  <div class="modal fade" id="modalCollectionDetails" tabindex="-1" aria-labelledby="modalCollectionTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-primary py-1">
          <h5 class="modal-title text-white" id="modalCollectionTitle">সঞ্চয় জমা/ঋণ ফেরত/লভ্যাংশ আদায়</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-collection-details">

          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">বাতিল</button>
          <button type="button" class="btn btn-primary">প্রিন্ট</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalEditDpsInstallment" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-info py-0">
          <h5 class="modal-title fw-bolder pb-2 pt-3 text-white" id="exampleModalCenterTitle">বিশেষ সঞ্চয় আদায় সম্পাদন</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
        </div>
        <form id="editDpsInstallmentForm">
          @csrf
          @method("PUT")
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <h6 class="text-center fw-bolder">হিসাব নং - <span class="text-danger account_no"></span></h6>
              </div>
              <input type="hidden" name="id" class="edit_dps_installment_id">
              <input type="hidden" name="update_type" value="dps">
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="dps_amount">জমা পরিমান</label>
                  <input type="number" class="form-control "
                         name="dps_amount" id="edit_dps_amount"
                         placeholder="DPS AMOUNT" readonly>

                </div>
              </div>

              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_dps_installments">#কিস্তি সংখ্যা</label>
                  <input type="number" class="form-control "
                         name="dps_installments" id="edit_dps_installments"
                         placeholder="# INSTALLMENTS" min="1">

                </div>
              </div>
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_receipt_no">রিসিপ্ট নং</label>
                  <input type="text" class="form-control" name="receipt_no"
                         id="edit_receipt_no"
                         placeholder="Note">

                </div>
              </div>

              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_late_fee"> বিলম্ব ফি</label>
                  <input type="number" class="form-control" name="late_fee" id="edit_late_fee"
                         placeholder="Late Fee">

                </div>
              </div>

              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_other_fee">অন্যান্য ফি</label>
                  <input type="number" class="form-control" name="other_fee"
                         id="edit_other_fee"
                         placeholder="OTHER FEE">

                </div>
              </div>

              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_due">বকেয়া</label>
                  <input type="number" class="form-control" name="due" id="edit_due"
                         placeholder="DUE">

                </div>
              </div>
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_due_return">বকেয়া ফেরত</label>
                  <input type="number" class="form-control" name="due_return"
                         id="edit_due_return"
                         placeholder="DUE RETURN">

                </div>
              </div>
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_advance">অগ্রিম</label>
                  <input type="number" class="form-control" name="advance" id="edit_advance"
                         placeholder="ADVANCE">

                </div>
              </div>
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_advance_return">অগ্রিম সমন্বয়</label>

                  <input type="number" class="form-control" name="advance_return"
                         id="edit_advance_return"
                         placeholder="ADVANCE">
                </div>
              </div>
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_grace">ছাড়</label>

                  <input type="number" class="form-control" name="grace"
                         id="edit_grace"
                         placeholder="GRACE">
                </div>
              </div>
              <div class="col-lg-8 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_date">তারিখ</label>

                  <input type="text" class="form-control datepicker" name="date"
                         id="edit_date">
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_dps_note">নোট</label>

                  <input type="text" class="form-control" name="dps_note" id="edit_dps_note"
                         placeholder="Note">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-update-dps">
              আপডেট
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalEditLoanInstallment" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success py-0">
          <h5 class="modal-title fw-bolder pb-2 pt-3 text-white" id="exampleModalCenterTitle">বিশেষ ঋণ/লভ্যাংশ আদায় সম্পাদন</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
        </div>
        <form id="editLoanInstallmentForm">
          @csrf
          @method("PUT")
          <div class="modal-body">
            <input type="hidden" name="id">
            <input type="hidden" name="update_type" value="loan">
            <div class="row">
              <div class="col-md-12">
                <h6 class="text-center fw-bolder">হিসাব নং - <span class="text-danger account_no"></span></h6>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_loan_installment">ঋণ ফেরত</label>
                  <input type="number" class="form-control" name="loan_installment"
                         id="edit_loan_installment"
                         placeholder="Installment">

                </div>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_interest">লভ্যাংশ</label>
                  <input type="number" class="form-control" name="interest" id="edit_interest"
                         placeholder=" " readonly>

                </div>
              </div>
              <div class="col-lg-12 edit-loan-list">
                <table class="table table-sm"></table>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_due_interest">বকেয়া লভ্যাংশ</label>
                  <input type="number" class="form-control" name="due_interest"
                         id="edit_due_interest"
                         placeholder=" ">

                </div>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_loan_late_fee">বিলম্ব ফি</label>
                  <input type="number" class="form-control" name="loan_late_fee"
                         id="edit_loan_late_fee"
                         placeholder="Late Fee">

                </div>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_loan_other_fee">অন্যান্য ফি</label>
                  <input type="number" class="form-control" name="loan_other_fee"
                         id="edit_loan_other_fee"
                         placeholder="Other Fee">

                </div>
              </div>
              <div class="col-lg-6 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_loan_grace">ছাড়</label>
                  <input type="number" class="form-control" name="loan_grace"
                         id="edit_loan_grace"
                         placeholder="GRACE">

                </div>
              </div>
              <input type="hidden" id="edit_user_id" name="user_id">
              <input type="hidden" id="edit_total_loan_interest" name="total_loan_interest">
              <input type="hidden" id="edit_loan_id" name="special_dps_loan_id">
              <input type="hidden" id="edit_total" name="total">
              <div class="col-lg-4 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold">তারিখ</label>
                  <input type="text" class="form-control datepicker edit_date" name="date">

                </div>
              </div>
              <div class="col-lg-8 my-1">
                <div class="form-group">
                  <label class="font-small-2 fw-bold" for="edit_loan_note">নোট</label>
                  <input type="text" class="form-control" name="loan_note" id="edit_loan_note"
                         placeholder="Note">

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-update-loan">
              আপডেট
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection


@section('page-script')
  <script>

    $(".select2").select2();
    var taken_loans = '';
    var total_interest = 0;
    var dps_amount = 0;
    var dpsInstallments = 0;
    var account_holder = "";

    $(".deposited_via_details").hide();

    $("#deposited_via").on("select2:select",function (e) {
      var value = e.params.data.id;
      if (value !== 'cash')
      {
        $(".deposited_via_details").show();
      }else {
        $(".deposited_via_details").hide();
      }
    })
    //modalData();

    function modalData() {
      let account_no = $("#account_no option:selected").val();
      let dps_amount = $("#dps_amount").val();
      let dps_installments = $("#dps_installments").val();
      let receipt_no = $("#receipt_no").val();
      let late_fee = $("#late_fee").val();
      let other_fee = $("#other_fee").val();
      let due = $("#due").val();
      let due_return = $("#due_return").val();
      let advance = $("#advance").val();
      let advance_return = $("#advance_return").val();
      let date = $("#date").val();
      let dps_note = $("#dps_note").val();
      let grace = $("#grace").val();
      let acc_holder = account_holder;
      let loan_installment = $("#loan_installment").val();
      let interest = $("#interest").val();
      let due_interest = $("#due_interest").val();
      let loan_late_fee = $("#loan_late_fee").val();
      let loan_other_fee = $("#loan_other_fee").val();
      let loan_grace = $("#loan_grace").val();

      $(".table-collection-info").empty();
      var total = 0;

      if (dps_amount != 0) {
        total += parseInt(dps_amount);
        $(".table-collection-info").append(`

<tr>
                    <th class="py-1">নাম</th>
                    <td>${acc_holder}</td>
                </tr>
<tr>
                    <th class="py-1">হিসাব নং</th>
                    <td>${account_no}</td>
                </tr>
<tr>
                    <th class="py-1">তারিখ</th>
                    <td>${date}</td>
                </tr>
<tr>
                    <th class="py-1">রিসিপ্ট নং</th>
                    <td>${receipt_no}</td>
                </tr>
           <tr>
                    <th class="py-1">জমা</th>
                    <td class="text-end">${dps_amount}</td>
                </tr>
            `);
      }

      if (late_fee != "") {
        total += parseInt(late_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বিলম্ব ফি</th>
                    <td class="text-end">${late_fee}</td>
                </tr>
            `);
      }
      if (other_fee != "") {
        total += parseInt(other_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অন্যান্য ফি</th>
                    <td class="text-end">${other_fee}</td>
                </tr>
            `);
      }

      if (due != "") {
        total -= parseInt(due);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বকেয়া</th>
                    <td class="text-end">${due}</td>
                </tr>
            `);
      }
      if (due_return != "") {
        total += parseInt(due_return);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বকেয়া ফেরত</th>
                    <td class="text-end">${due_return}</td>
                </tr>
            `);
      }

      if (advance != "") {
        total += parseInt(advance);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অগ্রিম</th>
                    <td class="text-end">${advance}</td>
                </tr>
            `);
      }
      if (advance_return != "") {
        total -= parseInt(advance_return);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">অগ্রিম সমন্বয়</th>
                    <td class="text-end">${advance_return}</td>
                </tr>
            `);
      }


      if (grace != "") {
        total -= parseInt(grace);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ছাড়</th>
                    <td class="text-end">${grace}</td>
                </tr>
            `);
      }

      if (loan_installment != "") {
        total += parseInt(loan_installment);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ঋণ ফেরত</th>
                    <td class="text-end">${loan_installment}</td>
                </tr>
            `);
      }
      if (interest != "") {
        total += parseInt(interest);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ঋণের লভ্যাংশ</th>
                    <td class="text-end">${interest}</td>
                </tr>
            `);
      }

      if (due_interest != "") {
        total += parseInt(due_interest);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">বকেয়া লভ্যাংশ</th>
                    <td class="text-end">${due_interest}</td>
                </tr>
            `);
      }

      if (loan_late_fee != "") {
        total += parseInt(loan_late_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ঋণের বিলম্ব ফি</th>
                    <td class="text-end">${loan_late_fee}</td>
                </tr>
            `);
      }

      if (loan_other_fee != "") {
        total += parseInt(loan_other_fee);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ঋণের অন্যান্য ফি</th>
                    <td class="text-end">${loan_other_fee}</td>
                </tr>
            `);
      }
      if (loan_grace != "") {
        total -= parseInt(loan_grace);
        $(".table-collection-info").append(`
           <tr>
                    <th class="py-1">ঋণের ছাড়</th>
                    <td class="text-end">${loan_grace}</td>
                </tr>
            `);
      }

      $("#total").val(total);
      $(".table-collection-info").append(`
            <tfoot>
            <tr>
                <td class="fw-bolder text-end">সর্বমোট</td>
                <td class="text-dark total fw-bolder text-end p-0">${total}</td>
            </tr>
            </tfoot>
            `);

      $("#modalCollection").modal("show");
    }

    function resetForm() {
      $("#collectionForm").trigger('reset');
      $("#formCollection").trigger('reset');
      $('#account_no').val(null).trigger('change');
      $(".savings-info-list").empty();
      $(".loan-info-list").empty();
      $("#interestTable").empty();
      $(".loan-list table").empty();
      $("#interest").val("");

    }

    $(document).on("click", ".loan-list table input[type=checkbox]", function () {
      if ($(this).prop("checked") == true) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', false);
        var interest_rate = $(row).find("input[name='taken_interest[]']").val();
        var installments = $(row).find("input[name='interest_installment[]']").val();
        var interest = calculateInterest(interest_rate, installments);
        $(row).find("input[name='taken_total_interest[]']").val(interest);
        sumOfInterest();
      } else if ($(this).prop("checked") == false) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', true);
        $(row).find("input[name='taken_total_interest[]']").val(0);
        sumOfInterest();
      }
    });

    $(document).on("click", ".edit-loan-list table input[type=checkbox]", function () {
      if ($(this).prop("checked") == true) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', false);
        var interest_rate = $(row).find("input[name='taken_interest[]']").val();
        var installments = $(row).find("input[name='interest_installment[]']").val();
        var interest = calculateInterest(interest_rate, installments);
        $(row).find("input[name='taken_total_interest[]']").val(interest);
        editSumOfInterest();
      } else if ($(this).prop("checked") == false) {
        var row = $(this).closest('tr');
        $(row).find('td').eq(1).find('input').prop('disabled', true);
        $(row).find("input[name='taken_total_interest[]']").val(0);
        editSumOfInterest();
      }
    });

    $(document).on("change", ".loan-list table input[name='interest_installment[]']", function () {
      var row = $(this).closest('tr');
      var temp_total = total_interest;
      var temp_taken_total_interest = $(row).find("input[name='taken_total_interest[]']").val();
      var interest_rate = $(row).find("input[name='taken_interest[]']").val();
      var installments = $(this).val();
      var interest = calculateInterest(interest_rate, installments);
      $(row).find("input[name='taken_total_interest[]']").val(interest);
      sumOfInterest();
    });

    $(document).on("change", ".edit-loan-list table input[name='interest_installment[]']", function () {
      var row = $(this).closest('tr');
      var temp_total = total_interest;
      var temp_taken_total_interest = $(row).find("input[name='taken_total_interest[]']").val();
      var interest_rate = $(row).find("input[name='taken_interest[]']").val();
      var installments = $(this).val();
      var interest = calculateInterest(interest_rate, installments);
      $(row).find("input[name='taken_total_interest[]']").val(interest);
      editSumOfInterest();
    });

    $(document).on("change", "#dps_installments", function () {
      var installment = $(this).val();
      var total = totalDpsAmount(dps_amount, installment);
      $("#dps_amount").val(total);

    });


    function totalDpsAmount(amount, installment) {
      return amount * installment;
    }

    function calculateInterest(interest, installments) {
      return interest * installments;
    }

    function sumOfInterest() {
      var sum = 0;
      $('.taken_total_interest').each(function () {
        sum += Number($(this).val());
      });
      $("#interest").val(sum);
    }

    function editSumOfInterest() {
      var sum = 0;
      $('.edit_taken_total_interest').each(function () {
        sum += Number($(this).val());
      });
      $("#edit_interest").val(sum);
    }
    $("#edit_dps_installments").on("change",function () {
      let tempDps = temp_dps_amount* $(this).val();
      $("#edit_dps_amount").val(tempDps);

    })

    $(document).on("change", "input[name='collection_type[]']", function () {

      let tempDps = dps_amount;
      let temp_installment = dpsInstallments;
      if ($('#dps_installment').is(':checked') == false) {
        $("#dps_installments").val(0);
        //let total = totalDpsAmount(dps_amount, installment);
        $("#dps_amount").val(0);
      } else if ($('#dps_installment').is(':checked') == true) {
        let total = totalDpsAmount(tempDps, temp_installment);
        $("#dps_installments").val(temp_installment);
        $("#dps_amount").val(total);
      }

      if ($('#loan_collection').is(':checked') == false) {
        $("#interest").val(0);
      } else if ($('#loan_collection').is(':checked') == true) {
        sumOfInterest();
      }
    });



    $('.btn-dps-info').on('click', function (e) {
      var account_no = $("#account_no option:selected").val();
      var date = $("#date").val();
      total_interest = 0;
      $("#info").html("");
      $(".savings-info-list").empty();
      $(".loan-info-list").empty();
      $("#interestTable").empty();
      $(".loan-list table").empty();
      $("#interest").val("");
      $(".buttons").empty();
      $.ajax({
        url: "{{ url('special-dps-info') }}",
        dataType: "JSON",
        data: {account: account_no, date: date},
        success: function (data) {
          console.log(data);
          $("#info").html(`
          <div id="savings-info">
        <div class="info-container">
          <table class="savings-info-list w-100">

          </table>
        </div>
      </div>
      <div id="loan-info">
        <div class="info-container">

          <table id="interestTable" class="table table-sm table-bordered">

          </table>

        </div>
      </div>
      <div class="d-flex justify-content-center pt-2 buttons">
      </div>
          `);

          $("#dps_id").val(data.dpsInfo.id);
          var loanInfo = data.loanInfo;
          if (loanInfo != "") {
            $("#interestTable").append(`
                        <thead class="table-dark"> <tr>
                        <th class="p-0 text-center">ঋণের পরিমাণ</th>
                        <th class="p-0 text-center">অবশিষ্ট ঋণ</th>
                        <th class="p-0 text-center">সুদের হার</th>
                        <th class="p-0 text-center">বকেয়া কিস্তি</th>
                        </tr>
                        </thead>
                    `);
            $.each(loanInfo, function (a, b) {
              total_interest += parseInt(b.interest) * parseInt(b.dueInstallment);
              $("#interestTable").append(`
                             <tr class="font-small-2">
                            <td>${b.loanAmount}<small class="text-danger font-small-2" style="display: block;padding: 0">${b.commencement}</small></td>
                            <td>${b.loanRemain}</td>
                            <td>${b.interest}</td>
                            <td>${b.dueInstallment}</td>
                            </tr>
                        `);
              if (b.dueInstallment > 0) {
                $(".loan-list table").append(`

                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="special_loan_taken_id[]" id="loan_taken_id_${b.taken_loan_id}" value="${b.taken_loan_id}" checked>
                                                                            <label class="form-check-label" for="loan_taken_id_${b.taken_loan_id}">${b.interest}</label>
                                                                        </div>
                            </td>
                            <td style="width: 20%">
<input type="number" class="form-control px-1" name="interest_installment[]" min="1" step="1" max="${b.dueInstallment}" value="${b.dueInstallment}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control px-1 taken_total_interest" name="taken_total_interest[]" value="${b.dueInstallment * b.interest}" disabled></td>
                            </tr>

                            `);
              }
            })
            $("#interest").val(total_interest);
            $("#total_loan_interest").val(total_interest);
          }

          $("#user_id").val(data.user.id);
          $(".ac_holder").text(data.user.name);
          $("#offcanvasScrollLabel").text(data.user.name);
          $(".phone").text(data.user.phone1);
          $(".acc_no").text(data.dpsInfo.account_no);
          var dps = data.dpsInfo;
          var loan = data.loan;
          account_holder = data.user.name;
          dps_amount = dps.package_amount;
          dpsInstallments = data.dpsDue;
          $(".savings-balance h4").text(dps.balance);
          $("#dps_amount").val(dps.package_amount * data.dpsDue);
          $("#dps_installments").val(data.dpsDue);
          $(".buttons").append(`<a href="{{ url('special-dps') }}/${dps.id}" class="btn btn-sm btn-primary me-1">
                            Savings InFo
                        </a>`);
          $(".savings-info-list").append(`
<tr>
<td class="fw-bolder">নাম</td><td>:</td><td>${data.user.name}</td> <td rowspan="5" style="width: 110px;text-align: right">
<img src="{{ asset('images') }}/${data.user.image}" alt="" class="img-fluid">
</td>
</tr>
<tr>
<td class="fw-bolder">মোবাইল নং</td><td>:</td><td colspan="2">${data.user.phone1}</td>
</tr>
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">হিসাব নং</td><td>:</td>
                                        <td class="account_no px-1" colspan="2">${dps.account_no}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মাসিক পরিমাণ</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.package_amount}</td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মোট জমা</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.balance}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">মাসিক সঞ্চয় বকেয়া</td><td>:</td>
                                        <td class="total_withdraw px-1" colspan="2">${dps.package_amount} x ${data.dpsDue} = <span class="text-danger">${dps.package_amount * data.dpsDue}</span></td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">বকেয়া</td><td>:</td>
                                        <td class="total_due px-1" colspan="2">${data.due}</td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">WALLET</td><td>:</td>
                                        <td class="total_due px-1" colspan="2">${data.user.wallet}</td>
                                    </tr>
                    `);
          if (data.loan != "") {
            $(".buttons").append(`
                        <a href="{{ url('dps-loans') }}/${data.loan.id}" class="btn btn-sm btn-outline-sm btn-outline-danger suspend-user">ঋণ </a>
`);
            $("#loan_id").val(data.loan.id);
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">ঋণের পরিমাণ</td><td>:</td>
                                        <td class="account_no px-1">${loan.loan_amount}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">ঋণ ফেরত</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.loan_amount - loan.remain_loan}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">অবশিষ্ট ঋণ</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.remain_loan}</td>
                                    </tr>
                    `);
          }
          if (loan.dueInterest != null) {
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">বকেয়া সুদ</td><td>:</td>
                                        <td class="px-1">${loan.dueInterest}</td>
                                    </tr>
                    `);
          }


          if (data.lastLoanPayment != 'null') {
            $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">সর্বশেষ ঋণ ফেরত</td><td>:</td>
                                        <td class="account_no px-1">${data.lastLoanPayment.loan_installment}</td>
                                    </tr>

                    `);
          }

          if (data.loan != "") {
            $("#loan-info").show();
            $(".loan-balance").show();
            console.log(data.loan)
            var loan = data.loan;
            $(".loan-balance h4").text(loan.remain_loan);
          } else {
            $("#loan-info").hide();
            $(".loan-balance").hide();
            $(".loan-balance h4").text('');
          }

          if (data.user.profile_photo_path == null) {
            $(".profile-image").attr('src', data.user.profile_photo_url);
          }
        }
      });

    });


    $(".btn-confirm").on("click", function () {
      //$(".spinner").show();
      //$(".btn-confirm").attr('disabled',true);
      var $this = $(".btn-confirm"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "{{ route('special-installments.store') }}",
        method: "POST",
        data: $("#collectionForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          $("#modalCollection").modal("hide");
          toastr['success']('👋 Submission has been saved successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });

          resetForm();
          //bsOffcanvas.hide();
        },
        error: function (data) {
          $("#modalCollection").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Submission failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })

    loadSavingsCollection();
    var assetPath = $('body').attr('data-asset-path'),
      userView = '{{ url('users') }}/';

    function loadSavingsCollection(account = '', collector = '', from = '', to = '') {
      $('.datatables-basic').DataTable({
        "proccessing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
          "url": "{{ url('dataSpecialDpsInstallment') }}",
          type: "GET",
          data: {account: account, collector: collector, from: from, to: to}
        },
        "columns": [

          {"data": "name"},
          {"data": "account_no"},
          {"data": "dps_amount"},
          {"data": "loan_installment"},
          {"data": "interest"},
          {"data": "total"},
          {"data": "date"},
          {"data": "sent"},
          {"data": "collector"},
          {"data": "action"},
        ],
        createdRow: function (row, data, index) {
          $(row).addClass('font-small-2');
        },
        columnDefs: [
          {
            // Actions
            targets: 7,
            title: 'এসএমএস',
            orderable: false,
            render: function(data, type, full, meta) {
              var sent = ''; // Assuming 'sent' is a variable in your context

              if (full['sent']) {
                sent = 'হ্যাঁ';
              } else {
                sent = 'না';
              }

              var switchHtml = `<label class="switch switch-square switch-success switch-sm">
  <input type="checkbox" class="switch-input" ${full['sent'] ? 'checked disabled' : ''} onchange="confirmSwitch(this, ${full['sent']})">
  <span class="switch-toggle-slider">
    <span class="switch-on">
      <i class="ti ti-check"></i>
    </span>
    <span class="switch-off">
      <i class="ti ti-x"></i>
    </span>
  </span>
  <span class="switch-label">${sent}</span>
</label>`;

              return switchHtml;

            }
          },
          {
            // Actions
            targets: 9,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-inline-flex">' +
                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                '<i class="ti ti-dots"></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-end">' +
                '<a href="javascript:;" data-id="' + full['id'] + '"' +
                ' class="dropdown-item item-details">' +
                'বিস্তারিত দেখুন</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-dps">' +
                'সঞ্চয় সম্পাদন</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-loan">' +
                'ঋণ সম্পাদন</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item fw-bolder text-danger delete-record">' +
                'ডিলেট</a>' +
                '</div>' +
                '</div>'
              );
            }
          }
        ],
        dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
          '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
          '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: 'Search',
          searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
              }
            ],
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
              $(node).parent().removeClass('btn-group');
              setTimeout(function () {
                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
              }, 50);
            }
          }
        ],

      });
    }



    $(document).on("click", ".delete-record", function () {
      var id = $(this).attr('data-id');
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.ajax(
            {
              url: "special-installments/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                toastr['success']('👋 Delete successfully.', 'Success!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
                $(".datatables-basic").DataTable().destroy();
                loadSavingsCollection();
              },error: function (data) {
                toastr['error']('Delete Failed.', 'Failed!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
              }
            });
        }
      });
    })

    $(document).on("click", ".delete-loan-record", function () {
      var id = $(this).attr('data-id');
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.ajax(
            {
              url: "{{ url('dps-installments') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)
                toastr['success']('👋 Installment has been deleted successfully.', 'Success!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
                $(".datatables-loan-collection").DataTable().destroy();
                loadLoanCollection();
              },
              error: function (data) {
                toastr['error']('👋 Installment delete failed.', 'Failed!', {
                  closeButton: true,
                  tapToDismiss: false,
                });
              }
            });
        }
      });
    })

    $(document).on("click", ".item-details", function () {
      var id = $(this).data('id');
      $.ajax({
        url: "{{ url('getSpecialDpsCollectionData') }}/"+id,
        dataType: "JSON",
        success: function (data) {
          let acc_holder = data.dpsInstallment.user.name;
          let account_no = data.dpsInstallment.account_no;
          let dps_amount = data.dpsInstallment.dps_amount;
          let receipt_no = data.dpsInstallment.receipt_no;
          let late_fee = data.dpsInstallment.late_fee;
          let other_fee = data.dpsInstallment.other_fee;
          let due = data.dpsInstallment.due;
          let due_return = data.dpsInstallment.due_return;
          let advance = data.dpsInstallment.advance;
          let advance_return = data.dpsInstallment.advance_return;
          let date = data.dpsInstallment.date;
          let dps_note = data.dpsInstallment.dps_note;
          let grace = data.dpsInstallment.grace;
          let loan_installment = data.dpsInstallment.loan_installment;
          let interest = data.dpsInstallment.interest;
          let due_interest = data.dpsInstallment.due_interest;
          let loan_late_fee = data.dpsInstallment.loan_late_fee;
          let loan_other_fee = data.dpsInstallment.loan_other_fee;
          let loan_grace = data.dpsInstallment.loan_grace;

          $(".table-collection-details").empty();
          var total = 0;
          $(".table-collection-details").append(`

<tr>
                    <th class="py-1">নাম</th>
                    <td>${acc_holder}</td>
                </tr>
<tr>
                    <th class="py-1">হিসাব নং</th>
                    <td>${account_no}</td>
                </tr>
<tr>
                    <th class="py-1">তারিখ</th>
                    <td>${date}</td>
                </tr>
<tr>
                    <th class="py-1">রিসিপ্ট নং</th>
                    <td>${receipt_no}</td>
                </tr>

            `);
          if (dps_amount !== null && dps_amount !== "" && dps_amount != 0) {
            total += parseInt(dps_amount);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">জমা</th>
      <td class="text-end">${dps_amount}</td>
    </tr>
  `);
          }

          if (late_fee !== null && late_fee !== "") {
            total += parseInt(late_fee);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">বিলম্ব ফি</th>
      <td class="text-end">${late_fee}</td>
    </tr>
  `);
          }

          if (other_fee !== null && other_fee !== "") {
            total += parseInt(other_fee);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">অন্যান্য ফি</th>
      <td class="text-end">${other_fee}</td>
    </tr>
  `);
          }

          if (due !== null && due !== "") {
            total -= parseInt(due);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">বকেয়া</th>
      <td class="text-end">${due}</td>
    </tr>
  `);
          }

          if (due_return !== null && due_return !== "") {
            total += parseInt(due_return);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">বকেয়া ফেরত</th>
      <td class="text-end">${due_return}</td>
    </tr>
  `);
          }

          if (advance !== null && advance !== "") {
            total += parseInt(advance);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">অগ্রিম</th>
      <td class="text-end">${advance}</td>
    </tr>
  `);
          }

          if (advance_return !== null && advance_return !== "") {
            total -= parseInt(advance_return);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">অগ্রিম সমন্বয়</th>
      <td class="text-end text-danger">${advance_return}</td>
    </tr>
  `);
          }

          if (grace !== null && grace !== "") {
            total -= parseInt(grace);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ছাড়</th>
      <td class="text-end text-danger">${grace}</td>
    </tr>
  `);
          }

          if (loan_installment !== null && loan_installment !== "") {
            total += parseInt(loan_installment);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ঋণ ফেরত</th>
      <td class="text-end">${loan_installment}</td>
    </tr>
  `);
          }

          if (interest !== null && interest !== "") {
            total += parseInt(interest);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ঋণের লভ্যাংশ</th>
      <td class="text-end">${interest}</td>
    </tr>
  `);
          }

          if (due_interest !== null && due_interest !== "") {
            total += parseInt(due_interest);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">বকেয়া লভ্যাংশ</th>
      <td class="text-end">${due_interest}</td>
    </tr>
  `);
          }

          if (loan_late_fee !== null && loan_late_fee !== "") {
            total += parseInt(loan_late_fee);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ঋণের বিলম্ব ফি</th>
      <td class="text-end">${loan_late_fee}</td>
    </tr>
  `);
          }

          if (loan_other_fee !== null && loan_other_fee !== "") {
            total += parseInt(loan_other_fee);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ঋণের অন্যান্য ফি</th>
      <td class="text-end">${loan_other_fee}</td>
    </tr>
  `);
          }

          if (loan_grace !== null && loan_grace !== "") {
            total -= parseInt(loan_grace);
            $(".table-collection-details").append(`
    <tr>
      <th class="py-1">ঋণের ছাড়</th>
      <td class="text-end text-danger">${loan_grace}</td>
    </tr>
  `);
          }

          $("#total").val(total);
          $(".table-collection-details").append(`
            <tfoot>
            <tr>
                <td class="fw-bolder text-end">সর্বমোট</td>
                <td class="text-dark total fw-bolder text-end p-0">${total}</td>
            </tr>
            </tfoot>
            `);

          $("#modalCollectionDetails").modal("show");
        }
      })
    })

    var editDate = $('#edit_date');


    function padTo2Digits(num) {
      return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
      return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
      ].join('-');
    }
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
      $("#s_fromdate").empty();
      $("#s_todate").empty();
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
      $("#l_fromdate").val('');
      $("#l_todate").val('');
      loadLoanCollection();
    }

    $(document).on("click",".edit-dps",function () {
      var id = $(this).attr('data-id');
      $("#editDpsInstallmentForm").trigger("reset");
      $.ajax({
        url: "{{ url('getSpecialDpsCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          console.log(data);
          let paymentDate = formatDate(new Date(data.dpsInstallment.date));


          temp_dps_amount = data.dpsCollection.dps_amount;
          let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
          $(".account_no").text(data.dpsInstallment.account_no);
          $("#editDpsInstallmentForm input[name='id']").val(data.dpsInstallment.id);
          $("#editDpsInstallmentForm input[name='dps_amount']").val(dpsAmount);
          $("#editDpsInstallmentForm input[name='dps_installments']").val(data.dpsInstallment.dps_installments);
          $("#editDpsInstallmentForm input[name='receipt_no']").val(data.dpsInstallment.receipt_no);
          $("#editDpsInstallmentForm input[name='late_fee']").val(data.dpsInstallment.late_fee);
          $("#editDpsInstallmentForm input[name='other_fee']").val(data.dpsInstallment.other_fee);
          $("#editDpsInstallmentForm input[name='due']").val(data.dpsInstallment.due);
          $("#editDpsInstallmentForm input[name='due_return']").val(data.dpsInstallment.due_return);
          $("#editDpsInstallmentForm input[name='advance']").val(data.dpsInstallment.advance);
          $("#editDpsInstallmentForm input[name='advance_return']").val(data.dpsInstallment.advance_return);
          $("#editDpsInstallmentForm input[name='grace']").val(data.dpsInstallment.grace);
          $("#editDpsInstallmentForm input[name='date']").val(data.dpsInstallment.date);
          $("#editDpsInstallmentForm input[name='dps_note']").val(data.dpsInstallment.dps_note);
        }
      })
      $("#modalEditDpsInstallment").modal("show");
    })
    $(document).on("click",".edit-loan",function () {
      var id = $(this).attr('data-id');
      $("#editLoanInstallmentForm").trigger("reset");
      $(".edit-loan-list table").empty();
      total_interest = 0;
      $.ajax({
        url: "{{ url('getSpecialDpsLoanCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
          console.log(data);
          let paymentDate = formatDate(new Date(data.dpsInstallment.date));


          //temp_dps_amount = data.dpsCollection.dps_amount;
          //let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
          $(".account_no").text(data.dpsInstallment.account_no);
          $("#editLoanInstallmentForm input[name='id']").val(data.dpsInstallment.id);
          $("#editLoanInstallmentForm input[name='user_id']").val(data.dpsInstallment.user_id);
          $("#editLoanInstallmentForm input[name='special_dps_loan_id']").val(data.dpsInstallment.special_dps_loan_id);
          $("#editLoanInstallmentForm input[name='loan_installment']").val(data.dpsInstallment.loan_installment);
          $("#editLoanInstallmentForm input[name='interest']").val(data.dpsInstallment.interest);
          $("#editLoanInstallmentForm input[name='due_interest']").val(data.dpsInstallment.due_interest);
          $("#editLoanInstallmentForm input[name='loan_late_fee']").val(data.dpsInstallment.loan_late_fee);
          $("#editLoanInstallmentForm input[name='loan_other_fee']").val(data.dpsInstallment.loan_other_fee);
          $("#editLoanInstallmentForm input[name='loan_grace']").val(data.dpsInstallment.loan_grace);
          $("#editLoanInstallmentForm input[name='loan_note']").val(data.dpsInstallment.loan_note);
          $("#editLoanInstallmentForm input[name='date']").val(data.dpsInstallment.date);
          let loanInfo = data.loanInterests;
          $.each(loanInfo, function (a, b) {
            total_interest += parseInt(b.interest) * parseInt(b.installments);
            if (b.installments > 0) {
              $(".edit-loan-list table").append(`
                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="special_loan_taken_id[]" id="loan_taken_id_${b.special_loan_taken_id}" value="${b.special_loan_taken_id}" checked>
                                                                            <label class="form-check-label" for="loan_taken_id_${b.special_loan_taken_id}">${b.interest}</label>
                                                                        </div>
                            </td>
                            <td style="width: 15%">
<input type="number" class="form-control px-1" name="interest_installment[]" min="1" step="1" value="${b.installments}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control px-1 edit_taken_total_interest" name="taken_total_interest[]" value="${b.installments * b.interest}" disabled></td>
                            </tr>

                            `);
            }
          })
          $("#edit_interest").val(total_interest);
          $("#edit_total_loan_interest").val(total_interest);
        }
      })
      $("#modalEditLoanInstallment").modal("show");
    })
    $(document).on("click",".btn-update-dps",function () {
      var id = $("#editDpsInstallmentForm input[name='id']").val();
      var $this = $(".btn-update-dps"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "special-installments/" + id,
        method: "POST",
        data: $("#editDpsInstallmentForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalEditDpsInstallment").modal("hide");
          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          toastr['success']('সঞ্চয় জমা আপডেট করা হয়েছে।', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });


        },
        error: function (data) {
          $("#modalEditDpsInstallment").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('আপডেট ব্যর্থ হয়েছে। আবার চেষ্টা করুন। ', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })
    $(document).on("click",".btn-update-loan",function () {
      var id = $("#editLoanInstallmentForm input[name='id']").val();
      var $this = $(".btn-update-loan"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "special-installments/" + id,
        method: "POST",
        data: $("#editLoanInstallmentForm").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalEditLoanInstallment").modal("hide");
          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          toastr['success']('আপডেট সফল হয়েছে।', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });


        },
        error: function (data) {
          $("#modalEditLoanInstallment").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('আপডেট ব্যর্থ হয়েছে। আবার চেষ্টা করুন।', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })
  </script>

  <script>
    document.addEventListener('change', function(event) {
      const target = event.target;

      if (target.classList.contains('switch-input')) {
        const switchLabel = target.closest('.switch').querySelector('.switch-label');
        switchLabel.innerText = target.checked ? 'হ্যাঁ' : 'না';
      }
    });

    function confirmSwitch(input, isSent) {
      if (!isSent) {
        Swal.fire({
          title: 'গ্রাহককে এসএমএস পাঠাতে চাইছেন?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'হ্যাঁ',
          cancelButtonText: 'না',
          customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
          },
          buttonsStyling: false
        }).then(function (result) {
          if (result.isConfirmed) {
            input.disabled = true;
            input.checked = true;

            const switchLabel = input.closest('.switch').querySelector('.switch-label');
            switchLabel.innerText = 'হ্যাঁ';
          } else {
            // If canceled, keep the switch off
            input.checked = false;
            input.disabled = false;

            const switchLabel = input.closest('.switch').querySelector('.switch-label');
            switchLabel.innerText = 'না';
          }
        });
      }
    }


  </script>
@endsection


{{--
<script>
  $(".btn-edit-loan").on("click", function () {
    var id = $("input[name='id']").val();
    var $this = $(".btn-edit-loan"); //submit button selector using ID
    var $caption = $this.html();// We store the html content of the submit button
    $.ajax({
      url: "daily-loan-collections/" + id,
      method: "PUT",
      data: $("#edit-loan-form").serialize(),
      beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
        $this.attr('disabled', true).html("Processing...");
      },
      success: function (data) {
        $this.attr('disabled', false).html($caption);
        $("#edit-loan-collection-modal").modal("hide");
        toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
          closeButton: true,
          tapToDismiss: false,
        });
        $(".datatables-loan-collection").DataTable().destroy();
        loadLoanCollection();

        resetForm();

      },
      error: function (data) {
        $("#edit-loan-collection-modal").modal("hide");
        $this.attr('disabled', false).html($caption);
        toastr['error']('Submission failed. Please try again.', 'Error!', {
          closeButton: true,
          tapToDismiss: false,
        });
      }
    })
  })
  var editDate = $('#edit_date');


  function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
  }


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
    $("#s_fromdate").empty();
    $("#s_todate").empty();
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
    $("#l_fromdate").val('');
    $("#l_todate").val('');
    loadLoanCollection();
  }


  $(document).on("click",".edit-dps",function () {
    var id = $(this).attr('data-id');
    $("#editDpsInstallmentForm").trigger("reset");
    $.ajax({
      url: "{{ url('getSpecialDpsCollectionData') }}/" + id,
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        let paymentDate = formatDate(new Date(data.dpsInstallment.date));

        editDate.val(paymentDate);
        temp_dps_amount = data.dpsCollection.dps_amount;
        let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
        $(".account_no").text(data.dpsInstallment.account_no);
        $("#editDpsInstallmentForm input[name='id']").val(data.dpsInstallment.id);
        $("#editDpsInstallmentForm input[name='dps_amount']").val(dpsAmount);
        $("#editDpsInstallmentForm input[name='dps_installments']").val(data.dpsInstallment.dps_installments);
        $("#editDpsInstallmentForm input[name='receipt_no']").val(data.dpsInstallment.receipt_no);
        $("#editDpsInstallmentForm input[name='late_fee']").val(data.dpsInstallment.late_fee);
        $("#editDpsInstallmentForm input[name='other_fee']").val(data.dpsInstallment.other_fee);
        $("#editDpsInstallmentForm input[name='due']").val(data.dpsInstallment.due);
        $("#editDpsInstallmentForm input[name='due_return']").val(data.dpsInstallment.due_return);
        $("#editDpsInstallmentForm input[name='advance']").val(data.dpsInstallment.advance);
        $("#editDpsInstallmentForm input[name='advance_return']").val(data.dpsInstallment.advance_return);
        $("#editDpsInstallmentForm input[name='grace']").val(data.dpsInstallment.grace);
        //$("#editDpsInstallmentForm input[name='date']").val(data.date);
        $("#editDpsInstallmentForm input[name='dps_note']").val(data.dpsInstallment.dps_note);
      }
    })
    $("#modalEditDpsInstallment").modal("show");
  })
  $(document).on("click",".edit-loan",function () {
    var id = $(this).attr('data-id');
    $("#editLoanInstallmentForm").trigger("reset");
    $(".edit-loan-list table").empty();
    total_interest = 0;
    $.ajax({
      url: "{{ url('getSpecialDpsLoanCollectionData') }}/" + id,
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        let paymentDate = formatDate(new Date(data.dpsInstallment.date));

        $(".edit_date").val(paymentDate);
        //temp_dps_amount = data.dpsCollection.dps_amount;
        //let dpsAmount = data.dpsCollection.dps_amount * data.dpsInstallment.dps_installments;
        $(".account_no").text(data.dpsInstallment.account_no);
        $("#editLoanInstallmentForm input[name='id']").val(data.dpsInstallment.id);
        $("#editLoanInstallmentForm input[name='user_id']").val(data.dpsInstallment.user_id);
        $("#editLoanInstallmentForm input[name='special_dps_loan_id']").val(data.dpsInstallment.special_dps_loan_id);
        $("#editLoanInstallmentForm input[name='loan_installment']").val(data.dpsInstallment.loan_installment);
        $("#editLoanInstallmentForm input[name='interest']").val(data.dpsInstallment.interest);
        $("#editLoanInstallmentForm input[name='due_interest']").val(data.dpsInstallment.due_interest);
        $("#editLoanInstallmentForm input[name='loan_late_fee']").val(data.dpsInstallment.loan_late_fee);
        $("#editLoanInstallmentForm input[name='loan_other_fee']").val(data.dpsInstallment.loan_other_fee);
        $("#editLoanInstallmentForm input[name='loan_grace']").val(data.dpsInstallment.loan_grace);
        $("#editLoanInstallmentForm input[name='loan_note']").val(data.dpsInstallment.loan_note);
        let loanInfo = data.loanInterests;
        $.each(loanInfo, function (a, b) {
          total_interest += parseInt(b.interest) * parseInt(b.installments);
          if (b.installments > 0) {
            $(".edit-loan-list table").append(`
                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="special_loan_taken_id[]" id="loan_taken_id_${b.special_loan_taken_id}" value="${b.special_loan_taken_id}" checked>
                                                                            <label class="form-check-label" for="loan_taken_id_${b.special_loan_taken_id}">${b.interest}</label>
                                                                        </div>
                            </td>
                            <td style="width: 15%">
<input type="number" class="form-control " name="interest_installment[]" min="1" step="1" value="${b.installments}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control  edit_taken_total_interest" name="taken_total_interest[]" value="${b.installments * b.interest}" disabled></td>
                            </tr>

                            `);
          }
        })
        $("#edit_interest").val(total_interest);
        $("#edit_total_loan_interest").val(total_interest);
      }
    })
    $("#modalEditLoanInstallment").modal("show");
  })
  $(document).on("click",".btn-update-dps",function () {
    var id = $("#editDpsInstallmentForm input[name='id']").val();
    var $this = $(".btn-update-dps"); //submit button selector using ID
    var $caption = $this.html();// We store the html content of the submit button
    $.ajax({
      url: "dps-installments/" + id,
      method: "POST",
      data: $("#editDpsInstallmentForm").serialize(),
      beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
        $this.attr('disabled', true).html("Processing...");
      },
      success: function (data) {
        $this.attr('disabled', false).html($caption);
        $("#modalEditDpsInstallment").modal("hide");
        toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
          closeButton: true,
          tapToDismiss: false,
        });


      },
      error: function (data) {
        $("#modalEditDpsInstallment").modal("hide");
        $this.attr('disabled', false).html($caption);
        toastr['error']('Submission failed. Please try again.', 'Error!', {
          closeButton: true,
          tapToDismiss: false,
        });
      }
    })
  })
  $(document).on("click",".btn-update-loan",function () {
    var id = $("#editLoanInstallmentForm input[name='id']").val();
    var $this = $(".btn-update-loan"); //submit button selector using ID
    var $caption = $this.html();// We store the html content of the submit button
    $.ajax({
      url: "special-installments/" + id,
      method: "POST",
      data: $("#editLoanInstallmentForm").serialize(),
      beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
        $this.attr('disabled', true).html("Processing...");
      },
      success: function (data) {
        $this.attr('disabled', false).html($caption);
        $("#modalEditLoanInstallment").modal("hide");
        toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
          closeButton: true,
          tapToDismiss: false,
        });


      },
      error: function (data) {
        $("#modalEditLoanInstallment").modal("hide");
        $this.attr('disabled', false).html($caption);
        toastr['error']('Submission failed. Please try again.', 'Error!', {
          closeButton: true,
          tapToDismiss: false,
        });
      }
    })
  })
</script>--}}
