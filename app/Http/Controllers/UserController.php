<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Helpers\Helpers;
use App\Imports\UsersImport;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\Nominees;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    ////$this->authorize('view-any', User::class);
    $breadcrumbs = [
      ['name' => "List"]
    ];

//    $users = User::all();
//    foreach ($users as $user) {
//      $user->name = ucwords($user->name);
//      $user->father_name = ucwords($user->father_name);
//      $user->mother_name = ucwords($user->mother_name);
//      $user->spouse_name = ucwords($user->spouse_name);
//      $user->present_address = ucwords($user->present_address);
//      $user->permanent_address = ucwords($user->permanent_address);
//      $user->nationality = ucwords($user->nationality);
//      $user->save();
//    }

    return view('app.users.index', compact('breadcrumbs'));
  }

  public function userData(Request $request)
  {
    $columns = array(
      0 => 'name',
      1 => 'phone',
      2 => 'father_name',
      3 => 'present_address',
      4 => 'join_date',
      5 => 'status',
    );

    $totalData = User::count();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    // $order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::with('dailySavings','dpsSavings','specialDpsSavings','dailyLoans','dpsLoans','specialLoans','fdrs')
        ->offset($start)
        ->limit($limit)
        ->orderBy('name', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::with('dailySavings','dpsSavings','specialDpsSavings','dailyLoans','dpsLoans','specialLoans','fdrs')
        ->where('name', 'LIKE', "%{$search}%")
        ->orWhere('phone1', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy('name', 'asc')
        ->get();

      $totalFiltered = User::where('name', 'LIKE', "%{$search}%")
        ->orWhere('phone1', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = array();
    if (!empty($users)) {
      foreach ($users as $user) {
        $show = route('users.show', $user->id);
        $edit = route('users.edit', $user->id);

        $dailyLoans = $user->dailyLoans->sum('balance');
        $dpsLoans = $user->dpsLoans->sum('remain_loan');
        $specialLoans = $user->specialLoans->sum('remain_loan');
        $dailySavings = $user->dailySavings->sum('balance');
        $dpsSavings = $user->dpsSavings->sum('balance');
        $specialSavings = $user->specialDpsSavings->sum('balance');
        $fdrSavings = $user->fdrs->sum('balance');

        $total_loan = $dailyLoans + $dpsLoans + $specialLoans;
        $total_savings = $dailySavings + $dpsSavings + $specialSavings;
        $total_fdr = $fdrSavings;

        $nestedData['ac_details'] = '<div class="ac_details">';
        if ($total_savings>0){
          $nestedData['ac_details'] .= '<p><strong>সঞ্চয়ঃ </strong>'.$total_savings.'</p>';
        }
        if ($total_fdr>0){
          $nestedData['ac_details'] .= '<p><strong>স্থায়ী সঞ্চয়ঃ </strong>'.$total_fdr.'</p>';
        }
        if ($total_loan>0){
          $nestedData['ac_details'] .= '<p><strong>ঋনঃ </strong>'.$total_loan.'</p>';
        }
        if ($user->due>0){
          $nestedData['ac_details'] .= '<p><strong>বকেয়াঃ </strong>'.$user->due.'</p>';
        }
        $nestedData['ac_details'] .= '</div>';


        $nestedData['bio'] = '<div class="bio"><p><strong>নামঃ </strong>'.$user->name.'</p>';
        if ($user->father_name!=""){
          $nestedData['bio'] .= '<p><strong>পিতাঃ </strong>'.$user->father_name.'</p>';
        }
        if ($user->mother_name!=""){
          $nestedData['bio'] .= '<p><strong>মাতাঃ </strong>'.$user->mother_name.'</p>';
        }
        if ($user->phone1!=""){
          $nestedData['bio'] .= '<p><strong>মোবাইলঃ </strong>'.$user->phone1.'</p>';
        }
        $nestedData['bio'] .= '</div>';

        $nestedData['address'] = '<div class="address">';
        if ($user->present_address!=""){
          $nestedData['address'] .= '<p><strong>বর্তমান ঠিকানাঃ </strong>'.$user->present_address.'</p>';
        }
        if ($user->permanent_address!=""){
          $nestedData['address'] .= '<p><strong>স্থায়ী ঠিকানাঃ </strong>'.$user->permanent_address.'</p>';
        }
        $nestedData['address'] .= '</div>';

        $nestedData['id'] = $user->id;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['phone'] = $user->phone1 ?? 'n/a';
        $nestedData['father_name'] = $user->father_name;
        $nestedData['mother_name'] = $user->mother_name;
        $nestedData['image'] =  '<img width="110" height="120" src="'.asset('storage/images/profile/'.$user->image).'" class="user-list-image">';
        $nestedData['status'] = $user->status;
        $nestedData['join_date'] = date('d/m/Y',strtotime($user->join_date));
        $data[] = $nestedData;

      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }

  public function allUsers(Request $request)
  {
    $users = User::all();
    $data = array();
    if (!empty($users)) {
      foreach ($users as $user) {
        $show = route('users.show', $user->id);
        $edit = route('users.edit', $user->id);
        $nestedData['id'] = $user->id;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['phone'] = $user->phone;
        $nestedData['father_name'] = $user->father_name;
        $nestedData['present_address'] = $user->present_address;
        $nestedData['join_date'] = $user->join_date;
        $nestedData['status'] = $user->status;
        $data[] = $nestedData;

      }
    }
    $json_data = array(
      "data" => $data
    );
    echo json_encode($json_data);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    //  //$this->authorize('create', User::class);

    $roles = Role::get();

    $dailySaving = DailySavings::orderBy('account_no', 'desc')->first();
    $dpsSaving = Dps::orderBy('account_no', 'desc')->first();
    $specialSaving = SpecialDps::orderBy('account_no', 'desc')->first();
    $fdrSaving = Fdr::orderBy('account_no', 'desc')->first();

    $dailyAccount = Helpers::newAccountNo('daily', $dailySaving->account_no);
    $dpsAccount = Helpers::newAccountNo('monthly', $dpsSaving->account_no);
    $specialAccount = Helpers::newAccountNo('special', $specialSaving->account_no);
    $fdrAccount = Helpers::newAccountNo('fdr', $fdrSaving->account_no);

    $breadcrumbs = [
      ['link' => "/", 'name' => "Home"], ['link' => "users", 'name' => "Users"], ['name' => "New User"]
    ];

    return view('app.users.create', compact('roles', 'breadcrumbs', 'dailyAccount', 'dpsAccount', 'specialAccount', 'fdrAccount'));
  }

  /**
   * @param \App\Http\Requests\UserStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    ////$this->authorize('create', User::class);

    $lastId = User::latest()->first();
    $id = $lastId->id + 1;
    $data = $request->except(['national_id', 'birth_id', 'image']);
    $data['email'] = "user" . $id . "@freedomsssl.com";
    $data['password'] = Hash::make('freedomuser13579');
    $user = User::create($data);

    if ($request->hasFile('national_id')) {
      $image = $request->file('national_id');
      $new_name = "nid_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/nid', $new_name, 'public');
      $user->national_id = $new_name;
      $user->save();
    }

    if ($request->hasFile('birth_id')) {
      $image = $request->file('birth_id');
      $new_name = "birthid_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/birth_id', $new_name, 'public');
      $user->birth_id = $new_name;
      $user->save();
    }

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $new_name = "profile_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/profile', $new_name, 'public');
      $user->image = $new_name;
      $user->save();
    }

    $account_type = $request->account_type;
    switch ($account_type) {
      case 'daily_savings':
        $data['user_id'] = $user->id;
        $data['created_by'] = Auth::id();
        //$data['account_no'] = 'DS'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $dailySavings = DailySavings::create($data);
        $nominee = Nominees::create([
          'account_no' => $dailySavings->account_no,
          'name' => $request->nominee_name ?? '',
          'address' => $request->nominee_address ?? '',
          'phone' => $request->nominee_phone ?? '',
          'relation' => $request->nominee_relation ?? '',
          'percentage' => $request->nominee_percentage ?? '100',
          'birthdate' => $request->nominee_birthdate ?? NULL,
          'name1' => $request->nominee_name1 ?? '',
          'address1' => $request->nominee_address1 ?? '',
          'phone1' => $request->nominee_phone1 ?? '',
          'relation1' => $request->nominee_relation1 ?? '',
          'percentage1' => $request->nominee_percentage1 ?? '100',
          'birthdate1' => $request->nominee_birthdate1 ?? NULL
        ]);
        if ($request->filled('nominee_user_id')) {
          $nominee->user_id = $request->nominee_user_id;
          $nominee->save();
        }
        if ($request->filled('nominee_user_id1')) {
          $nominee->user_id1 = $request->nominee_user_id1;
          $nominee->save();
        }
        break;
      case 'dps':
        $data['user_id'] = $user->id;
        //$data['account_no'] = 'DPS'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $data['balance'] = 0;
        $data['created_by'] = Auth::id();
        $dps = Dps::create($data);
        $nominee = Nominees::create([
          'account_no' => $dps->account_no,
          'name' => $request->nominee_name ?? '',
          'address' => $request->nominee_address ?? '',
          'phone' => $request->nominee_phone ?? '',
          'relation' => $request->nominee_relation ?? '',
          'percentage' => $request->nominee_percentage ?? '100',
          'birthdate' => $request->nominee_birthdate ?? NULL,
          'name1' => $request->nominee_name1 ?? '',
          'address1' => $request->nominee_address1 ?? '',
          'phone1' => $request->nominee_phone1 ?? '',
          'relation1' => $request->nominee_relation1 ?? '',
          'percentage1' => $request->nominee_percentage1 ?? '100',
          'birthdate1' => $request->nominee_birthdate1 ?? NULL
        ]);
        if ($request->filled('nominee_user_id')) {
          $nominee->user_id = $request->nominee_user_id;
          $nominee->save();
        }
        if ($request->filled('nominee_user_id1')) {
          $nominee->user_id1 = $request->nominee_user_id1;
          $nominee->save();
        }
        break;
      case 'special_dps':
        $data['user_id'] = $user->id;
        //$data['account_no'] = 'ML'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $data['balance'] = $request->initial_amount;
        $data['created_by'] = Auth::id();
        $specialDps = SpecialDps::create($data);
        $nominee = Nominees::create([
          'account_no' => $specialDps->account_no,
          'name' => $request->nominee_name ?? '',
          'address' => $request->nominee_address ?? '',
          'phone' => $request->nominee_phone ?? '',
          'relation' => $request->nominee_relation ?? '',
          'percentage' => $request->nominee_percentage ?? '100',
          'birthdate' => $request->nominee_birthdate ?? NULL,
          'name1' => $request->nominee_name1 ?? '',
          'address1' => $request->nominee_address1 ?? '',
          'phone1' => $request->nominee_phone1 ?? '',
          'relation1' => $request->nominee_relation1 ?? '',
          'percentage1' => $request->nominee_percentage1 ?? '100',
          'birthdate1' => $request->nominee_birthdate1 ?? NULL
        ]);
        if ($request->filled('nominee_user_id')) {
          $nominee->user_id = $request->nominee_user_id;
          $nominee->save();
        }
        if ($request->filled('nominee_user_id1')) {
          $nominee->user_id1 = $request->nominee_user_id1;
          $nominee->save();
        }
        break;

      case 'fdr':
        $data['user_id'] = $user->id;
        $data['created_by'] = Auth::id();
        $data['amount'] = $request->fdr_amount;
        //$data['account_no'] = 'FDR'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $fdr = Fdr::create($data);
        $data['fdr_id'] = $fdr->id;
        $data['balance'] = $fdr->amount;
        $fdr->balance += $request->fdr_amount;
        $fdr->save();
        $deposit = FdrDeposit::create($data);
        $nominee = Nominees::create([
          'account_no' => $fdr->account_no,
          'name' => $request->nominee_name ?? '',
          'address' => $request->nominee_address ?? '',
          'phone' => $request->nominee_phone ?? '',
          'relation' => $request->nominee_relation ?? '',
          'percentage' => $request->nominee_percentage ?? '100',
          'birthdate' => $request->nominee_birthdate ?? NULL,
          'name1' => $request->nominee_name1 ?? '',
          'address1' => $request->nominee_address1 ?? '',
          'phone1' => $request->nominee_phone1 ?? '',
          'relation1' => $request->nominee_relation1 ?? '',
          'percentage1' => $request->nominee_percentage1 ?? '100',
          'birthdate1' => $request->nominee_birthdate1 ?? NULL
        ]);
        if ($request->filled('nominee_user_id')) {
          $nominee->user_id = $request->nominee_user_id;
          $nominee->save();
        }
        if ($request->filled('nominee_user_id1')) {
          $nominee->user_id1 = $request->nominee_user_id1;
          $nominee->save();
        }
        break;

      default:

    }
    $user->assignRole('user');
    return redirect()->back()->with('success', 'সঞ্চয় হিসাব সফলভাবে তৈরি করা হয়েছে।');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, User $user)
  {
    //  //$this->authorize('view', $user);

    $dailySavings = DailySavings::where('user_id', $user->id)->orderBy('opening_date', 'asc')->sum('total');
    $dpsSavings = Dps::where('user_id', $user->id)->orderBy('opening_date', 'asc')->sum('balance');
    $specialDpsSavings = SpecialDps::where('user_id', $user->id)->orderBy('opening_date', 'asc')->sum('balance');

    $dpsLoans = TakenLoan::where('user_id', $user->id)->sum('remain');
    $specialDpsLoans = SpecialLoanTaken::where('user_id', $user->id)->sum('remain');
    $dailyLoans = DailyLoan::where('user_id', $user->id)->sum('balance');

    $totalLoans = $dpsLoans + $specialDpsLoans + $dailyLoans;
    $totalSavings = $dailySavings + $dpsSavings + $specialDpsSavings;
    $breadcrumbs = [
      ['link' => "/users", 'name' => "Users"], ['name' => "View Details"]
    ];

    return view('app.users.show', compact('user', 'totalSavings', 'totalLoans', 'breadcrumbs'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, User $user)
  {
    // //$this->authorize('update', $user);

    $roles = Role::get();

    return view('app.users.edit', compact('user', 'roles'));
  }

  /**
   * @param \App\Http\Requests\UserUpdateRequest $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);
    // //$this->authorize('update', $user);
    $user->update($request->all());
    //$user->syncRoles($request->roles);

    // Handle 'national_id' update
    if ($request->hasFile('national_id')) {
      // Delete the previous file
      Storage::disk('public')->delete('images/nid/' . $user->national_id);

      $image = $request->file('national_id');
      $new_name = "nid_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/nid', $new_name, 'public');
      $user->national_id = $new_name;
      $user->save();
    }

// Handle 'birth_id' update
    if ($request->hasFile('birth_id')) {
      Storage::disk('public')->delete('images/birth_id/' . $user->birth_id);

      $image = $request->file('birth_id');
      $new_name = "birthid_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/birth_id', $new_name, 'public');
      $user->birth_id = $new_name;
      $user->save();
    }

// Handle 'image' update
    if ($request->hasFile('image')) {
      Storage::disk('public')->delete('images/profile/' . $user->image);

      $image = $request->file('image');
      $new_name = "profile_" . $user->id . "_" . time() . '.' . $image->getClientOriginalExtension();
      $image->storeAs('images/profile', $new_name, 'public');
      $user->image = $new_name;
      $user->save();
    }

    return redirect()
      ->route('users.edit', $user)
      ->withSuccess('সদস্য তথ্য আপডেট সফল হয়েছে।');
    //return redirect()->back();
    //return json_encode("Success");


    /*$validated = $request->validated();

    if (empty($validated['password'])) {
        unset($validated['password']);
    } else {
        $validated['password'] = Hash::make($validated['password']);
    }

    $user->update($validated);

    $user->syncRoles($request->roles);

    return redirect()
        ->route('users.edit', $user)
        ->withSuccess(__('crud.common.saved'));*/
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    /*//$this->authorize('delete', $user);

    $user->delete();

    return redirect()
        ->route('users.index')
        ->withSuccess(__('crud.common.removed'));*/

    User::find($id)->delete($id);

    return response()->json([

      'success' => 'Record deleted successfully!'

    ]);
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function export()
  {
    return Excel::download(new UsersExport, 'users.xlsx');
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function import()
  {
    Excel::import(new UsersImport, request()->file('file'));
    return back();
  }

  public function userInfo($id)
  {
    $user = User::with('dailySavings', 'dpsSavings', 'specialDpsSavings', 'dailyLoans', 'dpsLoans', 'specialLoans', 'fdrs')->find($id);

    $dps = Dps::where('user_id', $user->id)->where('status', 'active')->sum('balance');
    $daily_savings = $user->dailySavings->sum('total');
    $special_dps = $user->specialDpsSavings->where('status', 'active')->sum('balance');
    $daily_loans = $user->dailyLoans->where('status', 'active')->sum('balance');
    $fdrs = $user->fdrs->where('status', 'active')->sum('balance');
    $dps_loans = $user->dpsLoans->where('status', 'active')->sum('remain_loan');
    $special_dps_loans = $user->specialLoans->where('status', 'active')->sum('remain_loan');

    $data['user'] = $user;
    $data['dps'] = $dps . ' টাকা';
    $data['fdr'] = $fdrs . ' টাকা';
    $data['daily_savings'] = $daily_savings . ' টাকা';
    $data['special_dps'] = $special_dps . ' টাকা';
    $data['daily_loans'] = $daily_loans . ' টাকা';
    $data['dps_loans'] = $dps_loans . ' টাকা';
    $data['special_dps_loans'] = $special_dps_loans . ' টাকা';
    return json_encode($data);
  }

  public function userAccounts($id)
  {
    // $accounts = [];
    $data = array();
    $dailySavings = DailySavings::where('user_id', $id)->orderBy('opening_date', 'asc')->get();
    $dpsSavings = Dps::where('user_id', $id)->orderBy('opening_date', 'asc')->get();
    foreach ($dailySavings as $daily) {
      $accounts['id'] = $daily->id;
      $accounts['account_no'] = $daily->account_no;
      $accounts['type'] = 'Daily Savings';
      $accounts['opening_date'] = $daily->opening_date;
      $accounts['balance'] = $daily->total;
      $accounts['status'] = $daily->status;
      $data[] = $accounts;
    }
    foreach ($dpsSavings as $dps) {
      $accounts['id'] = $dps->id;
      $accounts['account_no'] = $dps->account_no;
      $accounts['type'] = 'DPS';
      $accounts['opening_date'] = $dps->opening_date;
      $accounts['balance'] = $dps->balance;
      $accounts['status'] = $dps->status;
      $data[] = $accounts;
    }

    $json_data = array(
      "data" => $data
    );

    echo json_encode($json_data);
  }

  public function userLoans($userId)
  {
    $data = array();
    $dpsLoans = TakenLoan::where('user_id', $userId)->orderBy('date', 'asc')->get();
    $specialLoans = SpecialLoanTaken::where('user_id', $userId)->orderBy('date', 'asc')->get();
    $dailyLoans = DailyLoan::where('user_id', $userId)->orderBy('opening_date', 'asc')->get();

    foreach ($dpsLoans as $dpsLoan) {
      $account['id'] = $dpsLoan->id;
      $account['type'] = "DPS Loan";
      $account['account_no'] = $dpsLoan->account_no;
      $account['loan_amount'] = $dpsLoan->loan_amount;
      $account['remain'] = $dpsLoan->remain;
      $account['before_loan'] = $dpsLoan->before_loan ?? '';
      $account['after_loan'] = $dpsLoan->after_loan ?? '';
      $account['interest1'] = $dpsLoan->interest1 ?? '';
      $account['interest2'] = $dpsLoan->interest2 ?? '';
      $account['upto_amount'] = $dpsLoan->upto_amount;
      $account['date'] = $dpsLoan->date;
      $account['commencement'] = $dpsLoan->commencement;
      $account['created_by'] = $dpsLoan->created_by;
      $account['approved_by'] = $dpsLoan->approved_by;
      $account['installment'] = $dpsLoan->installment;
      $account['note'] = $dpsLoan->note;
      $data[] = $account;

    }
    foreach ($specialLoans as $specialLoan) {
      $account['id'] = $specialLoan->id;
      $account['type'] = 'Special Loan';
      $account['account_no'] = $specialLoan->account_no;
      $account['loan_amount'] = $specialLoan->loan_amount;
      $account['remain'] = $specialLoan->remain;
      $account['before_loan'] = $specialLoan->before_loan;
      $account['after_loan'] = $specialLoan->after_loan;
      $account['interest1'] = $specialLoan->interest1;
      $account['interest2'] = $specialLoan->interest2;
      $account['upto_amount'] = $specialLoan->upto_amount;
      $account['date'] = $specialLoan->date;
      $account['commencement'] = $specialLoan->commencement;
      $account['created_by'] = $specialLoan->created_by;
      $account['approved_by'] = $specialLoan->approved_by;
      $account['installment'] = $specialLoan->installment;
      $account['note'] = $specialLoan->note;
      $data[] = $account;
    }

    foreach ($dailyLoans as $dailyLoan) {
      $account['id'] = $dailyLoan->id;
      $account['type'] = "Daily Loan";
      $account['account_no'] = $dailyLoan->account_no;
      $account['loan_amount'] = $dailyLoan->loan_amount . "<br><span class='text-success font-small-2'>+$dailyLoan->interest</span>";
      $account['remain'] = $dailyLoan->balance;
      $account['date'] = $dailyLoan->opening_date;
      $data[] = $account;
    }

    $json_data = array(
      "data" => $data
    );
    return json_encode($json_data);
  }

  public function userProfile($id)
  {
    $user = User::find($id);

    return json_encode($user);
  }
}
