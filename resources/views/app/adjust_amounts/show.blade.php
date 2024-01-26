@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('adjust-amounts.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.adjust_amounts.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.loan_id')</h5>
                    <span>{{ $adjustAmount->loan_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.daily_loan_id')</h5>
                    <span
                        >{{ optional($adjustAmount->dailyLoan)->opening_date ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.adjust_amount')</h5>
                    <span>{{ $adjustAmount->adjust_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.before_adjust')</h5>
                    <span>{{ $adjustAmount->before_adjust ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.after_adjust')</h5>
                    <span>{{ $adjustAmount->after_adjust ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.date')</h5>
                    <span>{{ $adjustAmount->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.adjust_amounts.inputs.added_by')</h5>
                    <span
                        >{{ optional($adjustAmount->addedBy)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('adjust-amounts.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\AdjustAmount::class)
                <a
                    href="{{ route('adjust-amounts.create') }}"
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
