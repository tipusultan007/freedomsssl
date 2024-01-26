@extends('layouts/layoutMaster')

@section('title', 'বিশেষ সঞ্চয় প্যাকেজ')

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
    <!-- Basic table -->
    <section class="container-fluid">
      <div class="d-flex align-items-center pb-4">
        <h4 class="mb-0">বিশেষ সঞ্চয় প্যাকেজ তালিকা</h4>
        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addPackageModal">নতুন প্যাকেজ</button>
      </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th>প্যাকেজ নাম</th>
                            <th>পরিমাণ</th>
                            <th class="text-center">মুনাফা</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dpsPackages as $dpsPackage)
                            <tr>
                                <td>
                                    {{ $dpsPackage->name }}
                                </td>
                                <td>
                                    {{ $dpsPackage->amount }}
                                </td>
                                <td>
                                    @php
                                        $packageValues = \App\Models\SpecialDpsPackageValue::where('special_dps_package_id',$dpsPackage->id)->orderBy('year','asc')->get();
                                    @endphp
                                    <table class="table table-sm">
                                        <tr>
                                            @foreach($packageValues as $row)
                                                <td>{{ $row->year }} বছর <br> {{ $row->amount }} </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <form id="deleteForm{{ $dpsPackage->id }}" action="{{ route('special-dps-packages.destroy',$dpsPackage->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn rounded-pill btn-google-plus waves-effect waves-light" type="button" onclick="confirmDelete({{ $dpsPackage->id }})">ডিলেট</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
    </section>
    <!--/ Basic table -->

    <div
        class="modal fade"
        id="addPackageModal"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">বিশেষ সঞ্চয় প্যাকেজ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form id="addPackageForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="" class="form-label">প্যাকেজ নাম</label>
                                    <input type="text" name="name" class="form-control" placeholder="Package Name">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="" class="form-label">প্যাকেজ পরিমাণ</label>
                                    <input type="number" name="amount" class="form-control"
                                           placeholder="Package Amount">

                                </div>
                            </div>
                        </div>
                        <table class="table table-sm package-table mt-2">
                            <thead>
                            <tr>
                                <th class="text-center">বছর</th>
                                <th class="text-center">মুনাফা</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="px-0">
                                    <input type="number" name="year[]" class="form-control form-control-sm">
                                </td>
                                <td class="px-1">
                                    <input type="number" name="principal_profit[]" class="form-control form-control-sm">
                                </td>
                                <td class="p-0">
                                    <div class="btn-group bootstrap-touchspin">
                                        <button class="btn btn-sm btn-danger bootstrap-touchspin-down me-1 btn-remove" type="button">
                                            <i class='ti ti-minus'></i>
                                        </button>
                                        <button class="btn btn-sm btn-success bootstrap-touchspin-up btn-add" type="button">
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit">
                            সাবমিট
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('page-script')

    <script>
      function confirmDelete(id) {
        Swal.fire({
          title: 'ডিলেট করতে চান?',
          text: "এই প্যাকেজ ডিলেট হয়ে যাবে!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'হ্যাঁ, ডিলেট করুন!',
          cancelButtonText: 'না, বাতিল করুন',
          customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ms-1'
          },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
          }
        });
      }

        $(document).on("click",".package-table tbody tr .btn-add",function () {
            $(".package-table tbody").append(`
            <tr>

 <td class="px-0">
                                    <input type="number" name="year[]" class="form-control form-control-sm">
                                </td>
                                <td class="px-1">
                                    <input type="number" name="principal_profit[]" class="form-control form-control-sm">
                                </td>
                                <td class="p-0">
                                    <div class="input-group bootstrap-touchspin">
                                        <button class="btn btn-sm btn-danger bootstrap-touchspin-down me-1 btn-remove" type="button">
                                            <i class='ti ti-minus'></i>
                                        </button>
                                        <button class="btn btn-sm btn-success bootstrap-touchspin-up btn-add" type="button">
                                           <i class='ti ti-plus'></i>
                                        </button>
                                    </div>
                                </td>
</tr>
            `);


        })
        $(document).on("click",".package-table tbody tr .btn-remove",function () {
            var row = $(this).closest('tr');
            if (row.index()!=0)
            {
                row.remove();
            }
        })

        $(".btn-submit").on("click",function () {
            var $this = $(".btn-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            var formData = $("#addPackageForm").serializeArray();
            $.ajax({
                url: "{{ route('special-dps-packages.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    //$(".spinner").hide();
                    $("#addPackageForm").trigger('reset');
                    $("#addPackageModal").modal("hide");
                    toastr.success('New DPS Package successfully added.', 'New DPS Package!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    window.location.reload();
                },error: function () {
                    $this.attr('disabled', false).html($caption);
                    //$("#createAppModal").modal("hide");
                    $("#addPackageModal").modal("hide");
                    toastr.error('New DPS Package added failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });

                }
            })
        })
    </script>
@endsection
