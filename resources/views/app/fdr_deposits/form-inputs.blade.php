@php $editing = isset($fdrDeposit) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $fdrDeposit->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="fdr_id" label="Fdr" required>
            @php $selected = old('fdr_id', ($editing ? $fdrDeposit->fdr_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Fdr</option>
            @foreach($fdrs as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $fdrDeposit->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $fdrDeposit->amount : '')) }}"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="fdr_package_id" label="Fdr Package" required>
            @php $selected = old('fdr_package_id', ($editing ? $fdrDeposit->fdr_package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Fdr Package</option>
            @foreach($fdrPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($fdrDeposit->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="commencement"
            label="Commencement"
            value="{{ old('commencement', ($editing ? optional($fdrDeposit->commencement)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="balance"
            label="Balance"
            value="{{ old('balance', ($editing ? $fdrDeposit->balance : '')) }}"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="profit"
            label="Profit"
            value="{{ old('profit', ($editing ? $fdrDeposit->profit : '')) }}"
            placeholder="Profit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="created_by" label="Created By" required>
            @php $selected = old('created_by', ($editing ? $fdrDeposit->created_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="note"
            label="Note"
            value="{{ old('note', ($editing ? $fdrDeposit->note : '')) }}"
            placeholder="Note"
        ></x-inputs.text>
    </x-inputs.group>
</div>
