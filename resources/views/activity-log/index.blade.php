@extends('layouts/layoutMaster')
@section('title', 'কার্যকলাপ লগ তালিকা')
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
  <style>
    .created-event { background-color: #d4edda; }
    .updated-event { background-color: #cce5ff; }
    .deleted-event { background-color: #f8d7da; }
  </style>
  @php
    function getRowColorClass($eventName) {
        // Define your event-to-class mapping
        $eventClasses = [
            'created' => 'created-event',
            'updated' => 'updated-event',
            'deleted' => 'deleted-event',
        ];

        return $eventClasses[$eventName] ?? '';
    }
  @endphp
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">কার্যকলাপ লগ</h4>
      </div>
      <div class="card-body">
        <!-- Add a form for filtering by manager and date -->
        <form method="get" action="{{ route('activity-log.index') }}" class="mb-3">
          <div class="row">
            <div class="col-md-3 mb-3">
              @php
              $managers = \App\Models\Manager::all();
              @endphp
              <label for="manager_id" class="form-label">ম্যানেজার</label>
              <select name="manager_id" class="select2 form-control" id="manager_id" data-placeholder="সিলেক্ট ম্যানেজার">
                <option value=""></option>
                @foreach($managers as $manager)
                  <option value="{{ $manager->id }}" {{ $manager->id==request('manager_id')?'selected':"" }}>{{ $manager->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label for="start_date" class="form-label">শুরুর তারিখ</label>
              <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
              <label for="end_date" class="form-label">শেষ তারিখ</label>
              <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-3 mb-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary">সার্চ করুণ</button>
            </div>
          </div>
        </form>

        <table class="table table-sm table-bordered">
          <thead class="table-light">
          <tr>
            <th class="fw-bolder text-center fs-6">তারিখ</th>
            <th class="fw-bolder text-center fs-6">আদায়কারি</th>
            <th class="fw-bolder text-center fs-6">বর্ণনা</th>
          </tr>
          </thead>
          <tbody>
          @foreach($activityLogs as $key => $log)
            <tr class="{{ getRowColorClass($log->event) }}">
              <td>{{ $log->created_at->format('d/m/Y h:i:s A') }}</td>
              <td>{{ $log->causer->name ?? 'System' }}</td>
              <td>{{ $log->description }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $activityLogs->links() }}
      </div>
    </div>
  </div>
@endsection

@section('page-script')

@endsection
