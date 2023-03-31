
@extends('layouts/contentLayoutMaster')

@section('title', 'FDR Withdraws')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">

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
                            <th>A/C NO</th>
                            <th>PACKAGE</th>
                            <th>AMOUNT</th>
                            <th>BALANCE</th>
                            <th>CREATED BY</th>
                            <th>ACTIONS</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->
        <div class="modal modal-slide-in fade" id="modals-slide-in">
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
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        var basicPickr = $('.flatpickr-basic');

        // Default
        if (basicPickr.length) {
            basicPickr.flatpickr({
                altInput: true,
                altFormat: 'd/m/Y',
                dateFormat: 'Y-m-d'
            });
        }
        loadData();
        var assetPath = $('body').attr('data-asset-path'),
            userView = '{{ url('users') }}/';

        $("#modals-slide-in").on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: 'Select a A/C no'
            });
        });
        $('#fdr_id').on('change', function (e) {
            $('#fdr_deposit_id').empty();
            //set id
            let fdr_id = $(this).val();
            if (fdr_id) {
                $('#fdr_deposit_id').select2({
                    allowClear: true,
                    width: '100%',
                    ajax: {
                        url: "{{ url('fdrDeposits') }}/" + fdr_id,
                        dataType: 'json',
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text:item.balance+' || '+item.fdr_package.name,
                                        id: item.id
                                    }
                                })
                            };
                        }
                    }
                });
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
                                $image = full['profile_photo_url'];
                            if ($image != null) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
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
                                '<div class="avatar-wrapper">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<a href="' +
                                userView+$id +
                                '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                                $name +
                                '</span></a>' +
                                '<small class="emp_post text-success">' +
                                full['phone'] +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },

                    {
                        // Actions
                        targets: 6,
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


        $(document).on("click",".delete-record",function () {
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
                            url: "fdr-withdraws/"+id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response){

                                //$("#success").html(response.message)

                                Swal.fire(
                                    'Remind!',
                                    'FDR Withdrawal deleted successfully!',
                                    'success'
                                )
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        });
                }
            });
        })
    </script>
@endsection
