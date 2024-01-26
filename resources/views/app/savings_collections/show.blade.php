@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('savings-collections.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.savings_collections.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.savings_collections.inputs.account_no')</h5>
                    <span>{{ $savingsCollection->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.savings_collections.inputs.daily_savings_id')
                    </h5>
                    <span
                        >{{
                        optional($savingsCollection->dailySavings)->account_no
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.savings_collections.inputs.saving_amount')
                    </h5>
                    <span>{{ $savingsCollection->saving_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.savings_collections.inputs.type')</h5>
                    <span>{{ $savingsCollection->type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.savings_collections.inputs.collector_id')
                    </h5>
                    <span
                        >{{ optional($savingsCollection->collector)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.savings_collections.inputs.date')</h5>
                    <span>{{ $savingsCollection->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.savings_collections.inputs.balance')</h5>
                    <span>{{ $savingsCollection->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.savings_collections.inputs.user_id')</h5>
                    <span
                        >{{ optional($savingsCollection->user)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('savings-collections.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SavingsCollection::class)
                <a
                    href="{{ route('savings-collections.create') }}"
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
