@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fdr-profits.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fdr_profits.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.account_no')</h5>
                    <span>{{ $fdrProfit->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.user_id')</h5>
                    <span>{{ optional($fdrProfit->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.fdr_id')</h5>
                    <span
                        >{{ optional($fdrProfit->fdr)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.profit')</h5>
                    <span>{{ $fdrProfit->profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.balance')</h5>
                    <span>{{ $fdrProfit->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.date')</h5>
                    <span>{{ $fdrProfit->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.created_by')</h5>
                    <span
                        >{{ optional($fdrProfit->createdBy)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.trx_id')</h5>
                    <span>{{ $fdrProfit->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.month')</h5>
                    <span>{{ $fdrProfit->month ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.year')</h5>
                    <span>{{ $fdrProfit->year ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_profits.inputs.note')</h5>
                    <span>{{ $fdrProfit->note ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('fdr-profits.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FdrProfit::class)
                <a
                    href="{{ route('fdr-profits.create') }}"
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
