@extends('layouts/layoutMaster')
@section('title', __('মুনাফা তালিকা'))
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
  <div class="container-fluid">
    <h4 class="text-success text-center fw-bolder">মুনাফা তালিকা</h4>
    <hr>

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ route('profits.store') }}">
              @csrf
              <div class="form-group mb-3">
                <label for="type" class="form-label">ধরন</label>
                <select name="type" id="type" class="form-control select2" data-placeholder="সঞ্চয়ের ধরন" required>
                  <option value=""></option>
                  <option value="daily">দৈনিক সঞ্চয়</option>
                  <option value="dps">মাসিক (DPS) সঞ্চয়</option>
                  <option value="special">স্পেশাল সঞ্চয়</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="account_no" class="form-label">হিসাব নং</label>
                <select name="account_no" id="account_no" class="form-control select2" data-placeholder="হিসাব নং"
                        data-allow-clear="on">

                </select>
              </div>
              <div class="form-group mb-3">
                <label for="profit" class="form-label">মুনাফা</label>
                <input type="number" id="profit" class="form-control" name="profit" required>
              </div>
              <div class="form-group mb-3">
                <label for="date" class="form-label">তারিখ</label>
                <input type="number" id="date" class="form-control datepicker" name="date" required>
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">সাবমিট</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('profits.index') }}" method="GET" class="mb-3">
              <div class="row">
                <div class="col-md-4">
                  <select name="profit_type" id="profitType" class="form-select select2">
                    <option value="" @if(empty($profitType)) selected @endif>সকল মুনাফা</option>
                    <option value="dps" @if($profitType == 'dps') selected @endif>মাসিক (DPS) সঞ্চয়</option>
                    <option value="special" @if($profitType == 'special') selected @endif>স্পেশাল সঞ্চয়</option>
                    <option value="daily" @if($profitType == 'daily') selected @endif>দৈনিক সঞ্চয়</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">সার্চ</button>
                </div>
              </div>

            </form>
          </div>
        </div>
        <table class="table table-sm table-bordered">
          <thead class="table-light">
          <tr>
            <th class="fw-bolder align-middle py-2">তারিখ</th>
            <th class="fw-bolder py-2 align-middle">ধরন</th>
            <th class="fw-bolder align-middle py-2">হিসাব নং</th>
            <th class="fw-bolder align-middle py-2">মুনাফা</th>
            <th class="fw-bolder align-middle py-2"></th>
          </tr>
          </thead>
          <tbody>
          @forelse($profits as $profit)
            <tr>
              <td>{{ date('d-m-Y',strtotime($profit->date)) }}</td>
              <td>
                @if($profit->type == 'dps')
                  <span class="badge rounded-pill bg-primary bg-glow">মাসিক (DPS) সঞ্চয়</span>
                @elseif($profit->type == 'special')
                  <span class="badge rounded-pill bg-info bg-glow"> স্পেশাল সঞ্চয়</span>
                @else
                  <span class="badge rounded-pill bg-success bg-glow">দৈনিক সঞ্চয়</span>
                @endif
              </td>
              <td>{{ $profit->account_no }}</td>
              <td>{{ $profit->profit }}</td>
              <td>
                <button data-account="{{ $profit->account_no }}"
                        data-type="{{ $profit->type }}"
                        data-date="{{ $profit->date }}"
                        data-profit="{{ $profit->profit }}"
                        data-profit_id="{{ $profit->profit_id }}"
                        data-id="{{ $profit->id }}"
                        class="btn btn-warning btn-sm editBtn">এডিট
                </button>
                <button class="btn btn-danger btn-sm btnDelete" data-id="{{ $profit->id }}">ডিলেট</button>
              </td>
            </tr>
          @empty
          @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $profits->appends(['profitType' => $profitType])->links() }}
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <!-- Your modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Your modal content goes here -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Profit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Your edit form goes here -->
          <form id="editForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group mb-3">
              <label for="editAccountNo">হিসাব নং</label>
              <input type="text" name="editAccountNo" class="form-control" id="editAccountNo" readonly>
            </div>
            <input type="hidden" name="editType" id="editType">
            <div class="form-group mb-3">
              <label for="editProfit">মুনাফা</label>
              <input type="text" name="editProfit" class="form-control" id="editProfit">
            </div>
            <div class="form-group mb-3">
              <label for="editDate">তারিখ</label>
              <input type="text" name="editDate" class="form-control datepicker" id="editDate">
            </div>
            <input type="hidden" name="editProfitId" id="editProfitId">

            <input type="hidden" name="editId" id="editId">

            <div class="d-flex justify-content-end">
              <button type="submit" id="updateBtn" class="btn btn-primary">আপডেট</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- End Edit Modal -->
@endsection

@section('page-script')

  <script>
    $(document).ready(function() {
      // Add a click event listener to the Edit button
      $('.editBtn').on('click', function() {
        // Get the data attributes
        var accountNo = $(this).data('account');
        var type = $(this).data('type');
        var profit = $(this).data('profit');
        var profitId = $(this).data('profit_id');
        var id = $(this).data('id');
        var date = $(this).data('date');

        // Populate the modal fields
        $('#editAccountNo').val(accountNo);
        $('#editType').val(type);
        $('#editProfit').val(profit);
        $('#editProfitId').val(profitId);
        $('#editId').val(id);

        $('#editDate').flatpickr({
          altInput: true,
          allowInput: true,
          altFormat: 'd-m-Y',
          dateFormat: 'Y-m-d',
          defaultDate: date
        });

        $('#editModal').modal('show');
      });

      // Add a submit event listener to the form
      $('#updateBtn').on('click', function(e) {
        e.preventDefault(); // Prevent the default form submission
        var id = $('#editForm input[name="editId"]').val();
        // Get form data
        var formData = $('#editForm').serialize();

        console.log(id);
        // Perform AJAX submission
        $.ajax({
          type: 'POST',
          url: '{{ url('profits') }}/'+id, // Replace with your actual route
          data: formData,
          success: function (response) {
            window.location.reload();
          },
          error: function (error) {
            // Handle error (if needed)
            console.error(error);
          }
        });
      });

      $(".btnDelete").on("click", function () {
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
                url: "profits/" + id, //or you can use url: "company/"+id,
                type: 'DELETE',
                data: {
                  _token: token,
                  id: id
                },
                success: function (response) {
                  toastr['success']('👋 Delete successfully.', 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,
                  });

                  window.location.reload();

                },error: function (data) {
                  toastr['error']('Delete Failed.', 'Failed!', {
                    closeButton: true,
                    tapToDismiss: false,
                  });
                }
              });
          }
        });
      })
    });
    $('#type').on('change', function() {
      let type = $(this).val();
      $('#account_no').empty();
      $.ajax({
        url: "{{ url('accountList') }}/" + type,
        success: function(data) {

          $('#account_no').append('<option value=""></option>');

          $.each(data, function(a, b) {
            $('#account_no').append(`
            <option value="${b}">${b}</option>
            `);
          });
          $('#account_no').select2();
        }
      });
    });
  </script>

@endsection
