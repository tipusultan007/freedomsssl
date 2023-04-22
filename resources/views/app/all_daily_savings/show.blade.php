@extends('layouts/contentLayoutMaster')

@section('title', 'Savings Details')
@section('breadcrumb-menu')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#savingsImportModal">
                        <i class="me-1" data-feather="check-square"></i>
                        <span class="align-middle">Import Savings Collections</span>
                    </a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                       data-bs-target="#loanCollectionImportModal">
                        <i class="me-1" data-feather="message-square"></i>
                        <span class="align-middle">Import Daily Loan Collections</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <style>
        table.closing-form input{
            padding-right: 28px;
        }
    </style>
@endsection

@section('content')
    @php
        $collectors = \App\Models\User::role('super-admin')->get();
    @endphp
    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="user-avatar-section">
                                    <div class="d-flex align-items-center flex-column">
                                        <img
                                            class="img-fluid rounded mt-3 mb-2"
                                            src="{{ $dailySavings->user->profile_photo_url??'' }}"
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
                                <div class="d-flex justify-content-around my-2 pt-75">
                                    <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                        <div class="ms-75">
                                            <h4 class="mb-0">{{ $dailySavings->total }}</h4>
                                            <small>Savings</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                        @php
                                            $loan = \App\Models\DailyLoan::where('account_no',$dailySavings->account_no)
                                            ->where('status','active')->latest()->first();
                                        @endphp
                                        <div class="ms-75">
                                            <h4 class="mb-0">{{ $loan?$loan->balance:0 }}</h4>
                                            <small>Loan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <h4>Account Details</h4>
                                <hr>
                                <ul class="list-unstyled">
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">A/C No:</span>
                                        <span>{{ $dailySavings->account_no??'' }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Opening Date:</span>
                                        <span>{{ $dailySavings->opening_date??'' }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Deposited:</span>
                                        <span>{{ $dailySavings->deposit }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Withdraw:</span>
                                        <span>{{ $dailySavings->withdraw }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Profit:</span>
                                        <span>{{ $dailySavings->interest }}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Balance:</span>
                                        <span>{{ $dailySavings->total }}</span>
                                    </li>


                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">status:</span>
                                        <span
                                            class="badge bg-light-success">{{ strtoupper($dailySavings->status)??'' }}</span>
                                    </li>
                                    <li>
                                        @php
                                        $closing = \App\Models\DailySavingsClosing::where('daily_savings_id',$dailySavings->id)->first();
                                        @endphp
                                        @if($dailySavings->status=="active")
                                            <button class="btn btn-danger" id="btn-complete">Make Complete</button>
                                        @else
                                            <button data-id="{{ $closing->id }}" class="btn btn-success" id="btn-active">Make Active</button>
                                        @endif


                                    </li>

                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h4 class="divider-text">Nominee Details</h4>
                                <hr>
                                @php
                                    $nominee = \App\Models\Nominees::where('account_no',$dailySavings->account_no)->first();
                                @endphp
                                @if($nominee)
                                    <ul class="list-unstyled">
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Name:</span>
                                            <span><a
                                                    href="{{ url('users') }}/{{ $nominee->user_id??'#' }}">{{ $nominee->name??'' }}</a></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Phone:</span>
                                            <span>{{ $nominee->phone??'' }}</span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Name:</span>
                                            <span>{{ $nominee->address??'' }}</span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Relation:</span>
                                            <span>{{ $nominee->relation??'' }}</span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25">Percentage:</span>
                                            <span>{{ $nominee->percentage.'%'??'' }}</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->
            <div class="modal fade"
                id="modalComplete"
                tabindex="-1"
                aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Closing Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        @php
                        $loan = \App\Models\DailyLoan::where('status','active')->first();
                        @endphp
                        <form action="{{ route('daily-savings-closings.store') }}" method="POST">
                            @csrf
                        <div class="modal-body">
                            <table class="table table-sm table-bordered text-center">
                                <caption style="caption-side:top;text-align: center">Savings</caption>
                                <thead>
                                <tr>
                                    <th>Deposited</th><th>Profit</th><th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $dailySavings->total }}</td>
                                    <td>{{ $dailySavings->profit }}</td>
                                    <td class="payable">{{ $dailySavings->total + $dailySavings->profit }}</td>
                                </tr>
                                </tbody>
                            </table>
                            @if($loan)
                                <table class="table table-sm table-bordered text-center">
                                    <caption style="caption-side:top;text-align: center">Loan</caption>
                                    <thead>
                                    <tr>
                                        <th>Total Loan</th><th>Grace</th><th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $loan->balance }}</td>
                                        <td class="p-0"><input type="number" name="grace" value="0" min="0" class="form-control grace form-control-sm text-center border-0 text-end rounded-0"></td>
                                        <td class="recievable">{{ $loan->balance }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif

                            <table class="table table-borderless">
                                <tr>
                                    <th>Accounts Payable:</th>
                                    <td class="p-0"><input type="number" name="payable" value="{{ $dailySavings->total + $dailySavings->profit  }}" class="form-control text-end payable rounded-0" readonly></td>
                                </tr>
                                @if($loan)
                                <tr>
                                    <th>Accounts Receivable:</th>
                                    <td class="p-0"><input type="number" name="receivable" value="{{ $loan?$loan->balance:"0" }}" class="form-control receivable text-end rounded-0" readonly></td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Service Charge:</th>
                                    <td class="p-0"><input type="number" name="service_charge" class="form-control service_charge text-end rounded-0" value="0" min="0"></td>
                                </tr>
                                <tr>
                                    <th>Total <span class="total_type"></span>:</th>
                                    <td class="p-0"><input type="number" name="total" class="form-control total text-end rounded-0" readonly></td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td class="p-0"><input type="text" name="date" value="{{ date('Y-m-d') }}" class="form-control flatpickr-basic text-end rounded-0"></td>
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
                                Submit
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- User Content -->
            <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
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
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Savings Transaction</span></a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#loanAccounts"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">All Loans</span></a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#allTransactions"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true"><i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Loan Transactions</span></a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="datatables-basic table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Late Fee</th>
                                    <th>Other Fee</th>
                                    <th>Balance</th>
                                    <th>Collector</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                    <div class="tab-pane" id="loanAccounts" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            @php
                                $loan_list = \App\Models\DailyLoan::where('account_no',$dailySavings->account_no)
                                ->orderBy('opening_date','asc')->get();
                            @endphp
                            <div class="card-body">
                                <table class="table table-sm loan-list">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Loan</th>
                                        <th>Interest</th>
                                        <th>Adjusted Amount</th>
                                        <th>Total Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
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
                                                    <span class="badge badge-glow badge-light-danger">Active</span>
                                                @elseif($loan->status=='complete')
                                                    <span class="badge badge-glow badge-light-success">Active</span>
                                                @endif
                                            </td>
                                            <td>{{ $loan->createdBy->name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                            class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                            data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">
                                                            <i data-feather="eye" class="me-50"></i>
                                                            <span>View</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i data-feather="edit-2" class="me-50"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i data-feather="trash" class="me-50"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                        <!-- /Project table -->
                    </div>
                    <div class="tab-pane" id="allTransactions" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                        <div class="card">
                            <table class="loan-transactions table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Late Fee</th>
                                    <th>Other Fee</th>
                                    <th>Balance</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /Project table -->
                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>
    </section>


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
                                        @foreach($collectors as $collector)
                                            <option
                                                value="{{ $collector->id }}">{{ $collector->name }}</option>
                                        @endforeach
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
                                        @foreach($collectors as $collector)
                                            <option
                                                value="{{ $collector->id }}">{{ $collector->name }}</option>
                                        @endforeach
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

    {{--@include('content/_partials/_modals/modal-edit-user')--}}
    @include('content/_partials/_modals/modal-upgrade-plan')
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    {{-- data table --}}
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    {{--<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>--}}

    <script>

        $("#btn-complete").on("click",function () {
            $("#modalComplete").modal("show");
        })
        var total_loan =  {{ $loan?$loan->balance:0 }};
        var payable =  {{ $dailySavings->total + $dailySavings->profit }};
        //var receivable =  parseInt(total_loan) + parseInt(grace);

        calculate();
        $(".grace").on("input",function () {
            calculate();
        });
        $(".service_charge").on("input",function () {
            calculate();
        });

        function calculate() {
            let graceField =  $(".grace");
            let grace = 0;
            if (graceField.length)
            {
                grace = $(".grace").val();
            }
            let service_fee = $(".service_charge").val();
            let receivable = parseInt(total_loan) - parseInt(grace);
            var tempTotal = 0;
            if (payable>receivable) {
                tempTotal = parseInt(payable) - parseInt(receivable) - parseInt(service_fee);
                $(".total_type").text("(Payable)");
            }else {
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

        $("#btn-paid").on("click",function () {
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
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-savings')}}/' + full['id'] + '" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit" data-id="' + full['id'] + '">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4'}) +
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
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
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
                    "url": "{{ url('dataDailyLoanCollection') }}",
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
                                feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-loan-collections')}}/' + full['id'] + '" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-loan-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit-loan" data-id="' + full["id"] + '">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4'}) +
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
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
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
                                    'Data deleted successfully!',
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
                        url: "{{ url('daily-savings-closings') }}/"+id,
                        type: 'DELETE',
                        data: {"id": id, "_token": token},
                        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                            $this.attr('disabled', true).html("Processing...");
                        },
                        success: function (){
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
