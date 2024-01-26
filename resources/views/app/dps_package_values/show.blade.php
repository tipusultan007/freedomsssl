@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('dps-package-values.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.dps_package_values.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.dps_package_values.inputs.dps_package_id')
                    </h5>
                    <span
                        >{{ optional($dpsPackageValue->dpsPackage)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_package_values.inputs.year')</h5>
                    <span>{{ $dpsPackageValue->year ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.dps_package_values.inputs.amount')</h5>
                    <span>{{ $dpsPackageValue->amount ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('dps-package-values.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DpsPackageValue::class)
                <a
                    href="{{ route('dps-package-values.create') }}"
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
