@extends('layouts/contentLayoutMaster')

@section('title', 'Form Wizard')

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
                        <div class="step" data-target="#document-details" role="tab" id="document-details-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
            <span class="bs-stepper-title">Document Details</span>
            <span class="bs-stepper-subtitle">Setup Document Details</span>
          </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#nominee-info" role="tab" id="nominee-info-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">3</span>
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
                                        $accounts = \App\Models\Dps::with('user')->where('status','active')->get();
                                    @endphp
                                    <div class="col-md-6 mb-2">
                                        <label for="account_no" class="form-label">A/C No</label>
                                        <select data-allow-clear="true" name="account_no" id="account_no" class="select2 form-select" data-placeholder="Select Account">

                                            <option value="">Select Account</option>
                                            @forelse($accounts as $account)
                                                <option value="{{ $account->account_no }}">{{ $account->account_no }}
                                                    || {{ $account->user->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="loan_amount" class="form-label">Loan Amount</label>
                                        <input type="text" class="form-control" id="loan_amount" name="loan_amount">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="interest1" class="form-label">Interest Rate</label>
                                        <input type="number" class="form-control" id="interest1" name="interest1">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="interest2" class="form-label">Special Interest Rate</label>
                                        <input type="number" class="form-control" id="interest2" name="interest2">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="upto_amount" class="form-label">Upto Amount</label>
                                        <input type="text" class="form-control" id="upto_amount" name="upto_amount">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Loan Date</label>
                                        <input type="text" class="form-control flatpickr-basic" id="opening_date"
                                               name="opening_date" aria-label="MM/DD/YYYY">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Commencement</label>
                                        <input type="text" class="form-control flatpickr-basic" id="commencement"
                                               name="commencement" aria-label="MM/DD/YYYY">
                                    </div>


                                    <div class="col-md-12 mb-2">
                                        <label for="account_no" class="form-label">Note</label>
                                        <input type="text" class="form-control" id="note"
                                               name="note">
                                    </div>
                                </div>
                                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                                <input type="hidden" name="user_id" id="user_id">
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
                        <div id="document-details" class="content" role="tabpanel"
                             aria-labelledby="document-details-trigger">
                            <div class="content-header">
                                <h5 class="mb-0">Document Details</h5>
                                <small class="text-muted">Enter Document Details.</small>
                            </div>
                            <form>
                                <div class="row mb-3">

                                    <div class="col-md-4 mb-2">
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="branch_name" class="form-label">Branch Name</label>
                                        <input type="text" class="form-control" id="branch_name" name="branch_name">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="cheque_no" class="form-label">Cheque No</label>
                                        <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <label for="document_name" class="form-label">Upload Documents</label>
                                        <input class="form-control" type="file" name="document_name" id="document_name" multiple />
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label for="account_no" class="form-label">Note</label>
                                        <input type="text" class="form-control" id="note"
                                               name="note">
                                    </div>
                                </div>
                                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev">
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
                                    <div class="mb-1 col-md-12">
                                        <label class="form-label" for="name">Select User</label>
                                        <select name="guarantor_user_id" id="guarantor_user_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- Select User --">
                                            <option value="">Select Guarantor</option>
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

                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"/>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="percentage">A/C No</label>
                                        <input type="text" name="exist_ac_no" id="exist_ac_no" class="form-control"/>
                                    </div>
                                </div>


                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-submit">
                                    <span class="align-middle d-sm-inline-block  d-none">
                                        <span class="spinner spinner-border spinner-border-sm d-none"
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
                        <div class="divider-text">Applicant's Information</div>
                    </div>

                    <div class="card-body">
                        <div class="user-data">

                        </div>
                    </div>
                </div>

                <div class="card">

                    <div class="divider">
                        <div class="divider-text">Guarantor's Information</div>
                    </div>

                    <div class="card-body">
                        <div class="guarantor-data">

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
                        username: {
                            required: true
                        },
                        email: {
                            required: true
                        },
                        password: {
                            required: true
                        },
                        'confirm-password': {
                            required: true,
                            equalTo: '#password'
                        },
                        'first-name': {
                            required: true
                        },
                        'last-name': {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        landmark: {
                            required: true
                        },
                        country: {
                            required: true
                        },
                        language: {
                            required: true
                        },
                        twitter: {
                            required: true,
                            url: true
                        },
                        facebook: {
                            required: true,
                            url: true
                        },
                        google: {
                            required: true,
                            url: true
                        },
                        linkedin: {
                            required: true,
                            url: true
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
                            url: "{{ route('dps-loans.store') }}",
                            method: "POST",
                            data: formData,
                            success: function (data) {
                                $(".spinner").hide();
                                $("form").trigger('reset');
                                $("#account_no").val("").trigger("change");
                                $("#guarantor_user_id").val("").trigger("change");
                                $(".user-data").empty();
                                $(".guarantor-data").empty();
                                toastr.success('New DPS Loan successfully created.', 'New DPS Loan!', {
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
                url: "{{ url('dpsInfoByAccount') }}/"+data.id,
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
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td class="fw-bolder me-25">Father:</td>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Mother:</td>
                                        <td>${data.user.mother_name}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bolder me-25">Join Date:</td>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Savings:</td>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total DPS:</td>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Special DPS:</td>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Daily Loans:</td>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">DPS Loans:</td>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Special DPS Loan:</td>
                                        <td>${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">FDR:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">Guarantor:</td>
                                        <td class="gtable"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
                    if (data.guarantors != null)
                    {
                        $.each(data.guarantors,function (a,b) {
                            $(".gtable").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
                        })
                    }
                }
            })
        });
        $("#guarantor_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#name").val('');
            $("#address").val('');
            $("#phone").val('');
            $(".guarantor-data").empty();
            $.ajax({
                url: "{{ url('getDetails') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //console.log(data)
                    $("#name").val(data.user.name);
                    $("#address").val(data.user.present_address);
                    $("#phone").val(data.user.phone1);

                    var image = '';
                    if (data.user.profile_photo_path == null)
                    {
                        image = data.user.profile_photo_url+'&size=110';
                    }else {
                        image = data.user.profile_photo_path;
                    }
                    $(".guarantor-data").append(`
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
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td class="fw-bolder me-25">Father:</td>
                                        <td>${data.user.father_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Mother:</td>
                                        <td>${data.user.mother_name}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bolder me-25">Join Date:</td>
                                        <td>${data.user.join_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Savings:</td>
                                        <td>${data.daily_savings}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total DPS:</td>
                                        <td>${data.dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Total Special DPS:</td>
                                        <td>${data.special_dps}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Daily Loans:</td>
                                        <td>${data.daily_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">DPS Loans:</td>
                                        <td>${data.dps_loans}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder me-25">Special DPS Loan:</td>
                                        <td>${data.special_dps_loans}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">FDR:</td>
                                        <td>${data.fdr}</td>
                                    </tr>
<tr>
                                        <td class="fw-bolder me-25">Guarantor:</td>
                                        <td class="gtable2"></td>
                                    </tr>
                                </table>

                            </div>
                    `);
                    if (data.guarantors != null)
                    {
                        $.each(data.guarantors,function (a,b) {
                            $(".gtable2").append(`
                            <span class="badge bg-danger">${b}</span>
                            `);
                        })
                    }
                }
            })
        })
    </script>
@endsection
