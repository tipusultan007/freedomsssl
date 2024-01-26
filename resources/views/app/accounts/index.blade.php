@extends('layouts/layoutMaster')

@section('title', 'DataTables')

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
                        <h4>Create New Account</h4>
                    </div>
                    <div class="card-body pt-1">
                        <form id="accountEntryForm">
                            @csrf
                            @php
                                $types = \App\Models\AccountType::all();
                            @endphp
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Account Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Name">
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Account Type</label>
                                <select name="account_type_id" id="account_type_id"
                                        class="form-select select2"
                                        data-placeholder="-- Select Type --" data-allow-clear="on">
                                    <option value=""></option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Description">
                            </div>
                            <div class="mb-1 d-flex justify-content-end">
                                <button type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light btn-submit">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        {{--<tbody>
                        @php
                        $accounts = \App\Models\Account::with('type')->get();
                        @endphp
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->type->type_name }}</td>
                                <td>{{ $account->description??'' }}</td>
                                <td>{{ $account->amount }}</td>
                            </tr>
                        @endforeach
                        </tbody>--}}
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--/ Basic table -->

    <div class="modal fade"
         id="modalEditIncome"
         tabindex="-1"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form id="incomeEntryEditForm">
                    <div class="modal-body">

                        @csrf
                        @method('PUT')
                        @php
                            $incomesCategories = \App\Models\ExpenseCategory::all();
                        @endphp
                        <input type="hidden" name="id" id="income_id">
                        <div class="mb-1">
                            <label class="form-label">Category</label>
                            <select name="expense_category_id" id="edit_expense_category_id"
                                    class="form-select select2"
                                    data-placeholder="-- Select Category --" data-allow-clear="on">
                                <option value=""></option>
                                @foreach($incomesCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basicInput">Description</label>
                            <input type="text" name="description" class="form-control" id="edit_description"
                                   placeholder="Description">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput">Amount</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="amount" class="form-control" id="edit_amount"
                                               aria-label="Amount (to the nearest dollar)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="date">Entry Date</label>
                                    <input type="text" id="edit_date" class="form-control flatpickr-basic" name="date"
                                           placeholder="DD/MM/YYYY"/>
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
        $(".btn-submit").on("click", function () {
            var $this = $(".btn-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            var formData = $("#accountEntryForm").serializeArray();
            $.ajax({
                url: "{{ route('accounts.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function () {
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("form").trigger('reset');
                    $("#account_type_id").val("").change();
                    toastr.success('New Account added.', 'New Account!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    toastr.error('New Account add failed.', 'Failed!', {
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
                    "url": "{{ url('allAccounts') }}"
                },
                "columns": [
                    {"data": "name"},
                    {"data": "type"},
                    {"data": "description"},
                    {"data": "balance"},
                ],
                ordering: false,
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

        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return [
                date.getFullYear(),
                padTo2Digits(date.getMonth() + 1),
                padTo2Digits(date.getDate()),
            ].join('-');
        }

        $(document).on("click", ".item-edit", function () {
            let id = $(this).data('id');
            $("#incomeEntryEditForm").trigger('reset');
            $.ajax({
                url: '{{ url('getExpenseById') }}/' + id,
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $("#edit_income_category_id").val(data.expense_category_id).change();
                    $("#edit_description").val(data.description);
                    $("#edit_amount").val(data.amount);
                    $("#income_id").val(data.id);
                    let date = formatDate(new Date(data.date));

                    $("#edit_date").flatpickr({
                        static: true,
                        altInput: true,
                        altFormat: 'd/m/Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: date
                    });
                }
            })
            $("#modalEditIncome").modal("show");
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
                            url: "expenses/" + id, //or you can use url: "company/"+id,
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
            let id = $("#income_id").val();
            var $this = $(".btn-update");
            var $caption = $this.html();
            $.ajax({
                url: 'expenses/' + id,
                method: 'POST',
                data: $("#incomeEntryEditForm").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#modalEditIncome").modal('hide');
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('Data updated successfully.', 'Updated!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    $("#modalEditIncome").modal('hide');
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
