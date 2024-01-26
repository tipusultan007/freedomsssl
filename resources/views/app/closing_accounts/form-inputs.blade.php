@php $editing = isset($closingAccount) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $closingAccount->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $closingAccount->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="type"
            label="Type"
            value="{{ old('type', ($editing ? $closingAccount->type : '')) }}"
            placeholder="Type"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="deposit"
            label="Deposit"
            value="{{ old('deposit', ($editing ? $closingAccount->deposit : '')) }}"
            placeholder="Deposit"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="Withdraw"
            label="Withdraw"
            value="{{ old('Withdraw', ($editing ? $closingAccount->Withdraw : '')) }}"
            placeholder="Withdraw"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="remain"
            label="Remain"
            value="{{ old('remain', ($editing ? $closingAccount->remain : '')) }}"
            placeholder="Remain"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="profit"
            label="Profit"
            value="{{ old('profit', ($editing ? $closingAccount->profit : '')) }}"
            placeholder="Profit"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="service_charge"
            label="Service Charge"
            value="{{ old('service_charge', ($editing ? $closingAccount->service_charge : '')) }}"
            placeholder="Service Charge"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="total"
            label="Total"
            value="{{ old('total', ($editing ? $closingAccount->total : '')) }}"
            placeholder="Total"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($closingAccount->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="created_by" label="Created By" required>
            @php $selected = old('created_by', ($editing ? $closingAccount->created_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_savings_id" label="Daily Savings">
            @php $selected = old('daily_savings_id', ($editing ? $closingAccount->daily_savings_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Savings</option>
            @foreach($allDailySavings as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_id" label="Dps">
            @php $selected = old('dps_id', ($editing ? $closingAccount->dps_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps</option>
            @foreach($allDps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="special_dps_id" label="Special Dps">
            @php $selected = old('special_dps_id', ($editing ? $closingAccount->special_dps_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Special Dps</option>
            @foreach($allSpecialDps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="fdr_id" label="Fdr">
            @php $selected = old('fdr_id', ($editing ? $closingAccount->fdr_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Fdr</option>
            @foreach($fdrs as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
