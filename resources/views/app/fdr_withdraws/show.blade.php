@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fdr-withdraws.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fdr_withdraws.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.account_no')</h5>
                    <span>{{ $fdrWithdraw->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.user_id')</h5>
                    <span>{{ optional($fdrWithdraw->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.fdr_id')</h5>
                    <span
                        >{{ optional($fdrWithdraw->fdr)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.date')</h5>
                    <span>{{ $fdrWithdraw->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.fdr_deposit_id')</h5>
                    <span
                        >{{ optional($fdrWithdraw->fdrDeposit)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.withdraw_amount')</h5>
                    <span>{{ $fdrWithdraw->withdraw_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.balance')</h5>
                    <span>{{ $fdrWithdraw->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.created_by')</h5>
                    <span
                        >{{ optional($fdrWithdraw->createdBy)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_withdraws.inputs.note')</h5>
                    <span>{{ $fdrWithdraw->note ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('fdr-withdraws.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FdrWithdraw::class)
                <a
                    href="{{ route('fdr-withdraws.create') }}"
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
