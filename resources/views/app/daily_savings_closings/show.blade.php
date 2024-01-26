@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('daily-savings-closings.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.daily_savings_closings.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.account_no')
                    </h5>
                    <span>{{ $dailySavingsClosing->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.daily_savings_id')
                    </h5>
                    <span
                        >{{
                        optional($dailySavingsClosing->dailySavings)->account_no
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.total_deposit')
                    </h5>
                    <span
                        >{{ $dailySavingsClosing->total_deposit ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.total_withdraw')
                    </h5>
                    <span
                        >{{ $dailySavingsClosing->total_withdraw ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_savings_closings.inputs.balance')</h5>
                    <span>{{ $dailySavingsClosing->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.interest')
                    </h5>
                    <span>{{ $dailySavingsClosing->interest ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.closing_by')
                    </h5>
                    <span
                        >{{ optional($dailySavingsClosing->closingBy)->name ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_savings_closings.inputs.date')</h5>
                    <span>{{ $dailySavingsClosing->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_savings_closings.inputs.closing_fee')
                    </h5>
                    <span>{{ $dailySavingsClosing->closing_fee ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('daily-savings-closings.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DailySavingsClosing::class)
                <a
                    href="{{ route('daily-savings-closings.create') }}"
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
