@extends('layouts/layoutMaster')

@section('title', 'FDR উত্তোলন')
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
      <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
            </li>
            <li class="breadcrumb-item active">FDR উত্তোলন তালিকা</li>
          </ol>
        </nav>
      </div>
      <div class="card mb-4">
        <div class="card-header bg-warning py-0">
          <h5 class="card-title text-white mb-0 py-2">FDR উত্তোলন ফরম</h5>
        </div>
        <div class="card-body pt-3">
          <form class="add-new-record">
            @csrf
            <div class="row">
              @php
                $allFdrs = \App\Models\Fdr::all();
              @endphp
              <div class="mb-1 col">
                <label class="form-label" for="fdr_id">হিসাব নং</label>
                <select name="fdr_id" id="fdr_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- সিলেক্ট হিসাব নং --">
                  <option value=""></option>
                  @foreach($allFdrs as $fdr)
                    <option value="{{ $fdr->id }}">{{ $fdr->account_no }} || {{ $fdr->user->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-1 col">
                <label class="form-label" for="fdr_deposit_id">FDR জমা</label>
                <select name="fdr_deposit_id" id="fdr_deposit_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- সিলেক্ট FDR জমা--">

                </select>
              </div>
              <div class="mb-1 col">
                <label class="form-label" for="amount">উত্তোলন</label>
                <input
                  type="number"
                  id="amount"
                  class="form-control"
                  name="amount"
                />
              </div>

              <div class="mb-1 col">
                <label class="form-label" for="basic-icon-default-date">তারিখ</label>
                <input
                  type="text"
                  name="date"
                  class="form-control datepicker"
                  id="date"
                />
              </div>
              <div class="mb-1 col">
                <label class="form-label" for="note">নোট</label>
                <input
                  type="text"
                  id="note"
                  class="form-control"
                  name="note"
                />
              </div>

              <div class="col-md-12 mt-2 d-flex justify-content-center">
                  <button type="button" class="btn btn-primary data-submit me-1">সাবমিট</button>
              </div>

            </div>
          </form>
        </div>
      </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-bolder py-2">নাম</th>
                            <th class="fw-bolder py-2">হিসাব নং</th>
                            <th class="fw-bolder py-2">প্যাকেজ</th>
                            <th class="fw-bolder py-2">উত্তোলন</th>
                            <th class="fw-bolder py-2">ব্যালেন্স</th>
                            <th class="fw-bolder py-2">তারিখ</th>
                            <th class="fw-bolder py-2">আদায়কারী</th>
                            <th class="fw-bolder py-2"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
       {{-- <div class="modal modal-slide-in fade" id="modals-slide-in">
            <div class="modal-dialog sidebar-sm">
                <form class="add-new-record modal-content pt-0">
                    @csrf
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        @php
                        $allFdrs = \App\Models\Fdr::all();
                        @endphp
                        <div class="mb-1">
                            <label class="form-label" for="fdr_id">A/C No</label>
                            <select name="fdr_id" id="fdr_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- Select A/C --">
                                <option value=""></option>
                                @foreach($allFdrs as $fdr)
                                    <option value="{{ $fdr->id }}">{{ $fdr->account_no }} || {{ $fdr->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="fdr_deposit_id">Deposit List</label>
                            <select name="fdr_deposit_id" id="fdr_deposit_id" class="select2 form-select" data-allow-clear="on" data-placeholder="-- Select Deposit --">

                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="amount">Withdrawal</label>
                            <input
                                type="number"
                                id="amount"
                                class="form-control"
                                name="amount"
                            />
                        </div>

                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-date">Date</label>
                            <input
                                type="text"
                                name="date"
                                class="form-control flatpickr-basic"
                                id="date"
                            />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="note">Note</label>
                            <input
                                type="text"
                                id="note"
                                class="form-control"
                                name="note"
                            />
                        </div>

                        <button type="button" class="btn btn-primary data-submit me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>--}}
    </section>
    <!--/ Basic table -->

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
    </div>

@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';


        $('#fdr_id').on('change', function (e) {
            $('#fdr_deposit_id').empty();
            //set id
            let fdr_id = $(this).val();
            if (fdr_id) {
              $.ajax({
                url: "{{ url('fdrDeposits') }}/" + fdr_id,
                dataType: 'json',
                success: function(data) {
                  $.each(data,function (a,b) {
                    $("#fdr_deposit_id").append(`
                    <option value="${b.id}">${b.balance} || ${b.fdr_package.name}</option>
                    `);
                  })
                }
              })

            } else {
                $('#fdr_deposit_id').empty();
            }
        });

        $('#fdr_id').on('select2:clear', function(e) {
            $("#fdr_deposit_id").select2();
        });

        function loadData()
        {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('allFdrWithdraws') }}"
                },
                "columns": [
                    { "data": "name" },
                    { "data": "account_no" },
                    { "data": "package" },
                    { "data": "amount" },
                    { "data": "balance" },
                    { "data": "date" },
                    { "data": "created_by" },
                    { "data": "options" },
                ],
                columnDefs:[
                    {
                        // User full name and username
                        targets: 0,
                        render: function (data, type, full, meta) {
                            var $name = full['name'],
                                $id = full['user_id'],
                                $image = full['image'];
                            if ($image != null) {
                                // For Avatar image
                                var $output =
                                    '<img src="/images/' + $image + '" alt="Avatar" height="32" width="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6) + 1;
                                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }
                            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="d-flex flex-column">' +
                                '<a href="' +
                                userView+$id +
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +

                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },

                    {
                        // Actions
                        targets: 7,
                        orderable: false,
                        render: function (data, type, full, meta) {
                          var name = full['name'];
                          var date = full['date'];
                          var account_no = full['account_no'];
                          var note = full['note'];
                          var amount = full['amount'];
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                '<i class="ti ti-dots"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-savings')}}/'+full['id']+'" class="dropdown-item">' +
                                'বিস্তারিত</a>' +
                              '<a href="javascript:;" data-id="'+full['id']+'" data-name="'+name+'" data-account_no="'+account_no+'" ' +
                              'data-amount="'+amount+'" data-date="'+date+'" data-note="'+note+'" class="dropdown-item item-edit">এডিট' +
                              '</a>'+
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item fw-bolder text-danger delete-record">' +
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
                        extend: 'collection',
                        className: 'btn btn-label-secondary dropdown-toggle mx-3',
                        text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                        buttons: [
                            {
                                extend: 'print',
                               text: '<i class="ti ti-printer me-2" ></i>Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                          {
                            extend: 'csv',
                            text: '<i class="ti ti-file-text me-2" ></i>Csv',
                            bom: true,
                            className: 'dropdown-item',
                            exportOptions: {
                              columns: [0,1, 2, 3,4,5,6,7],
                            }
                          },
                          {
                            extend: 'excel',
                            text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                            bom: true,
                            className: 'dropdown-item',
                            exportOptions: {
                              columns: [0,1, 2, 3,4,5,6,7],
                            }
                          },
                          {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                            bom: true,
                            className: 'dropdown-item',
                            exportOptions: {
                              columns: [0,1, 2, 3,4,5,6,7],
                            }
                          },
                          {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-2" ></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                              columns: [0,1, 2, 3,4,5,6,7],
                            }
                          }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                            }, 50);
                        }
                    }
                ],

            });
        }
        $('.data-submit').on('click', function () {
            var $this = $(".data-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            $.ajax({
                url: "{{ route('fdr-withdraws.store') }}",
                method: "POST",
                data: $(".add-new-record").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('FDR Withdrawal Success.', 'FDR WIthdrawal!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $("form").trigger('reset');
                    $(".modal").modal('hide');
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    toastr.error('FDR Withdrawal failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                }

            })
        });


        function deleteFdrWithdraw(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('fdr-withdraws') }}/" + id, //or you can use url: "company/"+id,
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
        $(document).on('click', '.delete-record', function () {
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
              return deleteFdrWithdraw(id)
                .catch(() => {
                  Swal.showValidationMessage('FDR উত্তোলন ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('FDR উত্তোলন ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });
        function convertDateFormat(inputDate) {
          // Split the input date into day, month, and year
          var dateParts = inputDate.split("/");

          // Create a new Date object using the extracted parts
          var dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

          // Get the year, month, and day from the date object
          var year = dateObject.getFullYear();
          var month = ("0" + (dateObject.getMonth() + 1)).slice(-2); // Months are zero-based
          var day = ("0" + dateObject.getDate()).slice(-2);

          // Assemble the result in "Y-m-d" format
          var formattedDate = year + "-" + month + "-" + day;

          return formattedDate;
        }


        $(document).on("click",".item-edit",function () {
          var id = $(this).data('id');
          var name = $(this).data('name');
          var account_no = $(this).data('account_no');
          var amount = $(this).data('amount');
          var date = $(this).data('date');
          var note = $(this).data('note');

          $(".edit-name").text(name);
          $(".edit-account-no").text(account_no);
          $("#edit-withdraw-form input[name='id']").val(id);
          $("#edit-withdraw-form .amount").val(amount);
          $("#edit-withdraw-form #old_amount").val(amount);
          $("#edit-withdraw-form .date").val(convertDateFormat(date));
          $("#edit-withdraw-form .note").val(note);

          $(".edit-withdraw").modal("show");
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
              $(".datatables-basic").DataTable().destroy();
              loadData();
              resetForm();

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
