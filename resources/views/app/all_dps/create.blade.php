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
                        <div class="step" data-target="#nominee-info" role="tab" id="nominee-info-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
            <span class="bs-stepper-title">Nominee Info</span>
            <span class="bs-stepper-subtitle">Add Nominee Info</span>
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
                                    <div class="col-md-6 mb-2">
                                        <label for="user_id" class="form-label">User Name</label>
                                        <select name="user_id" id="user_id" class="select2 form-select">
                                            @forelse($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                    || {{ $user->father_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Account No</label>
                                        <input type="text" class="form-control" id="account_no" name="account_no">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">DPS Package</label>
                                        <select name="dps_package_id" id="dps_package_id" class="select2 form-select">
                                            @forelse($dpsPackages as $package)
                                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">DPS Amount</label>
                                        <input type="text" class="form-control" id="package_amount" name="package_amount">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">DPS Duration</label>
                                        <select class="form-select select2" id="duration" name="duration">
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Opening Date</label>
                                        <input type="text" class="form-control flatpickr-basic" id="opening_date"
                                               name="opening_date" aria-label="MM/DD/YYYY">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="account_no" class="form-label">Commencement</label>
                                        <input type="text" class="form-control flatpickr-basic" id="commencement"
                                               name="commencement" aria-label="MM/DD/YYYY">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        @php
                                            $introducers = \App\Models\User::role('collector')->get();
                                        @endphp
                                        <label for="account_no" class="form-label">Introducer</label>
                                        <select name="introducer_id" id="introducer_id" class="select2 form-select">
                                            @forelse($introducers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-9 mb-2">
                                        <label for="account_no" class="form-label">Note</label>
                                        <input type="text" class="form-control" id="note"
                                               name="note">
                                    </div>
                                </div>
                                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
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
                                <h5 class="mb-0">Nominee Info</h5>
                                <small>Enter Nominee Info.</small>
                            </div>
                            <form>
                                <div class="row">
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
                                        <label class="form-label" for="relation">Relation</label>
                                        <input type="text" name="relation" id="relation" class="form-control"/>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="relation">Birthdate</label>
                                        <input type="text" name="birthdate" id="birthdate"
                                               class="form-control flatpickr-basic"/>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"/>
                                    </div>
                                    <div class="mb-1 col-md-6">
                                        <label class="form-label" for="percentage">Percentage</label>
                                        <input type="text" name="percentage" id="percentage" class="form-control"/>
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
                            url: "{{ route('daily-savings.store') }}",
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

        $('#user_id').on('select2:select', function (e) {
            $(".user-data").empty();
            var data = e.params.data;
            $.ajax({
                url: "{{ url('userInfo') }}/"+data.id,
                dataType: "json",
                type: "get",
                success: function (data) {
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
    </script>
@endsection
