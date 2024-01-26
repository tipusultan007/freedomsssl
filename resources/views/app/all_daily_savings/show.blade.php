@extends('layouts/layoutMaster')

@section('title', $dailySavings->account_no.' - দৈনিক সঞ্চয়')
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
  @php
    $collectors = \App\Models\User::role('super-admin')->get();
  @endphp
  <div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ url('daily-savings') }}">দৈনিক সঞ্চয় তালিকা</a>
          </li>
          <li class="breadcrumb-item active">দৈনিক সঞ্চয় - {{ $dailySavings->account_no }}</li>
        </ol>
      </nav>
      <a class="btn rounded-pill btn-primary waves-effect waves-light"
         href="{{ route('daily-savings.edit', $dailySavings->id) }}" target="_blank">এডিট করুণ</a>
    </div>
  </div>
  <section class="app-user-view-account">
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
                      src="{{ asset('storage/images/profile') }}/{{ $dailySavings->user->image??'' }}"
                      height="110"
                      width="110"
                      alt="User avatar"
                    />
                    <div class="user-info text-center">
                      <h4>
                        <a href="{{ route('users.show',$dailySavings->user_id) }}">{{ $dailySavings->user->name }}</a>
                      </h4>
                      <span class="badge bg-light-secondary">{{ $dailySavings->user->phone1 }}</span>
                      <span
                        class="badge bg-light-success">{{ strtoupper($dailySavings->status)??'' }}</span>
                    </div>
                  </div>
                </div>
                @php
                  $loan = \App\Models\DailyLoan::where('account_no',$dailySavings->account_no)
                  ->where('status','active')->latest()->first();
                @endphp
                <table class="table table-sm text-center table-bordered">
                  <tr>
                    <th class="py-1 fw-bolder">সঞ্চয় জমা</th>
                    <th class="py-1 fw-bolder">অবশিষ্ট ঋণ</th>
                  </tr>
                  <tr>
                    <td>{{ $dailySavings->total }}</td>
                    <td>{{ $loan?$loan->balance:0 }}</td>
                  </tr>
                </table>

              </div>
              <div class="col-md-3">
                <table class="table table-sm table-bordered">
                  <tr>
                    <th class="py-1 fw-bolder">হিসাব নং</th>
                    <td>{{ $dailySavings->account_no??'' }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">তারিখ:</th>
                    <td>{{ date('d/m/Y',strtotime($dailySavings->opening_date))??'' }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">জমা:</th>
                    <td>{{ $dailySavings->deposit }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">উত্তোলন:</th>
                    <td>{{ $dailySavings->withdraw }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">লভ্যাংশ:</th>
                    <td>{{ $dailySavings->interest }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">অবশিষ্ট:</th>
                    <td>{{ $dailySavings->total }}</td>
                  </tr>
                  <tr>
                    <th class="py-1 fw-bolder">স্ট্যাটাস:</th>
                    <td> @if($dailySavings->status==='active')
                        <span class="badge rounded-pill bg-label-success">চলমান</span>
                          <button class="btn rounded-pill btn-sm btn-warning waves-effect waves-light mt-2"
                                  id="btn-complete">হিসাব সম্পন্ন করুণ
                          </button>
                      @else
                        <span class="badge rounded-pill bg-label-danger">পরিশোধ</span>
                        <a href="{{ route('active.daily.savings',$dailySavings->id) }}" class="btn btn-success">চালু করুন</a>

                      @endif
                    </td>
                  </tr>
                </table>
              </div>
              <div class="col-md-3">
                @php
                  $nominee = \App\Models\Nominees::where('account_no',$dailySavings->account_no)->first();
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
        <!-- /User Card -->
      </div>

      <!--/ User Sidebar -->
      {{-- <div class="modal fade"
            id="modalComplete"
            tabindex="-1"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
             <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="exampleModalCenterTitle">হিসাব নিষ্পত্তির ফরম</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                       aria-label="Close"></button>
             </div>

             <form action="{{ route('daily-savings-complete.store') }}" method="POST">
               @csrf
               <div class="modal-body">
                 <table class="table table-sm table-bordered text-center">
                   <caption style="caption-side:top;text-align: center">সঞ্চয়</caption>
                   <thead>
                   <tr>
                     <th class="py-1 fw-bolder">জমা</th>
                     <th class="py-1 fw-bolder">মুনাফা</th>
                     <th class="py-1 fw-bolder">সর্বমোট</th>
                   </tr>
                   </thead>
                   <tbody>
                   <tr>
                     <td class="py-1">{{ $dailySavings->total }}</td>
                     <td class="py-1">{{ $dailySavings->profit }}</td>
                     <td class="payable">{{ $dailySavings->total + $dailySavings->profit }}</td>
                   </tr>
                   </tbody>
                 </table>
                 @if($loan)
                   <table class="table table-sm table-bordered text-center">
                     <caption style="caption-side:top;text-align: center">ঋণ</caption>
                     <thead>
                     <tr>
                       <th class="py-1 fw-bolder">সর্বমোট ঋণ</th>
                       <th class="py-1 fw-bolder">ছাড়</th>
                       <th class="py-1 fw-bolder">সর্বমোট</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr>
                       <td class="">{{ $loan->balance }}</td>
                       <td class="p-0"><input type="number" name="grace" value="0" min="0"
                                              class="form-control grace form-control-sm text-center border-0 text-end rounded-0">
                       </td>
                       <td class="recievable">{{ $loan->balance }}</td>
                     </tr>
                     </tbody>
                   </table>
                 @endif

                 <table class="table table-borderless">
                   <tr>
                     <th class="py-1 fw-bolder">পরিশোধযোগ্য হিসাব:</th>
                     <td class="p-0"><input type="number" name="payable"
                                            value="{{ $dailySavings->total + $dailySavings->profit  }}"
                                            class="form-control form-control-sm text-end payable rounded-0" readonly>
                     </td>
                   </tr>
                   @if($loan)
                     <tr>
                       <th class="py-1 fw-bolder">হিসাব গ্রহনযোগ্য:</th>
                       <td class="p-0"><input type="number" name="receivable" value="{{ $loan?$loan->balance:"0" }}"
                                              class="form-control form-control-sm receivable text-end rounded-0"
                                              readonly></td>
                     </tr>
                   @endif
                   <tr>
                     <th class="py-1 fw-bolder">ফি:</th>
                     <td class="p-0"><input type="number" name="service_charge"
                                            class="form-control form-control-sm service_charge text-end rounded-0"
                                            value="0" min="0"></td>
                   </tr>
                   <tr>
                     <th class="py-1 fw-bolder">সর্বমোট <span class="total_type"></span>:</th>
                     <td class="p-0"><input type="number" name="total"
                                            class="form-control  form-control-sm total text-end rounded-0" readonly></td>
                   </tr>
                   <tr>
                     <th class="py-1 fw-bolder">তারিখ:</th>
                     <td class="p-0"><input type="text" name="date" value="{{ date('Y-m-d') }}"
                                            class="form-control form-control-sm datepicker text-end rounded-0"></td>
                   </tr>
                 </table>
                 <input type="hidden" name="status" value="closed">
                 <input type="hidden" name="user_id" value="{{ $dailySavings->user_id }}">
                 <input type="hidden" name="daily_savings_id" value="{{ $dailySavings->id }}">
                 <input type="hidden" name="saving_type" value="withdraw">
                 <input type="hidden" name="saving_amount" value="{{ $dailySavings->total + $dailySavings->profit }}">
                 <input type="hidden" name="account_no" value="{{ $dailySavings->account_no }}">
                 <input type="hidden" name="deposit" value="{{ $dailySavings->total }}">
                 @if($loan)
                   <input type="hidden" name="loan" value="{{ $loan->balance }}">
                   <input type="hidden" name="loan_installment" value="{{ $loan->balance }}">
                   <input type="hidden" name="daily_loan_id" value="{{ $loan->id }}">
                 @endif
                 <input type="hidden" name="profit" value="{{ $dailySavings->profit }}">
                 <input type="hidden" name="closing_by" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
               </div>
               <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">
                   সাবমিট
                 </button>
               </div>
             </form>
           </div>
         </div>
       </div>--}}
      <!-- User Content -->
      <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1 mt-4">
        <!-- User Pills -->
        <ul class="nav nav-pills nav-justified" role="tablist">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="savings-tab"
              data-bs-toggle="tab"
              href="#savingAccount"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">সঞ্চয় লেন-দেন</span></a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="savings-tab"
              data-bs-toggle="tab"
              href="#loanAccounts"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">সকল ঋণ</span></a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              id="savings-tab"
              data-bs-toggle="tab"
              href="#allTransactions"
              aria-controls="home"
              role="tab"
              aria-selected="true">
              <span class="fw-bold">ঋণ ফেরত/লভ্যাংশ আদায়</span></a>
          </li>

        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="datatables-basic table-bordered table table-sm">
              <thead class="table-light py-1 fw-bolder">
              <tr>
                <th class="fw-bolder py-1">তারিখ</th>
                <th class="fw-bolder py-1">ধরন</th>
                <th class="fw-bolder py-1">পরিমান</th>
                <th class="fw-bolder py-1">বিলম্ব ফি</th>
                <th class="fw-bolder py-1">অন্যান্য ফি</th>
                <th class="fw-bolder py-1">ব্যালেন্স</th>
                <th class="fw-bolder py-1"> আদায়কারী</th>
                <th class="fw-bolder py-1">#</th>
              </tr>
              </thead>
            </table>
          </div>
          <div class="tab-pane" id="loanAccounts" aria-labelledby="homeIcon-tab" role="tabpanel">
            @php
              $loan_list = \App\Models\DailyLoan::where('account_no',$dailySavings->account_no)
              ->orderBy('opening_date','asc')->get();
            @endphp

            <table class="table table-sm loan-list table-bordered">
              <thead class="table-light py-1 fw-bolder">
              <tr>
                <th class="fw-bolder py-1">তারিখ</th>
                <th class="fw-bolder py-1">ঋণের পরিমাণ</th>
                <th class="fw-bolder py-1">সুদের পরিমাণ</th>
                <th class="fw-bolder py-1">সমন্বিত পরিমাণ</th>
                <th class="fw-bolder py-1">সর্বমোট</th>
                <th class="fw-bolder py-1">ব্যালেন্স</th>
                <th class="fw-bolder py-1">স্ট্যাটাস</th>
                <th class="fw-bolder py-1">আদায়কারী</th>
                <th class="fw-bolder py-1">#</th>
              </tr>
              </thead>
              @foreach($loan_list as $loan)
                <tr>
                  <td>{{ $loan->opening_date }}</td>
                  <td>{{ $loan->loan_amount }}</td>
                  <td>{{ $loan->interest }}</td>
                  <td>{{ $loan->adjusted_amount }}</td>
                  <td>{{ $loan->total }}</td>
                  <td>{{ $loan->balance }}</td>
                  <td>
                    @if($loan->status=='active')
                      <span class="badge badge-glow bg-label-danger">Active</span>
                    @elseif($loan->status=='complete')
                      <span class="badge badge-glow bg-label-success">Active</span>
                    @endif
                  </td>
                  <td>{{ $loan->manager->name }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button"
                              class="btn btn-sm dropdown-toggle hide-arrow py-0"
                              data-bs-toggle="dropdown">
                        <i class="ti ti-dots"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('daily-loans.show',$loan->id) }}" target="_blank">
                          <i data-feather="eye" class="me-50"></i>
                          <span>বিস্তারিত</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('daily-loans.edit',$loan->id) }}">
                          <i data-feather="edit-2" class="me-50"></i>
                          <span>সম্পাদন</span>
                        </a>
                        <a class="dropdown-item delete-loan" data-id="{{ $loan->id }}" href="javascript:;">
                          <i data-feather="trash" class="me-50"></i>
                          <span>ডিলেট</span>
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
          <div class="tab-pane" id="allTransactions" aria-labelledby="homeIcon-tab" role="tabpanel">
            <table class="loan-transactions table table-bordered table-sm">
              <thead class="table-light py-1 fw-bolder">
              <tr>
                <th class="fw-bolder py-1">তারিখ</th>
                <th class="fw-bolder py-1">পরিমাণ</th>
                <th class="fw-bolder py-1">বিলম্ব ফি</th>
                <th class="fw-bolder py-1">অন্যান্য ফি</th>
                <th class="fw-bolder py-1">ব্যালেন্স</th>
                <th class="fw-bolder py-1">মন্তব্য</th>
                <th class="fw-bolder py-1">#</th>
              </tr>
              </thead>
            </table>
          </div>
        </div>

      </div>
      <!--/ User Content -->
    </div>
  </section>

  <div class="modal fade" id="modal-complete-savings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="modalCenterTitle">সঞ্চয় হিসাব প্রত্যাহার ফরম</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form class="complete-saving-form" action="{{ route('daily-savings-complete.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            @php
              $activeLoan = $dailySavings->dailyLoans->where('status','active')->first();
            @endphp
            <input type="hidden" name="daily_savings_id" value="{{ $dailySavings->id }}">
            <input type="hidden" name="account_no" value="{{ $dailySavings->account_no }}">
            <table class="table table-sm table-borderless">
              <tr>
                <th class="fw-bolder py-2">সঞ্চয় জমা</th>
                <td><input type="text" name="withdraw" value="{{ $dailySavings->total }}" class="form-control form-control-sm rounded-0 text-end withdraw"></td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">সঞ্চয়ের লভ্যাংশ</th>
                <td><input type="text" name="profit" value="{{ $dailySavings->profit }}" class="form-control form-control-sm rounded-0 text-end profit"></td>
              </tr>
              @if($activeLoan)
                <input type="hidden" name="daily_loan_id" value="{{ $activeLoan->id }}">
                <tr>
                  <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
                  <td><input type="text" name="loan_payment" value="{{ $activeLoan->balance }}" class="form-control form-control-sm rounded-0 text-end loan_payment"></td>
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
  <!-- Modal -->
  <div class="modal fade" id="edit-saving-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">সঞ্চয় আদায়/উত্তোলন সম্পাদন</h5>
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
                  <label class="form-label" for="city-column">পরিমাণ</label>
                  <input type="number" class="form-control savings_amount" name="saving_amount">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">তারিখ</label>
                  <input type="text" class="form-control date flatpickr-basic" name="date">
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
                  <label class="form-label" for="email-id-column">নোট</label>
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
          <h5 class="modal-title" id="exampleModalCenterTitle">ঋণ ফেরত সম্পাদন</h5>
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
                  <label class="form-label" for="city-column">পরিমাণ</label>
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
                  <input type="text" class="form-control date flatpickr-basic" name="date">
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
                  <label class="form-label" for="email-id-column">নোট</label>
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

  {{--@include('content/_partials/_modals/modal-edit-user')--}}

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var submitButton = document.querySelector('.btn-complete-submit');
      var form = document.querySelector('.complete-saving-form');

      form.addEventListener('submit', function () {
        // Disable the submit button on form submission
        submitButton.disabled = true;

        // Optionally, you can re-enable the button after a delay
        setTimeout(function () {
          submitButton.disabled = false;
        }, 3000); // Adjust the delay (in milliseconds) as needed
      });
    });
    $("#btn-complete").on("click", function () {
      $("#modal-complete-savings").modal("show");
    })
    $(document).ready(function () {
      // Function to calculate and update the total
      function updateTotal() {
        // Get values from input fields
        var withdraw = parseFloat($('.withdraw').val()) || 0;
        var profit = parseFloat($('.profit').val()) || 0;
        var loan_payment = parseFloat($('.loan_payment').val()) || 0;
        var grace = parseFloat($('.grace').val()) || 0;
        var service_charge = parseFloat($('.service_charge').val()) || 0;

        // Calculate total
        var total = withdraw + profit - loan_payment - grace - service_charge;

        // Display total in the appropriate place
        $('.total').text(total.toFixed(0));
      }

      // Call the updateTotal function when the modal is shown and when the input fields change
      $('#modal-complete-savings').on('shown.bs.modal', updateTotal);
      $('.withdraw, .profit, .loan_payment, .grace, .service_charge').on('input', updateTotal);
    });
    var total_loan = {{ $loan?$loan->balance:0 }};
    var payable = {{ $dailySavings->total + $dailySavings->profit }};
    //var receivable =  parseInt(total_loan) + parseInt(grace);

    calculate();
    $(".grace").on("input", function () {
      calculate();
    });
    $(".service_charge").on("input", function () {
      calculate();
    });

    function calculate() {
      console.log(total_loan);
      let graceField = $(".grace");
      let grace = 0;
      if (graceField.length) {
        grace = $(".grace").val();
      }
      let service_fee = $(".service_charge").val();
      let receivable = parseInt(total_loan) - parseInt(grace);
      var tempTotal = 0;
      if (payable > receivable) {
        tempTotal = parseInt(payable) - parseInt(receivable) - parseInt(service_fee);
        $(".total_type").text("(Payable)");
      } else {
        tempTotal = parseInt(receivable) - parseInt(payable) - parseInt(service_fee);
        $(".total_type").text("(Receivable)");
      }
      $(".total").val(tempTotal)
    }

    /*$(".service_charge").on("input",function () {
        let fee = $(this).val();
        let tempTotal = total;
        $(".total").text(total-fee);
        $("input[name='total']").val(total-fee);
    })*/

    $("#btn-paid").on("click", function () {
      var $this = $(".btn-confirm"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button

      $.ajax({
        url: "{{ route('closing-accounts.store') }}",
        method: "POST",
        data: $("#formClosing").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modalComplete").modal("hide");
          toastr['success']('Daily Savings has been closed successfully!', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });
          $("#modalComplete").modal("hide");
        },
        error: function (data) {
          $("#modalComplete").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Daily Savings closing failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })

    // Variable declaration for table
    var dtAccountsTable = $('.datatable-accounts'),
      dtLoansTable = $('.datatable-loans'),
      invoicePreview = 'app-invoice-preview.html',
      assetPath = '../../../app-assets/';

    if ($('body').attr('data-framework') === 'laravel') {
      assetPath = $('body').attr('data-asset-path');
      invoicePreview = assetPath + 'app/invoice/preview';
    }
    var ac = "{{ $dailySavings->account_no }}";

    loadSavingsCollection(ac);

    //loadLoanCollection();

    function loadSavingsCollection(account = '') {
      $('.datatables-basic').DataTable({
        "proccessing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
          "url": "{{ url('dataSavingsCollection') }}",
          type: "GET",
          data: {account: ac}
        },
        "columns": [
          {"data": "date"},
          {"data": "type"},
          {"data": "amount"},
          {"data": "late_fee"},
          {"data": "other_fee"},
          {"data": "balance"},
          {"data": "collector"},
          {"data": "action"},
        ],
        columnDefs: [

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
                '<a href="{{url('daily-savings')}}/' + full['id'] + '" class="dropdown-item">' +
                'বিস্তারিত</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                'ডিলেট</a>' +
                '</div>' +
                '</div>' +
                '<a href="javascript:;" class="item-edit" data-id="' + full['id'] + '">' +
                '<i class="ti ti-edit"></i>' +
                '</a>'
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

    loadLoanCollection(ac);

    function loadLoanCollection(account = '') {
      $('.loan-transactions').DataTable({
        "proccessing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
          url: "{{ url('dataDailyLoanCollection') }}",
          type: "GET",
          data: {account: account}
        },
        "columns": [
          {"data": "date"},
          {"data": "amount"},
          {"data": "late_fee"},
          {"data": "other_fee"},
          {"data": "balance"},
          {"data": "note"},
          {"data": "action"},
        ],
        columnDefs: [
          {
            // Actions
            targets: 6,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-inline-flex">' +
                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                '<i class="ti ti-dots"></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-end">' +
                '<a href="{{url('daily-loan-collections')}}/' + full['id'] + '" class="dropdown-item">' +
                'বিস্তারিত</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-loan-record">' +
                'ডিলেট</a>' +
                '</div>' +
                '</div>' +
                '<a href="javascript:;" class="item-edit-loan" data-id="' + full["id"] + '">' +
                '<i class="ti ti-edit"></i>' +
                '</a>'
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
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'csv',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'pdf',
                text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
              },
              {
                extend: 'copy',
                text: '<i class="ti ti-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
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
              url: "{{ url('savings-collections') }}/" + id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                Swal.fire(
                  'Deleted!',
                  'ডিলেট সফল হয়েছে!',
                  'success'
                )
                $(".datatables-basic").DataTable().destroy();
                loadSavingsCollection();
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
              url: "{{ url('daily-loan-collections') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                Swal.fire(
                  'Deleted!',
                  'Data deleted successfully!',
                  'success'
                )
                $(".loan-transactions").DataTable().destroy();
                loadLoanCollection();
              }
            });
        }
      });
    })
    $(document).on("click", ".delete-loan", function () {
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
              url: "{{ url('daily-loans') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                Swal.fire(
                  'Deleted!',
                  'Data deleted successfully!',
                  'success'
                )
                window.location = "/daily-savings/{{ $dailySavings->id }}";
              }
            });
        }
      });
    })
    $(document).on("click", ".item-edit", function () {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "{{ url('getSavingsCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
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
      })
    })
    $(document).on("click", ".item-edit-loan", function () {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "{{ url('getLoanCollectionData') }}/" + id,
        dataType: "JSON",
        success: function (data) {
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
      })
    })
    $(".btn-edit").on("click", function () {
      var id = $("input[name='id']").val();
      var $this = $(".edit"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "{{ url('savings-collections') }}/" + id,
        method: "PUT",
        data: $("#edit-form").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#edit-saving-collection-modal").modal("hide");
          toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });
          $(".datatables-basic").DataTable().destroy();
          loadSavingsCollection();
          //resetForm();

        },
        error: function (data) {
          $("#edit-saving-collection-modal").modal("hide");
          $this.attr('disabled', false).html($caption);
          toastr['error']('Submission failed. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
          });
        }
      })
    })

    $(".btn-edit-loan").on("click", function () {
      var id = $("input[name='id']").val();
      var $this = $(".btn-edit-loan"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "{{ url('daily-loan-collections') }}/" + id,
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

          // resetForm();

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

    $('#btn-active').on('click', function () {
      var id = $(this).data("id");
      var token = $("meta[name='csrf-token']").attr("content");
      var $this = $("#btn-active");
      var $caption = $this.html();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, active it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ url('daily-savings-closings') }}/" + id,
            type: 'DELETE',
            data: {"id": id, "_token": token},
            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
              $this.attr('disabled', true).html("Processing...");
            },
            success: function () {
              $this.attr('disabled', false).html($caption);
              // $(".deleteToast").toast('show');
              toastr.error('Daily Savings activated again', 'Activated!', {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });

        }
      })


    });
  </script>
@endsection
