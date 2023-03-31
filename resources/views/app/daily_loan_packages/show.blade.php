@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('daily-loan-packages.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.daily_loan_packages.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.daily_loan_packages.inputs.months')</h5>
                    <span>{{ $dailyLoanPackage->months ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.daily_loan_packages.inputs.interest')</h5>
                    <span>{{ $dailyLoanPackage->interest ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('daily-loan-packages.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DailyLoanPackage::class)
                <a
                    href="{{ route('daily-loan-packages.create') }}"
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
