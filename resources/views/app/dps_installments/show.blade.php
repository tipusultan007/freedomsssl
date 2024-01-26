@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('dps-installments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.dps_installments.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.account_no')</h5>
                    <span>{{ $dpsInstallment->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.user_id')</h5>
                    <span
                        >{{ optional($dpsInstallment->user)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.dps_id')</h5>
                    <span
                        >{{ optional($dpsInstallment->dps)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.collector_id')</h5>
                    <span
                        >{{ optional($dpsInstallment->collector)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.dps_loan_id')</h5>
                    <span
                        >{{ optional($dpsInstallment->dpsLoan)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.dps_amount')</h5>
                    <span>{{ $dpsInstallment->dps_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.dps_balance')</h5>
                    <span>{{ $dpsInstallment->dps_balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.receipt_no')</h5>
                    <span>{{ $dpsInstallment->receipt_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.late_fee')</h5>
                    <span>{{ $dpsInstallment->late_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.other_fee')</h5>
                    <span>{{ $dpsInstallment->other_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.grace')</h5>
                    <span>{{ $dpsInstallment->grace ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.advance')</h5>
                    <span>{{ $dpsInstallment->advance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_installments.inputs.loan_installment')
                    </h5>
                    <span>{{ $dpsInstallment->loan_installment ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.interest')</h5>
                    <span>{{ $dpsInstallment->interest ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.trx_id')</h5>
                    <span>{{ $dpsInstallment->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.loan_balance')</h5>
                    <span>{{ $dpsInstallment->loan_balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.total')</h5>
                    <span>{{ $dpsInstallment->total ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.due')</h5>
                    <span>{{ $dpsInstallment->due ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.due_return')</h5>
                    <span>{{ $dpsInstallment->due_return ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_installments.inputs.date')</h5>
                    <span>{{ $dpsInstallment->date ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('dps-installments.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DpsInstallment::class)
                <a
                    href="{{ route('dps-installments.create') }}"
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
