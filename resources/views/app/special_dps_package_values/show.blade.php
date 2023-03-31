@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('special-dps-package-values.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.special_dps_package_values.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.special_dps_package_values.inputs.special_dps_package_id')
                    </h5>
                    <span
                        >{{
                        optional($specialDpsPackageValue->specialDpsPackage)->name
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.special_dps_package_values.inputs.year')
                    </h5>
                    <span>{{ $specialDpsPackageValue->year ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.special_dps_package_values.inputs.amount')
                    </h5>
                    <span>{{ $specialDpsPackageValue->amount ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('special-dps-package-values.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SpecialDpsPackageValue::class)
                <a
                    href="{{ route('special-dps-package-values.create') }}"
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
