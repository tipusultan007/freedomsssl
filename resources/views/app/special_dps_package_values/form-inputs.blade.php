@php $editing = isset($specialDpsPackageValue) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select
            name="special_dps_package_id"
            label="Special Dps Package"
            required
        >
            @php $selected = old('special_dps_package_id', ($editing ? $specialDpsPackageValue->special_dps_package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Special Dps Package</option>
            @foreach($specialDpsPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="year"
            label="Year"
            value="{{ old('year', ($editing ? $specialDpsPackageValue->year : '')) }}"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $specialDpsPackageValue->amount : '')) }}"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
