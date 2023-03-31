@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('all-loan-documents.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.all_loan_documents.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.all_loan_documents.inputs.account_no')</h5>
                    <span>{{ $loanDocuments->account_no ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.all_loan_documents.inputs.document_name')
                    </h5>
                    <span>{{ $loanDocuments->document_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.all_loan_documents.inputs.document_location')
                    </h5>
                    <span>{{ $loanDocuments->document_location ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_loan_documents.inputs.date')</h5>
                    <span>{{ $loanDocuments->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.all_loan_documents.inputs.taken_loan_id')
                    </h5>
                    <span
                        >{{ optional($loanDocuments->takenLoan)->account_no ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.all_loan_documents.inputs.collect_by')</h5>
                    <span
                        >{{ optional($loanDocuments->collectBy)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('all-loan-documents.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\LoanDocuments::class)
                <a
                    href="{{ route('all-loan-documents.create') }}"
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
