@php $editing = isset($dailyLoanPackage) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="months"
            label="Months"
            value="{{ old('months', ($editing ? $dailyLoanPackage->months : '')) }}"
            placeholder="Months"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="interest"
            label="Interest"
            value="{{ old('interest', ($editing ? $dailyLoanPackage->interest : '')) }}"
            placeholder="Interest"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
