@php $editing = isset($adjustAmount) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="loan_id"
            label="Loan Id"
            value="{{ old('loan_id', ($editing ? $adjustAmount->loan_id : '')) }}"
            placeholder="Loan Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="daily_loan_id" label="Daily Loan" required>
            @php $selected = old('daily_loan_id', ($editing ? $adjustAmount->daily_loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Loan</option>
            @foreach($dailyLoans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="adjust_amount"
            label="Adjust Amount"
            value="{{ old('adjust_amount', ($editing ? $adjustAmount->adjust_amount : '')) }}"
            placeholder="Adjust Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="before_adjust"
            label="Before Adjust"
            value="{{ old('before_adjust', ($editing ? $adjustAmount->before_adjust : '')) }}"
            placeholder="Before Adjust"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="after_adjust"
            label="After Adjust"
            value="{{ old('after_adjust', ($editing ? $adjustAmount->after_adjust : '')) }}"
            placeholder="After Adjust"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($adjustAmount->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="added_by" label="Added By" required>
            @php $selected = old('added_by', ($editing ? $adjustAmount->added_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
