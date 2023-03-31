@php $editing = isset($dailyCollection) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $dailyCollection->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $dailyCollection->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="collector_id" label="Collector" required>
            @php $selected = old('collector_id', ($editing ? $dailyCollection->collector_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="saving_amount"
            label="Saving Amount"
            value="{{ old('saving_amount', ($editing ? $dailyCollection->saving_amount : '')) }}"
            placeholder="Saving Amount"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="saving_type"
            label="Saving Type"
            value="{{ old('saving_type', ($editing ? $dailyCollection->saving_type : '')) }}"
            placeholder="Saving Type"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="late_fee"
            label="Late Fee"
            value="{{ old('late_fee', ($editing ? $dailyCollection->late_fee : '')) }}"
            placeholder="Late Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="other_fee"
            label="Other Fee"
            value="{{ old('other_fee', ($editing ? $dailyCollection->other_fee : '')) }}"
            placeholder="Other Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_installment"
            label="Loan Installment"
            value="{{ old('loan_installment', ($editing ? $dailyCollection->loan_installment : '')) }}"
            placeholder="Loan Installment"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_late_fee"
            label="Loan Late Fee"
            value="{{ old('loan_late_fee', ($editing ? $dailyCollection->loan_late_fee : '')) }}"
            placeholder="Loan Late Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_other_fee"
            label="Loan Other Fee"
            value="{{ old('loan_other_fee', ($editing ? $dailyCollection->loan_other_fee : '')) }}"
            max="255"
            placeholder="Loan Other Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="saving_note"
            label="Saving Note"
            value="{{ old('saving_note', ($editing ? $dailyCollection->saving_note : '')) }}"
            placeholder="Saving Note"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="loan_note"
            label="Loan Note"
            value="{{ old('loan_note', ($editing ? $dailyCollection->loan_note : '')) }}"
            placeholder="Loan Note"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_savings_id" label="Daily Savings">
            @php $selected = old('daily_savings_id', ($editing ? $dailyCollection->daily_savings_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Savings</option>
            @foreach($allDailySavings as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_loan_id" label="Daily Loan">
            @php $selected = old('daily_loan_id', ($editing ? $dailyCollection->daily_loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Loan</option>
            @foreach($dailyLoans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="savings_balance"
            label="Savings Balance"
            value="{{ old('savings_balance', ($editing ? $dailyCollection->savings_balance : '')) }}"
            placeholder="Savings Balance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_balance"
            label="Loan Balance"
            value="{{ old('loan_balance', ($editing ? $dailyCollection->loan_balance : '')) }}"
            placeholder="Loan Balance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($dailyCollection->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
