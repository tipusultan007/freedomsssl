@extends('layouts/layoutMaster')

@section('title', $dailyLoan->account_no.' - দৈনিক ঋণ ')

@section('content')
    @php
        $collectors = \App\Models\User::role('super-admin')->get();
    @endphp
    <section class="container-fluid">
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li><li class="breadcrumb-item">
              <a href="{{ url('daily-loans') }}">দৈনিক ঋণের তালিকা</a>
            </li>
            <li class="breadcrumb-item active">দৈনিক ঋণ - {{ $dailyLoan->account_no }}</li>
          </ol>
        </nav>
        <a class="btn rounded-pill btn-primary waves-effect waves-light" href="{{ route('daily-loans.edit',$dailyLoan->id) }}" target="_blank">এডিট করুন</a>
      </div>
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
                                    src="{{ asset('storage/images/profile/'.$dailyLoan->user->image) }}"
                                    height="110"
                                    width="110"
                                    alt="User avatar"
                                />
                                <div class="user-info text-center">
                                    <h6>
                                        <a href="{{ route('users.show',$dailyLoan->user_id) }}">{{ $dailyLoan->user->name }}</a>
                                    </h6>
                                    <span>{{ $dailyLoan->user->phone1 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                          <table class="table table-sm table-bordered">
                            <tr>
                              <th class="fw-bolder py-0">হিসাব নং</th>
                              <td class="text-end">{{ $dailyLoan->account_no??'' }}</td>
                            </tr>

                            <tr>
                              <th class="fw-bolder py-0">ঋণ প্রদান</th>
                              <td class="text-end">{{ $dailyLoan->loan_amount }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">ঋণের সুদ</th>
                              <td class="text-end">{{ $dailyLoan->interest }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">সর্বমোট ঋণ</th>
                              <td class="text-end">{{ $dailyLoan->total }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">তারিখ</th>
                              <td class="text-end">{{ date('d/m/Y',strtotime($dailyLoan->opening_date)) }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">হিসাব শুরু</th>
                              <td  class="text-end">{{ date('d/m/Y',strtotime($dailyLoan->commencement)) }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">পরিশোধ</th>
                              <td class="text-end">{{ $dailyLoan->dailyLoanCollections->sum('loan_installment') }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">সংযোজন</th>
                              <td class="text-end">{{ $dailyLoan->adjusted_amount }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">ব্যালেন্স</th>
                              <td class="text-end">{{ $dailyLoan->balance }}</td>
                            </tr>
                            <tr>
                              <th class="fw-bolder py-0">স্ট্যাটাস:</th>
                              <td class="text-end"> <span class="badge bg-label-success">{{ strtoupper($dailyLoan->status)??'' }}</span></td>
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
              <h4 class="text-white bg-primary px-3 py-2">ঋণ সংক্রান্ত লেনদেন</h4>
              <table class="table-bordered table-responsive table table-sm table-primary">
                <thead class="table-light">
                <tr>
                  <th class="fw-bolder py-2">তারিখ</th>
                  <th class="fw-bolder py-2">ঋণ ফেরত</th>
                  <th class="fw-bolder py-2">বিলম্ব ফি</th>
                  <th class="fw-bolder py-2">অন্যান্য ফি</th>
                  <th class="fw-bolder py-2">ব্যালেন্স</th>
                  <th class="fw-bolder py-2"> মন্তব্য</th>
                  <th class="fw-bolder py-2">আদায়কারী</th>
                  <th class="fw-bolder py-2">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dailyLoan->dailyLoanCollections as $collection)
                 <tr>
                   <td>{{ date('d/m/Y',strtotime($collection->date)) }}</td>
                   <td>{{ $collection->loan_installment }}</td>
                   <td>{{ $collection->loan_late_fee??'-' }}</td>
                   <td>{{ $collection->loan_other_fee??'-' }}</td>
                   <td>{{ $collection->loan_balance }}</td>
                   <td>{{ $collection->loan_note??'-' }}</td>
                   <td>{{ $collection->manager->name??'-' }}</td>
                   <td>
                     <div class="btn-group">
                       <button type="button" class="btn btn-primary btn-icon text-white rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                       <ul class="dropdown-menu dropdown-menu-end">
                         <li><a class="dropdown-item item-edit-loan" data-id="{{ $collection->id }}" href="javascript:void(0);">এডিট</a></li>
                         <li>
                           <hr class="dropdown-divider">
                         </li>
                         <li><a class="dropdown-item delete-loan-record" data-id="{{ $collection->id }}" href="javascript:void(0);">ডিলেট</a></li>
                       </ul>
                     </div>
                   </td>
                 </tr>
                @endforeach
                </tbody>
              </table>

            </div>
            <!--/ User Content -->
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="edit-loan-collection-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">ঋন আদায় এডিট</h5>
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
                    <label class="form-label" for="city-column">পরিমান</label>
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
                    <input type="date" class="form-control date flatpickr-basic" name="date">
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
                    <label class="form-label" for="email-id-column">মন্তব্য</label>
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
    {{--@include('content/_partials/_modals/modal-edit-user')--}}

@endsection
@section('page-script')

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
        var loanId = "{{ $dailyLoan->id }}";

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
                    location.reload();

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
        $(document).on("click", ".delete-loan-record", function() {
          var id = $(this).attr("data-id");
          var token = $("meta[name='csrf-token']").attr("content");
          Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            customClass: {
              confirmButton: "btn btn-primary",
              cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: false
          }).then(function(result) {
            if (result.value) {
              $.ajax(
                {
                  url: "{{ url('daily-loan-collections') }}/" + id, //or you can use url: "company/"+id,
                  type: "DELETE",
                  data: {
                    _token: token,
                    id: id
                  },
                  success: function(response) {

                    //$("#success").html(response.message)

                    Swal.fire(
                      "Deleted!",
                      "Data deleted successfully!",
                      "success"
                    );
                  location.reload();
                  }
                });
            }
          });
        });
    </script>
@endsection
