@php $editing = isset($dpsLoanCollection) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $dpsLoanCollection->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $dpsLoanCollection->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_loan_id" label="Dps Loan" required>
            @php $selected = old('dps_loan_id', ($editing ? $dpsLoanCollection->dps_loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps Loan</option>
            @foreach($dpsLoans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="collector_id" label="Collector" required>
            @php $selected = old('collector_id', ($editing ? $dpsLoanCollection->collector_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select
            name="dps_installment_id"
            label="Dps Installment"
            required
        >
            @php $selected = old('dps_installment_id', ($editing ? $dpsLoanCollection->dps_installment_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps Installment</option>
            @foreach($dpsInstallments as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="trx_id"
            label="Trx Id"
            value="{{ old('trx_id', ($editing ? $dpsLoanCollection->trx_id : '')) }}"
            placeholder="Trx Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_installment"
            label="Loan Installment"
            value="{{ old('loan_installment', ($editing ? $dpsLoanCollection->loan_installment : '')) }}"
            placeholder="Loan Installment"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="balance"
            label="Balance"
            value="{{ old('balance', ($editing ? $dpsLoanCollection->balance : '')) }}"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest"
            label="Interest"
            value="{{ old('interest', ($editing ? $dpsLoanCollection->interest : '')) }}"
            max="255"
            placeholder="Interest"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($dpsLoanCollection->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="receipt_no"
            label="Receipt No"
            value="{{ old('receipt_no', ($editing ? $dpsLoanCollection->receipt_no : '')) }}"
            placeholder="Receipt No"
        ></x-inputs.text>
    </x-inputs.group>
</div>
