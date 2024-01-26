@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('all-nominees.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.all_nominees.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.account_no')</h5>
                    <span>{{ $nominees->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.name')</h5>
                    <span>{{ $nominees->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.phone')</h5>
                    <span>{{ $nominees->phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.relation')</h5>
                    <span>{{ $nominees->relation ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.address')</h5>
                    <span>{{ $nominees->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.percentage')</h5>
                    <span>{{ $nominees->percentage ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_nominees.inputs.user_id')</h5>
                    <span>{{ optional($nominees->user)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('all-nominees.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Nominees::class)
                <a
                    href="{{ route('all-nominees.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
