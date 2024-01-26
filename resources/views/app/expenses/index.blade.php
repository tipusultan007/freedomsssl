@extends('layouts/layoutMaster')

@section('title', 'ব্যয়')

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
      <h3 class="fw-bolder text-danger text-center">সকল ব্যয়</h3>
      <hr>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-primary py-0">
                        <h4 class="text-white mb-0 py-2">নতুন ব্যয় এন্ট্রি</h4>
                    </div>
                    <div class="card-body pt-1">
                        <form id="incomeEntryForm">
                            @csrf
                            @php
                                $incomesCategories = \App\Models\ExpenseCategory::all();
                            @endphp
                            <div class="mb-1">
                                <label class="form-label">ক্যাটেগরি</label>
                                <select name="expense_category_id" id="expense_category_id"
                                        class="form-select select2"
                                        data-placeholder="-- Select Category --" data-allow-clear="on">
                                    <option value=""></option>
                                    @foreach($incomesCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">বর্ণনা</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Description">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="basicInput">পরিমাণ</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">৳</span>
                                            <input type="number" name="amount" class="form-control"
                                                   aria-label="Amount (to the nearest dollar)">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="date">তারিখ</label>
                                        <input type="text" id="date" class="form-control datepicker" name="date"
                                               placeholder="DD/MM/YYYY"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 d-flex justify-content-end">
                                <button type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light btn-submit">সাবমিট
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-bolder py-2">তারিখ</th>
                            <th class="fw-bolder py-2">পরিমাণ</th>
                            <th class="fw-bolder py-2">ক্যাটেগরি</th>
                            <th class="fw-bolder py-2">বর্ণনা</th>
                            <th class="fw-bolder py-2"></th>
                        </tr>
                        </thead>
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">ব্যয় সম্পাদনা</h5>
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
                        <input type="hidden" name="id" id="expense_id">
                        <div class="mb-1">
                            <label class="form-label">ক্যাটেগরি</label>
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
                            <label class="form-label" for="basicInput">বর্ণনা</label>
                            <input type="text" name="description" class="form-control" id="edit_description"
                                   placeholder="Description">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput">পরিমাণ</label>
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
                                    <label class="form-label" for="date">তারিখ</label>
                                    <input type="text" id="edit_date" class="form-control datepicker" name="date"
                                           placeholder="DD/MM/YYYY"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            বাতিল
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
        $(".btn-submit").on("click", function () {
            var $this = $(".btn-submit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            var formData = $("#incomeEntryForm").serializeArray();
            $.ajax({
                url: "{{ route('expenses.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function () {
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("form").trigger('reset');
                    $("#income_category_id").val("").change();
                    toastr.success('ব্যয় রেকর্ড যোগ হয়েছে!', 'নতুন ব্যয়!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    toastr.error('ব্যয় রেকর্ড এন্ট্রি ব্যর্থ হয়েছে', 'ব্যর্থ!', {
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
                    "url": "{{ url('allExpenses') }}"
                },
                "columns": [
                    {"data": "date"},
                    {"data": "amount"},
                    {"data": "category"},
                    {"data": "description"},
                    {"data": "options"},
                ],
                columnDefs: [
                    {
                        // Actions
                        targets: 4,
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
                  extend: 'collection',
                  className: 'btn btn-label-secondary dropdown-toggle mx-3',
                  text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                  buttons: [
                    {
                      extend: 'print',
                      text: '<i class="ti ti-printer me-2" ></i>Print',
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [0,1, 2, 3,4,5],
                      }
                    },
                    {
                      extend: 'csv',
                      text: '<i class="ti ti-file-text me-2" ></i>Csv',
                      bom: true,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [0,1, 2, 3,4,5],
                      }
                    },
                    {
                      extend: 'excel',
                      text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                      bom: true,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [0,1, 2, 3,4,5],
                      }
                    },
                    {
                      extend: 'pdf',
                      text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                      bom: true,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [0,1, 2, 3,4,5],
                      }
                    },
                    {
                      extend: 'copy',
                      text: '<i class="ti ti-copy me-2" ></i>Copy',
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [0,1, 2, 3,4,5],
                      }
                    }
                  ]
                },
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
                    $("#edit_expense_category_id").val(data.expense_category_id).trigger('change');
                    $("#edit_description").val(data.description);
                    $("#edit_amount").val(data.amount);
                    $("#expense_id").val(data.id);
                    $("#edit_date").val(data.date);
                }
            })
            $("#modalEditIncome").modal("show");
        })
        $(document).on("click", ".delete-record", function () {
            var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'ডিলেট করতে চান?',
                text: "ব্যয় রেকর্ড ডিলেট হয়ে যাবে",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না',
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

                                toastr.success('ব্যয় রেকর্ড ডিলেট করা হয়েছে!', 'ডিলেট সম্পন্ন!', {
                                    closeButton: true,
                                    tapToDismiss: false
                                });
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            },
                            error: function (data) {
                                toastr.error('ব্যয় রেকর্ড ডিলেট করা যায় নি!', 'ব্যর্থ!', {
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
                    toastr.success('ব্যয় রেকর্ড আপডেট করা হয়েছে!', 'আপডেট সম্পন্ন!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    $("#modalEditIncome").modal('hide');
                    toastr.error('ব্যয় রেকর্ড আপডেট করা যায়নি!', 'Failed!', {
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
