<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DailyLoanAccount;
use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Http\Controllers\Accounts\PaidProfitAccount;
use App\Http\Controllers\Accounts\SavingsAccount;
use App\Models\Account;
use App\Models\AddProfit;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DailySavingsClosing;
use App\Models\DailySavingsComplete;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\LoanDocuments;
use App\Models\Nominees;
use App\Models\SavingsCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DailySavings;
use Illuminate\Http\Request;
use App\Http\Requests\DailySavingsStoreRequest;
use App\Http\Requests\DailySavingsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DailySavingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', DailySavings::class);
//Working
        /*$savings = DailySavings::all();
        foreach ($savings as $saving)
        {
            $expNum = explode('-', $saving->account_no);
            $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
            $saving->account_no = 'DS'.$s;
            $saving->save();
        }*/

        /*$collections = SavingsCollection::orderBy('date', 'asc')->get();
        foreach ($collections as $collection) {
            $dailySavings = DailySavings::find($collection->daily_savings_id);
            if ($collection->type == 'deposit') {
                $dailySavings->deposit += $collection->saving_amount;
                $dailySavings->total += $collection->saving_amount;
                $dailySavings->save();

            } elseif ($collection->type == 'withdraw') {
                $dailySavings->withdraw += $collection->saving_amount;
                $dailySavings->total -= $collection->saving_amount;
                $dailySavings->save();

            }
            $collection->balance = $dailySavings->total;
            $collection->save();
        }*/

        /*SavingsCollection::chunk(2000, function ($collections) {
            foreach ($collections as $collection) {
                switch ($collection->type)
                {
                    case 'deposit':
                        $dailySavings = DailySavings::find($collection->daily_savings_id);
                        $dailySavings->deposit += $collection->saving_amount;
                        $dailySavings->total += $collection->saving_amount;
                        $dailySavings->save();
                        $collection->balance = $dailySavings->total;
                        $collection->save();
                        break;
                    case 'withdraw':
                        $dailySavings = DailySavings::find($collection->daily_savings_id);
                        $dailySavings->withdraw += $collection->saving_amount;
                        $dailySavings->total -= $collection->saving_amount;
                        $dailySavings->save();
                        $collection->balance = $dailySavings->total;
                        $collection->save();
                        break;
                    default:
                }
            }
        });*/
        $breadcrumbs = [
            ['name' => "List"]
        ];
        return view(
            'app.all_daily_savings.index', compact('breadcrumbs')
        );
    }

    public function dailySavingsData(Request $request)
    {
        $totalData = DailySavings::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = DailySavings::with('user')->offset($start)
                ->limit($limit)
                ->orderBy('account_no', 'asc')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DailySavings::with('user')
                ->where('account_no','LIKE', "%{$search}%")
                ->orWhereHas('user', function ($query) use($search){
                    $query->where('name','LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy('account_no', 'asc')
                ->get();

            $totalFiltered = DailySavings::with('user')
                ->where('account_no', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($query) use($search){
                    $query->where('name','LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('daily-savings.show', $post->id);
                $edit = route('daily-savings.edit', $post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->user->name;
                $nestedData['phone'] = $post->user->phone1;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['date'] = date('d/m/Y',strtotime($post->opening_date));
                $nestedData['withdraw'] = $post->withdraw;
                $nestedData['profit'] = $post->profit;
                $nestedData['total'] = $post->total;
                $nestedData['status'] = $post->status;
                $nestedData['image'] = $post->user->image;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', DailySavings::class);
        $users = User::select('name','father_name','id')->get();

        $members = User::pluck('name','id');

        $accounts = DailySavings::orderBy('account_no', 'desc')->first();
        if ($accounts) {
          $new_account = $this->manipulateString($accounts->account_no);
        }else{
          $new_account = "DS0001";
        }

        return view(
            'app.all_daily_savings.create',
            compact('users','members','new_account')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
    $data = $request->all();
    $data['manager_id'] = Auth::id();
    $dailySavings = DailySavings::create($data);

    // Upload and save nominee image
    if ($request->hasFile('image')) {
      $imageName = "nominee_" . $dailySavings->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    }

    if ($request->hasFile('image1')) {
      $imageName1 = "nominee_" . $dailySavings->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    }

    $nominee = Nominees::create($data);

    return redirect()->back()->with('success','দৈনিক সঞ্চয় হিসাব খোলা সম্পন্ন হয়েছে!');
  }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dailySavings = DailySavings::find($id);

        $breadcrumbs = [
            ['link' => "/daily-savings", 'name' => "Daily Savings"], ['link' => "javascript:void(0)", 'name' => "Details"], ['name' => $dailySavings->account_no]
        ];

        return view('app.all_daily_savings.show', compact('dailySavings', 'breadcrumbs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $dailySavings = DailySavings::find($id);
        $users = User::select('name','father_name', 'id')->get();
        $members = User::select('id','name')->get();

        return view(
            'app.all_daily_savings.edit',
            compact('dailySavings', 'users', 'members')
        );
    }

    /**
     * @param \App\Http\Requests\DailySavingsUpdateRequest $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $dailySavings = DailySavings::find($id);
        $dailySavings->update($data);

        //$nominee = Nominees::firstOrCreate(['account_no'=> $dailySavings->account_no]);
        $data['user_id'] = $request->filled('nominee_user_id')?$request->nominee_user_id:null;
        $data['user_id1'] = $request->filled('nominee_user_id1')?$request->nominee_user_id1:null;
        //$nominee->update($data);

      // Handle 'image' update
      if ($request->hasFile('image')) {
        // Delete the previous file
        Storage::disk('public')->delete('nominee_images/' . $dailySavings->nominee->image);

        $imageName = "nominee_" . $dailySavings->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/nominee_images', $imageName);
        $data['image'] = $imageName;
      } else {
        unset($data['image']);
      }

      // Handle 'image1' update
      if ($request->hasFile('image1')) {
        // Delete the previous file
        Storage::disk('public')->delete('nominee_images/' . $dailySavings->nominee->image1);

        $imageName1 = "nominee_" . $dailySavings->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
        $request->file('image1')->storeAs('public/nominee_images', $imageName1);
        $data['image1'] = $imageName1;
      } else {
        unset($data['image1']);
      }

      // Update or create nominee data
      $nominee = Nominees::updateOrCreate(['account_no' => $dailySavings->account_no], $data);


      return redirect()
            ->route('daily-savings.edit', $dailySavings->id)
            ->with('success','দৈনিক সঞ্চয় হিসাব আপডেট সম্পন্ন হয়েছে!');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DailySavings $dailySavings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // //$this->authorize('delete', $dailySavings);

        $dailySavings = DailySavings::find($id);
        $dailyCollection = DailyCollection::where('account_no', $dailySavings->account_no)->get();

        $loans = DailyLoan::where('account_no', $dailySavings->account_no)->get();
        foreach ($loans as $loan) {
            DailyLoanAccount::delete($loan->trx_id);
        }
        foreach ($dailyCollection as $item) {
            if ($item->saving_type == "deposit") {
                SavingsAccount::delete($item->trx_id);
            } elseif ($item->saving_type == "withdraw") {
                DailyWithdrawAccount::delete($item->trx_id);
            }

            DailyLoanAccount::delete($item->trx_id);
            PaidInterestAccount::delete($item->trx_id, 'daily');
            PaidProfitAccount::delete($item->trx_id, 'daily');

            if ($item->late_fee > 0) {
                LateFeeAccount::delete($item->trx_id);
            }
            if ($item->other_fee > 0) {
                LateFeeAccount::delete($item->trx_id);
            }
            if ($item->loan_late_fee > 0) {
                LateFeeAccount::delete($item->trx_id);
            }
            if ($item->loan_other_fee > 0) {
                LateFeeAccount::delete($item->trx_id);
            }
            DailyLoanPaymentAccount::delete($item->trx_id);
        }



        //DailyLoan::where('account_no',$dailySavings->account_no)->delete();
        Nominees::where('account_no', $dailySavings->account_no)->delete();
        LoanDocuments::where('account_no', $dailySavings->account_no)->delete();
        AddProfit::where('account_no', $dailySavings->account_no)->delete();
        SavingsCollection::where('account_no', $dailySavings->account_no)->delete();
        DailyLoanCollection::where('account_no', $dailySavings->account_no)->delete();
        DailySavingsClosing::where('account_no', $dailySavings->account_no)->delete();
        DailyCollection::where('account_no', $dailySavings->account_no)->delete();
        CashIn::where('account_no', $dailySavings->account_no)->delete();
        Cashout::where('account_no', $dailySavings->account_no)->delete();
        //Transaction::where('account_no',$dailySavings->account_no)->delete();
        $dailySavings->delete();
        return response()->json([
           'success' => "Successfully deleted!"
        ]);
    }

    public function savingsInfoByAccount($account)
    {
        $daily_savings = DailySavings::where('account_no', $account)->first();
        $user = User::find($daily_savings->user_id);
        $dps = Dps::where('user_id', $user->id)->count();
        $daily_savings = DailySavings::where('user_id', $user->id)->count();
        $special_dps = SpecialDps::where('user_id', $user->id)->count();
        $daily_loans = DailyLoan::where('user_id', $user->id)->count();
        $dps_loans = DpsLoan::where('user_id', $user->id)->count();
        $special_dps_loans = SpecialDpsLoan::where('user_id', $user->id)->count();

        $data['user'] = $user;
        $data['dps'] = $dps;
        $data['daily_savings'] = $daily_savings;
        $data['special_dps'] = $special_dps;
        $data['daily_loans'] = $daily_loans;
        $data['dps_loans'] = $dps_loans;
        $data['special_dps_loans'] = $special_dps_loans;
        return json_encode($data);
    }

    public function isSavingsExist($ac)
    {
        $savings = DailySavings::where('account_no', $ac)->count();

        if ($savings > 0) {
            return "yes";
        } else {
            return "no";
        }
    }

    public function reset($id)
    {
        $savings = DailySavings::find($id);
        //Transaction::where('account_no',$savings->account_no)->delete();
        $dailyCollection = DailyCollection::where('account_no', $savings->account_no)->get();
        foreach ($dailyCollection as $item) {
            if ($item->saving_type == "deposit") {
               // SavingsAccount::delete($item->trx_id);
            } elseif ($item->saving_type == "withdraw") {
                //DailyWithdrawAccount::delete($item->trx_id);
            }

            //PaidProfitAccount::delete($item->trx_id, 'daily');

            if ($item->late_fee > 0) {
                //LateFeeAccount::delete($item->trx_id);
            }
            if ($item->other_fee > 0) {
                //LateFeeAccount::delete($item->trx_id);
            }
        }

        $savings->deposit = 0;
        $savings->withdraw = 0;
        $savings->profit = 0;
        $savings->total = 0;
        $savings->save();

    }

    public function manipulateString($inputString)
    {
        // Extract the numeric part from the input string
        preg_match('/\d+/', $inputString, $matches);

        if (!empty($matches)) {
            // Increment the numeric part by 1
            $numericPart = intval($matches[0]) + 1;

            // Create the new string with incremented numeric part
            $newString = 'DS' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);

            return $newString;
        }

        return $inputString; // Return the input string if no numeric part found
    }

    public function activeSavings($id)
    {
      $dailySavings = DailySavings::find($id);
      $completes = DailySavingsComplete::where('daily_savings_id',$id)->get();
      foreach ($completes as $savingsComplete)
      {
        $dailySavings->withdraw -= $savingsComplete->withdraw;
        $dailySavings->profit += $savingsComplete->profit;
        $dailySavings->total += $savingsComplete->withdraw + $savingsComplete->profit;
        $dailySavings->save();

        if ($savingsComplete->daily_loan_id != "")
        {
          $loan = DailyLoan::find($savingsComplete->daily_loan_id);
          $loan->balance += $savingsComplete->loan_payment;
          $loan->grace -= $savingsComplete->grace;
          $loan->status= 'active';
          $loan->save();
        }
        $savingsComplete->delete();
      }
      $dailySavings->status = 'active';
      $dailySavings->save();

      return redirect()->back()->with('success','সঞ্চয় হিসাব চালু করা হয়েছে!');
    }
}
