@extends('layouts/layoutMaster')

@section('title', __('সংক্ষেপ রিপোর্ট'))
@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
@endsection
@section('content')
  <h3 class="fw-bolder text-center text-primary">সংক্ষেপ রিপোর্ট</h3>
  <hr>
  <div class="date-range-search d-block mx-auto w-25 my-4">
    <form id="filterForm">
      @csrf
      <p class="fw-bolder text-center">তারিখের পরিসীমা নির্বাচন করুন:</p>
      <input type="text" id="date_filter" name="date_filter" class="form-control"/>
    </form>
  </div>
  <div class="text-center" id="loader" style="display: none">
    <div class="spinner-grow text-success" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div id="summaryResult">
    <!-- Updated summary will be displayed here -->
  </div>


@endsection
@section('page-script')
  <script>
    $(document).ready(function () {
      filterSummary(); // Trigger filterSummary on page load
    });
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#date_filter').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);
    $('#date_filter').on('apply.daterangepicker', function () {
      filterSummary(); // Trigger filterSummary when the date range changes
    });
    function filterSummary() {
      // Get the selected date range from daterangepicker
      var dateRange = $('#date_filter').data('daterangepicker');

      // Extract the start and end dates
      var startDate = dateRange.startDate.format('YYYY-MM-DD');
      var endDate = dateRange.endDate.format('YYYY-MM-DD');

      // Add the start and end dates to the form data
      var formData = $('#filterForm').serialize() + '&start_date=' + startDate + '&end_date=' + endDate;

      $('#summaryResult').html("");
      $('#loader').show();
      $.ajax({
        url: "{{ route('summary.report') }}",
        type: "GET",
        data: formData,
        success: function (response) {
          $('#summaryResult').html(response);
        },
        error: function (error) {
          console.log(error);
        },
        complete: function () {
          // Hide the loader when the AJAX request is complete
          $('#loader').hide();
        }
      });
    }

  </script>
@endsection
