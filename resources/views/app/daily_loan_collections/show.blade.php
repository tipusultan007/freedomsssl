@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('daily-loan-collections.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.daily_loan_collections.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.account_no')
                    </h5>
                    <span>{{ $dailyLoanCollection->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.daily_loan_id')
                    </h5>
                    <span
                        >{{
                        optional($dailyLoanCollection->dailyLoan)->opening_date
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.loan_installment')
                    </h5>
                    <span
                        >{{ $dailyLoanCollection->loan_installment ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.loan_late_fee')
                    </h5>
                    <span
                        >{{ $dailyLoanCollection->loan_late_fee ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.loan_other_fee')
                    </h5>
                    <span
                        >{{ $dailyLoanCollection->loan_other_fee ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.loan_note')
                    </h5>
                    <span>{{ $dailyLoanCollection->loan_note ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.loan_balance')
                    </h5>
                    <span>{{ $dailyLoanCollection->loan_balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.daily_loan_collections.inputs.collector_id')
                    </h5>
                    <span
                        >{{ optional($dailyLoanCollection->collector)->name ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_loan_collections.inputs.date')</h5>
                    <span>{{ $dailyLoanCollection->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_loan_collections.inputs.user_id')</h5>
                    <span
                        >{{ optional($dailyLoanCollection->user)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('daily-loan-collections.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DailyLoanCollection::class)
                <a
                    href="{{ route('daily-loan-collections.create') }}"
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
