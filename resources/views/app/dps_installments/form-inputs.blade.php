@php $editing = isset($dpsInstallment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $dpsInstallment->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $dpsInstallment->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_id" label="Dps">
            @php $selected = old('dps_id', ($editing ? $dpsInstallment->dps_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps</option>
            @foreach($allDps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="collector_id" label="Collector" required>
            @php $selected = old('collector_id', ($editing ? $dpsInstallment->collector_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_loan_id" label="Dps Loan">
            @php $selected = old('dps_loan_id', ($editing ? $dpsInstallment->dps_loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps Loan</option>
            @foreach($dpsLoans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="dps_amount"
            label="Dps Amount"
            value="{{ old('dps_amount', ($editing ? $dpsInstallment->dps_amount : '')) }}"
            placeholder="Dps Amount"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="dps_balance"
            label="Dps Balance"
            value="{{ old('dps_balance', ($editing ? $dpsInstallment->dps_balance : '')) }}"
            placeholder="Dps Balance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="receipt_no"
            label="Receipt No"
            value="{{ old('receipt_no', ($editing ? $dpsInstallment->receipt_no : '')) }}"
            placeholder="Receipt No"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="late_fee"
            label="Late Fee"
            value="{{ old('late_fee', ($editing ? $dpsInstallment->late_fee : '')) }}"
            placeholder="Late Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="other_fee"
            label="Other Fee"
            value="{{ old('other_fee', ($editing ? $dpsInstallment->other_fee : '')) }}"
            placeholder="Other Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="grace"
            label="Grace"
            value="{{ old('grace', ($editing ? $dpsInstallment->grace : '')) }}"
            placeholder="Grace"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="advance"
            label="Advance"
            value="{{ old('advance', ($editing ? $dpsInstallment->advance : '')) }}"
            placeholder="Advance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_installment"
            label="Loan Installment"
            value="{{ old('loan_installment', ($editing ? $dpsInstallment->loan_installment : '')) }}"
            placeholder="Loan Installment"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest"
            label="Interest"
            value="{{ old('interest', ($editing ? $dpsInstallment->interest : '')) }}"
            placeholder="Interest"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="trx_id"
            label="Trx Id"
            value="{{ old('trx_id', ($editing ? $dpsInstallment->trx_id : '')) }}"
            placeholder="Trx Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_balance"
            label="Loan Balance"
            value="{{ old('loan_balance', ($editing ? $dpsInstallment->loan_balance : '')) }}"
            placeholder="Loan Balance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="total"
            label="Total"
            value="{{ old('total', ($editing ? $dpsInstallment->total : '')) }}"
            placeholder="Total"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="due"
            label="Due"
            value="{{ old('due', ($editing ? $dpsInstallment->due : '')) }}"
            placeholder="Due"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="due_return"
            label="Due Return"
            value="{{ old('due_return', ($editing ? $dpsInstallment->due_return : '')) }}"
            placeholder="Due Return"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($dpsInstallment->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
