@php $editing = isset($dailyLoan) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $dailyLoan->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="package_id" label="Daily Loan Package" required>
            @php $selected = old('package_id', ($editing ? $dailyLoan->package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Daily Loan Package</option>
            @foreach($dailyLoanPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="per_installment"
            label="Per Installment"
            value="{{ old('per_installment', ($editing ? $dailyLoan->per_installment : '11')) }}"
            placeholder="Per Installment"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="opening_date"
            label="Opening Date"
            value="{{ old('opening_date', ($editing ? optional($dailyLoan->opening_date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest"
            label="Interest"
            value="{{ old('interest', ($editing ? $dailyLoan->interest : '')) }}"
            placeholder="Interest"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="adjusted_amount"
            label="Adjusted Amount"
            value="{{ old('adjusted_amount', ($editing ? $dailyLoan->adjusted_amount : '')) }}"
            placeholder="Adjusted Amount"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="commencement"
            label="Commencement"
            value="{{ old('commencement', ($editing ? optional($dailyLoan->commencement)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_amount"
            label="Loan Amount"
            value="{{ old('loan_amount', ($editing ? $dailyLoan->loan_amount : '')) }}"
            placeholder="Loan Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="application_date"
            label="Application Date"
            value="{{ old('application_date', ($editing ? optional($dailyLoan->application_date)->format('Y-m-d') : '')) }}"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="created_by" label="Created By" required>
            @php $selected = old('created_by', ($editing ? $dailyLoan->created_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="approved_by" label="Approved By" required>
            @php $selected = old('approved_by', ($editing ? $dailyLoan->approved_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $dailyLoan->status : '')) }}"
            placeholder="Status"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
