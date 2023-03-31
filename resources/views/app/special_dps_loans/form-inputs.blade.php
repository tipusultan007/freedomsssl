@php $editing = isset($specialDpsLoan) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $specialDpsLoan->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $specialDpsLoan->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="loan_amount"
            label="Loan Amount"
            value="{{ old('loan_amount', ($editing ? $specialDpsLoan->loan_amount : '')) }}"
            max="255"
            placeholder="Loan Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest1"
            label="Interest1"
            value="{{ old('interest1', ($editing ? $specialDpsLoan->interest1 : '')) }}"
            placeholder="Interest1"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest2"
            label="Interest2"
            value="{{ old('interest2', ($editing ? $specialDpsLoan->interest2 : '')) }}"
            placeholder="Interest2"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="upto_amount"
            label="Upto Amount"
            value="{{ old('upto_amount', ($editing ? $specialDpsLoan->upto_amount : '')) }}"
            max="255"
            placeholder="Upto Amount"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="application_date"
            label="Application Date"
            value="{{ old('application_date', ($editing ? optional($specialDpsLoan->application_date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="approved_by" label="Approved By" required>
            @php $selected = old('approved_by', ($editing ? $specialDpsLoan->approved_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="opening_date"
            label="Opening Date"
            value="{{ old('opening_date', ($editing ? optional($specialDpsLoan->opening_date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="commencement"
            label="Commencement"
            value="{{ old('commencement', ($editing ? optional($specialDpsLoan->commencement)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $specialDpsLoan->status : '')) }}"
            placeholder="Status"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="created_by" label="Created By" required>
            @php $selected = old('created_by', ($editing ? $specialDpsLoan->created_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="total_paid"
            label="Total Paid"
            value="{{ old('total_paid', ($editing ? $specialDpsLoan->total_paid : '0')) }}"
            placeholder="Total Paid"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="remain_loan"
            label="Remain Loan"
            value="{{ old('remain_loan', ($editing ? $specialDpsLoan->remain_loan : '')) }}"
            placeholder="Remain Loan"
        ></x-inputs.number>
    </x-inputs.group>
</div>
