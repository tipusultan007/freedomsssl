@php
$nomineeUsers = \App\Models\User::select('name','father_name','id')->get();
 @endphp
<div class="row g-1">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 mb-1">
                <select name="nominee_user_id[]" id="nominee_user_id1" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="name1">নাম</label>
                <input type="text" id="name1" class="form-control " name="name[]" placeholder="Name">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="phone1">মোবাইল নং</label>
                <input type="text" id="phone1" class="form-control  dt-salary" name="phone[]" placeholder="Phone">
            </div>
            <div class="col-md-12 mb-1">
                <label class="form-label" for="address1">ঠিকানা</label>
                <input type="text" class="form-control " id="address1" name="address[]" placeholder="Address">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="relation1">সম্পর্ক</label>
                <input type="text" id="relation1" class="form-control " name="relation[]" placeholder="Relation">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="pecentage1">অংশ</label>
                <input type="number" id="percentage1" class="form-control " name="percentage[]" value="100" placeholder="Percentage">
            </div>
            <div class="col-md-12 mb-1">
                <label class="form-label" for="image1">ছবি</label>
                <input type="file" id="image1" class="form-control" name="image[]">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 mb-1">
                <select name="nominee_user_id[]" id="nominee_user_id2" class="form-control select2" data-allow-clear="on" data-placeholder="সিলেক্ট করুণ">
                    <option value=""></option>
                    @foreach($nomineeUsers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->father_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="name2">নাম</label>
                <input type="text" id="name2" class="form-control " name="name[]" placeholder="Name">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="phone2">মোবাইল নং</label>
                <input type="text" id="phone2" class="form-control  dt-salary" name="phone[]" placeholder="Phone">
            </div>
            <div class="col-md-12 mb-1">
                <label class="form-label" for="address2">ঠিকানা</label>
                <input type="text" class="form-control " id="address2" name="address[]" placeholder="Address">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="relation2">সম্পর্ক</label>
                <input type="text" id="relation2" class="form-control " name="relation[]" placeholder="Relation">
            </div>
            <div class="col-md-6 mb-1">
                <label class="form-label" for="pecentage2">অংশ</label>
                <input type="number" id="percentage2" class="form-control " name="percentage[]" value="100" placeholder="Percentage">
            </div>
            <div class="col-md-12 mb-1">
                <label class="form-label" for="image2">ছবি</label>
                <input type="file" id="image2" class="form-control" name="image[]">
            </div>
        </div>
    </div>
</div>
