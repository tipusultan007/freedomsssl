@extends('layouts/layoutMaster')

@section('title', $fdrDeposit->account_no.' - FDR জমা')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-user-view.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection
@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">FDR সঞ্চয় - </span> হিসাব নংঃ {{$fdrDeposit->account_no}}
  </h4>
  <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <!-- User Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="user-avatar-section">
            <div class=" d-flex align-items-center flex-column">
              <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('storage/images/profile') }}/{{ $fdrDeposit->user->image }}" height="100" width="100" alt="User avatar" />
              <div class="user-info text-center">
                <h6 class="mb-2">{{ $fdrDeposit->user->name }}</h6>
                <span>{{ $fdrDeposit->user->phone1 }}</span>
              </div>
            </div>
          </div>
          <table class="table table-bordered text-center mt-2">
            <tr>
              <th class="fw-bolder py-2 text-center">অবশিষ্ট জমা</th><th class="fw-bolder py-2 text-center">মুনাফা উত্তোলন</th>
            </tr>
            <tr>
              <td class="text-success">{{ $fdrDeposit->balance }} টাকা</td>
              <td class="text-danger">{{ $fdrDeposit->profit??0 }} টাকা</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="card mb-4">
        <div class="card-body">
          <div class="info-container">
            <table class="table table-striped table-bordered">
              <caption style="caption-side: top; text-align: center">বিস্তারিত তথ্য</caption>
              <tr class="mb-2">
                <th class="fw-bolder py-2">নাম:</th>
                <td>{{ $fdrDeposit->user->name }}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-2">মোবাইল নং:</th>
                <td>{{ $fdrDeposit->user->phone1 }}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-2">ঠিকানা:</th>
                <td>{{ $fdrDeposit->user->present_address }}</td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">FDR জমা</th><td class="text-success">{{ number_format($fdrDeposit->amount,0) }} টাকা</td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">FDR প্যাকেজ</th><td class="text-primary">{{ $fdrDeposit->fdrPackage->name??'-' }}</td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">FDR জমার তারিখ</th><td class="text-info">{{ date('d/m/Y',strtotime($fdrDeposit->date)) }}</td>
              </tr>
              <tr>
                <th class="fw-bolder py-2">হিসাব শুরু</th><td class="text-info">{{ date('d/m/Y',strtotime($fdrDeposit->commencement)) }}</td>
              </tr>
            </table>

          </div>
        </div>
      </div>
      <!-- /User Card -->
      <!-- Plan Card -->
      @if($fdrDeposit->fdr->nominee)
      <div class="card mb-4">
        <div class="card-body">
          <div class="info-container">
            <table class="table table-bordered table-striped">
              <caption style="caption-side: top; text-align: center">মনোনীত ব্যক্তি</caption>
              <tr class="mb-2">
                <th class="fw-bolder py-1">নাম:</th>
                <td>{{ $fdrDeposit->fdr->nominee->name }}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-1">মোবাইল:</th>
                <td>{{ $fdrDeposit->fdr->nominee->phone }}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-1">ঠিকানা:</th>
                <td>{{ $fdrDeposit->fdr->nominee->address }}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-1">সম্পর্ক:</th>
                <td>{{ $fdrDeposit->fdr->nominee->relation}}</td>
              </tr>
              <tr class="mb-2 pt-1">
                <th class="fw-bolder py-1">অংশ:</th>
                <td>{{ $fdrDeposit->fdr->nominee->percentage }}%</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      @endif
      <!-- /Plan Card -->
    </div>
    <!--/ User Sidebar -->


    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <!-- User Pills -->
      <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false"> FDR উত্তোলন</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false"> মুনাফা উত্তোলন</button>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="navs-pills-justified-profile" role="tabpanel">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
              <tr>
                <th class="fw-bolder py-2">তারিখ</th>
                <th class="fw-bolder py-2">পরিমাণ</th>
                <th class="fw-bolder py-2">ব্যালেন্স</th>
                <th></th>
              </tr>
              </thead>
              @foreach($fdrDeposit->fdrWithdraws as $withdraw)
                <tr>
                  <td>{{ date('d/m/Y',strtotime($withdraw->date)) }}</td>
                  <td>{{ $withdraw->amount }}</td>
                  <td>{{ $withdraw->balance }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="javascript:;" class="dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item withdraw-edit"
                               data-id="{{ $withdraw->id }}"
                               data-user_id="{{ $withdraw->user_id }}"
                               data-date="{{ $withdraw->date }}"
                               data-fdr_deposit_id="{{ $withdraw->fdr_deposit_id }}"
                               data-amount="{{ $withdraw->amount }}"
                               data-balance="{{ $withdraw->balance }}"
                               href="javascript:void(0);">এডিট</a></li>
                        <li>
                          <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger fw-bolder withdraw-delete" data-id="{{ $withdraw->id }}" href="javascript:void(0);">ডিলেট</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
          <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
           <table class="table table-bordered">
             <thead class="table-light">
             <tr>
               <th class="fw-bolder py-2">তারিখ</th>
               <th class="fw-bolder py-2">মুনাফা রেট</th>
               <th class="fw-bolder py-2">কিস্তি সংখ্যা </th>
               <th class="fw-bolder py-2">সর্বমোট</th>
               <th class="fw-bolder py-2">মাস</th>
             </tr>
             </thead>
             @foreach($fdrDeposit->profitCollections as $collection)
               <tr>
                 <td>{{ date('d/m/Y',strtotime($collection->date)) }}</td>
                 <td>{{ $collection->profit }}</td>
                 <td>{{ $collection->installments }}</td>
                 <td>{{ $collection->total }}</td>
                 <td>{{ $collection->month.'-'.$collection->year }}</td>
               </tr>
             @endforeach
           </table>
          </div>
        </div>
      </div>
      <!-- /Invoice table -->
    </div>
    <!--/ User Content -->
  </div>
  <div class="modal edit-withdraw fade" id="edit-withdraw" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning py-3">
          <h5 class="modal-title text-white" id="exampleModalCenterTitle">FDR উত্তোলন আপডেট ফরম</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-withdraw-form">
            @csrf
            @method('PATCH')
            <div class="row">
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="old_amount" id="old_amount">
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
                  <label class="form-label" for="city-column">পরিমাণ</label>
                  <input type="number" class="form-control amount" name="amount">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">তারিখ</label>
                  <input type="text" class="form-control date datepicker" name="date">
                </div>
              </div>

              <div class="col-md-12 col-12">
                <div class="mb-1">
                  <label class="form-label" for="email-id-column">মন্তব্য</label>
                  <input type="text" class="form-control note" name="note">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-edit" data-bs-dismiss="modal">আপডেট</button>
        </div>
      </div>
    </div>
  </div
@endsection

@section('page-script')
  <script>
    $(document).on("click",".withdraw-delete",function () {
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
              url: "/fdr-withdraws/"+id, //or you can use url: "company/"+id,
              type: 'DELETE',
              data: {
                _token: token,
                id: id
              },
              success: function (response){

                //$("#success").html(response.message)

                Swal.fire(
                  'Remind!',
                  'FDR Deposit deleted successfully!',
                  'success'
                )

              }
            });
        }
      });
    })
    $(".withdraw-edit").on("click",function() {
      var id = $(this).attr('data-id');
      console.log("test")
      $.ajax({
        url: "{{ url('getFdrWithdrawData') }}/"+id,
        dataType: "JSON",
        success: function (data) {
          console.log(data);
          var user = data.user;
          $(".edit-name").text(user.name);
          $(".edit-account-no").text(data.account_no);
          $(".amount").val(data.amount);
          $("#old_amount").val(data.amount);
          $(".fdr_package_id").val(data.fdr_package_id);
          $(".date").val(data.date);
          $(".commencement").val(data.commencement);
          $("input[name='id']").val(data.id);
          $(".note").val(data.note);
        }
      })
      $("#edit-withdraw").modal("show");
    })
    $(".btn-edit").on("click", function () {
      var id = $("#edit-withdraw-form input[name='id']").val();
      var $this = $(".edit"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "/fdr-withdraws/" + id,
        method: "POST",
        data: $("#edit-withdraw-form").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#edit-withdraw").modal("hide");
          toastr['success']('আপডেট সম্পন্ন হয়েছে!', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });
          location.reload(true);

        },
        error: function (data) {
          $("#edit-withdraw").modal("hide");
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
