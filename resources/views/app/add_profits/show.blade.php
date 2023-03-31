@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('add-profits.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.add_profits.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.daily_savings_id')</h5>
                    <span
                        >{{ optional($addProfit->dailySavings)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.user_id')</h5>
                    <span>{{ optional($addProfit->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.account_no')</h5>
                    <span>{{ $addProfit->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.profit')</h5>
                    <span>{{ $addProfit->profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.before_profit')</h5>
                    <span>{{ $addProfit->before_profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.after_profit')</h5>
                    <span>{{ $addProfit->after_profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.date')</h5>
                    <span>{{ $addProfit->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.duration')</h5>
                    <span>{{ $addProfit->duration ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.add_profits.inputs.created_by')</h5>
                    <span
                        >{{ optional($addProfit->createdBy)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('add-profits.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\AddProfit::class)
                <a
                    href="{{ route('add-profits.create') }}"
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
