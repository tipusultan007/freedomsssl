@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('guarantors.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.guarantors.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.guarantors.inputs.user_id')</h5>
                    <span>{{ optional($guarantor->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.guarantors.inputs.name')</h5>
                    <span>{{ $guarantor->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.guarantors.inputs.address')</h5>
                    <span>{{ $guarantor->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.guarantors.inputs.exist_ac_no')</h5>
                    <span>{{ $guarantor->exist_ac_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.guarantors.inputs.daily_loan_id')</h5>
                    <span
                        >{{ optional($guarantor->dailyLoan)->opening_date ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('guarantors.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Guarantor::class)
                <a
                    href="{{ route('guarantors.create') }}"
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
