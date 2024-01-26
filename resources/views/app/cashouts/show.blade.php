@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('cashouts.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.cashouts.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.cashout_category_id')</h5>
                    <span
                        >{{ optional($cashout->cashoutCategory)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.account_no')</h5>
                    <span>{{ $cashout->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.amount')</h5>
                    <span>{{ $cashout->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.trx_id')</h5>
                    <span>{{ $cashout->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.description')</h5>
                    <span>{{ $cashout->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.date')</h5>
                    <span>{{ $cashout->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.created_by')</h5>
                    <span
                        >{{ optional($cashout->createdBy)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cashouts.inputs.user_id')</h5>
                    <span>{{ optional($cashout->user)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('cashouts.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Cashout::class)
                <a href="{{ route('cashouts.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
