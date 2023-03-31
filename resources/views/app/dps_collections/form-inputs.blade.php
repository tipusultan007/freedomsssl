@php $editing = isset($dpsCollection) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $dpsCollection->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $dpsCollection->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_id" label="Dps" required>
            @php $selected = old('dps_id', ($editing ? $dpsCollection->dps_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps</option>
            @foreach($allDps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="dps_amount"
            label="Dps Amount"
            value="{{ old('dps_amount', ($editing ? $dpsCollection->dps_amount : '')) }}"
            placeholder="Dps Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="balance"
            label="Balance"
            value="{{ old('balance', ($editing ? $dpsCollection->balance : '')) }}"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="receipt_no"
            label="Receipt No"
            value="{{ old('receipt_no', ($editing ? $dpsCollection->receipt_no : '')) }}"
            placeholder="Receipt No"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="late_fee"
            label="Late Fee"
            value="{{ old('late_fee', ($editing ? $dpsCollection->late_fee : '')) }}"
            placeholder="Late Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="other_fee"
            label="Other Fee"
            value="{{ old('other_fee', ($editing ? $dpsCollection->other_fee : '')) }}"
            placeholder="Other Fee"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="advance"
            label="Advance"
            value="{{ old('advance', ($editing ? $dpsCollection->advance : '')) }}"
            placeholder="Advance"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="month" label="Month">
            @php $selected = old('month', ($editing ? $dpsCollection->month : '')) @endphp
            <option value="January" {{ $selected == 'January' ? 'selected' : '' }} >January</option>
            <option value="February" {{ $selected == 'February' ? 'selected' : '' }} >February</option>
            <option value="March" {{ $selected == 'March' ? 'selected' : '' }} >March</option>
            <option value="April" {{ $selected == 'April' ? 'selected' : '' }} >April</option>
            <option value="May" {{ $selected == 'May' ? 'selected' : '' }} >May</option>
            <option value="June" {{ $selected == 'June' ? 'selected' : '' }} >June</option>
            <option value="July" {{ $selected == 'July' ? 'selected' : '' }} >July</option>
            <option value="August" {{ $selected == 'August' ? 'selected' : '' }} >August</option>
            <option value="September" {{ $selected == 'September' ? 'selected' : '' }} >September</option>
            <option value="October" {{ $selected == 'October' ? 'selected' : '' }} >October</option>
            <option value="November" {{ $selected == 'November' ? 'selected' : '' }} >November</option>
            <option value="December" {{ $selected == 'December' ? 'selected' : '' }} >December</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="year"
            label="Year"
            value="{{ old('year', ($editing ? $dpsCollection->year : '')) }}"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="trx_id"
            label="Trx Id"
            value="{{ old('trx_id', ($editing ? $dpsCollection->trx_id : '')) }}"
            placeholder="Trx Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($dpsCollection->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="collector_id" label="Collector" required>
            @php $selected = old('collector_id', ($editing ? $dpsCollection->collector_id : '')) @endphp
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
            @php $selected = old('dps_installment_id', ($editing ? $dpsCollection->dps_installment_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps Installment</option>
            @foreach($dpsInstallments as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
