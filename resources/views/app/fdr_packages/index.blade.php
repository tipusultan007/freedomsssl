
@extends('layouts/contentLayoutMaster')

@section('title', 'FDR Packages')
@section('breadcrumb-menu')
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#newPackageModal">
                        <i class="me-1" data-feather="check-square"></i>
                        <span class="align-middle">New Package</span>
                    </a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                       data-bs-target="#newPackageValueModal">
                        <i class="me-1" data-feather="message-square"></i>
                        <span class="align-middle">Package Value</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead>
                        <tr>
                            <th>NAME</th>
                            <th>AMOUNT</th>
                            <th>1 YEAR</th>
                            <th>2 YEAR</th>
                            <th>3 YEAR</th>
                            <th>4 YEAR</th>
                            <th>5 YEAR</th>
                            <th>5.5 YEAR</th>
                            <th>6 YEAR</th>
                            <th>OPTIONS</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
        <div class="modal modal-slide-in fade" id="modals-slide-in-edit">
            <div class="modal-dialog sidebar-sm">
                <form class="edit-record modal-content pt-0">
                    @csrf
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New FDR Package</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" name="name" type="text" id="edit_name">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input class="form-control" name="amount" type="number" id="edit_amount">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">1 YEAR</label>
                                        <input class="form-control" name="one" type="number" id="edit_one">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">2 YEAR</label>
                                        <input class="form-control" name="two" type="number" id="edit_two">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">3 YEAR</label>
                                        <input class="form-control" name="three" type="number" id="edit_three">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">4 YEAR</label>
                                        <input class="form-control" name="four" type="number" id="edit_four">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">5 YEAR</label>
                                        <input class="form-control" name="five" type="number" id="edit_five">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">5.5 YEAR</label>
                                        <input class="form-control" name="five_half" type="number" id="edit_five_half">
                                    </div>
                                    <div class=" mb-1 mb-sm-0">
                                        <label for="amount" class="form-label">6 YEAR</label>
                                        <input class="form-control" name="six" type="number" id="edit_six">
                                    </div>
                                </div>
                        <button type="button" class="btn btn-primary data-update me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal modal-slide-in fade" id="modals-slide-in">
            <div class="modal-dialog sidebar-sm">
                <form class="add-new-record modal-content pt-0">
                    @csrf
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New FDR Package</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="mb-1">
                            <input type="hidden" name="id" id="id">
                            <div class=" mb-1 mb-sm-0">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" name="name" type="text" id="name">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">Amount</label>
                                <input class="form-control" name="amount" type="number" id="amount">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">1 YEAR</label>
                                <input class="form-control" name="one" type="number" id="one">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">2 YEAR</label>
                                <input class="form-control" name="two" type="number" id="two">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">3 YEAR</label>
                                <input class="form-control" name="three" type="number" id="three">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">4 YEAR</label>
                                <input class="form-control" name="four" type="number" id="four">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">5 YEAR</label>
                                <input class="form-control" name="five" type="number" id="five">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">5.5 YEAR</label>
                                <input class="form-control" name="five_half" type="number" id="five_half">
                            </div>
                            <div class=" mb-1 mb-sm-0">
                                <label for="amount" class="form-label">6 YEAR</label>
                                <input class="form-control" name="six" type="number" id="six">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary data-submit me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--/ Basic table -->


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
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script>
        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        function loadData()
        {
            $('.datatables-basic').DataTable({
                "proccessing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('allPackages') }}"
                },
                "columns": [

                    { "data": "name" },
                    { "data": "amount" },
                    { "data": "one" },
                    { "data": "two" },
                    { "data": "three" },
                    { "data": "four" },
                    { "data": "five" },
                    { "data": "five_half" },
                    { "data": "six" },
                    { "data": "options" },
                ],
                createdRow: function (row, data, index) {
                    $(row).attr('data-id',data.id);
                    $(row).attr('data-name',data.name);
                    $(row).attr('data-amount',data.amount);
                    $(row).attr('data-one',data.one);
                    $(row).attr('data-two',data.two);
                    $(row).attr('data-three',data.three);
                    $(row).attr('data-four',data.four);
                    $(row).attr('data-five',data.five);
                    $(row).attr('data-five_half',data.five_half);
                    $(row).attr('data-six',data.six);
                },
                columnDefs:[
                    {
                        // Actions
                        targets: 9,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('daily-savings')}}/'+full['id']+'" class="dropdown-item">' +
                                feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" class="dropdown-item">' +
                                feather.icons['archive'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Reset</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item delete-record">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '<a href="javascript:;" class="item-edit">' +
                                feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                                '</a>'
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
                        text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                            }, 50);
                        }
                    },
                    {
                        text: 'Add New User',
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

        $(document).on("click",".item-edit",function () {
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
