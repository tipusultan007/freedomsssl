@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('dps-loan-collections.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.dps_loan_collections.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.account_no')
                    </h5>
                    <span>{{ $dpsLoanCollection->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_loan_collections.inputs.user_id')</h5>
                    <span
                        >{{ optional($dpsLoanCollection->user)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.dps_loan_id')
                    </h5>
                    <span
                        >{{ optional($dpsLoanCollection->dpsLoan)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.collector_id')
                    </h5>
                    <span
                        >{{ optional($dpsLoanCollection->collector)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.dps_installment_id')
                    </h5>
                    <span
                        >{{
                        optional($dpsLoanCollection->dpsInstallment)->account_no
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_loan_collections.inputs.trx_id')</h5>
                    <span>{{ $dpsLoanCollection->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.loan_installment')
                    </h5>
                    <span
                        >{{ $dpsLoanCollection->loan_installment ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_loan_collections.inputs.balance')</h5>
                    <span>{{ $dpsLoanCollection->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_loan_collections.inputs.interest')</h5>
                    <span>{{ $dpsLoanCollection->interest ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_loan_collections.inputs.date')</h5>
                    <span>{{ $dpsLoanCollection->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_loan_collections.inputs.receipt_no')
                    </h5>
                    <span>{{ $dpsLoanCollection->receipt_no ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('dps-loan-collections.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DpsLoanCollection::class)
                <a
                    href="{{ route('dps-loan-collections.create') }}"
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
