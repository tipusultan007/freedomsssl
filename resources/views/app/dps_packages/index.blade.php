@extends('layouts/contentLayoutMaster')

@section('title', 'DPS Package')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table table-sm table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Principal Profit</th>
                            <th>Action</th>
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
                                    $packageValues = \App\Models\DpsPackageValue::where('dps_package_id',$dpsPackage->id)->orderBy('year','asc')->get();
                                    @endphp
                                    <table class="table">
                                        <tr>
                                            @foreach($packageValues as $row)
                                                <td>{{ $row->year }} Years <br> {{ $row->amount }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <form action="{{ route('dps-packages.destroy',$dpsPackage->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-flat-danger" type="submit">Delete</button>
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">Vertically
                        Centered</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form id="addPackageForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control" placeholder="Package Name">
                                    <label for="" class="form-label">Package Name</label>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="amount" class="form-control"
                                           placeholder="Package Amount">
                                    <label for="" class="form-label">Package Amount</label>
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm package-table mt-2">
                            <thead>
                            <tr>
                                <th class="text-center">Year</th>
                                <th class="text-center">Principal-Profit</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="number" name="year[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="number" name="principal_profit[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <div class="input-group bootstrap-touchspin">
                                        <button class="btn btn-sm btn-danger bootstrap-touchspin-down me-1 btn-remove" type="button">
                                            <i data-feather='minus'></i>
                                        </button>
                                        <button class="btn btn-sm btn-success bootstrap-touchspin-up btn-add" type="button">
                                            <i data-feather="plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit">
                            Submit
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
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
    <script>
        var dt_basic_table = $('.datatables-basic'),
            dt_date_table = $('.dt-date');
        loadData();
        function loadData() {
            var dt_basic = dt_basic_table.DataTable({
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                order: false,
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4, 5, 6, 7] }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    },
                    {
                        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Record',
                        className: 'create-new btn btn-primary',
                        attr: {
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#addPackageModal'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],
            });
        }

        $(document).on("click",".package-table tbody tr .btn-add",function () {
            $(".package-table tbody").append(`
            <tr>

 <td>
                                    <input type="number" name="year[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="number" name="principal_profit[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <div class="input-group bootstrap-touchspin">
                                        <button class="btn btn-sm btn-danger bootstrap-touchspin-down me-1 btn-remove" type="button">
                                            <i data-feather='minus'></i>
                                        </button>
                                        <button class="btn btn-sm btn-success bootstrap-touchspin-up btn-add" type="button">
                                            <i data-feather="plus"></i>
                                        </button>
                                    </div>
                                </td>
</tr>
            `);

            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }

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
                    url: "{{ route('dps-packages.store') }}",
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
