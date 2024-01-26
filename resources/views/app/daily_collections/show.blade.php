@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('daily-collections.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.daily_collections.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.account_no')</h5>
                    <span>{{ $dailyCollection->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.user_id')</h5>
                    <span
                        >{{ optional($dailyCollection->user)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.collector_id')</h5>
                    <span
                        >{{ optional($dailyCollection->collector)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.saving_amount')
                    </h5>
                    <span>{{ $dailyCollection->saving_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.saving_type')</h5>
                    <span>{{ $dailyCollection->saving_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.late_fee')</h5>
                    <span>{{ $dailyCollection->late_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.other_fee')</h5>
                    <span>{{ $dailyCollection->other_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.loan_installment')
                    </h5>
                    <span>{{ $dailyCollection->loan_installment ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.loan_late_fee')
                    </h5>
                    <span>{{ $dailyCollection->loan_late_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.loan_other_fee')
                    </h5>
                    <span>{{ $dailyCollection->loan_other_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.saving_note')</h5>
                    <span>{{ $dailyCollection->saving_note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.loan_note')</h5>
                    <span>{{ $dailyCollection->loan_note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.daily_savings_id')
                    </h5>
                    <span
                        >{{ optional($dailyCollection->dailySavings)->account_no
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.daily_loan_id')
                    </h5>
                    <span
                        >{{ optional($dailyCollection->dailyLoan)->opening_date
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_collections.inputs.savings_balance')
                    </h5>
                    <span>{{ $dailyCollection->savings_balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.loan_balance')</h5>
                    <span>{{ $dailyCollection->loan_balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_collections.inputs.date')</h5>
                    <span>{{ $dailyCollection->date ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('daily-collections.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DailyCollection::class)
                <a
                    href="{{ route('daily-collections.create') }}"
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
