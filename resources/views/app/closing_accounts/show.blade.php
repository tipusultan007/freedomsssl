@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('closing-accounts.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.closing_accounts.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.account_no')</h5>
                    <span>{{ $closingAccount->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.user_id')</h5>
                    <span
                        >{{ optional($closingAccount->user)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.type')</h5>
                    <span>{{ $closingAccount->type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.deposit')</h5>
                    <span>{{ $closingAccount->deposit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.Withdraw')</h5>
                    <span>{{ $closingAccount->Withdraw ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.remain')</h5>
                    <span>{{ $closingAccount->remain ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.profit')</h5>
                    <span>{{ $closingAccount->profit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.closing_accounts.inputs.service_charge')
                    </h5>
                    <span>{{ $closingAccount->service_charge ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.total')</h5>
                    <span>{{ $closingAccount->total ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.date')</h5>
                    <span>{{ $closingAccount->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.created_by')</h5>
                    <span
                        >{{ optional($closingAccount->createdBy)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.closing_accounts.inputs.daily_savings_id')
                    </h5>
                    <span
                        >{{ optional($closingAccount->dailySavings)->account_no
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.dps_id')</h5>
                    <span
                        >{{ optional($closingAccount->dps)->account_no ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.closing_accounts.inputs.special_dps_id')
                    </h5>
                    <span
                        >{{ optional($closingAccount->specialDps)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.closing_accounts.inputs.fdr_id')</h5>
                    <span
                        >{{ optional($closingAccount->fdr)->account_no ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('closing-accounts.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\ClosingAccount::class)
                <a
                    href="{{ route('closing-accounts.create') }}"
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
