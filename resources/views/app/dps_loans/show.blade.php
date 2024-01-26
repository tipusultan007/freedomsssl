@extends('layouts/layoutMaster')

@section('title', 'Loan Details | '.$dpsLoan->account_no)

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
    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img
                                    class="img-fluid rounded mt-3 mb-2"
                                    src="{{ $dpsLoan->user->profile_photo_url??'' }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h4>
                                        <a href="{{ route('users.show',$dpsLoan->user_id) }}">{{ $dpsLoan->user->name }}</a>
                                    </h4>
                                    <span class="badge bg-light-secondary">{{ $dpsLoan->user->phone1 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="d-flex align-items-start me-2">
              <span class="badge bg-light-primary p-75 rounded">
                <i data-feather="dollar-sign" class="font-medium-2"></i>
              </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $dpsLoan->remain_loan }}</h4>
                                    <small>অবশিষ্ট ঋণ</small>
                                </div>
                            </div>
                        </div>
                        <div class="info-container">
                            <table class="table table-sm table-bordered">
                                <tr class="mb-75">
                                    <th class="py-1">হিসাব নং:</th>
                                    <td class="text-end">{{ $dpsLoan->account_no??'' }}</td>
                                </tr>
                                <tr>
                                    @php
                                    $loans = \App\Models\TakenLoan::where('account_no',$dpsLoan->account_no)->get();
                                    $total_interest = \App\Models\DpsLoanInterest::where('account_no',$dpsLoan->account_no)->sum('total');
                                    @endphp
                                    <th class="py-1">সর্বমোট ঋণ:</th>
                                    <td class="text-end">{{ $loans->sum('loan_amount') }}</td>
                                </tr>
                                <tr>
                                    <th class="py-1">ঋণ ফেরত:</th>
                                    <td class="text-end">{{ $loans->sum('loan_amount') - $loans->sum('remain') }}</td>
                                </tr>
                                <tr>
                                    <th class="py-1"> অবশিষ্ট ঋণ:</th>
                                    <td class="text-end">{{ $loans->sum('remain') }}</td>
                                </tr>
                                <tr>

                                    <th class="py-1">সুদ পরিশোধ:</th>
                                    <td class="text-end">{{ $dpsLoan->paid_interest }}</td>
                                </tr>
                                <tr>

                                    <th class="py-1">বকেয়া সুদ:</th>
                                    <td class="text-end" >{{ $dpsLoan->dueInterest }}</td>
                                </tr>
                                <tr>
                                    <th class="py-1">ছাড়:</th>
                                    <td class="text-end">{{ $dpsLoan->grace }}</td>
                                </tr>

                                <tr>
                                    <th class="py-1">স্ট্যাটাস:</th>
                                    <td><span class="badge badge-sm rounded-pill bg-label-success">{{ strtoupper($dpsLoan->status)??'' }} </span></td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">
                <!-- User Pills -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item ">
                        <a
                            class="nav-link active"
                            id="loans-tab"
                            data-bs-toggle="tab"
                            href="#takenLoans"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true">
                            <span class="fw-bold fs-3">সকল ঋণের তালিকা</span></a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link "
                            id="savings-tab"
                            data-bs-toggle="tab"
                            href="#savingAccount"
                            aria-controls="home"
                            role="tab"
                            aria-selected="true">
                            <span class="fw-bold fs-3">ঋণ ফেরত/ লভ্যাংশ আদায়</span></a>
                    </li>


                </ul>

                <div class="tab-content px-0">
                    <div class="tab-pane active" id="takenLoans" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                            <table class="taken-loans-table table table-bordered table-sm">
                                <thead class="table-light">
                                <tr>
                                    <th class="fw-bolder py-2">ঋণের পরিমাণ</th>
                                    <th class="fw-bolder py-2">সুদ</th>
                                    <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
                                    <th class="fw-bolder py-2">তারিখ</th>
                                    <th class="fw-bolder py-2">#</th>
                                </tr>
                                </thead>
                              @foreach($dpsLoan->takenLoans as $loan)
                                <tr>
                                  <td>{{ $loan->loan_amount }}</td>
                                  <td>{{ $loan->interest1 }} {{ $loan->interest2!=""?" | ".$loan->interest2:"" }}</td>
                                  <td>{{ $loan->remain }}</td>
                                  <td>{{ date('d/m/Y',strtotime($loan->date)) }}</td>
                                  <td>
                                    <div class="dropdown">
                                      <a href="javascript:;" class="btn p-0" id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-dots ti-sm text-primary"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-end"  style="">
                                        <a class="dropdown-item" href="{{ route('taken-loans.show',$loan->id) }}" target="_blank">দেখুন</a>
                                        <a class="dropdown-item" href="{{ route('taken-loans.edit',$loan->id) }}" target="_blank">এডিট</a>
                                        <a class="dropdown-item text-danger delete fw-bolder" data-id="{{ $loan->id }}" href="javascript:void(0);">ডিলেট</a>
                                      </div>
                                    </div>
                                  </td>
                                </tr>

                              @endforeach
                            </table>
                    </div>
                    <div class="tab-pane " id="savingAccount" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <!-- Project table -->
                            <table class="datatables-basic table table-bordered table-sm">
                                <thead class="table-light">
                                <tr>
                                    <th class="fw-bolder py-2">তারিখ</th>
                                    <th class="fw-bolder py-2">সুদ</th>
                                    <th class="fw-bolder py-2">ঋণ ফেরত</th>
                                    <th class="fw-bolder py-2">অবশিষ্ট ঋণ</th>
                                    <th class="fw-bolder py-2">#</th>
                                </tr>
                                </thead>
                              @foreach($dpsLoan->dpsLoanCollections as $collection)
                                <tr>
                                  <td>{{ date('d/m/Y',strtotime($collection->date)) }}</td>
                                  <td>{{ $collection->interest }}</td>
                                  <td>{{ $collection->loan_installment }}</td>
                                  <td>{{ $collection->balance }}</td>
                                  <td>
                                    <div class="dropdown">
                                      <a href="javascript:;" class="btn p-0" id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-dots ti-sm text-primary"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-end"  style="">
                                        <a class="dropdown-item view-collection" data-id="{{ $collection->id }}" href="javascript:void(0);" target="_blank">দেখুন</a>
                                        <a class="dropdown-item edit-collection" data-id="{{ $collection->id }}" href="javascript:void(0);" target="_blank">এডিট</a>
                                        <a class="dropdown-item text-danger item-loan-delete fw-bolder" data-id="{{ $collection->id }}" href="javascript:void(0);">ডিলেট</a>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              @endforeach
                            </table>
                    </div>
                </div>

            </div>
            <!--/ User Content -->
        </div>
    </section>

@endsection

@section('page-script')
    {{-- Page js files --}}
    {{--<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>--}}

    <script>
        // Variable declaration for table
        var dtAccountsTable = $('.datatable-accounts'),
            dtLoansTable = $('.datatable-loans'),
            invoicePreview = 'app-invoice-preview.html',
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
            invoicePreview = assetPath + 'app/invoice/preview';
        }
        var ac = "{{ $dpsLoan->account_no }}";
        var loanId = "{{ $dpsLoan->id }}";

        function deleteTakenLoan(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('taken-loans') }}/" + id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token
              },
              success: function () {
                resolve();
              },
              error: function (data) {
                reject();
              }
            });
          });
        }
        $(document).on('click', '.delete', function () {
          var id = $(this).data("id");
          Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: 'এটি আপনি পুনরায় পাবেন না!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, এটি ডিলেট করুন!',
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false,
            allowOutsideClick: () => !Swal.isLoading(),
            showLoaderOnConfirm: true,
            preConfirm: () => {
              // Return the promise from the AJAX request function
              return deleteTakenLoan(id)
                .catch(() => {
                  Swal.showValidationMessage('ঋণ ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('ঋন্টি সফলভাবে ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              window.location.reload();
            }
          });
        });

        /*$(document).on("click", ".delete", function () {
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
                  url: "{{ url('taken-loans') }}/" + id, //or you can use url: "company/"+id,
                  type: 'DELETE',
                  data: {
                    _token: token
                  },
                  success: function (response) {

                    //$("#success").html(response.message)
                    toastr['success']('Loan Installment has been deleted successfully.', 'Success!', {
                      closeButton: true,
                      tapToDismiss: false,
                    });

                    window.location.reload();

                  },
                  error: function (data) {
                    toastr['error']('👋 Loan Installment delete failed.', 'Failed!', {
                      closeButton: true,
                      tapToDismiss: false,
                    });
                  }
                });
            }
          });
        })*/
        $(document).on("click", ".item-loan-delete", function () {
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
                            url: "{{ url('dps-loan-collections') }}/" + id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response) {

                                //$("#success").html(response.message)
                                toastr['success']('Loan Installment has been deleted successfully.', 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadLoanCollection(loanId);
                            },
                            error: function (data) {
                                toastr['error']('👋 Loan Installment delete failed.', 'Failed!', {
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
