@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.all_loan_documents.index_title')
                </h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\LoanDocuments::class)
                        <a
                            href="{{ route('all-loan-documents.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.account_no')
                            </th>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.document_name')
                            </th>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.document_location')
                            </th>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.date')
                            </th>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.taken_loan_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.all_loan_documents.inputs.collect_by')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allLoanDocuments as $loanDocuments)
                        <tr>
                            <td>{{ $loanDocuments->account_no ?? '-' }}</td>
                            <td>{{ $loanDocuments->document_name ?? '-' }}</td>
                            <td>
                                {{ $loanDocuments->document_location ?? '-' }}
                            </td>
                            <td>{{ $loanDocuments->date ?? '-' }}</td>
                            <td>
                                {{
                                optional($loanDocuments->takenLoan)->account_no
                                ?? '-' }}
                            </td>
                            <td>
                                {{ optional($loanDocuments->collectBy)->name ??
                                '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $loanDocuments)
                                    <a
                                        href="{{ route('all-loan-documents.edit', $loanDocuments) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $loanDocuments)
                                    <a
                                        href="{{ route('all-loan-documents.show', $loanDocuments) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $loanDocuments)
                                    <form
                                        action="{{ route('all-loan-documents.destroy', $loanDocuments) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                {!! $allLoanDocuments->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
