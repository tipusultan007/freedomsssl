@extends('layouts/layoutMaster')

@section('title', $dps->account_no.' - বিশেষ সঞ্চয়')

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
  <section class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li><li class="breadcrumb-item">
            <a href="{{ url('special-dps') }}">বিশেষ সঞ্চয় তালিকা</a>
          </li>
          <li class="breadcrumb-item active">বিশেষ সঞ্চয় - {{ $dps->account_no }}</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('special-dps.edit',$dps->id) }}" target="_blank">এডিট করুন</a>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img
                  class="img-fluid rounded mt-3 mb-2"
                  src="{{ asset('storage/images/profile') }}/{{ $dps->user->image??'' }}"
                  height="110"
                  width="110"
                  alt="User avatar"
                />
                <div class="user-info text-center">
                  <h6>
                    <a href="{{ url('users') }}/{{ $dps->user_id }}">{{ $dps->user->name }}</a>
                  </h6>
                  <span>{{ $dps->user->phone1 }}</span>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-around my-2 pt-75">
              @php
                $loan = \App\Models\DpsLoan::where('account_no',$dps->account_no)->first();
              @endphp
              <table class="table table-sm text-center table-bordered">
                <tr>
                  <th class="py-1 fw-bolder">জমা</th>
                  <th class="py-1 fw-bolder">অবশিষ্ট ঋণ</th>
                </tr>
                <tr>
                  <td>{{ $dps->balance }}</td>
                  <td>{{ $dps->givenLoans->sum('remain') }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-3">
            <table class="table table-sm table-bordered">
              <tr>
                <th class="py-1 fw-bolder">হিসাব নং</th>
                <td>{{ $dps->account_no }}</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">প্যাকেজ</th>
                <td>{{ $dps->specialDpsPackage->name }}</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">মাসিক জমা পরিমাণ</th>
                <td>{{ $dps->package_amount }}</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">তারিখ</th>
                <td>{{ date('d/m/Y',strtotime($dps->opening_date)) }}</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">হিসাব শুরু</th>
                <td>{{ date('d/m/Y',strtotime($dps->commencement)) }}</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">মেয়াদ</th>
                <td>{{ $dps->duration }} বছর</td>
              </tr>
              <tr>
                <th class="py-1 fw-bolder">স্ট্যাটাস</th>
                <td>
                  @if($dps->status=='active')
                    <span class="badge bg-success">চলমান</span>
                  @else
                    <span class="badge bg-danger">বন্ধ</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  @if($dps->status=='active')
                    <button class="btn rounded-pill btn-sm btn-warning waves-effect waves-light"
                            id="btn-complete">হিসাব সম্পন্ন করুণ
                    </button>
                  @else
                    <a href="{{ route('active.special.dps',$dps->id) }}" class="btn-btn-success">চালু করুন</a>
                  @endif
                  <button data-id="{{ $dps->id }}" class="btn rounded-pill btn-sm btn-danger waves-effect waves-light"
                          id="item-reset">হিসাব রিসেট করুণ
                  </button>
                </td>
              </tr>
            </table>
          </div>
          <div class="col-md-3">
            @php
              $nominee = \App\Models\Nominees::where('account_no',$dps->account_no)->first();
            @endphp
            @if($nominee)
              <table class="table table-sm table-bordered">
                <tr>
                  <th colspan="2" class="text-center fw-bolder py-1">নমিনী - ০১</th>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">নাম:</th>
                  <td><a
                      href="{{ url('users') }}/{{ $nominee->user_id??'#' }}">{{ $nominee->name??'' }}</a></td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">মোবাইল:</th>
                  <td>{{ $nominee->phone??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">ঠিকানা:</th>
                  <td>{{ $nominee->address??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">সম্পর্ক:</th>
                  <td>{{ $nominee->relation??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">অংশ:</th>
                  <td>{{ $nominee->percentage.'%'??'' }}</td>
                </tr>
              </table>
            @endif
          </div>
          <div class="col-md-3">
            @if($nominee)
              <table class="table table-sm table-bordered">
                <tr>
                  <th colspan="2" class="text-center fw-bolder py-1">নমিনী - ০২</th>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">নাম:</th>
                  <td><a
                      href="{{ url('users') }}/{{ $nominee->user_id1??'#' }}">{{ $nominee->name1??'' }}</a></td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">মোবাইল:</th>
                  <td>{{ $nominee->phone1??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">ঠিকানা:</th>
                  <td>{{ $nominee->address1??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">সম্পর্ক:</th>
                  <td>{{ $nominee->relation1??'' }}</td>
                </tr>
                <tr>
                  <th class="py-1 fw-bolder">অংশ:</th>
                  <td>{{ $nominee->percentage1.'%'??'' }}</td>
                </tr>
              </table>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row">


      <!-- User Content -->
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1 my-4">
        <!-- User Pills -->
        <ul class="nav nav-tabs nav-justified" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="savings-tab"
              data-bs-toggle="tab"
              href="#savingAccount"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">মাসিক সঞ্চয় জমা</span></a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="loans-tab"
              data-bs-toggle="tab"
              href="#loanAccount"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">মাসিক ঋণের তালিকা</span></a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="closing-transactions-tab"
              data-bs-toggle="tab"
              href="#closingTransactions"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">উত্তোলন</span></a>
          </li>

        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
            <!-- Project table -->
            <table class="datatables-basic table table-sm table-bordered">
              <thead class="table-light py-0">
              <tr>
                <th class="fs-6 fw-bolder py-1">তারিখ</th>
                <th class="fs-6 fw-bolder py-1">সঞ্চয়</th>
                <th class="fs-6 fw-bolder py-1">ঋণ</th>
                <th class="fs-6 fw-bolder py-1">সুদ</th>
                <th class="fs-6 fw-bolder py-1">সর্বমোট</th>
                <th class="fs-6 fw-bolder py-1">আদায়কারী</th>
                <th class="fs-6 fw-bolder py-1">এসএমএস</th>
                <th class="fs-6 fw-bolder py-1">#</th>
              </tr>
              </thead>
            </table>
            <!-- /Project table -->
          </div>
          <div class="tab-pane " id="loanAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="table table-sm table-bordered">
              <thead class="table-light py-0">
              <tr>
                <th class="fs-6 fw-bolder py-1">ঋনের পরিমাণ</th>
                <th class="fs-6 fw-bolder py-1">সুদের হার</th>
                <th class="fs-6 fw-bolder py-1">অবশিষ্ট ঋণ</th>
                <th class="fs-6 fw-bolder py-1">তারিখ</th>
                <th class="fs-6 fw-bolder py-1">হিসাব শুরু</th>
                <th class="fs-6 fw-bolder py-1">আগে-পরে ব্যালেন্স</th>
                <th class="fs-6 fw-bolder py-1">#</th>
              </tr>
              </thead>

              @forelse($dps->givenLoans as $loan)
                <tr>
                  <td>{{ $loan->loan_amount}}</td>
                  <td>{{ $loan->interest1}} {{ $loan->interest2?" | ".$loan->interest2:"" }}</td>
                  <td>{{ $loan->remain}}</td>
                  <td>{{ date('d/m/Y',strtotime($loan->date))}}</td>
                  <td>{{ date('d/m/Y',strtotime($loan->commencement)) }}</td>
                  <td>{{ $loan->before_loan."-".$loan->after_loan }}</td>
                  <td>
                    <div class="dropdown chart-dropdown">
                      <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer" data-bs-toggle="dropdown"></i>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('special-loan-takens.show',$loan->id) }}">বিস্তারিত দেখুন</a>
                        <a class="dropdown-item" href="{{ route('special-loan-takens.edit',$loan->id) }}">এডিট করুন </a>
                        <a class="dropdown-item reset-taken-loan" data-id="{{ $loan->id }}" href="javascript:;">রিসেট করুণ</a>
                        <a class="dropdown-item delete-taken-loan" data-id="{{ $loan->id }}" href="javascript:;">ডিলেট</a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty

              @endforelse
            </table>
          </div>
          <div class="tab-pane " id="closingTransactions" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="table table-sm table-bordered">
              <thead class="table-light py-0">
              <tr>
                <th class="fs-6 fw-bolder py-1">তারিখ</th>
                <th class="fs-6 fw-bolder py-1">সঞ্চয় উত্তোলন</th>
                <th class="fs-6 fw-bolder py-1">মুনাফা উত্তোলন</th>
                <th class="fs-6 fw-bolder py-1">ঋন ফেরত</th>
                <th class="fs-6 fw-bolder py-1">ঋণের লভ্যাংশ</th>
                <th class="fs-6 fw-bolder py-1">ছাড়</th>
                <th class="fs-6 fw-bolder py-1">উত্তোলন ফি</th>
                <th class="fs-6 fw-bolder py-1">কর্মীর নাম</th>
                <th class="fs-6 fw-bolder py-1">#</th>
              </tr>
              </thead>

              @forelse($dps->dpsCompletes as $complete)
                <tr>
                  <td>{{ date('d/m/Y',strtotime($complete->date))}}</td>
                  <td>{{ $complete->withdraw??"-"}}</td>
                  <td>{{ $complete->profit??'-' }}</td>
                  <td>{{ $complete->loan_payment??'-' }}</td>
                  <td>{{ $complete->interest??'-' }}</td>
                  <td>{{ $complete->grace??'-' }}</td>
                  <td>{{ $complete->service_fee??'-' }}</td>
                  <td>{{ $complete->manager->name??'-' }}</td>
                  <td>
                    <div class="dropdown chart-dropdown">
                      <i class="ti ti-dots-vertical font-medium-3 text-primary cursor-pointer" data-bs-toggle="dropdown"></i>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-info edit-dps-complete" href="javascript:;" data-id="{{ $complete->id }}">এডিট করুন </a>
                        <a class="dropdown-item text-danger delete-dps-complete" data-id="{{ $complete->id }}" href="javascript:;">ডিলেট</a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty

              @endforelse
            </table>
          </div>
        </div>

      </div>
      <!--/ User Content -->
    </div>
  </section>
  <div class="modal fade" id="modalComplete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="modalCenterTitle">সঞ্চয় হিসাব প্রত্যাহার ফরম</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form class="complete-form" action="{{ route('special-dps-complete.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            @php
              $activeLoan =\App\Models\SpecialDpsLoan::where('account_no',$dps->account_no)->where('remain_loan','>',0)->first();
            @endphp
            <input type="hidden" name="user_id" value="{{ $dps->user_id }}">
            <input type="hidden" name="special_dps_id" value="{{ $dps->id }}">
            <input type="hidden" name="account_no" value="{{ $dps->account_no }}">
            <table class="table table-sm table-borderless">
              <tr>
                <th class="fw-bolder py-2">সঞ্চয় জমা</th>
                <td><input type="text" name="withdraw" value="{{ $dps->balance }}" class="form-control form-control-sm rounded-0 text-end withdraw"></td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">সঞ্চয়ের লভ্যাংশ</th>
                <td><input type="text" name="profit" value="{{ $dps->profit }}" class="form-control form-control-sm rounded-0 text-end profit"></td>
              </tr>
              @if($activeLoan)
                <input type="hidden" name="special_dps_loan_id" value="{{ $activeLoan->id }}">
                <tr>
                  <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
                  <td><input type="text" name="loan_payment" value="{{ $activeLoan->remain_loan }}" class="form-control form-control-sm rounded-0 text-end loan_payment"></td>
                </tr>

                <tr>
                  <th class="fw-bolder py-2">ঋণের লভ্যাংশ</th>
                  <td><input type="text" name="interest" value="{{ \App\Helpers\Helpers::getSpecialInterest($dps->account_no,date('Y-m-d'),'interest') }}" class="form-control form-control-sm rounded-0 text-end interest"></td>
                </tr>
                <tr>
                  <th class="fw-bolder py-2">ঋণ মওকুফ</th>
                  <td><input type="text" name="grace" value="0" class="form-control form-control-sm rounded-0 text-end grace"></td>
                </tr>
              @endif
              <tr>
                <th class="fw-bolder py-2">হিসাব প্রত্যাহার ফি</th>
                <td><input type="text" name="service_fee" value="100" class="form-control form-control-sm rounded-0 text-end service_charge"></td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">তারিখ</th>
                <td><input type="text" name="date" value="{{ date('Y-m-d') }}" class="form-control form-control-sm datepicker rounded-0 text-end date"></td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">সর্বমোট</th>
                <td class="text-end"><span class="total px-2"></span></td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
            <button type="submit" class="btn btn-primary btn-complete-submit">সাবমিট</button>
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
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Edit DPS Installment <span class="text-success account_no"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
        </div>
        <form id="editDpsInstallmentForm">
          @csrf
          @method("PUT")
          <div class="modal-body">
            <div class="row">
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

                  <input type="date" class="form-control" name="date"
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
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Edit Loan Installment <span class="text-success account_no"></span></h5>
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
                  <input type="date" class="form-control edit_date" name="date">

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
    document.addEventListener('DOMContentLoaded', function () {
      var submitButton = document.querySelector('.btn-complete-submit');
      var form = document.querySelector('.complete-form');

      form.addEventListener('submit', function () {
        // Disable the submit button on form submission
        submitButton.disabled = true;

        // Optionally, you can re-enable the button after a delay
        setTimeout(function () {
          submitButton.disabled = false;
        }, 3000); // Adjust the delay (in milliseconds) as needed
      });
    });

    $(document).ready(function () {
      $("#btn-complete").on("click", function () {
        console.log("hello")
        $("#modalComplete").modal("show");
      })
      // Function to calculate and update the total
      function updateTotal() {
        // Get values from input fields
        var withdraw = parseFloat($('.withdraw').val()) || 0;
        var profit = parseFloat($('.profit').val()) || 0;
        var loan_payment = parseFloat($('.loan_payment').val()) || 0;
        var interest = parseFloat($('.interest').val()) || 0;
        var grace = parseFloat($('.grace').val()) || 0;
        var service_charge = parseFloat($('.service_charge').val()) || 0;

        // Calculate total
        var total = withdraw + profit - loan_payment - interest - grace - service_charge;

        // Display total in the appropriate place
        $('.total').text(total.toFixed(0));
      }

      // Call the updateTotal function when the modal is shown and when the input fields change
      $('#modalComplete').on('shown.bs.modal', updateTotal);
      $('.withdraw, .profit, .loan_payment,.interest, .grace, .service_charge').on('input', updateTotal);
    });
  </script>
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

    loadSavingsCollection("{{ $dps->account_no }}");
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
          {"data": "date"},
          {"data": "dps_amount"},
          {"data": "loan_installment"},
          {"data": "interest"},
          {"data": "total"},
          {"data": "collector"},
          {"data": "sent"},
          {"data": "action"},
        ],
        createdRow: function (row, data, index) {
          $(row).addClass('font-small-2');
        },
        columnDefs: [
          {
            // Actions
            targets: 6,
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
            targets: 7,
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
                'বিস্তারিত</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-dps">' +
                'সঞ্চয় এডিট</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-loan">' +
                'ঋণ এডিট</a>' +
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
        url: "/special-installments/" + id,
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

    function resetMonthlyDPS(id) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "{{ url('reset-special-dps') }}/" + id,
          success: function () {
            resolve();
          },
          error: function (data) {
            reject();
          }
        });
      });
    }
    $('#item-reset').on('click', function () {
      var id = $(this).data("id");
      var token = $("meta[name='csrf-token']").attr("content");

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
          return resetMonthlyDPS(id)
            .catch(() => {
              Swal.showValidationMessage('স্পেশাল DPS একাউন্ট রিসেট ব্যর্থ হয়েছে।');
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          toastr.success('স্পেশাল DPS একাউন্টটি সফলভাবে রিসেট হয়েছে।', 'রিসেট!', {
            closeButton: true,
            tapToDismiss: false
          });

          window.location.reload();
        }
      });
    });

    $(document).on("click", ".delete-dps-complete", function () {
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
              url: "{{ url('special-dps-complete') }}/" + id, //or you can use url: "company/"+id,
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
                window.location.reload();
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
  </script>
@endsection
