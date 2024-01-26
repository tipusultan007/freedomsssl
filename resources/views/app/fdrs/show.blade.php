@extends('layouts/layoutMaster')

@section('title', $fdr->account_no.' - স্থায়ী সঞ্চয় (FDR)')

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

  <div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item ">
            <a href="{{ url('fdrs') }}">স্থায়ী সঞ্চয়(FDR) তালিকা</a>
          </li>
          <li class="breadcrumb-item active">{{ $fdr->account_no }} - স্থায়ী সঞ্চয় (FDR)</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="user-avatar-section">
              <div class=" d-flex align-items-center flex-column">
                <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('storage/images/profile') }}/{{ $fdr->user->image }}" height="100" width="100" alt="User avatar" />
                <div class="user-info text-center">
                  <h6 class="mb-2">{{ $fdr->user->name }}</h6>
                  <span class="badge bg-label-secondary mt-1">{{ $fdr->user->phone1??"" }}</span>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
              <div class="d-flex align-items-start me-4 mt-3 gap-2">
                <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-moneybag ti-sm'></i></span>
                <div>
                  <p class="mb-0 fw-medium">{{ $fdr->balance }}</p>
                  <small>অবশিষ্ট জমা</small>
                </div>
              </div>
              <div class="d-flex align-items-start mt-3 gap-2">
                <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-moneybag ti-sm'></i></span>
                <div>
                  <p class="mb-0 fw-medium">{{ $fdr->profit }}</p>
                  <small>মুনাফা উত্তোলন</small>
                </div>
              </div>
            </div>
            <p class="mt-4 small text-uppercase text-muted">বিস্তারিত তথ্য</p>
            <div class="info-container">
              <ul class="list-unstyled">
                <li class="mb-2">
                  <span class="fw-medium me-1">নাম:</span>
                  <span>{{ $fdr->user->name }}</span>
                </li>
                <li class="mb-2 pt-1">
                  <span class="fw-medium me-1">মোবাইল নং:</span>
                  <span>{{ $fdr->user->phone1 }}</span>
                </li>
                <li class="mb-2 pt-1">
                  <span class="fw-medium me-1">ঠিকানা:</span>
                  <span>{{ $fdr->user->present_address }}</span>
                </li>
              </ul>
            </div>

          </div>
        </div>
        <!-- /User Card -->
        <!-- Plan Card -->
        @if($fdr->nominee)
          <div class="card mb-4">
            <div class="card-header py-2">
              <h4 class="card-title text-center">মনোনীত ব্যক্তি</h4>
            </div>
            <div class="card-body">
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <span class="fw-medium me-1">নাম:</span>
                    <span>{{ $fdr->nominee->name }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">মোবাইল নং:</span>
                    <span>{{ $fdr->nominee->phone }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">ঠিকানা:</span>
                    <span>{{ $fdr->nominee->address }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">সম্পর্ক:</span>
                    <span>{{ $fdr->nominee->relation}}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">অংশ:</span>
                    <span>{{ $fdr->nominee->percentage }}</span>
                  </li>
                </ul>
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
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true"> FDR জমা <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $fdr->fdrDeposits->count() }}</span></button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false"> FDR উত্তোলন</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false"> মুনাফা উত্তোলন</button>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
              <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                  <th class="fw-bolder py-2">তারিখ</th>
                  <th class="fw-bolder py-2">জমার পরিমাণ</th>
                  <th class="fw-bolder py-2">প্যাকেজ</th>
                  <th class="fw-bolder py-2">মুনাফা উত্তোলন</th>
                  <th class="fw-bolder py-2">অবশিষ্ট জমা</th>
                  <th></th>
                </tr>
                </thead>
                @foreach($fdr->fdrDeposits as $deposit)
                  <tr>
                    <td>{{ date('d/m/Y',strtotime($deposit->date)) }} <br>{{ date('d/m/Y',strtotime($deposit->commencement)) }}</td>
                    <td>{{ $deposit->amount }}</td>
                    <td>{{ $deposit->fdrPackage->name??'-' }}</td>
                    <td>{{ $deposit->profit }}</td>
                    <td>{{ $deposit->balance }}</td>
                    <td>
                      <div class="btn-group">
                        <a href="javascript:;" class="dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item view" href="{{ route('fdr-deposits.show',$deposit->id) }}">দেখুন</a></li>
                          <li><a class="dropdown-item deposit-edit" data-id="{{ $deposit->id }}" href="javascript:void(0);">এডিট</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item deposit-delete" data-id="{{ $deposit->id }}" href="javascript:void(0);">ডিলেট</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
              <table class="table table-bordered fdr-withdraws">
                <thead class="table-light">
                <tr>
                  <th class="fw-bolder py-2">তারিখ</th>
                  <th class="fw-bolder py-2">প্যাকেজ</th>
                  <th class="fw-bolder py-2">উত্তোলন</th>
                  <th class="fw-bolder py-2">ব্যালেন্স</th>
                  <th class="fw-bolder py-2">এসএমএস</th>
                  <th class="fw-bolder py-2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fdr->fdrWithdraws as $withdraw)
                  <tr>
                    <td>{{ date('d/m/Y',strtotime($withdraw->date)) }}</td>
                    <td>{{ $withdraw->fdrDeposit->fdrPackage->name??'-' }}</td>
                    <td>{{ $withdraw->amount }}</td>
                    <td>{{ $withdraw->balance }}</td>
                    <td>{{ $withdraw->is_sms_sent }}</td>
                    <td></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
              <table class="table table-bordered fdr-withdraws">
                <thead class="table-light">
                <tr>
                  <th class="fw-bolder py-2">তারিখ</th>
                  <th class="fw-bolder py-2">মুনাফা</th>
                  <th class="fw-bolder py-2">গ্রেস</th>
                  <th class="fw-bolder py-2">অন্যান্য ফি</th>
                  <th class="fw-bolder py-2">ব্যালেন্স</th>
                  <th class="fw-bolder py-2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fdr->fdrProfits as $withdraw)
                  <tr>
                    <td>{{ date('d/m/Y',strtotime($withdraw->date)) }}</td>
                    <td>{{ $withdraw->profit }}</td>
                    <td>{{ $withdraw->grace??'-' }}</td>
                    <td>{{ $withdraw->other_fee??'-' }}</td>
                    <td>{{ $withdraw->balance }}</td>
                    <td>
                      <form
                        action="{{ route('fdr-profits.destroy', $withdraw->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure?')"
                      >
                        @csrf @method('DELETE')
                        <button
                          type="submit"
                          class="btn btn-sm btn-danger"
                        >
                          ডিলেট
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /Invoice table -->
      </div>
      <!--/ User Content -->
    </div>
  </div>
  <div class="modal fade" id="modalFdrDeposit" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning py-3">
          <h5 class="modal-title text-white" id="exampleModalCenterTitle">FDR জমা আপডেট ফরম</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" id="edit-form">
            @csrf
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
                  <label class="form-label" for="company-column">প্যাকেজ</label>
                  <select class="form-select select2 fdr_package_id" name="fdr_package_id">
                    @forelse($fdrPackages as $package)
                      <option value="{{ $package->id }}"> {{ $package->name }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">তারিখ</label>
                  <input type="text" class="form-control date datepicker" name="date">
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="mb-1">
                  <label class="form-label" for="country-floating">হিসাব নং</label>
                  <input type="text" class="form-control commencement datepicker" name="commencement">
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
  </div>
@endsection

@section('page-script')
  <script>
      $(document).on("click",".deposit-delete",function () {
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
                url: "/fdr-deposits/"+id, //or you can use url: "company/"+id,
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
                  $(".datatables-basic").DataTable().destroy();
                  loadData();
                }
              });
          }
        });
      })
      $(".deposit-edit").on("click",function() {
        var id = $(this).attr('data-id');
        console.log("test")
        $.ajax({
          url: "{{ url('getFdrDeposit') }}/"+id,
          dataType: "JSON",
          success: function (data) {
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
        $("#modalFdrDeposit").modal("show");
      })
      $(".btn-edit").on("click", function () {
        var id = $("input[name='id']").val();
        var $this = $(".edit"); //submit button selector using ID
        var $caption = $this.html();// We store the html content of the submit button
        $.ajax({
          url: "/fdr-deposits/" + id,
          method: "PUT",
          data: $("#edit-form").serialize(),
          beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
            $this.attr('disabled', true).html("Processing...");
          },
          success: function (data) {
            $this.attr('disabled', false).html($caption);
            $("#modalFdrDeposit").modal("hide");
            toastr['success']('আপডেট সম্পন্ন হয়েছে!', 'Success!', {
              closeButton: true,
              tapToDismiss: false,
            });
            $(".datatables-basic").DataTable().destroy();
            loadData();
            resetForm();

          },
          error: function (data) {
            $("#modalFdrDeposit").modal("hide");
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
