@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fdr-deposits.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fdr_deposits.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.account_no')</h5>
                    <span>{{ $fdrDeposit->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.fdr_id')</h5>
                    <span
                        >{{ optional($fdrDeposit->fdr)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.user_id')</h5>
                    <span>{{ optional($fdrDeposit->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.amount')</h5>
                    <span>{{ $fdrDeposit->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.fdr_package_id')</h5>
                    <span
                        >{{ optional($fdrDeposit->fdrPackage)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.date')</h5>
                    <span>{{ $fdrDeposit->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.commencement')</h5>
                    <span>{{ $fdrDeposit->commencement ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.balance')</h5>
                    <span>{{ $fdrDeposit->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.profit')</h5>
                    <span>{{ $fdrDeposit->profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.created_by')</h5>
                    <span
                        >{{ optional($fdrDeposit->createdBy)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdr_deposits.inputs.note')</h5>
                    <span>{{ $fdrDeposit->note ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('fdr-deposits.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FdrDeposit::class)
                <a
                    href="{{ route('fdr-deposits.create') }}"
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
