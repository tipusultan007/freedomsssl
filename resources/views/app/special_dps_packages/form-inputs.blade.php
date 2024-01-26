@php $editing = isset($specialDpsPackage) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $specialDpsPackage->name : '')) }}"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $specialDpsPackage->amount : '')) }}"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
