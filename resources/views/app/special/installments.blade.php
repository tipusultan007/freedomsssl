@extends('layouts/contentLayoutMaster')

@section('title', 'Installments')
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
                <form id="collectionForm" method="POST" action="{{ route('special-installments.store') }}">
                    @csrf
                    <div class="card">
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
                                        <input type="text" id="date" class="form-control flatpickr-basic"
                                               value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-12">
                                    <div class="mb-1">
                                        <button type="button" class="btn btn-gradient-success btn-dps-info">
                                            Check
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
                                    <div class="row">
                                        <div class="col-lg-12 my-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="collection_type[]"
                                                       id="dps_installment" value="dps_installment" checked>
                                                <label class="form-check-label" for="dps_installment">SPECIAL DPS</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control form-control-sm"
                                                       name="dps_amount" id="dps_amount"
                                                       placeholder="DPS AMOUNT" readonly>
                                                <label class="font-small-2 fw-bold" for="dps_amount">SPECIAL DPS</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control form-control-sm"
                                                       name="dps_installments" id="dps_installments"
                                                       placeholder="# INSTALLMENTS">
                                                <label class="font-small-2 fw-bold" for="dps_installments"># INSTALLMENTS</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="receipt_no"
                                                       id="receipt_no"
                                                       placeholder="Note">
                                                <label class="font-small-2 fw-bold" for="receipt_no">RECEIPT NO</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="late_fee" id="late_fee"
                                                       placeholder="Late Fee">
                                                <label class="font-small-2 fw-bold" for="late_fee">LATE FEE</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="other_fee"
                                                       id="other_fee"
                                                       placeholder="OTHER FEE">
                                                <label class="font-small-2 fw-bold" for="other_fee">OTHER FEE</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="due" id="due"
                                                       placeholder="DUE">
                                                <label class="font-small-2 fw-bold" for="due">DUE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="due_return"
                                                       id="due_return"
                                                       placeholder="DUE RETURN">
                                                <label class="font-small-2 fw-bold" for="due_return">DUE RETURN</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="advance" id="advance"
                                                       placeholder="ADVANCE">
                                                <label class="font-small-2 fw-bold" for="advance">ADVANCE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="advance_return"
                                                       id="advance_return"
                                                       placeholder="ADVANCE">
                                                <label class="font-small-2 fw-bold" for="advance_return">ADVANCE RETURN</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="grace"
                                                       id="grace"
                                                       placeholder="GRACE">
                                                <label class="font-small-2 fw-bold" for="grace">GRACE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control flatpickr-basic" name="date"
                                                       value="{{ date('Y-m-d') }}" id="date">
                                                <label class="font-small-2 fw-bold" for="date">DATE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="dps_note" id="dps_note"
                                                       placeholder="Note">
                                                <label class="font-small-2 fw-bold" for="dps_note">NOTE</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-12">
                                            <div class="mb-1">
                                                <select class="select2 form-select" name="deposited_via" id="deposited_via">
                                                    <option value="cash">Cash</option>
                                                    <option value="bkash">bKash</option>
                                                    <option value="nagad">Nagad</option>
                                                    <option value="bank">Bank</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 deposited_via_details">
                                            <div class="mb-1">
                                                <input type="text" class="form-control" name="deposited_via_details" id="deposited_via_details"
                                                       placeholder="Bank / Bkash/ Nagad Details">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-12 my-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="collection_type[]"
                                                       id="loan_collection" value="loan_installment" checked>
                                                <label class="form-check-label" for="loan_collection">SPECIAL LOAN
                                                    INSTALLMENT</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_installment"
                                                       id="loan_installment"
                                                       placeholder="Installment">
                                                <label class="font-small-2 fw-bold" for="loan_installment">LOAN PAYMENT</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="interest" id="interest"
                                                       placeholder=" " readonly>
                                                <label class="font-small-2 fw-bold" for="interest">INTEREST</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 loan-list">
                                            <table class="table table-sm"></table>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="due_interest"
                                                       id="due_interest"
                                                       placeholder=" ">
                                                <label class="font-small-2 fw-bold" for="due_interest">DUE INTEREST</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_late_fee"
                                                       id="loan_late_fee"
                                                       placeholder="Late Fee">
                                                <label class="font-small-2 fw-bold" for="loan_late_fee">LATE FEE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_other_fee"
                                                       id="loan_other_fee"
                                                       placeholder="Other Fee">
                                                <label class="font-small-2 fw-bold" for="loan_other_fee">OTHER FEE</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 my-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" name="loan_grace"
                                                       id="loan_grace"
                                                       placeholder="GRACE">
                                                <label class="font-small-2 fw-bold" for="loan_grace">GRACE</label>
                                            </div>
                                        </div>

                                        <input type="hidden" id="user_id" name="user_id">
                                        <input type="hidden" id="total_loan_interest" name="total_loan_interest">
                                        <input type="hidden" id="dps_id" name="special_dps_id">
                                        <input type="hidden" id="loan_id" name="special_dps_loan_id">
                                        <input type="hidden" id="total" name="total">



                                        <div class="col-lg-12 my-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="loan_note" id="loan_note"
                                                       placeholder="Note">
                                                <label class="font-small-2 fw-bold" for="loan_note">NOTE</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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

            {{--  <!-- User Sidebar -->
              <div class="col-xl-3 col-lg-4 col-md-4">
                  <!-- User Card -->
                  <div class="card">
                      <div class="card-body">


                      </div>
                  </div>
                  <!-- /User Card -->
              </div>
              <!--/ User Sidebar -->--}}
        </div>

        <section id="nav-filled">
            <div class="row match-height">
                <!-- Filled Tabs starts -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
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
                                    <th>NAME</th>
                                    <th>A/C</th>
                                    <th>DPS</th>
                                    <th>LOAN</th>
                                    <th>INTEREST</th>
                                    <th>TOTAL</th>
                                    <th>TRX ID</th>
                                    <th>DATE</th>
                                    <th>COLLECTOR</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                            </table>
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
                        {{-- <input type="hidden" name="account_no">
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
                         <input type="hidden" name="created_by" value="{{ \Illuminate\Support\Facades\Auth::id() }}">--}}
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
                        height="100"
                        width="100"
                        alt="User avatar"
                    />
                    <div class="user-info text-center mb-1">
                        <h4 class="ac_holder"></h4>
                        <span class="badge bg-light-danger"><i data-feather='phone'></i> <span
                                class="phone"></span></span>
                    </div>
                </div>
            </div>

            <div id="savings-info">
                <div class="info-container">
                    <table class="savings-info-list">

                    </table>
                </div>
            </div>

            <div id="loan-info">
                <div class="info-container">
                    <ul class="list-unstyled loan-info-list">

                    </ul>
                    <table id="interestTable" class="table table-sm bordered">

                    </table>

                </div>
            </div>

            <div class="d-flex justify-content-center pt-2 buttons">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-installment-details" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Installment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Name: <span class="name"></span></td>
                            <td>A/C No: <span class="account"></span></td>
                        </tr>
                        <tr>
                            <td>DPS: <span class="dps"></span></td>
                            <td>Loan Payment: <span class="loan"></span></td>
                        </tr>
                        <tr>
                            <td>Interest: <span class="interest"></span></td>
                            <td>Date: <span class="date"></span></td>
                        </tr>
                    </table>
                    <table class="table table-sm dps-installment-list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>DPS Amount</th>
                            <th>Month</th>
                            <th>Collector</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <table class="table table-sm loan-installment-list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Interest</th>
                            <th>Month</th>
                            <th>Collector</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-edit" data-bs-dismiss="modal">Submit</button>
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
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-sm"
                                           name="dps_amount" id="edit_dps_amount"
                                           placeholder="DPS AMOUNT" readonly>
                                    <label class="font-small-2 fw-bold" for="dps_amount">DPS</label>
                                </div>
                            </div>

                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-sm"
                                           name="dps_installments" id="edit_dps_installments"
                                           placeholder="# INSTALLMENTS" min="1">
                                    <label class="font-small-2 fw-bold" for="edit_dps_installments"># INSTALLMENTS</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="receipt_no"
                                           id="edit_receipt_no"
                                           placeholder="Note">
                                    <label class="font-small-2 fw-bold" for="edit_receipt_no">RECEIPT NO</label>
                                </div>
                            </div>

                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="late_fee" id="edit_late_fee"
                                           placeholder="Late Fee">
                                    <label class="font-small-2 fw-bold" for="edit_late_fee">LATE FEE</label>
                                </div>
                            </div>

                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="other_fee"
                                           id="edit_other_fee"
                                           placeholder="OTHER FEE">
                                    <label class="font-small-2 fw-bold" for="edit_other_fee">OTHER FEE</label>
                                </div>
                            </div>

                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="due" id="edit_due"
                                           placeholder="DUE">
                                    <label class="font-small-2 fw-bold" for="edit_due">DUE</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="due_return"
                                           id="edit_due_return"
                                           placeholder="DUE RETURN">
                                    <label class="font-small-2 fw-bold" for="edit_due_return">DUE RETURN</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="advance" id="edit_advance"
                                           placeholder="ADVANCE">
                                    <label class="font-small-2 fw-bold" for="edit_advance">ADVANCE</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="advance_return"
                                           id="edit_advance_return"
                                           placeholder="ADVANCE">
                                    <label class="font-small-2 fw-bold" for="edit_advance_return">ADV. RETURN</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="grace"
                                           id="edit_grace"
                                           placeholder="GRACE">
                                    <label class="font-small-2 fw-bold" for="edit_grace">GRACE</label>
                                </div>
                            </div>
                            <div class="col-lg-8 my-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="date"
                                           id="edit_date">
                                    <label class="font-small-2 fw-bold" for="edit_date">DATE</label>
                                </div>
                            </div>
                            <div class="col-lg-12 my-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="dps_note" id="edit_dps_note"
                                           placeholder="Note">
                                    <label class="font-small-2 fw-bold" for="edit_dps_note">NOTE</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-update-dps">
                            Update
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
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="loan_installment"
                                           id="edit_loan_installment"
                                           placeholder="Installment">
                                    <label class="font-small-2 fw-bold" for="edit_loan_installment">LOAN PAYMENT</label>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="interest" id="edit_interest"
                                           placeholder=" " readonly>
                                    <label class="font-small-2 fw-bold" for="edit_interest">INTEREST</label>
                                </div>
                            </div>
                            <div class="col-lg-12 edit-loan-list">
                                <table class="table table-sm"></table>
                            </div>
                            <div class="col-lg-6 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="due_interest"
                                           id="edit_due_interest"
                                           placeholder=" ">
                                    <label class="font-small-2 fw-bold" for="edit_due_interest">DUE INTEREST</label>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="loan_late_fee"
                                           id="edit_loan_late_fee"
                                           placeholder="Late Fee">
                                    <label class="font-small-2 fw-bold" for="edit_loan_late_fee">LATE FEE</label>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="loan_other_fee"
                                           id="edit_loan_other_fee"
                                           placeholder="Other Fee">
                                    <label class="font-small-2 fw-bold" for="edit_loan_other_fee">OTHER FEE</label>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="loan_grace"
                                           id="edit_loan_grace"
                                           placeholder="GRACE">
                                    <label class="font-small-2 fw-bold" for="edit_loan_grace">GRACE</label>
                                </div>
                            </div>
                            <input type="hidden" id="edit_user_id" name="user_id">
                            <input type="hidden" id="edit_total_loan_interest" name="total_loan_interest">
                            <input type="hidden" id="edit_loan_id" name="special_dps_loan_id">
                            <input type="hidden" id="edit_total" name="total">
                            <div class="col-lg-4 my-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control edit_date" name="date">
                                    <label class="font-small-2 fw-bold">DATE</label>
                                </div>
                            </div>
                            <div class="col-lg-8 my-1">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="loan_note" id="edit_loan_note"
                                           placeholder="Note">
                                    <label class="font-small-2 fw-bold" for="edit_loan_note">NOTE</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-update-loan">
                            Update
                        </button>
                    </div>
                </form>
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

        var taken_loans = '';
        var total_interest = 0;
        var dps_amount = 0;
        var dpsInstallments = 0;
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
            let collectionType = $("input[name='collection_type[]']").val();
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
            let loan_installment = $("#loan_installment").val();
            let interest = $("#interest").val();
            let due_interest = $("#due_interest").val();
            let loan_late_fee = $("#loan_late_fee").val();
            let loan_other_fee = $("#loan_other_fee").val();
            let loan_grace = $("#loan_grace").val();
            let grace = $("#grace").val();

            console.log(loan_installment);

            $(".table-collection-info").empty();
            var total = 0;
            $(".date").text(date);
            $(".ac_holder").text();

            if ($("input[name='collection_type']:checked") == 'dps_installment') {
                console.log("dps")
            }

            if (dps_amount != 0) {
                total += parseInt(dps_amount);
                $(".table-collection-info").append(`
           <tr>
                    <th>DPS</th>
                    <td>${dps_amount}</td>
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

            if (due != "") {
                total -= parseInt(due);
                $(".table-collection-info").append(`
           <tr>
                    <th>Due</th>
                    <td>${due}</td>
                </tr>
            `);
            }
            if (due_return != "") {
                total += parseInt(due_return);
                $(".table-collection-info").append(`
           <tr>
                    <th>Due Return</th>
                    <td>${due_return}</td>
                </tr>
            `);
            }

            if (advance != "") {
                total += parseInt(advance);
                $(".table-collection-info").append(`
           <tr>
                    <th>Advance</th>
                    <td>${advance}</td>
                </tr>
            `);
            }
            if (advance_return != "") {
                total -= parseInt(advance_return);
                $(".table-collection-info").append(`
           <tr>
                    <th>Advance Return</th>
                    <td>${advance_return}</td>
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
            if (interest != "") {
                total += parseInt(interest);
                $(".table-collection-info").append(`
           <tr>
                    <th>Loan Interest</th>
                    <td>${interest}</td>
                </tr>
            `);
            }

            if (due_interest != "") {
                total += parseInt(due_interest);
                $(".table-collection-info").append(`
           <tr>
                    <th>Due Interest</th>
                    <td>${due_interest}</td>
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
            if (loan_grace != "") {
                total -= parseInt(loan_grace);
                $(".table-collection-info").append(`
           <tr>
                    <th>Loan Grace</th>
                    <td>${loan_grace}</td>
                </tr>
            `);
            }

            if (grace != "") {
                total -= parseInt(grace);
                $(".table-collection-info").append(`
           <tr>
                    <th>DPS Grace</th>
                    <td>${grace}</td>
                </tr>
            `);
            }

            $("#total").val(total);
            $(".table-collection-info").append(`
            <tfoot>
            <tr>
                <th>Total</th>
                <td class="bg-success text-white"><span class="total">${total}</span></td>
            </tr>
            </tfoot>
            `);

            $("#modalCollection").modal("show");
        }

        function resetForm() {
            $("#collectionForm").trigger('reset');
            $("#formCollection").trigger('reset');
            $('#account_no').val(null).trigger('change');
            $('#collector_id').val(null).trigger('change');
            $('#saving_type').val(null).trigger('change');
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

        var myOffcanvas = document.getElementById('offcanvasScroll');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $(".submission-form").addClass("col-xl-12 col-lg-12 col-md-12");
            $(".submission-form").removeClass("col-xl-9 col-lg-9 col-md-9");
        })

        $('.btn-dps-info').on('click', function (e) {
            var account_no = $("#account_no option:selected").val();
            var date = $("#date").val();
            total_interest = 0;
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
                    $("#dps_id").val(data.dpsInfo.id);
                    var loanInfo = data.loanInfo;
                    if (loanInfo != "") {
                        $("#interestTable").append(`
                        <thead> <tr class="font-small-2">
                        <th class="font-small-1">Loan</th>
<th class="font-small-1">Remain</th>
<th class="font-small-1">Interest</th>
<th class="font-small-1">Due</th>
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
                            <td style="width: 15%">
<input type="number" class="form-control form-control-sm" name="interest_installment[]" min="1" step="1" max="${b.dueInstallment}" value="${b.dueInstallment}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control form-control-sm taken_total_interest" name="taken_total_interest[]" value="${b.dueInstallment * b.interest}" disabled></td>
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
                    dps_amount = dps.package_amount;
                    dpsInstallments = data.dpsDue;
                    $(".savings-balance h4").text(dps.balance);
                    $("#dps_amount").val(dps.package_amount * data.dpsDue);
                    $("#dps_installments").val(data.dpsDue);
                    $(".buttons").append(`<a href="{{ url('all-dps') }}/${dps.id}" class="btn btn-sm btn-primary me-1">
                            Savings InFo
                        </a>`);
                    $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">A/C NO</td><td>:</td>
                                        <td class="account_no px-1">${dps.account_no}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">DPS AMOUNT</td><td>:</td>
                                        <td class="total_withdraw px-1">${dps.package_amount}</td>
                                    </tr>
</tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">DPS BALANCE</td><td>:</td>
                                        <td class="total_withdraw px-1">${dps.balance}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">DPS DUE</td><td>:</td>
                                        <td class="total_withdraw px-1">${dps.package_amount} x ${data.dpsDue} = <span class="text-danger">${dps.package_amount * data.dpsDue}</span></td>
                                    </tr>
                    `);
                    if (data.loan != "") {
                        $(".buttons").append(`
                        <a href="{{ url('dps-loans') }}/${data.loan.id}" class="btn btn-sm btn-outline-sm btn-outline-danger suspend-user">Loan InFo</a>
`);
                        $("#loan_id").val(data.loan.id);
                        $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">LOAN</td><td>:</td>
                                        <td class="account_no px-1">${loan.loan_amount}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">RETURN</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.loan_amount - loan.remain_loan}</td>
                                    </tr>
<tr class="font-small-2">
                                        <td class="fw-bolder ">REMAIN</td><td>:</td>
                                        <td class="total_withdraw px-1">${loan.remain_loan}</td>
                                    </tr>
                    `);
                    }
                    if (loan.dueInterest != null) {
                        $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">DUE INTEREST</td><td>:</td>
                                        <td class="px-1">${loan.dueInterest}</td>
                                    </tr>
                    `);
                    }

                    if (data.lastLoanPayment != 'null') {
                        $(".savings-info-list").append(`
                    <tr class="font-small-2">
                                        <td class="fw-bolder ">LAST LOAN PAYMENT</td><td>:</td>
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

            //$("#modals-slide-in").modal("show");
            //var myOffcanvas = document.getElementById('offcanvasScroll');
            // var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();
            myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
                $(".submission-form").removeClass("col-xl-12 col-lg-12 col-md-12");
                $(".submission-form").addClass("col-xl-9 col-lg-9 col-md-9");
            })
        });

        // var myOffcanvas = document.getElementById('offcanvasScroll');
        //var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

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
                    bsOffcanvas.hide();
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
                    {"data": "trx_id"},
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
                                $id = full['id'],
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
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +
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
                                '<a href="javascript:;" data-id="' + full['id'] + '" data-name="' + full['name'] + '"' +
                                'data-account_no="' + full['account_no'] + '" data-dps="' + full['dps_amount'] + '"' +
                                'data-loan="' + full['loan_installment'] + '" data-interest="' + full['interest'] + '"' +
                                'data-date="' + full['date'] + '" class="dropdown-item item-details">' +
                                feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) +
                                'Details</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-dps">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4 me-50'}) +
                                'Edit DPS</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-loan">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4 me-50'}) +
                                'Edit Loan</a>' +
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
                                $id = full['id'],
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
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +
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
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-dps">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4 me-50'}) +
                                'Edit DPS</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item edit-loan">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4 me-50'}) +
                                'Edit Loan</a>' +
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
        $(document).on("click", ".item-edit", function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('getDpsCollectionData') }}/" + id,
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
        $(document).on("click", ".item-details", function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var account = $(this).attr('data-account_no');
            var dps = $(this).attr('data-dps');
            var loan = $(this).attr('data-loan');
            var interest = $(this).attr('data-interest');
            var date = $(this).attr('data-date');

            $(".name").text(`${name}`);
            $(".account").text(`${account}`);
            $(".dps").text(`${dps}`);
            $(".loan").text(`${loan}`);
            $(".interest").text(`${interest}`);
            $(".date").text(`${date}`);
            $("#modal-installment-details").modal("show")
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
        var editDate = $('#edit_date');
        if (editDate.length) {
            editDate.flatpickr({
                static: true,
                altInput: true,
                altFormat: 'd/m/Y',
                dateFormat: 'Y-m-d',
            });
        }

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

                    editDate.flatpickr({
                        altFormat: 'd/m/Y',
                        defaultDate: paymentDate
                    });
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

                    $(".edit_date").flatpickr({
                        altFormat: 'd/m/Y',
                        defaultDate: paymentDate
                    });
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
<input type="number" class="form-control form-control-sm" name="interest_installment[]" min="1" step="1" value="${b.installments}">
                            <input type="hidden" name="taken_interest[]" value="${b.interest}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control form-control-sm edit_taken_total_interest" name="taken_total_interest[]" value="${b.installments * b.interest}" disabled></td>
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
    </script>
@endsection
