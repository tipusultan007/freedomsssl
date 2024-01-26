@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('dps-collections.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.dps_collections.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.account_no')</h5>
                    <span>{{ $dpsCollection->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.user_id')</h5>
                    <span
                        >{{ optional($dpsCollection->user)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.dps_id')</h5>
                    <span
                        >{{ optional($dpsCollection->dps)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.dps_amount')</h5>
                    <span>{{ $dpsCollection->dps_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.balance')</h5>
                    <span>{{ $dpsCollection->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.receipt_no')</h5>
                    <span>{{ $dpsCollection->receipt_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.late_fee')</h5>
                    <span>{{ $dpsCollection->late_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.other_fee')</h5>
                    <span>{{ $dpsCollection->other_fee ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.advance')</h5>
                    <span>{{ $dpsCollection->advance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.month')</h5>
                    <span>{{ $dpsCollection->month ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.year')</h5>
                    <span>{{ $dpsCollection->year ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.trx_id')</h5>
                    <span>{{ $dpsCollection->trx_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.date')</h5>
                    <span>{{ $dpsCollection->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_collections.inputs.collector_id')</h5>
                    <span
                        >{{ optional($dpsCollection->collector)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_collections.inputs.dps_installment_id')
                    </h5>
                    <span
                        >{{ optional($dpsCollection->dpsInstallment)->account_no
                        ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('dps-collections.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DpsCollection::class)
                <a
                    href="{{ route('dps-collections.create') }}"
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
