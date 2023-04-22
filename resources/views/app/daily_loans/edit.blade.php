@extends('layouts/contentLayoutMaster')

@section('title', 'Daily Loan')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <!-- Horizontal Wizard -->
    <section class="horizontal-wizard">
        <div class="row">
            <div class="col-md-8">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
            <span class="bs-stepper-title">Account Details</span>
            <span class="bs-stepper-subtitle">Setup Account Details</span>
          </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#nominee-info" role="tab" id="nominee-info-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
            <span class="bs-stepper-title">Guarantor Info</span>
            <span class="bs-stepper-subtitle">Add Guarantor Info</span>
          </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="account-details" class="content" role="tabpanel"
                             aria-labelledby="account-details-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Account Details</h5>
                                <small class="text-muted">Enter Your Account Details.</small>
                            </div>
                            <form>
                                <div class="row mb-3">
                                    @php
                                        $accounts = \App\Models\DailySavings::with('user')->where('status','active')->orderBy('account_no','asc')->get();
                                    @endphp
                                    <div class="col-md-6 mb-2">
                                        <label for="account_no" class="form-label">A/C No</label>
                                        <select data-allow-clear="true" name="account_no" id="account_no" data-placeholder="-- Select A/C --" class="select2 form-select">
                                            <option value=""></option>
                                            @forelse($accounts as $account)
                                                <option value="{{ $account->account_no }}" @if($account->account_no==$dailyLoan->account_no) selected @endif>{{ $account->account_no }}
                                                    || {{ $account->user->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="loan_amount" class="form-label">Loan Amount</label>
                                        <input type="number" class="form-control" id="loan_amount" name="loan_amount" value="{{ $dailyLoan->loan_amount }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="package_id" class="form-label">Package</label>
                                        <select name="package_id" id="package_id" data-placeholder="-- Select Package --" data-allow-clear="true" class="select2 form-select">
                                            <option value=""></option>
                                            @forelse($dailyLoanPackages as $package)
                                                <option value="{{ $package->id }}" @if($package->id==$dailyLoan->package_id) selected @endif>{{ $package->months }} || {{ $package->interest }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $dailyLoan->user_id }}">
                                    <div class="col-md-3 mb-2">
                                        <label for="interest" class="form-label">Interest</label>
                                        <input type="number" class="form-control" id="interest" name="interest" value="{{ $dailyLoan->interest }}">
                                    </div>
                                    <input type="hidden" name="balance" id="loan_balance">
                                    <div class="col-md-3 mb-2">
                                        <label for="per_installment" class="form-label">Per Installment</label>
                                        <input type="number" class="form-control" id="per_installment" name="per_installment" value="{{ $dailyLoan->per_installment }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Opening Date</label>
                                        <input type="text" class="form-control flatpickr-basic" id="opening_date"
                                               name="opening_date" aria-label="MM/DD/YYYY" value="{{ $dailyLoan->opening_date }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Commencement</label>
                                        <input type="text" class="form-control flatpickr-basic" id="commencement"
                                               name="commencement" aria-label="MM/DD/YYYY" value="{{ $dailyLoan->commencement }}">
                                    </div>


                                    <div class="col-md-12 mb-2">
                                        <label for="account_no" class="form-label">Note</label>
                                        <input type="text" class="form-control" id="note"
                                               name="note" value="{{ $dailyLoan->note??'' }}">
                                    </div>
                                </div>

                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev" disabled>
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none">Next</span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="nominee-info" class="content" role="tabpanel" aria-labelledby="nominee-info-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Guarantor Info</h5>
                                <small>Enter Guarantor Info.</small>
                            </div>
                            <form>
                                <div class="row">
                                    @php
                                        $users = \App\Models\User::all();
                                    @endphp
                                    <div class="mb-1 col-md-12">
                                        <label class="form-label" for="name">Select User</label>
                                        <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-placeholder="-- Select User --">
                                            <option value=""></option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="John"/>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control"/>
                                    </div>

                                    <div class="mb-1 col-md-12">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"/>
                                    </div>

                                </div>


                                <input type="hidden" name="status" value="active">
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-submit">
                                    <span class="align-middle d-sm-inline-block  d-none">
                                        <span class="spinner spinner-border spinner-border-sm"
                                              style="display: none" role="status"
                                              aria-hidden="true"></span> Submit</span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">

                    <div class="divider">
                        <div class="divider-text">User Information</div>
                    </div>

                    <div class="card-body">
                        <div class="user-data">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /Horizontal Wizard -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>

    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    {{-- <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>--}}
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    <script>
        var formSection = $('.horizontal-wizard-example');
        var bsStepper = document.querySelectorAll('.bs-stepper'),
            select = $('.select2'),
            horizontalWizard = document.querySelector('.horizontal-wizard-example');
        // Adds crossed class
        if (typeof bsStepper !== undefined && bsStepper !== null) {
            for (var el = 0; el < bsStepper.length; ++el) {
                bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                    var index = event.detail.indexStep;
                    var numberOfSteps = $(event.target).find('.step').length - 1;
                    var line = $(event.target).find('.step');

                    // The first for loop is for increasing the steps,
                    // the second is for turning them off when going back
                    // and the third with the if statement because the last line
                    // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                    for (var i = 0; i < index; i++) {
                        line[i].classList.add('crossed');

                        for (var j = index; j < numberOfSteps; j++) {
                            line[j].classList.remove('crossed');
                        }
                    }
                    if (event.detail.to == 0) {
                        for (var k = index; k < numberOfSteps; k++) {
                            line[k].classList.remove('crossed');
                        }
                        line[0].classList.remove('crossed');
                    }
                });
            }
        }

        // select2
        select.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                placeholder: 'Select value',
                dropdownParent: $this.parent()
            });
        });

        // Horizontal Wizard
        // --------------------------------------------------------------------
        if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
            var numberedStepper = new Stepper(horizontalWizard),
                $form = $(horizontalWizard).find('form');
            $form.each(function () {
                var $this = $(this);
                $this.validate({
                    rules: {
                        account_no:{
                            required: true
                        },
                        loan_amount:{
                            required: true
                        },
                        package_id:{
                            required: true
                        },
                        interest:{
                            required: true
                        },
                        per_installment:{
                            required: true
                        },
                        opening_date:{
                            required: true
                        },
                        commencement:{
                            required: true
                        }
                    }
                });
            });

            $(horizontalWizard)
                .find('.btn-next')
                .each(function () {
                    $(this).on('click', function (e) {
                        var isValid = $(this).parent().siblings('form').valid();
                        if (isValid) {
                            numberedStepper.next();
                        } else {
                            e.preventDefault();
                        }
                    });
                });

            $(horizontalWizard)
                .find('.btn-prev')
                .on('click', function () {
                    numberedStepper.previous();
                });

            $(horizontalWizard)
                .find('.btn-submit')
                .on('click', function () {
                    var isValid = $(this).parent().siblings('form').valid();
                    if (isValid) {
                        $(".spinner").show();
                        var formData = $("form").serializeArray();
                        $.ajax({
                            url: "{{ route('daily-loans.store') }}",
                            method: "POST",
                            data: formData,
                            success: function (data) {
                                $(".spinner").hide();
                                $("form").trigger('reset');
                                toastr.success('New savings account successfully added.', 'New Savings!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                            }
                        })
                    }
                });
        }

        $('#account_no').on('select2:select', function (e) {
            $(".user-data").empty();
            var data = e.params.data;
            $.ajax({
                url: "{{ url('savingsInfoByAccount') }}/"+data.id,
                dataType: "json",
                type: "get",
                success: function (data) {
                    $("#user_id").val(data.user.id);
                    var image = '';
                    if (data.user.profile_photo_path == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.profile_photo_path;
                    }
                    $(".user-data").append(`
                    <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mt-3 mb-2" src="${image}" height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>${data.user.name}</h4>
                                        <span class="badge bg-light-secondary">${data.user.phone1}</span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Father:</span>
                                        <span>${data.user.father_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Mother:</span>
                                        <span>${data.user.mother_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Spouse:</span>
                                        <span class="badge bg-light-success">${data.user.spouse_name}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Present Address:</span>
                                        <span>${data.user.present_address}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Join Date:</span>
                                        <span>${data.user.join_date}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Savings:</span>
                                        <span>${data.daily_savings}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total DPS:</span>
                                        <span>${data.dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Total Special DPS:</span>
                                        <span>${data.special_dps}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Daily Loans:</span>
                                        <span>${data.daily_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">DPS Loans:</span>
                                        <span>${data.dps_loans}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Special DPS Loan:</span>
                                        <span>${data.special_dps_loans}</span>
                                    </li>
                                </ul>
                            </div>
                    `);
                }
            })
        });


        $("#package_id").on('select2:select',function(e) {
            var principal = $("#loan_amount").val();
            console.log(principal);
            var packageId = e.params.data.id;
            $('#per_installment').empty();
            $("#interest").empty();
            $("#loan_balance").val('');
            $.ajax({
                url : "{{ url('getPackageInfo') }}/" +packageId,
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    console.log(data);
                    if (data)
                    {
                        var interest = principal*(data.interest/100)*1;
                        var principalWithInterest = parseFloat(principal) + parseFloat(interest);
                        var installment = principalWithInterest/data.months;

                        $("#loan_balance").val(principalWithInterest);

                        $("#interest").val(interest);

                        $('#per_installment').empty();
                        $('#per_installment').focus();
                        $('#per_installment').val(Math.round(installment));

                    }else {
                        $('#per_installment').empty();
                        $("#interest").empty();

                    }
                }
            });
        });

        $("#guarantor_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#name").val('');
            $("#address").val('');
            $("#phone").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //console.log(data)
                    $("#name").val(data.name);
                    $("#address").val(data.present_address);
                    $("#phone").val(data.phone1);
                }
            })
        })
    </script>
@endsection
