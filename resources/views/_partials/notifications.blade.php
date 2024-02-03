@php
  $notifications = \App\Models\Notification::all();
  @endphp
<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
     data-bs-auto-close="outside" aria-expanded="false">
    <i class="ti ti-bell ti-md"></i>
    <span class="badge bg-danger rounded-pill badge-notifications">{{ $notifications->count() }}</span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end py-0">
    <li class="dropdown-menu-header border-bottom">
      <div class="dropdown-header d-flex align-items-center py-3">
        <h5 class="text-body mb-0 me-auto">Notification</h5>
        <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip"
           data-bs-placement="top" title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
      </div>
    </li>
    <li class="dropdown-notifications-list scrollable-container">
      <ul class="list-group list-group-flush">
        @foreach($notifications->take(10) as $notification)
          @php
            $data = json_decode($notification->data, true);
          @endphp
          <li class="list-group-item list-group-item-action dropdown-notifications-item">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar">
                  <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="h-auto rounded-circle">
                </div>
              </div>
              @if($notification->notifiable_type == 'App\\Models\\DpsLoan')
                <div class="flex-grow-1">
                  <h6 class="mb-1 text-success">মাসিক (DPS) ঋণ </h6>
                  <p class="mb-0">হিসাব নং-{{ $data['account_no'] }}, বকেয়া সুদ {{ $data['total_interest'] }}।</p>
                </div>
              @else
                <div class="flex-grow-1">
                  <h6 class="mb-1 text-danger">স্থায়ী সঞ্চয় মুনাফা </h6>
                  <p class="mb-0">হিসাব নং-{{ $data['account_no'] }}, মুনাফা পাওনা {{ $data['total_profit'] }}।</p>
                </div>
              @endif

              {{--<div class="flex-shrink-0 dropdown-notifications-actions">
                <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                    class="badge badge-dot"></span></a>
                <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                    class="ti ti-x"></span></a>
              </div>--}}
            </div>
          </li>
        @endforeach

      </ul>
    </li>
    <li class="dropdown-menu-footer border-top">
      <a href="{{ url('notifications') }}"
         class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
        View all notifications
      </a>
    </li>
  </ul>
</li>
