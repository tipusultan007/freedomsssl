@extends('layouts/contentLayoutMaster')

@section('title', 'Add New User')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
    <!-- Horizontal Wizard -->
    <section class="horizontal-wizard">
        <div class="bs-stepper horizontal-wizard-example">
            <div class="bs-stepper-header" role="tablist">
                <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">1</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Personal Info</span>
            <span class="bs-stepper-subtitle">Add Personal Info</span>
          </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#personal-info" role="tab" id="personal-info-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">2</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Account Details</span>
            <span class="bs-stepper-subtitle">Setup Account Details</span>
          </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#address-step" role="tab" id="address-step-trigger">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">3</span>
                        <span class="bs-stepper-label">
            <span class="bs-stepper-title">Nominee Details</span>
            <span class="bs-stepper-subtitle">Add Nominee Details</span>
          </span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
                    <div class="content-header">
                        <h5 class="mb-0">Personal Info</h5>
                        <small class="text-muted">Enter Personal Info.</small>
                    </div>
                    <form enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="row mt-2">
                            <div class="mb-2 col-md-3">
                               <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Applicant's Name"/>
                                <label class="form-label" for="name">Applicant's Name</label>
                               </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="father_name" id="father_name" class="form-control"
                                           placeholder="Father's Name"/>
                                    <label class="form-label" for="father_name">Father's Name</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="mother_name" id="mother_name" class="form-control"
                                           placeholder="Father's Name"/>
                                    <label class="form-label" for="mother_name">Mother's Name</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <select name="gender" id="gender" class="form-select select2" data-allow-clear="on" data-placeholder="Gender">
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="present_address" id="present_address" class="form-control"
                                           placeholder="Present Address"/>
                                    <label class="form-label" for="present_address">Present Address</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="permanent_address" id="permanent_address" class="form-control"
                                           placeholder="Permanent Address"/>
                                    <label class="form-label" for="permanent_address">Permanent Address</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="text" id="birthdate" name="birthdate" class="form-control flatpickr-basic" placeholder="Date of Birth" />
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="phone1" class="form-control phone-number-mask" placeholder="Mobile" id="phone1" />
                                    <label class="form-label" for="phone1">Mobile 1</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="phone2" class="form-control phone-number-mask" placeholder="Mobile" id="phone2" />
                                    <label class="form-label" for="phone2">Mobile 2</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="phone3" class="form-control phone-number-mask" placeholder="Mobile" id="phone3" />
                                    <label class="form-label" for="phone3">Mobile 3</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="occupation" id="occupation" class="form-control"
                                           placeholder="Occupation"/>
                                    <label class="form-label" for="occupation">Occupation</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="workplace" id="workplace" class="form-control"
                                           placeholder="Workplace"/>
                                    <label class="form-label" for="workplace">Workplace</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-3">
                                <select name="marital_status" id="marital_status" class="form-select select2" data-allow-clear="on" data-placeholder="Marital Status">
                                    <option value=""></option>
                                    <option value="Married">Married</option>
                                    <option value="Unmarried">Unmarried</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-3 spouse-name">
                                <div class="form-floating">
                                    <input type="text" name="spouse_name" id="spouse_name" class="form-control"
                                           placeholder="Spouse Name"/>
                                    <label class="form-label" for="spouse_name">Spouse Name</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="national_id" class="form-label">National ID</label>
                                <input class="form-control" name="national_id" type="file" id="national_id">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="birth_id" class="form-label">Birth ID</label>
                                <input class="form-control" name="birth_id" type="file" id="birth_id">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="profile_photo_path" class="form-label">Profile Photo</label>
                                <input class="form-control" name="profile_photo_path" type="file" id="profile_photo_path">
                            </div>

                            <div class="col-md-3 mb-2">
                                <input type="text" id="join_date" name="join_date" class="form-control flatpickr-basic" placeholder="Join Date" />
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
                <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
                    <div class="content-header">
                        <h5 class="mb-0">Account Details</h5>
                        <small>Enter Account Details.</small>
                    </div>
                    <form enctype="multipart/form-data" class="form">
                        <div class="row custom-options-checkable g-1 mb-2">
                            <div class="col-md-2">
                                <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="account_type"
                                    id="type_daily_savings"
                                    value="daily_savings"
                                    checked
                                />
                                <label class="custom-option-item text-center p-1" for="type_daily_savings">
                                    <i data-feather="box" class="font-large-1 mb-75"></i>
                                    <span class="custom-option-item-title h6 d-block">Daily Savings</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="account_type"
                                    id="type_dps"
                                    value="dps"
                                />
                                <label class="custom-option-item text-center text-center p-1" for="type_dps">
                                    <i data-feather="box" class="font-large-1 mb-75"></i>
                                    <span class="custom-option-item-title h6 d-block">DPS</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="account_type"
                                    id="type_special_dps"
                                    value="special_dps"
                                />
                                <label class="custom-option-item text-center p-1" for="type_special_dps">
                                    <i data-feather="box" class="font-large-1 mb-75"></i>
                                    <span class="custom-option-item-title h6 d-block">Special DPS</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="account_type"
                                    id="type_fdr"
                                    value="fdr"
                                />
                                <label class="custom-option-item text-center p-1" for="type_fdr">
                                    <i data-feather="box" class="font-large-1 mb-75"></i>
                                    <span class="custom-option-item-title h6 d-block">FDR</span>
                                </label>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3 mb-2">
                                <label for="account_no" class="form-label">A/C No</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="account-prefix">DS</span>
                                    <input type="number" class="form-control" name="account_no"
                                           id="account_no" aria-describedby="basic-addon3">
                                </div>
                                <span id="result" class="font-small-3"></span>
                            </div>


                            <div class="col-md-3 mb-2 dps-package dps d-none">
                                @php
                                    $packages = \App\Models\DpsPackage::all();
                                @endphp
                                <label for="dps_package_id" class="form-label">Package</label>
                                <select name="dps_package_id" id="dps_package_id"
                                        class="select2 form-select" data-placeholder="Select Package">
                                    <option value=""></option>
                                    @forelse($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}
                                            - {{ $package->amount }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-md-3 mb-2 special-dps-package special-dps d-none">
                                @php
                                    $specialPackage = \App\Models\SpecialDpsPackage::all();
                                @endphp
                                <label for="special_dps_package_id" class="form-label">Package</label>
                                <select name="special_dps_package_id" id="special_dps_package_id"
                                        class="select2 form-select" data-placeholder="Select Package">
                                    <option value=""></option>
                                    @forelse($specialPackage as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}
                                            - {{ $package->amount }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>


                            <div class="mb-1 col-md-3 fdr-package fdr d-none">
                                <?php
                                    $fdrPackages = \App\Models\FdrPackage::all();
                                ?>
                                <label class="form-label" for="name">Package</label>
                                <select class="form-select select2" name="fdr_package_id"
                                        id="fdr_package_id"
                                        data-placeholder="-- Select Package --">
                                    <option value=""></option>
                                    @forelse($fdrPackages as $package)
                                        <option value="{{ $package->id }}"> {{ $package->name }} </option>
                                    @empty
                                    @endforelse
                                </select>


                            </div>

                            <div class="col-md-2 mb-2 package-amount dps d-none">
                                <label class="form-label" for="package_amount">DPS Amount</label>
                                <input
                                    type="number"
                                    class="form-control dt-initial_amount"
                                    id="package_amount"
                                    name="package_amount"
                                />
                            </div>
                            <div class="col-md-2 mb-2 fdr-amount fdr d-none">
                                <label class="form-label" for="fdr_amount">FDR Amount</label>
                                <input
                                    type="number"
                                    class="form-control dt-initial_amount"
                                    id="fdr_amount"
                                    name="fdr_amount"
                                />
                            </div>
                            <div class="col-md-2 mb-2 duration d-none">
                                <label class="form-label" for="duration">Duration</label>
                                <input
                                    type="number"
                                    class="form-control dt-initial_amount"
                                    id="duration"
                                    name="duration"

                                />
                            </div>
                            <div class="col-md-2 mb-2 initial-amount special-dps d-none">
                                <label class="form-label" for="initial_amount">Initial Amount</label>
                                <input
                                    type="number"
                                    class="form-control dt-initial_amount"
                                    id="initial_amount"
                                    name="initial_amount"

                                />
                            </div>


                            <div class="col-md-3 opening_date mb-2">
                                <label class="form-label">Opening Date</label>
                                <input type="text" id="opening_date" name="opening_date" class="form-control flatpickr-basic" placeholder="Opening Date" />
                            </div>
                            <div class="col-md-3 deposit-date mb-2 d-none">
                                <label class="form-label">Deposit Date</label>
                                <input type="text" id="deposit_date" name="date" class="form-control flatpickr-basic" placeholder="Opening Date" />
                            </div>
                            <div class="mb-2 col-md-3">
                                <label class="form-label" for="commencement">Commencement</label>
                                <input type="text" id="commencement" name="commencement"
                                       class="form-control flatpickr-basic flatpickr-input"
                                       placeholder="DD/MM/YYYY"
                                >
                            </div>
                            <div class="col-md-3 mb-2 introducer">
                                @php
                                    $introducers = \App\Models\User::all();
                                @endphp
                                <label for="" class="form-label">Introducer</label>
                                <select name="introducer_id" class="form-select select2" id="introducer_id" data-placeholder="Select Introducer">
                                    <option value=""></option>
                                    @foreach($introducers as $introducer)
                                        <option value="{{ $introducer->id }}">{{ $introducer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                        </button>
                    </div>
                </div>
                <div id="address-step" class="content" role="tabpanel" aria-labelledby="address-step-trigger">
                    <div class="content-header">
                        <h5 class="mb-0">Nominee</h5>
                        <small>Enter Nominee Details.</small>
                    </div>
                    <form enctype="multipart/form-data" class="form">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                @php
                                $users = \App\Models\User::orderBy('name','asc')->get();
                                @endphp

                                <label for="" class="form-label">Exist User</label>
                                <select name="nominee_user_id" id="nominee_user_id" class="form-select select2"
                                        data-placeholder="Select User" data-allow-clear="on">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} || {{ $user->father_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" name="nominee_name" id="nominee_name" class="form-control"
                                       placeholder="John"/>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="text" name="nominee_phone" id="nominee_phone" class="form-control"/>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="relation">Relation</label>
                                <input type="text" name="nominee_relation" id="relation" class="form-control"/>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="relation">Birthdate</label>
                                <input type="text" name="nominee_birthdate" id="nominee_birthdate" class="form-control flatpickr-basic"/>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" name="nominee_address" id="nominee_address" class="form-control"/>
                            </div>
                            <div class="mb-1 col-md-4">
                                <label class="form-label" for="percentage">Percentage</label>
                                <input type="text" name="nominee_percentage" id="percentage" class="form-control"/>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-success btn-submit">Submit</button>
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
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js'))}}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.bd.js'))}}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>

@endsection
@section('page-script')
    <!-- Page js files -->


    <script>
        var phoneMask = $('.phone-number-mask');
        if (phoneMask.length) {
            new Cleave(phoneMask, {
                phone: true,
                phoneRegionCode: 'BD'
            });
        }

        var bsStepper = document.querySelectorAll('.bs-stepper'),
            select = $('.select2'),
            horizontalWizard = document.querySelector('.horizontal-wizard-example');
        //verticalWizard = document.querySelector('.vertical-wizard-example'),
        //modernWizard = document.querySelector('.modern-wizard-example'),
        //modernVerticalWizard = document.querySelector('.modern-vertical-wizard-example');

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
                       /* name: {
                            required: true
                        },
                        phone1: {
                            required: true
                        },
                        gender: {
                            required: true
                        },
                        join_date: {
                            required: true,
                        }*/
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
                        const form = document.querySelector('.form');
                        const formData = new FormData();
                        var $this = $(".btn-submit"); //submit button selector using ID
                        var $caption = $this.html();// We store the html content of the submit button
                        var x = $("form").serializeArray();
                        $.each(x, function(i, field){
                            formData.append(field.name, field.value);
                        });
                        formData.append('national_id',$("#national_id")[0].files[0]);
                        formData.append('birth_id',$("#birth_id")[0].files[0]);
                        formData.append('profile_photo_path',$("#profile_photo_path")[0].files[0]);
                        $.ajax({
                            url: "{{ route('users.store') }}",
                            method: "POST",
                            data: formData,
                            dataType:'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                                $this.attr('disabled', true).html("Processing...");
                            },
                            success: function (data) {
                                //console.log(data)
                                $this.attr('disabled', false).html($caption);
                                //$(".spinner").hide();
                                $("form").trigger('reset');
                                toastr.success('New account successfully added.', 'New Account!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });

                                if (data.message=='daily_savings')
                                {
                                    window.location.href = "{{ url('daily-collections') }}";
                                }else if (data.message=='dps')
                                {
                                    window.location.href = "{{ url('dps-installments') }}";
                                }else if (data.message=='special_dps')
                                {
                                    window.location.href = "{{ url('special-installments') }}";
                                }else if (data.message=='fdr')
                                {
                                    window.location.href = "{{ url('fdrs') }}";
                                }

                            },
                            error: function (data) {
                                console.log(data)
                                $this.attr('disabled', false).html($caption);
                                //$("#createAppModal").modal("hide");
                                toastr.error('New account added failed.', 'Failed!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });

                            }
                        })
                    }
                });
        }

        $("input[name='account_type']").on("change",function () {
            var selected = $(this).val();
            if (selected == 'dps')
            {
                $("#account-prefix").text('DPS');
                $(".dps-package, .package-amount, .duration, .opening_date").removeClass('d-none');
                $(".special-dps-package, .initial-amount, .fdr-amount, .fdr-package, .deposit-date").addClass('d-none');
            }else if(selected == 'special_dps')
            {
                $("#account-prefix").text('ML');
                $(".dps-package, .fdr-amount, .fdr-package, .deposit-date").addClass('d-none');
                $(".special-dps-package, .package-amount, .duration, .initial-amount,.opening_date").removeClass('d-none');
            }else if(selected == 'fdr')
            {
                $("#account-prefix").text('FDR');
                $(".fdr-amount, .fdr-package, .deposit-date,.duration").removeClass('d-none');
                $(".special-dps-package, .package-amount, .initial-amount,.dps-package, .opening_date").addClass('d-none');
            }else {
                $("#account-prefix").text('DS');
                $(".opening_date").removeClass('d-none');
                $(".special-dps-package, .package-amount, .initial-amount,.dps-package,.fdr-amount,.deposit-date, .fdr-package, .duration").addClass('d-none');
            }
        })

        $("#account_no").on("input", function () {
            // Print entered value in a div box
            let type = $("input[name='account_type']:checked").val();
            let prefix = $("#account-prefix").text();
            let account_digit = $(this).val();
            let account_no = account_digit.padStart(4,'0');
            if ($(this).val() != "") {
                let ac = prefix+""+account_no;
                console.log(ac)
                $("#result").empty();
               if (type=="daily_savings")
               {
                   isDailyExist(ac);
               }else if (type=="dps")
               {
                   isDpsExist(ac);
               }else if (type=="special_dps")
               {
                   isSpecialDpsExist(ac);
               }else if (type=="fdr")
               {
                   isFdrExist(ac);
               }
            } else {
                $("#result").removeClass("text-success");
                $("#result").addClass("text-danger");
                $("#result").text("Enter Valid A/C number.");
                $(".btn-next").prop('disabled',true);
            }
        });

        function isDailyExist(ac) {
            $.ajax({
                url: "{{ url('isSavingsExist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.")
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isDpsExist(ac) {
            $.ajax({
                url: "{{ url('dps-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isSpecialDpsExist(ac) {
            $.ajax({
                url: "{{ url('special-dps-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }

        function isFdrExist(ac) {
            $.ajax({
                url: "{{ url('is-fdr-exist') }}/" + ac,
                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        $("#result").removeClass("text-success");
                        $("#result").addClass("text-danger");
                        $("#result").text("This A/C Number Already Exists. Please Try Another.");
                        $(".btn-next").prop('disabled',true);
                    } else {
                        $("#result").removeClass("text-danger");
                        $("#result").addClass("text-success");
                        $("#result").text("Congrats! This A/C Number is available.");
                        $(".btn-next").prop('disabled',false);
                    }
                }
            })
        }
        $("#nominee_user_id").on("select2:select",function (e) {
            let user_id = e.params.data.id;
            $("#nominee_name").val('');
            $("#nominee_address").val('');
            $("#nominee_phone").val('');
            $("#nominee_birthdate").val('');
            $.ajax({
                url: "{{ url('userProfile') }}/"+user_id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data)
                    $("#nominee_name").val(data.name);
                    $("#nominee_address").val(data.present_address);
                    $("#nominee_phone").val(data.phone1);
                    $("#nominee_birthdate").val(data.birthdate);
                }
            })
        })
    </script>
@endsection

{{--
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('users.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.users.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('users.store') }}"
                class="mt-4"
            >
                @include('app.users.form-inputs')

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
--}}
