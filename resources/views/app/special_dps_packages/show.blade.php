@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('special-dps-packages.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.special_dps_packages.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.special_dps_packages.inputs.name')</h5>
                    <span>{{ $specialDpsPackage->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.special_dps_packages.inputs.amount')</h5>
                    <span>{{ $specialDpsPackage->amount ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('special-dps-packages.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SpecialDpsPackage::class)
                <a
                    href="{{ route('special-dps-packages.create') }}"
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
