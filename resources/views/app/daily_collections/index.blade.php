@extends('layouts/contentLayoutMaster')

@section('title', 'Daily Collection')
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
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">


    <style>
        .inline-spacing > * {
            margin-top: 14px;
            margin-right: 15px;
        }
    </style>
@endsection

@section('content')
    <section class="app-user-view-account">
        <div class="row">
            <!-- User Content -->
            <div class="col-xl-12 col-lg-12 col-md-12 submission-form">
                <form id="collectionForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    @php
                                        $accounts = \App\Models\DailySavings::with('user')->where('status','active')->get();
                                    @endphp
                                    <div class="mb-1">
                                        <label class="form-label" for="basicInput">A/C No</label>
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
                                        <label class="form-label" for="date">Date</label>
                                        <input type="text" id="date" name="date" class="form-control flatpickr-basic"
                                               value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="collection_date">Collection Date</label>
                                        <input type="text" class="form-control flatpickr-basic" name="collection_date"
                                               id="collection_date" value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card collection-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <h6 class="text-center">Savings Installment</h6>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="saving_amount"
                                                       placeholder="Amount">
                                                <label for="saving_amount">Amount</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <select id="saving_type" class="form-control select2"
                                                        data-placeholder="Select Type">
                                                    <option value=""></option>
                                                    <option value="deposit">Deposit</option>
                                                    <option value="withdraw">Withdraw</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="late_fee" id="late_fee"
                                                       placeholder="Late Fee">
                                                <label for="late_fee">Late Fee</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="other_fee" id="other_fee"
                                                       placeholder="Other Fee">
                                                <label for="other_fee">Other Fee</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 my-1">
                                            <div class="form-floating">
                                                @php
                                                    $collectors = \App\Models\User::role('super-admin')->get();
                                                @endphp
                                                <select id="collector_id" class="form-control select2"
                                                        data-placeholder="Select collector">
                                                    <option value=""></option>
                                                    @foreach($collectors as $collector)
                                                        <option
                                                            value="{{ $collector->id }}">{{ $collector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="saving_note"
                                                       placeholder="Note">
                                                <label for="saving_note">Note</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-5">
                                    <div class="row">
                                        <h6 class="text-center">Loan Installment</h6>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="loan_installment"
                                                       placeholder="Installment">
                                                <label for="loan_installment">Installment</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="installment_no"
                                                       placeholder="Installment No">
                                                <label for="installment_no">Installment No</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_late_fee" id="loan_late_fee"
                                                       placeholder="Late Fee">
                                                <label for="loan_late_fee">Late Fee</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_other_fee" id="loan_other_fee"
                                                       placeholder="Other Fee">
                                                <label for="loan_other_fee">Other Fee</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="loan_note"
                                                       placeholder="Note">
                                                <label for="loan_note">Note</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <input type="hidden" id="user_id">
                                <input type="hidden" id="daily_savings_id">
                                <input type="hidden" id="daily_loan_id">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-gradient-success btn-submit w-25" onclick="modalData()">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--/ User Content -->
            <!--/ User Sidebar -->
        </div>

        <section id="nav-filled">
            <div class="row match-height">
                <!-- Filled Tabs starts -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a
                                        class="nav-link active"
                                        id="home-tab-fill"
                                        data-bs-toggle="tab"
                                        href="#home-fill"
                                        role="tab"
                                        aria-controls="home-fill"
                                        aria-selected="true"
                                    >Savings Collection</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        id="profile-tab-fill"
                                        data-bs-toggle="tab"
                                        href="#profile-fill"
                                        role="tab"
                                        aria-controls="profile-fill"
                                        aria-selected="false"
                                    >Loan Collection</a
                                    >
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
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
                                                <input type="text" id="s_fromdate" name="s_fromdate"
                                                       class="form-control flatpickr-basic"
                                                       placeholder="From"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-12">
                                            <div class="mb-1">
                                                <input type="text" class="form-control flatpickr-basic" name="s_todate"
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
                                    <table class="datatables-basic table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>A/C</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Late Fee</th>
                                            <th>Other Fee</th>
                                            <th>Balance</th>
                                            <th>Date</th>
                                            <th>Collector</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
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
                                                <input type="text" id="l_fromdate" name="l_fromdate"
                                                       class="form-control flatpickr-basic"
                                                       placeholder="From"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-12">
                                            <div class="mb-1">
                                                <input type="text" class="form-control flatpickr-basic" name="l_todate"
                                                       id="l_todate" placeholder="To">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <button type="button" class="btn btn-gradient-info btn-loan-collection"
                                                    onclick="filterLoanData()">
                                                Filter
                                            </button>
                                            <button type="button"
                                                    class="btn btn-gradient-danger btn-loan-collection-reset"
                                                    onclick="resetFilterLoan()">Reset
                                            </button>
                                        </div>
                                    </div>

                                    <table class="datatables-loan-collection table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>A/C</th>
                                            <th>Installment</th>
                                            <th>Late Fee</th>
                                            <th>Other Fee</th>
                                            <th>Balance</th>
                                            <th>Date</th>
                                            <th>Note</th>
                                            <th>Collector</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filled Tabs ends -->
            </div>
        </section>

    </section>
    <div class="modal fade" id="modalCollection" tabindex="-1" aria-labelledby="modalCollectionTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCollectionTitle">Daily Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formCollection">
                    @csrf
                    <div class="modal-body">
                        <p>Date: <span class="date"></span></p>
                        <table class="table table-sm table-user-info">
                            <tr>
                                <th>A/C Holder</th>
                                <td class="ac_holder"></td>
                            </tr>
                            <tr>
                                <th>A/C No</th>
                                <td class="acc_no"></td>
                            </tr>
                        </table>

                        <table class="table table-sm table-collection-info">


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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-confirm">Submit</button>
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

    <div
        class="offcanvas offcanvas-end"
        data-bs-scroll="true"
        data-bs-backdrop="false"
        tabindex="-1"
        id="offcanvasScroll"
        aria-labelledby="offcanvasScrollLabel"
    >
        <div class="offcanvas-header bg-success">
            <h5 id="offcanvasScrollLabel" class="offcanvas-title text-white"></h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <img
                        class="img-fluid rounded profile-image"
                        src="https://dummyimage.com/110x110"
                        height="110"
                        width="110"
                        alt="User avatar"
                    />
                    <div class="user-info text-center mb-1">
                        <h4 class="ac_holder"></h4>
                        <span class="badge bg-light-danger"><i data-feather='phone'></i> <span
                                class="phone"></span></span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-around my-2 pt-75">
                <div class="d-flex align-items-start me-2 savings-balance">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                    <div class="ms-75">
                        <h5 class="mb-0"></h5>
                        <small>Savings</small>
                    </div>
                </div>
                <div class="d-flex align-items-start loan-balance">
                  <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                    <div class="ms-75">
                        <h5 class="mb-0"></h5>
                        <small>Loan</small>
                    </div>
                </div>
            </div>
            <div id="savings-info">
                <h4 class="fw-bolder border-bottom pb-50 mb-1">Savings Details</h4>
                <div class="info-container">
                    <ul class="list-unstyled savings-info-list">

                    </ul>
                </div>
            </div>

            <div id="loan-info" style="display: none">
                <h4 class="fw-bolder border-bottom pb-50 mb-1">Loan Details</h4>
                <div class="info-container">
                    <ul class="list-unstyled loan-info-list">

                    </ul>

                </div>
            </div>
            <div class="d-flex justify-content-center pt-2 buttons">

            </div>
        </div>
    </div>
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

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    <script>
        var myOffcanvas = document.getElementById('offcanvasScroll');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $(".submission-form").addClass("col-xl-12 col-lg-12 col-md-12");
            $(".submission-form").removeClass("col-xl-9 col-lg-9 col-md-9");
        })
        function resetForm() {
            $("#collectionForm").trigger('reset');
            $("#formCollection").trigger('reset');
            $('#account_no').val(null).trigger('change');
            $('#collector_id').val(null).trigger('change');
            $('#saving_type').val(null).trigger('change');
        }

        $('#account_no').on('select2:select', function (e) {
            var account_no = e.params.data.id;
            $(".savings-info-list").empty();
            $(".loan-info-list").empty();
            $(".buttons").empty();
            $.ajax({
                url: "{{ url('dataByAccount') }}/" + account_no,
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
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
                    <li class="mb-75">
                                        <span class="fw-bolder me-25">A/C No:</span>
                                        <span class="account_no">${saving.account_no}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Deposit:</span>
                                        <span class="total_deposit">${saving.deposit}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Withdraw:</span>
                                        <span class="total_withdraw">${saving.withdraw}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Profit:</span>
                                        <span class="profit">${saving.profit}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Balance:</span>
                                        <span class="balance">${saving.total}</span>
                                    </li>
                    `);

                    if (data.loans != null) {
                        $(".buttons").append(`
                        <a href="{{ url('daily-loans') }}/${data.loans.id}" class="btn btn-sm btn-outline-sm btn-outline-danger suspend-user">Loan InFo</a>
`);
                        $("#loan-info").show();
                        $(".loan-balance").show();

                        var loans = data.loans;
                        $(".loan-balance h5").text(loans.balance);
                        $("#daily_loan_id").val(data.loans.id);
                        $(".loan-info-list").append(`
                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Loan Amount:</span>
                                        <span>${loans.loan_amount}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Commencement:</span>
                                        <span>${loans.commencement}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Paid:</span>
                                        <span class="badge bg-light-success"></span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Should Pay:</span>
                                        <span></span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Remain Loan:</span>
                                        <span>${loans.balance}</span>
                                    </li>

                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Last Installment:</span>
                                        <span></span>
                                    </li>
                    `);
                    } else {
                        $("#loan-info").hide();
                        $(".loan-balance").hide();
                        $(".loan-balance h4").text('');
                    }

                    if (data.savings.user.profile_photo_path == null) {
                        $(".profile-image").attr('src', data.savings.user.profile_photo_url);
                    }
                }
            });
            bsOffcanvas.show();
            myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
                $(".submission-form").removeClass("col-xl-12 col-lg-12 col-md-12");
                $(".submission-form").addClass("col-xl-9 col-lg-9 col-md-9");
            })
        });

        $(".btn-submit").on("click", function () {
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
            $(".ac_holder").text()
            if (saving_type == "deposit") {
                $(".table-collection-info").append(`
            <tr>
                                <th>Saving Type</th>
                                <td><span class="text-success">Deposit</span></td>
                            </tr>
            `);
            } else if (saving_type == "withdraw") {
                $(".table-collection-info").append(`
            <tr>
                                <th>Saving Type</th>
                                <td><span class="text-danger">Withdraw</span></td>
                            </tr>
            `);
            }
            if (saving_amount != "") {
                $(".table-collection-info").append(`
           <tr>
                    <th>Amount</th>
                    <td>${saving_amount}</td>
                </tr>
            `);
            }


            if (late_fee != "") {
                total += parseInt(late_fee);
                $(".table-collection-info").append(`
           <tr>
                    <th>Late Fee</th>
                    <td>${late_fee}</td>
                </tr>
            `);
            }

            if (other_fee != "") {
                total += parseInt(other_fee);
                $(".table-collection-info").append(`
           <tr>
                    <th>Other Fee</th>
                    <td>${other_fee}</td>
                </tr>
            `);
            }
            if (loan_installment != "") {
                total += parseInt(loan_installment);
                $(".table-collection-info").append(`
           <tr>
                    <th>Loan Payment</th>
                    <td>${loan_installment}</td>
                </tr>
            `);
            }
            if (loan_late_fee != "") {
                total += parseInt(loan_late_fee);
                $(".table-collection-info").append(`
           <tr>
                    <th>Loan Late Fee</th>
                    <td>${loan_late_fee}</td>
                </tr>
            `);
            }

            if (loan_other_fee != "") {
                total += parseInt(loan_other_fee);
                $(".table-collection-info").append(`
           <tr>
                    <th>Loan Other Fee</th>
                    <td>${loan_other_fee}</td>
                </tr>
            `);
            }

            if (saving_type == "deposit") {
                total += parseInt(saving_amount);
            } else if (saving_type == "withdraw") {
                total -= parseInt(saving_amount);
            }
            $(".table-collection-info").append(`
            <tfoot>
            <tr>
                <th>Total</th>
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
            $(".btn-confirm").attr('disabled', false);
            $(".spinner").hide();
            $("#modalCollection").modal("show");
        })

        $(".btn-confirm").on("click", function () {
            //$(".spinner").show();
            //$(".btn-confirm").attr('disabled',true);
            var $this = $(".btn-confirm"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            $.ajax({
                url: "{{ route('daily-collections.store') }}",
                method: "POST",
                data: $("#formCollection").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#modalCollection").modal("hide");
                    toastr['success']('👋 Submission has been saved successfully.', 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });

                    resetForm();

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
        loadLoanCollection();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadSavingsCollection(account = '', collector = '', from = '', to = '') {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('dataSavingsCollection') }}",
                    type: "GET",
                    data: {account: account, collector: collector, from: from, to: to}
                },
                "columns": [

                    {"data": "name"},
                    {"data": "account_no"},
                    {"data": "type"},
                    {"data": "amount"},
                    {"data": "late_fee"},
                    {"data": "other_fee"},
                    {"data": "balance"},
                    {"data": "date"},
                    {"data": "collector"},
                    {"data": "action"},
                ],
                createdRow: function (row, data, index) {
                    $(row).addClass('font-small-2 fw-bold');
                },
                columnDefs: [
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['user_id'],
                                $image = full['profile_photo_url'];
                            if ($image != null) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6) + 1;
                                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }
                            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="avatar-wrapper">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<a href="' +
                                userView + $id +
                                '" class="user_name">' +
                                $name +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
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


        function loadLoanCollection(account = '', collector = '', from = '', to = '') {
            $('.datatables-loan-collection').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{ url('dataDailyLoanCollection') }}",
                    type: "GET",
                    data: {account: account, collector: collector, from: from, to: to}
                },
                "columns": [

                    {"data": "name"},
                    {"data": "account_no"},
                    {"data": "amount"},
                    {"data": "late_fee"},
                    {"data": "other_fee"},
                    {"data": "balance"},
                    {"data": "date"},
                    {"data": "note"},
                    {"data": "collector"},
                    {"data": "action"},
                ],
                createdRow: function (row, data, index) {
                  $(row).addClass('font-small-2 fw-bold');
                },
                columnDefs: [
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['user_id'],
                                $image = full['profile_photo_url'];
                            if ($image != null) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6) + 1;
                                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }
                            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="avatar-wrapper">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<a href="' +
                                userView + $id +
                                '" class="user_name">' +
                                $name +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
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
                                $(".datatables-loan-collection").DataTable().destroy();
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
                url: "savings-collections/" + id,
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
                    resetForm();

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
            $("#s_fromdate").val('');
            $("#s_todate").val('');
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
    </script>
@endsection
