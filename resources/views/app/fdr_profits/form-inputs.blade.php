@php $editing = isset($fdrProfit) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="account_no"
            label="Account No"
            value="{{ old('account_no', ($editing ? $fdrProfit->account_no : '')) }}"
            placeholder="Account No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $fdrProfit->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="fdr_id" label="Fdr" required>
            @php $selected = old('fdr_id', ($editing ? $fdrProfit->fdr_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Fdr</option>
            @foreach($fdrs as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="profit"
            label="Profit"
            value="{{ old('profit', ($editing ? $fdrProfit->profit : '')) }}"
            placeholder="Profit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.number
            name="balance"
            label="Balance"
            value="{{ old('balance', ($editing ? $fdrProfit->balance : '')) }}"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($fdrProfit->date)->format('Y-m-d') : '')) }}"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="created_by" label="Created By" required>
            @php $selected = old('created_by', ($editing ? $fdrProfit->created_by : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.text
            name="trx_id"
            label="Trx Id"
            value="{{ old('trx_id', ($editing ? $fdrProfit->trx_id : '')) }}"
            placeholder="Trx Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-3">
        <x-inputs.select name="month" label="Month">
            @php $selected = old('month', ($editing ? $fdrProfit->month : '')) @endphp
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
            value="{{ old('year', ($editing ? $fdrProfit->year : '')) }}"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text
            name="note"
            label="Note"
            value="{{ old('note', ($editing ? $fdrProfit->note : '')) }}"
            placeholder="Note"
        ></x-inputs.text>
    </x-inputs.group>
</div>
