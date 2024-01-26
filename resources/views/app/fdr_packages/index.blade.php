@extends('layouts/layoutMaster')

@section('title', 'FDR প্যাকেজ')

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
  <section class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item active">FDR প্যাকেজ তালিকা</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <table class="datatables-basic table-sm table">
            <thead class="table-light">
            <tr>
              <th class="fw-bolder">নাম</th>
              <th class="fw-bolder">পরিমাণ</th>
              <th class="fw-bolder">১ বছর</th>
              <th class="fw-bolder">২ বছর</th>
              <th class="fw-bolder">৩ বছর</th>
              <th class="fw-bolder">৪ বছর</th>
              <th class="fw-bolder">৫ বছর</th>
              <th class="fw-bolder">৫.৫ বছর</th>
              <th class="fw-bolder">৬ বছর</th>
              <th class="fw-bolder"></th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="modal modal-slide-in fade" id="modals-slide-in" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white" id="modalCenterTitle">FDR প্যাকেজ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="add-new-record">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 mb-2 mb-sm-2">
                  <label for="name" class="form-label">প্যাকেজ নাম</label>
                  <input class="form-control" name="name" type="text" id="name">
                </div>
                <div class="col-md-6 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">পরিমাণ</label>
                  <input class="form-control" name="amount" type="number" id="amount">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">১ বছর</label>
                  <input class="form-control" name="one" type="number" id="one">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">২ বছর</label>
                  <input class="form-control" name="two" type="number" id="two">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">৩ বছর</label>
                  <input class="form-control" name="three" type="number" id="three">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">৪ বছর</label>
                  <input class="form-control" name="four" type="number" id="four">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">৫ বছর</label>
                  <input class="form-control" name="five" type="number" id="five">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">৫.৫ বছর</label>
                  <input class="form-control" name="five_half" type="number" id="five_half">
                </div>
                <div class="col-md-4 mb-2 mb-sm-2">
                  <label for="amount" class="form-label">৬ বছর</label>
                  <input class="form-control" name="six" type="number" id="six">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary data-submit">সাবমিট</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modal-slide-in fade" id="modals-slide-in-edit" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title text-white" id="modalCenterTitle">FDR প্যাকেজ আপডেট</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="edit-record">
            @csrf
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="id" id="edit_id">
                <div class="col-md-6 mb-2 mb-sm-0">
                  <label for="name" class="form-label">Name</label>
                  <input class="form-control" name="name" type="text" id="edit_name">
                </div>
                <div class="col-md-6 mb-2 mb-sm-0">
                  <label for="amount" class="form-label">Amount</label>
                  <input class="form-control" name="amount" type="number" id="edit_amount">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">১ বছর</label>
                  <input class="form-control" name="one" type="number" id="edit_one">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">২ বছর</label>
                  <input class="form-control" name="two" type="number" id="edit_two">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">৩ বছর</label>
                  <input class="form-control" name="three" type="number" id="edit_three">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">৪ বছর</label>
                  <input class="form-control" name="four" type="number" id="edit_four">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">৫ বছর</label>
                  <input class="form-control" name="five" type="number" id="edit_five">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">৫.৫ বছর</label>
                  <input class="form-control" name="five_half" type="number" id="edit_five_half">
                </div>
                <div class="col-md-4 mb-1 mb-sm-0">
                  <label for="amount" class="form-label">৬ বছর</label>
                  <input class="form-control" name="six" type="number" id="edit_six">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary data-update">আপডেট</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!--/ Basic table -->

@endsection

@section('page-script')
  {{-- Page js files --}}
  <script>
    loadData();
    var assetPath = $('body').attr('data-asset-path'),
      userView = '{{ url('users') }}/';

    function loadData() {
      $('.datatables-basic').DataTable({
        "proccessing": true,
        "serverSide": true,
        lengthMenu: [100],
        "ajax": {
          "url": "{{ url('allPackages') }}"
        },
        "columns": [

          {"data": "name"},
          {"data": "amount"},
          {"data": "one"},
          {"data": "two"},
          {"data": "three"},
          {"data": "four"},
          {"data": "five"},
          {"data": "five_half"},
          {"data": "six"},
          {"data": "options"},
        ],
        createdRow: function (row, data, index) {
          $(row).attr('data-id', data.id);
          $(row).attr('data-name', data.name);
          $(row).attr('data-amount', data.amount);
          $(row).attr('data-one', data.one);
          $(row).attr('data-two', data.two);
          $(row).attr('data-three', data.three);
          $(row).attr('data-four', data.four);
          $(row).attr('data-five', data.five);
          $(row).attr('data-five_half', data.five_half);
          $(row).attr('data-six', data.six);
        },
        columnDefs: [
          {
            // Actions
            targets: 9,
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-inline-flex">' +
                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                '<i class="ti ti-dots"></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-end">' +
                '<a data-id="' + full['id'] + '" href="javascript:;" class="dropdown-item item-edit">' +
                'এডিট</a>' +
                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item text-danger fw-bolder delete-record">' +
                'ডিলেট</a>' +
                '</div>' +
                '</div>'
              );
            }
          }
        ],
        dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
          '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
          '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: 'Search',
          searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        buttons: [

          {
            text: 'নতুন প্যাকেজ',
            className: 'add-new btn btn-primary',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
            }
          }
        ],

      });
    }

    $(document).on("click", ".delete-record", function () {
      var id = $(this).attr("data-id");
      var token = $("meta[name='csrf-token']").attr("content");
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
      }).then(function (result) {
        if (result.value) {
          $.ajax(
            {
              url: "{{ url('fdr-packages') }}/" + id, //or you can use url: "company/"+id,
              type: "DELETE",
              data: {
                _token: token,
                id: id
              },
              success: function (response) {

                //$("#success").html(response.message)

                toastr.success("FDR প্যাকেজ ডিলেট করা হয়েছে!", "Success!", {
                  closeButton: true,
                  tapToDismiss: false
                });
                $(".datatables-basic").DataTable().destroy();
                loadData();
              },
              error: function (data) {
                toastr.error("FDR প্যাকেজ ডিলেট ব্যর্থ হয়েছে!", "Failed!", {
                  closeButton: true,
                  tapToDismiss: false
                });
                $(".datatables-basic").DataTable().destroy();
                loadData();
              }
            });
        }
      });
    });
    $('.data-submit').on('click', function () {

      $.ajax({
        url: "{{ route('fdr-packages.store') }}",
        method: "POST",
        data: $(".add-new-record").serialize(),
        success: function (data) {
          $(".datatables-basic").DataTable().destroy();
          loadData();
          toastr.success('New FDR Packages Successfully Added.', 'New Package!', {
            closeButton: true,
            tapToDismiss: false
          });
          $(".modal").modal('hide');
        }

      })
    });

    $(document).on("click", ".item-edit", function () {
      var row = $(this).closest("tr");
      var id = row.data('id');
      var name = row.data('name');
      var amount = row.data('amount');
      var one = row.data('one');
      var two = row.data('two');
      var three = row.data('three');
      var four = row.data('four');
      var five = row.data('five');
      var six = row.data('six');
      var five_half = row.data('five_half');

      $("#edit_id").val(id);
      $("#edit_name").val(name);
      $("#edit_amount").val(amount);
      $("#edit_one").val(one);
      $("#edit_two").val(two);
      $("#edit_three").val(three);
      $("#edit_four").val(four);
      $("#edit_five").val(five);
      $("#edit_five_half").val(five_half);
      $("#edit_six").val(six);
      $("#modals-slide-in-edit").modal("show")
    })

    $(".data-update").on("click", function () {
      var id = $("#edit_id").val();
      var $this = $(".data-update"); //submit button selector using ID
      var $caption = $this.html();// We store the html content of the submit button
      $.ajax({
        url: "fdr-packages/" + id,
        method: "PATCH",
        data: $(".edit-record").serialize(),
        beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr('disabled', true).html("Processing...");
        },
        success: function (data) {
          $this.attr('disabled', false).html($caption);
          $("#modals-slide-in-edit").modal("hide");
          toastr['success']('👋 Submission has been updated successfully.', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
          });
          $(".datatables-basic").DataTable().destroy();
          loadData();

          // resetForm();

        },
        error: function (data) {
          //$("#edit-loan-collection-modal").modal("hide");
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
