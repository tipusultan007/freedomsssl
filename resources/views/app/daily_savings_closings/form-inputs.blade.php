@php $editing = isset($dailySavingsClosing) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $dailySavingsClosing->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_savings_id" label="Daily Savings" required>
            @php $selected = old('daily_savings_id', ($editing ? $dailySavingsClosing->daily_savings_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Savings</option>
            @foreach($allDailySavings as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="total_deposit"
            label="Total Deposit"
            value="{{ old('total_deposit', ($editing ? $dailySavingsClosing->total_deposit : '')) }}"
            placeholder="Total Deposit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="total_withdraw"
            label="Total Withdraw"
            value="{{ old('total_withdraw', ($editing ? $dailySavingsClosing->total_withdraw : '')) }}"
            placeholder="Total Withdraw"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="balance"
            label="Balance"
            value="{{ old('balance', ($editing ? $dailySavingsClosing->balance : '')) }}"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest"
            label="Interest"
            value="{{ old('interest', ($editing ? $dailySavingsClosing->interest : '')) }}"
            placeholder="Interest"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="closing_by" label="Closing By" required>
            @php $selected = old('closing_by', ($editing ? $dailySavingsClosing->closing_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($dailySavingsClosing->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="closing_fee"
            label="Closing Fee"
            value="{{ old('closing_fee', ($editing ? $dailySavingsClosing->closing_fee : '')) }}"
            placeholder="Closing Fee"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
