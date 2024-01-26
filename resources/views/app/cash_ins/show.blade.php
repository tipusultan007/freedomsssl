@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('cash-ins.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.cash_ins.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.user_id')</h5>
                    <span>{{ optional($cashIn->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.cashin_category_id')</h5>
                    <span
                        >{{ optional($cashIn->cashinCategory)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.account_no')</h5>
                    <span>{{ $cashIn->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.amount')</h5>
                    <span>{{ $cashIn->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.trx_id')</h5>
                    <span>{{ $cashIn->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.description')</h5>
                    <span>{{ $cashIn->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.date')</h5>
                    <span>{{ $cashIn->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cash_ins.inputs.created_by')</h5>
                    <span>{{ optional($cashIn->createdBy)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('cash-ins.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\CashIn::class)
                <a href="{{ route('cash-ins.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
