@extends('layouts/layoutMaster')

@section('title', 'লাভ প্রদান - দৈনিক সঞ্চয়')

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
    <section id="basic-datatable">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-primary border-bottom py-0">
                        <h4 class="card-title text-white py-2 mb-0">লভ্যাংশ প্রদান</h4>
                    </div>
                    <div class="card-body pt-1">
                        <form id="profitForm">
                            @csrf
                            @php
                                $savings = \App\Models\DailySavings::with('user')->orderBy('account_no','asc')->get();
                            @endphp
                            <div class="mb-1">
                                <label class="form-label">হিসাব নং</label>
                                <select name="daily_savings_id" data-allow-clear="on" id="daily_savings_id" class="form-select select2" data-placeholder="-- Select A/C --">
                                    <option value=""></option>
                                    @foreach($savings as $saving)
                                        <option value="{{ $saving->id }}">{{ $saving->account_no }} | {{ $saving->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="details">
                                <table class="table table-borderless table-sm table-striped"></table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">শুরু তারিখ</label>
                                        <input type="text" id="from_date" class="form-control datepicker" name="from_date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">শেষ তারিখ</label>
                                        <input type="text" id="to_date" class="form-control datepicker" name="to_date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="basicInput">পরিমাণ</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="profit" class="form-control"  aria-label="Amount (to the nearest dollar)">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">তারিখ</label>
                                        <input type="text" id="date" class="form-control datepicker" name="date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light btn-submit">সাবমিট</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <table class="datatables-basic table table-sm">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-bolder py-3"> হিসাব নং</th>
                            <th class="fw-bolder py-3"> লভ্যাংশের আগে</th>
                            <th class="fw-bolder py-3"> লভ্যাংশ</th>
                            <th class="fw-bolder py-3">লভ্যাংশের পরে</th>
                            <th class="fw-bolder py-3">মেয়াদ</th>
                            <th class="fw-bolder py-3">তারিখ</th>
                            <th class="fw-bolder py-3"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
          </section>
    <!--/ Basic table -->

    <div class="modal fade"
         id="modalEditProfit"
         tabindex="-1"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary py-0">
                    <h5 class="modal-title text-white py-2 mb-0" id="exampleModalCenterTitle">এডিট লভ্যাংশ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form id="profitEditForm">
                    <div class="modal-body">

                        @csrf
                        @method('PUT')
                        @php
                            $savings = \App\Models\DailySavings::with('user')->orderBy('account_no','asc')->get();
                        @endphp
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-1">
                            <label class="form-label">হিসাব নং</label>
                          <input type="text" class="form-control account_no" readonly>
                          <input type="hidden" id="edit_daily_savings_id" name="daily_savings_id">
                        </div>
                        <div class="details">
                            <table class="table table-borderless table-sm table-striped"></table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="edit_from_date">শুরু তারিখ</label>
                                    <input type="text" id="edit_from_date" class="form-control datepicker" name="from_date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="edit_to_date">শেষ তারিখ</label>
                                    <input type="text" id="edit_to_date" class="form-control datepicker" name="to_date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput">পরিমাণ</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="profit" id="edit_profit" class="form-control"  aria-label="Amount (to the nearest dollar)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="date">তারিখ</label>
                                    <input type="text" id="edit_date" class="form-control datepicker" name="date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            বন্ধ করুন
                        </button>
                        <button type="button" class="btn btn-primary btn-update">
                          আপডেট
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script>
        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return [
                padTo2Digits(date.getDate()),
                padTo2Digits(date.getMonth() + 1),
                date.getFullYear(),
            ].join('/');
        }
        $(document).on("select2:select","#daily_savings_id",function (e) {
           let id = e.params.data.id;
           $(".details table").empty();
           $.ajax({
               url: "{{ url('profitDetails') }}/"+id,
               dataType: "JSON",
               success: function (data) {
                   $(".details table").append(`

<tr>
<td>হিসাব নং</td> <td>:</td> <td>${data.savings.account_no}</td>
</tr>
<tr>
<td>জমা</td> <td>:</td> <td>${data.savings.deposit}</td>
</tr>
<tr>
<td>উত্তোলন</td> <td>:</td> <td>${data.savings.withdraw}</td>
</tr>
<tr>
<td>লভ্যাংশ</td> <td>:</td> <td>${data.savings.profit}</td>
</tr>
<tr>
<td>ব্যালেন্স</td> <td>:</td> <td>${data.savings.total}</td>
</tr>

                   `);

                   if (data.profit !=null)
                   {
                       let profitDate = formatDate(new Date(data.profit.date));
                       $(".details table").append(`

<tr>
<td>সর্বশেষ লভ্যাংশ প্রদান</td> <td>:</td> <td>${data.profit.profit}</td>
</tr>
<tr>
<td>মেয়াদ</td> <td>:</td> <td class="text-success">${data.profit.duration}</td>
</tr>
<tr>
<td>লভ্যাংশের তারিখ</td> <td>:</td> <td class="text-success">${profitDate}</td>
</tr>
                   `);
                   }
               }
           })
        })
        $(document).on("select2:clear",function () {
            $(".details table").empty();
        })
        $(".btn-submit").on("click",function () {
            var $this = $(".btn-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            var formData = $("#profitForm").serializeArray();
            $.ajax({
                url: "{{ route('add-profits.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function () {
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("form").trigger('reset');
                    $("#daily_savings_id").val("").change();
                    $(".details table").empty();
                    toastr.success('Profit.', 'New Profit!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".datatables-basic").DataTable().destroy();
                    loadData();

                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    toastr.error('New entry added failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    //$(".datatables-basic").DataTable().destroy();
                    //loadData();
                }
            })
        })

        loadData();
        function loadData() {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('allProfits') }}"
                },
                "columns": [
                    {"data": "account_no"},
                    {"data": "before_profit"},
                    {"data": "profit"},
                    {"data": "after_profit"},
                    {"data": "duration"},
                    {"data": "date"},
                    {"data": "options"},
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 6,
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                '<i class="ti ti-dots"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="javascript:;" class="dropdown-item item-edit" data-id="' + full['id'] + '">' +
                                'এডিট</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
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
                      exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                    },
                    {
                      extend: 'csv',
                      text: '<i class="ti ti-file-text me-2" ></i>Csv',
                      className: 'dropdown-item',
                      exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                    },
                    {
                      extend: 'excel',
                      text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                      className: 'dropdown-item',
                      exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                    },
                    {
                      extend: 'pdf',
                      text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                      className: 'dropdown-item',
                      exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                    },
                    {
                      extend: 'copy',
                      text: '<i class="ti ti-copy me-2" ></i>Copy',
                      className: 'dropdown-item',
                      exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
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

        $(document).on("click", ".item-edit", function () {
            let id = $(this).data('id');
            $("#profitEditForm").trigger('reset');
            $.ajax({
                url: '{{ url('getProfitById') }}/' + id,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $("#edit_daily_savings_id").val(data.daily_savings_id).change();
                    $("#edit_profit").val(data.profit);
                    $("#edit_id").val(data.id);
                    let date = formatDate(new Date(data.date));
                    let from_date = formatDate(new Date(data.from_date));
                    let to_date = formatDate(new Date(data.to_date));

                    $("#edit_date").val(data.date);
                    $(".account_no").val(data.account_no);
                    $("#edit_from_date").val(data.from_date);
                    $("#edit_to_date").val(data.to_date);
                }
            })
            $("#modalEditProfit").modal("show");
        })
        $(document).on("click", ".delete-record", function () {
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
                            url: "add-profits/" + id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response) {

                                toastr.success('Expense entry successfully deleted.', 'Deleted!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function (data) {
                                toastr.error('Delete failed.', 'Failed!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        });
                }
            });
        })
        $(document).on("click", ".btn-update", function () {
            let id = $("#edit_id").val();
            var $this = $(".btn-update");
            var $caption = $this.html();
            $.ajax({
                url: 'add-profits/' + id,
                method: 'POST',
                data: $("#profitEditForm").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#modalEditProfit").modal('hide');
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('Data updated successfully.', 'Updated!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    $("#modalEditProfit").modal('hide');
                    toastr.error('Data update failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                }

            })
        })
    </script>
@endsection
