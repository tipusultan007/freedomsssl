@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('incomes.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.incomes.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.incomes.inputs.income_category_id')</h5>
                    <span
                        >{{ optional($income->incomeCategory)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.incomes.inputs.amount')</h5>
                    <span>{{ $income->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.incomes.inputs.description')</h5>
                    <span>{{ $income->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.incomes.inputs.date')</h5>
                    <span>{{ $income->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.incomes.inputs.created_by')</h5>
                    <span>{{ optional($income->createdBy)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('incomes.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Income::class)
                <a href="{{ route('incomes.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
