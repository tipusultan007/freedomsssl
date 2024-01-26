@extends('layouts/layoutMaster')

@section('title', 'দৈনিক ঋণ প্যাকেজ')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
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
  <section id="basic-datatable">
    <div class="row">
      <div class="col-5">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="text-center py-2 mb-0">দৈনিক ঋণের প্যাকেজ</h4>
            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">নতুন প্যাকেজ</a>
          </div>
          <div class="card-body">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
              <tr>
                <th class="fw-bolder">মাস</th>
                <th class="fw-bolder">সুদের হার</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              @foreach($dailyLoanPackages as $package)
                <tr>
                  <td>{{ $package->months }}</td>
                  <td>{{ $package->interest }}</td>
                  <td>
                    <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-success " data-bs-target="#editModal{{ $package->id }}">এডিট</a>
                    <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-danger " data-bs-target="#deleteModal{{ $package->id }}">ডিলেট</a>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $package->id }}" tabindex="-1"
                         aria-labelledby="editModalLabel{{ $package->id }}" aria-hidden="true">
                      @include('app.daily_loan_packages.edit', ['dailyLoanPackage' => $package])
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $package->id }}" tabindex="-1"
                         aria-labelledby="deleteModalLabel{{ $package->id }}" aria-hidden="true">
                      @include('app.daily_loan_packages.delete', ['dailyLoanPackage' => $package])
                    </div>
                  </td>
                </tr>

              @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <!-- Create Modal -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary py-0">
          <h5 class="modal-title text-white py-2 mb-0" id="createModalLabel">নতুন প্যাকেজ তৈরি করুন</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('daily-loan-packages.store') }}" method="POST">
            @csrf
            <div class="mb-1">
              <label class="form-label" for="months">মাস</label>
              <input
                type="number"
                class="form-control dt-months"
                id="months"
                name="months"
              />
            </div>
            <div class="mb-1">
              <label class="form-label" for="interest">সুদের হার</label>
              <input
                type="number"
                id="interest"
                name="interest"
                class="form-control dt-interest"
              />
            </div>
            <button type="submit" class="btn btn-primary">সাবমিট</button>
          </form>
        </div>
      </div>
    </div>

  </div>
  <!--/ Basic table -->
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script>
    var dt_basic_table = $('.datatables-basic'),
      dt_date_table = $('.dt-date');

    // DataTable with buttons
    // --------------------------------------------------------------------
    loadData();

    function loadData() {
      var dt_basic = dt_basic_table.DataTable({
        ajax: "{{ url('dailyLoanPackageData') }}",
        columns: [
          {data: 'months'},
          {data: 'interest'},
          {data: ''}
        ],
        columnDefs: [
          {
            // Actions
            targets: -1,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-inline-flex">' +
                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                '<i class="ti ti-dots"></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-end">' +
                '<a href="javascript:;" class="dropdown-item">' +
                'Details</a>' +
                '<a href="javascript:;" class="dropdown-item">' +
                'Archive</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                'Delete</a>' +
                '</div>' +
                '</div>' +
                '<a href="javascript:;" class="item-edit">' +
                '<i class="ti ti-edit"></i>' +
                '</a>'
              );
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end">><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],

      });
    }


    // Delete Record
    $('.datatables-basic tbody').on('click', '.delete-record', function () {

      var id = $(this).data("id");
      var token = $("meta[name='csrf-token']").attr("content");

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ url('daily-loan-packages') }}/" + id,
            type: 'DELETE',
            data: {"id": id, "_token": token},
            success: function () {
              $(".datatables-basic").DataTable().destroy();
              loadData();
              toastr.error('Daily loan package has been deleted successfully.', 'Deleted!', {
                closeButton: true,
                tapToDismiss: false
              });
            }
          });

        }
      })


    });

    $('.data-submit').on('click', function () {
      $.ajax({
        url: "{{ route('daily-loan-packages.store') }}",
        method: "POST",
        data: $(".add-new-record").serialize(),
        success: function (data) {
          $(".datatables-basic").DataTable().destroy();
          loadData();
          toastr.success('New daily loan package successfully added.', 'New Package!', {
            closeButton: true,
            tapToDismiss: false
          });
          $(".modal").modal('hide');
        }

      })
    });
  </script>
@endsection
