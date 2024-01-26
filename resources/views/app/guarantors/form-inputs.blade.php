@php $editing = isset($guarantor) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User">
            @php $selected = old('user_id', ($editing ? $guarantor->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $guarantor->name : '')) }}"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="address"
            label="Address"
            value="{{ old('address', ($editing ? $guarantor->address : '')) }}"
            placeholder="Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="exist_ac_no"
            label="Exist Ac No"
            value="{{ old('exist_ac_no', ($editing ? $guarantor->exist_ac_no : '')) }}"
            placeholder="Exist Ac No"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_loan_id" label="Daily Loan" required>
            @php $selected = old('daily_loan_id', ($editing ? $guarantor->daily_loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Loan</option>
            @foreach($dailyLoans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
