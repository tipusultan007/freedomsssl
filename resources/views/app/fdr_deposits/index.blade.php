@extends('layouts/layoutMaster')

@section('title', 'FDR জমা তালিকা')

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
    @php
        $fdrPackages = \App\Models\FdrPackage::all();
        $fdrAccounts = \App\Models\Fdr::all();
    @endphp
    <style>
      @media print{
        .phone-number{
          visibility: hidden;
        }
      }
    </style>
    <div class="d-flex justify-content-between mb-3">
      <nav aria-label="breadcrumb" class="d-flex align-items-center">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">ড্যাশবোর্ড</a>
          </li>
          <li class="breadcrumb-item active">FDR জমা তালিকা</li>
        </ol>
      </nav>
    </div>
    <!-- Basic table -->
    <div class="card mb-3">
      <div class="card-body">
        <form class="add-new-record">
          @csrf
          <div class="row">
            <div class="mb-1 col-md-3">
              <label class="form-label" for="name">হিসাব নং</label>
              <select class="form-select select2" name="fdr_id" id="fdr_id" data-placeholder="হিসাব নং" data-search-allow="on">
                <option value=""></option>
                @forelse($fdrAccounts as $account)
                  <option value="{{ $account->id }}"> {{ $account->account_no }} || {{ $account->user->name }} </option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="name">প্যাকেজ</label>
              <select class="form-select select2" name="fdr_package_id" data-placeholder="সিলেক্ট প্যাকেজ">
                <option value=""></option>
                @forelse($fdrPackages as $package)
                  <option value="{{ $package->id }}"> {{ $package->name }} </option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="phone">মেয়াদ <small class="text-danger">(Years)</small></label>
              <input type="number" name="duration" id="duration" class="form-control"/>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="amount">পরিমাণ</label>
              <input type="number" name="amount" id="amount" class="form-control"/>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="date">জমার তারিখ</label>
              <input type="text" value="{{ date('Y-m-d') }}" name="date" id="date" class="form-control datepicker"/>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="commencement">হিসাব শুরু</label>
              <input type="text" value="{{ date('Y-m-d') }}" placeholder="DD-MM-YYYY" name="commencement" id="commencement" class="form-control datepicker"/>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="note">মন্তব্য</label>
              <input type="text" name="note" id="note" class="form-control"/>
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-success data-submit mb-1">সাবমিট</button>
            </div>
          </div>

        </form>
      </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic table">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-bolder py-2">নাম </th>
                            <th class="fw-bolder py-2">হিসাব নং</th>
                            <th class="fw-bolder py-2">পরিমাণ </th>
                            <th class="fw-bolder py-2">প্যাকেজ</th>
                            <th class="fw-bolder py-2">অবশিষ্ট</th>
                            <th class="fw-bolder py-2">মুনাফা উত্তোলন</th>
                            <th class="fw-bolder py-2">তারিখ</th>
                            <th class="fw-bolder py-2"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal to add new record -->

      {{--<div class="modal modal-slide-in fade" id="modals-slide-in" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary py-3">
              <h5 class="modal-title text-white" id="modalCenterTitle">FDR জমা ফরম</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="add-new-record">
              @csrf
            <div class="modal-body">
              <div class="row">
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="name">হিসাব নং</label>
                  <select class="form-select select2" name="fdr_id" id="fdr_id" data-placeholder="হিসাব নং" data-search-allow="on">
                    <option value=""></option>
                    @forelse($fdrAccounts as $account)
                      <option value="{{ $account->id }}"> {{ $account->account_no }} || {{ $account->user->name }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="name">প্যাকেজ</label>
                  <select class="form-select select2" name="fdr_package_id">
                    @forelse($fdrPackages as $package)
                      <option value="{{ $package->id }}"> {{ $package->name }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="phone">মেয়াদ <small class="text-danger">(Years)</small></label>
                  <input type="number" name="duration" id="duration" class="form-control"/>
                </div>
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="amount">পরিমাণ</label>
                  <input type="number" name="amount" id="amount" class="form-control"/>
                </div>
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="date">জমার তারিখ</label>
                  <input type="text" value="{{ date('Y-m-d') }}" name="date" id="date" class="form-control datepicker"/>
                </div>
                <div class="mb-1 col-md-6">
                  <label class="form-label" for="percentage">হিসাব শুরু</label>
                  <input type="text" value="{{ date('Y-m-d') }}" placeholder="DD-MM-YYYY" name="commencement" id="commencement" class="form-control datepicker"/>
                </div>
                <div class="mb-1 col-md-12">
                  <label class="form-label" for="note">মন্তব্য</label>
                  <input type="text" name="note" id="note" class="form-control"/>
                </div>
              </div>
              <input type="hidden" name="status" value="active">
              <input type="hidden" name="created_by" value="{{ auth()->id() }}">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">বাতিল</button>
              <button type="button" class="btn btn-primary data-submit">সাবমিট</button>
            </div>
            </form>
          </div>
        </div>
      </div>--}}
    </section>
    <!--/ Basic table -->
    <div class="modal fade" id="modalFdrDeposit" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning py-3">
                    <h5 class="modal-title text-white" id="exampleModalCenterTitle">FDR জমা আপডেট ফরম</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" id="edit-form">
                        @csrf
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
                                    <label class="form-label" for="company-column">প্যাকেজ</label>
                                    <select class="form-select select2 fdr_package_id" name="fdr_package_id">
                                        @forelse($fdrPackages as $package)
                                            <option value="{{ $package->id }}"> {{ $package->name }} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="country-floating">তারিখ</label>
                                    <input type="text" class="form-control date datepicker" name="date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="country-floating">হিসাব নং</label>
                                    <input type="text" class="form-control commencement datepicker" name="commencement">
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
                    "url": "{{ url('allFdrDeposits') }}"
                },
                "columns": [
                    { "data": "name" },
                    { "data": "account_no" },
                    { "data": "amount" },
                    { "data": "package" },
                    { "data": "balance" },
                    { "data": "profit" },
                    { "data": "commencement" },
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
                                    '<img src="{{ asset('storage/images/profile') }}/' + $image + '" alt="Avatar" height="32" width="32">';
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
                                '<div class="d-flex justify-content-left align-items-center user-name">' +
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
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                '<i class="ti ti-dots"></i>' +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="{{url('fdr-deposits')}}/'+full['id']+'" class="dropdown-item">' +
                                'বিস্তারিত</a>' +
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item item-edit">এডিট</a>'+
                                '<a href="javascript:;" data-id="'+full['id']+'" class="dropdown-item delete-record text-danger fw-bolder">' +
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
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            var el = $.parseHTML(inner);
                            var result = '';
                            $.each(el, function (index, item) {
                              if (item.classList !== undefined && item.classList.contains('user-name')) {
                                result = result + item.lastChild.textContent;
                              } else result = result + item.innerText;
                            });
                            return result;
                          }
                        }
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
                {
                  text: 'FDR জমা ফরম',
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
                url: "{{ route('fdr-deposits.store') }}",
                method: "POST",
                data: $(".add-new-record").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    toastr.success('New FDR Deposited successfully.', 'New FDR Deposit!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    $("form").trigger('reset');
                    $("form select").val('').trigger('change');

                },
                error: function () {
                    $this.attr('disabled', false).html($caption);
                    toastr.error('New FDR Deposit failed.', 'Failed!', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                }

            })
        });

        function deleteFdrDeposit(id) {
          var token = $("meta[name='csrf-token']").attr("content");
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "{{ url('fdr-deposits') }}/" + id, //or you can use url: "company/"+id,
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
              return deleteFdrDeposit(id)
                .catch(() => {
                  Swal.showValidationMessage('FDR জমা ডিলেট ব্যর্থ হয়েছে।');
                });
            }
          }).then((result) => {
            if (result.isConfirmed) {
              toastr.success('FDR জমা ডিলেট হয়েছে।', 'ডিলেট!', {
                closeButton: true,
                tapToDismiss: false
              });

              $(".datatables-basic").DataTable().destroy();
              loadData();
            }
          });
        });

        /*$(document).on("click",".delete-record",function () {
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
                            url: "fdr-deposits/"+id, //or you can use url: "company/"+id,
                            type: 'DELETE',
                            data: {
                                _token: token,
                                id: id
                            },
                            success: function (response){

                                //$("#success").html(response.message)

                                Swal.fire(
                                    'Remind!',
                                    'FDR Deposit deleted successfully!',
                                    'success'
                                )
                                $(".datatables-basic").DataTable().destroy();
                                loadData();
                            }
                        });
                }
            });
        })*/
        $(document).on("click",".item-edit",function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('getFdrDeposit') }}/"+id,
                dataType: "JSON",
                success: function (data) {
                    var user = data.user;
                    $(".edit-name").text(user.name);
                    $(".edit-account-no").text(data.account_no);
                    $(".amount").val(data.amount);
                    $("#old_amount").val(data.amount);
                    $(".fdr_package_id").val(data.fdr_package_id);
                    $(".date").val(data.date);
                    $(".commencement").val(data.commencement);
                    $("input[name='id']").val(data.id);
                    $(".note").val(data.note);
                }
            })
            $("#modalFdrDeposit").modal("show");
        })
        $(".btn-edit").on("click", function () {
            var id = $("input[name='id']").val();
            var $this = $(".edit"); //submit button selector using ID
            var $caption = $this.html();// We store the html content of the submit button
            $.ajax({
                url: "fdr-deposits/" + id,
                method: "PUT",
                data: $("#edit-form").serialize(),
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    $this.attr('disabled', true).html("Processing...");
                },
                success: function (data) {
                    $this.attr('disabled', false).html($caption);
                    $("#modalFdrDeposit").modal("hide");
                    toastr['success']('আপডেট সম্পন্ন হয়েছে!', 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,
                    });
                    $(".datatables-basic").DataTable().destroy();
                    loadData();
                    resetForm();

                },
                error: function (data) {
                    $("#modalFdrDeposit").modal("hide");
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
