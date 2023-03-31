@extends('layouts/contentLayoutMaster')

@section('title', 'Daily Profit')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <h4>Add Profit</h4>
                    </div>
                    <div class="card-body pt-1">
                        <form id="profitForm">
                            @csrf
                            @php
                                $savings = \App\Models\DailySavings::with('user')->orderBy('account_no','asc')->get();
                            @endphp
                            <div class="mb-1">
                                <label class="form-label">Savings A/C</label>
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
                                        <label class="form-label" for="date">From</label>
                                        <input type="text" id="from_date" class="form-control flatpickr-basic" name="from_date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">To</label>
                                        <input type="text" id="to_date" class="form-control flatpickr-basic" name="to_date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="basicInput">Amount</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="profit" class="form-control"  aria-label="Amount (to the nearest dollar)">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">Entry Date</label>
                                        <input type="text" id="date" class="form-control flatpickr-basic" name="date" placeholder="DD/MM/YYYY" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <table class="datatables-basic table table-sm">
                        <thead>
                        <tr>
                            <th>A/C No</th>
                            <th>Before Profit</th>
                            <th>Profit</th>
                            <th>After Profit</th>
                            <th>Duration</th>
                            <th>Date</th>
                            <th>Action</th>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Profit</h5>
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
                            <label class="form-label">Savings A/C</label>
                            <select name="daily_savings_id" data-allow-clear="on" id="edit_daily_savings_id" class="form-select select2" data-placeholder="-- Select A/C --">
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
                                    <label class="form-label" for="edit_from_date">From</label>
                                    <input type="text" id="edit_from_date" class="form-control flatpickr-basic" name="from_date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="edit_to_date">To Date</label>
                                    <input type="text" id="edit_to_date" class="form-control flatpickr-basic" name="to_date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput">Amount</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="profit" id="edit_profit" class="form-control"  aria-label="Amount (to the nearest dollar)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="date">Entry Date</label>
                                    <input type="text" id="edit_date" class="form-control flatpickr-basic" name="date" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary btn-update">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
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
<td>A/C No</td> <td>:</td> <td>${data.savings.account_no}</td>
</tr>
<tr>
<td>Deposit</td> <td>:</td> <td>${data.savings.deposit}</td>
</tr>
<tr>
<td>Withdraw</td> <td>:</td> <td>${data.savings.withdraw}</td>
</tr>
<tr>
<td>Profit</td> <td>:</td> <td>${data.savings.profit}</td>
</tr>
<tr>
<td>Balance</td> <td>:</td> <td>${data.savings.total}</td>
</tr>

                   `);

                   if (data.profit !=null)
                   {
                       let profitDate = formatDate(new Date(data.profit.date));
                       $(".details table").append(`

<tr>
<td>Last Profit</td> <td>:</td> <td>${data.profit.profit}</td>
</tr>
<tr>
<td>Duration</td> <td>:</td> <td class="text-success">${data.profit.duration}</td>
</tr>
<tr>
<td>Profit Date</td> <td>:</td> <td class="text-success">${profitDate}</td>
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
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="javascript:;" class="dropdown-item item-edit" data-id="' + full['id'] + '">' +
                                feather.icons['edit'].toSvg({class: 'font-small-4 me-50'}) +
                                'Edit</a>' +
                                '<a href="javascript:;" data-id="' + full['id'] + '" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({class: 'font-small-4 me-50'}) +
                                'Delete</a>' +
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
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['external-link'].toSvg({class: 'font-small-4 me-50'}) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({class: 'font-small-4 me-50'}) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({class: 'font-small-4 me-50'}) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({class: 'font-small-4 me-50'}) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({class: 'font-small-4 me-50'}) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({class: 'font-small-4 me-50'}) + 'Copy',
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

                    $("#edit_date").flatpickr({
                        static: true,
                        altInput: true,
                        altFormat: 'd/m/Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: date
                    });
                    $("#edit_from_date").flatpickr({
                        static: true,
                        altInput: true,
                        altFormat: 'd/m/Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: from_date
                    });
                    $("#edit_to_date").flatpickr({
                        static: true,
                        altInput: true,
                        altFormat: 'd/m/Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: to_date
                    });
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
