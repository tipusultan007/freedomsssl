@php $editing = isset($dpsPackageValue) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="dps_package_id" label="Dps Package">
            @php $selected = old('dps_package_id', ($editing ? $dpsPackageValue->dps_package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Dps Package</option>
            @foreach($dpsPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="year"
            label="Year"
            value="{{ old('year', ($editing ? $dpsPackageValue->year : '')) }}"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $dpsPackageValue->amount : '')) }}"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
