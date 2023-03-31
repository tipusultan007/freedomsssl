@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fdrs.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fdrs.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.account_no')</h5>
                    <span>{{ $fdr->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.user_id')</h5>
                    <span>{{ optional($fdr->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.fdr_package_id')</h5>
                    <span>{{ optional($fdr->fdrPackage)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.duration')</h5>
                    <span>{{ $fdr->duration ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.date')</h5>
                    <span>{{ $fdr->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.fdr_amount')</h5>
                    <span>{{ $fdr->fdr_amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.deposit_date')</h5>
                    <span>{{ $fdr->deposit_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.commencement')</h5>
                    <span>{{ $fdr->commencement ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fdrs.inputs.note')</h5>
                    <span>{{ $fdr->note ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('fdrs.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Fdr::class)
                <a href="{{ route('fdrs.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
