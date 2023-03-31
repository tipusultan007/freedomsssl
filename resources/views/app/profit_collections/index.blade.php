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
                <form id="formCollection">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    @php
                                        $accounts = \App\Models\Fdr::with('user')->where('status','active')->get();
                                    @endphp
                                    <div class="mb-1">
                                        <label class="form-label" for="basicInput">A/C No</label>
                                        <select class="select2 form-select" name="fdr_id" id="account_no"
                                                data-placeholder="Select Account" data-allow-clear="on">
                                            <option value=""></option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}"> {{$account->account_no}}
                                                    || {{$account->user->name}}
                                                    || {{$account->user->father_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">Date</label>
                                        <input type="text" id="date" name="date" class="form-control flatpickr-basic"
                                               value="{{date('Y-m-d')}}" placeholder="DD-MM-YYYY"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card collection-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 my-1">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="profit" id="interest"
                                               placeholder=" " readonly>
                                        <label for="interest">PROFIT</label>
                                    </div>

                                    <div class=" loan-list">
                                        <table class=""></table>
                                    </div>
                                </div>


                                <div class="col-lg-6 my-1">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="other_fee"
                                               id="other_fee"
                                               placeholder="Other Fee">
                                        <label for="other_fee">OTHER FEE</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 my-1">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="grace"
                                               id="grace"
                                               placeholder="GRACE">
                                        <label for="grace">GRACE</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 my-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="note" id="note"
                                               placeholder="Note">
                                        <label for="loan_note">NOTE</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-gradient-success btn-submit w-25"
                                            onclick="modalData()">
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
                                    <th>Profit</th>
                                    <th>Grace</th>
                                    <th>Other Fee</th>
                                    <th>Balance</th>
                                    <th>TrxID</th>
                                    <th>Date</th>
                                    <th>Created By</th>
                                    <th>Action</th>
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
                    <h5 class="modal-title" id="modalCollectionTitle">Profit Withdraw</h5>
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

    <div class="modal fade" id="modal-profit-details" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Profit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1 name"></div>
                    <div class="mb-1 account"></div>
                    <div class="mb-1 total"></div>
                    <div class="mb-1 date"></div>
                    <table class="table table-sm profit-list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Profit</th>
                            <th>Installments</th>
                            <th>Total</th>
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
    <div class="modal fade" id="modalFdrDeposit" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit FDR Deposit</h5>
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
    <div class="offcanvas offcanvas-end"
        data-bs-scroll="true"
        data-bs-backdrop="false"
        tabindex="-1"
        id="offcanvasScroll"
        aria-labelledby="offcanvasScrollLabel">
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
                        <small>FDR Balance</small>
                    </div>
                </div>

            </div>
            <div id="savings-info">
                <h4 class="fw-bolder border-bottom pb-50 mb-1">FDR Details</h4>
                <div class="info-container">
                    <ul class="list-unstyled savings-info-list">

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

        var total_interest = 0;
        var dpsInstallments = 0;

        var myOffcanvas = document.getElementById('offcanvasScroll');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $(".submission-form").addClass("col-xl-12 col-lg-12 col-md-12");
            $(".submission-form").removeClass("col-xl-9 col-lg-9 col-md-9");
        })

        function modalData() {
            let profit = $("#interest").val();
            let other_fee = $("#other_fee").val();
            let grace = $("#grace").val();
            let date = $("#date").val();


            $(".table-collection-info").empty();
            var total = 0;
            $(".date").text(date);
            $(".ac_holder").text();


            if (profit != 0) {
                total += parseInt(profit);
                $(".table-collection-info").append(`
           <tr>
                    <th>Profit</th>
                    <td>${profit}</td>
                </tr>
            `);
            }

            if (other_fee != "") {
                total -= parseInt(other_fee);
                $(".table-collection-info").append(`
           <tr>
                    <th>Other Fee</th>
                    <td>${other_fee}</td>
                </tr>
            `);
            }


            if (grace != "") {
                total += parseInt(grace);
                $(".table-collection-info").append(`
           <tr>
                    <th>Grace</th>
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

        function calculateInterest(interest, installments) {
            return interest * installments;
        }

        $(document).on("change", ".loan-list table input[name='installments[]']", function () {
            var row = $(this).closest('tr');
            var temp_total = total_interest;
            var temp_taken_total_interest = $(row).find("input[name='taken_total_interest[]']").val();
            var interest_rate = $(row).find("input[name='profit_rate[]']").val();
            var installments = $(this).val();
            var interest = calculateInterest(interest_rate, installments);
            $(row).find("input[name='taken_total_interest[]']").val(interest);
            sumOfInterest();
        });
        $(document).on("click", ".loan-list table input[type=checkbox]", function () {
            if ($(this).prop("checked") == true) {
                var row = $(this).closest('tr');
                $(row).find('td').eq(1).find('input').prop('disabled', false);
                var interest_rate = $(row).find("input[name='profit_rate[]']").val();
                var installments = $(row).find("input[name='installments[]']").val();
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

        function sumOfInterest() {
            var sum = 0;
            $('.taken_total_interest').each(function () {
                sum += Number($(this).val());
            });
            $("#interest").val(sum);
        }

        $("#account_no").on("select2:clear", function (e) {
            $(".loan-list table").empty();
            $("#interest").val(0);
            bsOffcanvas.hide();
        })
        $('#account_no').on('select2:select', function (e) {
            var account_no = e.params.data.id;
            $(".savings-info-list").empty();
            $(".fdr-list").empty();
            $(".loan-list table").empty();
            $(".buttons").empty();
            $.ajax({
                url: "{{ url('profitInfo') }}/",
                dataType: "JSON",
                data: {fdr_id: account_no, date: $("#date").val()},
                success: function (data) {
                    console.log(data);
                    $("#user_id").val(data.fdr.user_id);
                    $(".ac_holder").text(data.fdr.user.name);
                    $(".phone").text(data.fdr.user.phone1);
                    $(".acc_no").text(data.fdr.account_no);
                    $("#offcanvasScrollLabel").text(data.fdr.user.name);
                    $("#daily_savings_id").val(data.fdr.id);
                    var fdr = data.fdr;
                    $(".savings-balance h5").text(fdr.balance);
                    $(".buttons").append(`<a href="{{ url('fdrs') }}/${data.fdr.id}" class="btn btn-sm btn-primary me-1">
                            FDR InFo
                        </a>`);
                    $(".savings-info-list").append(`
<li class="mb-75">
                                        <span class="fw-bolder me-25">A/C No:</span>
                                        <span class="account_no">${fdr.account_no}</span>
                                    </li>

  <li class="mb-75">
                                        <span class="fw-bolder me-25">Name:</span>
                                        <span class="">${fdr.user.name}</span>
                                    </li>
  <li class="mb-75">
                                        <span class="fw-bolder me-25">Mobile:</span>
                                        <span class=" badge bg-light-danger">${fdr.user.phone1}</span>
                                    </li>

 <li class="mb-75">
                                        <span class="fw-bolder me-25">FDR Balance:</span>
                                        <span class="">${fdr.balance}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Deposit:</span>
                                        <span class="total_deposit">${fdr.amount}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Withdraw:</span>
                                        <span class="total_withdraw">${fdr.amount - fdr.balance}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Profit Withdraw:</span>
                                        <span class="profit">${fdr.profit}</span>
                                    </li>

                    `);

                    if (data.profit_list.length) {
                        $(".fdr-list").append(`
                        <thead>
	<tr>
		<th>FDR</th>
		<th>Commencement</th>
		<th>Profit Rate</th>
		<th>Due</th>
<th>Total</th>
	</tr>
</thead>
                        `);
                        let total_profit = 0;
                        $.each(data.profit_list, function (a, b) {
                            total_profit += (b.dueInstallment * b.profit);
                            $(".fdr-list").append(`
                            <tr>
<td>${b.fdr_deposit} </td>
<td>${b.commencement} </td>
<td>${b.profit} </td>
<td>${b.dueInstallment} </td>
<td>${b.dueInstallment * b.profit} </td>
</tr>
                            `);
                            if (b.dueInstallment > 0) {
                                $(".loan-list table").append(`

                            <tr>
                            <td>
                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="fdr_deposit_id[]" id="fdr_deposit_id_${b.fdr_deposit_id}" value="${b.fdr_deposit_id}" checked>
                                                                            <label class="form-check-label" for="fdr_deposit_id_${b.fdr_deposit_id}">${b.profit}</label>
                                                                        </div>
                            </td>
                            <td style="width: 15%">
<input type="number" class="form-control form-control-sm" name="installments[]" min="1" step="1" max="${b.dueInstallment}" value="${b.dueInstallment}">
                            <input type="hidden" name="profit_rate[]" value="${b.profit}">
                            </td>
<td style="width: 30%"><input type="number" class="form-control form-control-sm taken_total_interest" name="taken_total_interest[]" value="${b.dueInstallment * b.profit}" disabled></td>
                            </tr>

                            `);
                            }

                        })

                        $("#interest").val(total_profit);
                        //$("#total_loan_interest").val(total_interest);
                    }
                    if (data.fdr.user.profile_photo_path == null) {
                        $(".profile-image").attr('src', data.fdr.user.profile_photo_url);
                    }
                }
            })

            bsOffcanvas.show();
            myOffcanvas.addEventListener('shown.bs.offcanvas', function () {
                $(".submission-form").removeClass("col-xl-12 col-lg-12 col-md-12");
                $(".submission-form").addClass("col-xl-9 col-lg-9 col-md-9");
            })
        });


        $(".btn-confirm").on("click", function () {
            //$(".spinner").show();
            //$(".btn-confirm").attr('disabled',true);
            var $this = $(".btn-confirm"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            $.ajax({
                url: "{{ route('fdr-profits.store') }}",
                method: "POST",
                data: $("#formCollection").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $(".datatables-basic").DataTable().destroy();
                    loadSavingsCollection();
                    $this.attr('disabled', false).html($caption);
                    $("#modalCollection").modal("hide");
                    toastr['success']('👋 Submission has been saved successfully.', 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    bsOffcanvas.hide();
                    resetForm();
                    $(".savings-info-list").empty();
                    $(".fdr-list").empty();
                    $(".loan-list table").empty();
                },
                error: function (data) {
                    $("#modalCollection").modal("hide");
                    $this.attr('disabled', false).html($caption);
                    toastr['error']('Submission failed. Please try again.', 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    bsOffcanvas.hide();
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
                    "url": "{{ url('allFdrProfits') }}",
                    type: "GET",
                    data: {account: account, collector: collector, from: from, to: to}
                },
                "columns": [

                    {"data": "name"},
                    {"data": "account_no"},
                    {"data": "profit"},
                    {"data": "grace"},
                    {"data": "other_fee"},
                    {"data": "balance"},
                    {"data": "trx_id"},
                    {"data": "date"},
                    {"data": "created_by"},
                    {"data": "action"},
                ],
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
                                '<a href="javascript:;" data-date="' + full['date'] + '" data-id="' + full['id'] + '" data-total="' + full['profit'] + '" data-ac="' + full['account_no'] + '"  data-name="' + full['name'] + '" class="dropdown-item item-details">' +
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


        $(document).on("click",".item-details",function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var ac = $(this).attr('data-ac');
            var total = $(this).attr('data-total');
            var date = $(this).attr('data-date');
            $(".name,.account,.total,.date").empty();
            $(".profit-list tbody").empty();
            $.ajax({
                url: "{{ url('getProfitList') }}/"+id,
                dataType: "JSON",
                success: function (data) {
                    $(".name").append(`
                    Name: <span class="text-success">${name}</span>
                    `);
                    $(".account").append(`
                    A/C No: <span class="text-success">${ac}</span>
                    `);
                    $(".total").append(`
                    Total: <span class="text-danger">${total}</span>
                    `);
                    $(".date").append(`
                    Date: <span class="text-success">${date}</span>
                    `);
                    $.each(data,function (a,b) {
                        $(".profit-list tbody").append(`
                        <tr>
<td>${a+1}</td>
<td>${b.profit}</td>
<td>${b.installments}</td>
<td>${b.total}</td>
</tr>
                        `);
                    })
                }
            })
            $("#modal-profit-details").modal("show");
        })
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
                            url: "fdr-profits/" + id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response) {

                                //$("#success").html(response.message)

                                Swal.fire(
                                    'Remind!',
                                    'Company deleted successfully!',
                                    'success'
                                )
                                $(".datatables-basic").DataTable().destroy();
                                loadSavingsCollection();
                            }
                        });
                }
            });
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
