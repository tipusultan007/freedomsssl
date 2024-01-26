<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\AdvanceAccount;
use App\Http\Controllers\Accounts\AdvanceAdjustAccount;
use App\Http\Controllers\Accounts\DpsAccount;
use App\Http\Controllers\Accounts\DueAccount;
use App\Http\Controllers\Accounts\DueReturnAccount;
use App\Models\CashIn;
use App\Models\Dps;
use App\Models\Due;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DpsCollection;
use App\Models\DpsInstallment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class DpsCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', DpsCollection::class);

        $search = $request->get('search', '');

        $dpsCollections = DpsCollection::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.dps_collections.index',
            compact('dpsCollections', 'search')
        );
    }

    public function dataDpsCollection(Request $request)
    {

      $totalData = DpsInstallment::where('account_no', $request->account);

      if (!empty($request->collector)) {
        $totalData->where('collector_id', $request->collector);
      }

      if (!empty($request->from) && !empty($request->to)) {
        $totalData->whereBetween('date', [$request->from, $request->to]);
      }

      $totalData = $totalData->count();

// Total Filtered Count (should be based on the specific account_no)
      $totalFiltered = $totalData;

// Pagination
      $limit = $request->input('length');
      $start = $request->input('start');

// If there is a search term
      if (!empty($request->input('search.value'))) {
        $search = $request->input('search.value');

        $posts = DpsInstallment::with('user', 'manager')
          ->where('account_no', $request->account)
          ->where(function($query) use ($search) {
            $query->where('dps_installments.account_no', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
              });
          })
          ->offset($start)
          ->limit($limit)
          ->orderBy('id', 'desc')
          ->get();

        // Update Total Filtered Count
        $totalFiltered = DpsInstallment::where('account_no', $request->account)
          ->where(function($query) use ($search) {
            $query->where('account_no', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
              });
          })
          ->count();
      }
      else {
        // If there is no search term, fetch paginated data without filtering
        $posts = DpsInstallment::with('user', 'manager')
          ->where('account_no', $request->account)
          ->offset($start)
          ->limit($limit)
          ->orderBy('id', 'desc')
          ->get();
      }

      $data = array();
      if (!empty($posts)) {
        foreach ($posts as $post) {
          $show = route('dps-installments.show', $post->id);
          $edit = route('dps-installments.edit', $post->id);

          $date = new Carbon($post->date);
          $nestedData['id'] = $post->id;
          $nestedData['dps_id'] = $post->dps_id;
          $nestedData['trx_id'] = $post->trx_id;
          $nestedData['interest'] = $post->interest;
          $nestedData['total'] = $post->total;
          $nestedData['dps_loan_id'] = $post->dps_loan_id;
          $nestedData['name'] = $post->user->name;
          $nestedData['account_no'] = $post->account_no;
          $nestedData['dps_amount'] = $post->dps_amount;
          $nestedData['loan_installment'] = $post->loan_installment;
          $nestedData['date'] = $date->format('d/m/Y');
          $nestedData['loan_late_fee'] = $post->loan_late_fee;
          $nestedData['loan_other_fee'] = $post->loan_other_fee;
          $nestedData['late_fee'] = $post->late_fee;
          $nestedData['other_fee'] = $post->other_fee;
          $nestedData['dps_balance'] = $post->dps_balance;
          $nestedData['loan_balance'] = $post->loan_balance;
          $nestedData['dps_note'] = $post->dps_note;
          $nestedData['loan_note'] = $post->loan_note;
          $nestedData['collector'] = $post->manager->name;
          $nestedData['collection_id'] = $post->dps_installment_id;

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
    public function create()
    {
        //$this->authorize('create', DpsCollection::class);

        $users = User::pluck('name', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $dpsInstallments = DpsInstallment::pluck('account_no', 'id');

        return view(
            'app.dps_collections.create',
            compact('users', 'allDps', 'users', 'dpsInstallments')
        );
    }

    /**
     * @param \App\Http\Requests\DpsCollectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $data['collector_id'] = Auth::user()->id;
      $data['trx_id'] = $data['trx_id'] = Str::uuid();
      $savings = Dps::where('account_no',$request->account_no)->first();
      $data['user_id'] = $savings->user_id;
      $data['dps_id'] = $savings->id;
      $installment = DpsInstallment::create($data);

      $data['trx_type'] = $request->deposited_via;
      $data['name'] = $installment->user->name;

      if ($installment->dps_amount > 0) {
        $dps = Dps::find($installment->dps_id);
        if ($installment->dps_installments == 1) {
          $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
          if ($dpsCollections > 0) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $date->addMonthsNoOverflow($dpsCollections);
            $dps->balance += $installment->dps_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'trx_id' => $installment->trx_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'dps_id' => $installment->dps_id,
              'dps_amount' => $installment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'collector_id' => $installment->collector_id,
              'dps_installment_id' => $installment->id,
            ]);
          } else {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps->balance += $installment->dps_amount;
            $dps->save();
            $dpsCollection = DpsCollection::create([
              'account_no' => $installment->account_no,
              'user_id' => $installment->user_id,
              'dps_id' => $installment->dps_id,
              'trx_id' => $installment->trx_id,
              'late_fee' => $installment->late_fee,
              'other_fee' => $installment->other_fee,
              'dps_amount' => $installment->dps_amount,
              'balance' => $dps->balance,
              'month' => $date->format('F'),
              'year' => $date->format('Y'),
              'date' => $installment->date,
              'collector_id' => $installment->collector_id,
              'dps_installment_id' => $installment->id,
            ]);
          }
        } else {
          for ($i = 1; $i <= $installment->dps_installments; $i++) {
            $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
            $dps = Dps::find($installment->dps_id);
            $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
            if ($dpsCollections == 0) {
              $dps->balance += $dps->package_amount;
              $dps->save();
              $dpsCollection = DpsCollection::create([
                'account_no' => $installment->account_no,
                'user_id' => $installment->user_id,
                'dps_id' => $installment->dps_id,
                'trx_id' => $installment->trx_id,
                'late_fee' => $installment->late_fee,
                'other_fee' => $installment->other_fee,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $installment->date,
                'collector_id' => $installment->collector_id,
                'dps_installment_id' => $installment->id,
              ]);
            } else {
              $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
              $date->addMonthsNoOverflow($dpsCollections);

              $dps->balance += $dps->package_amount;
              $dps->save();
              $dpsCollection = DpsCollection::create([
                'account_no' => $installment->account_no,
                'user_id' => $installment->user_id,
                'dps_id' => $installment->dps_id,
                'trx_id' => $installment->trx_id,
                'late_fee' => $installment->late_fee,
                'other_fee' => $installment->other_fee,
                'dps_amount' => $dps->package_amount,
                'balance' => $dps->balance,
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'date' => $installment->date,
                'collector_id' => $installment->collector_id,
                'dps_installment_id' => $installment->id,
              ]);

            }
          }
        }

        $installment->dps_balance = $dps->balance;
        $installment->save();

        DpsAccount::create($data);
      }

      if ($installment->advance > 0) {
        $user = User::find($installment->user_id);
        $user->wallet += $installment->advance;
        $user->save();
        AdvanceAccount::create($data);
      }
      if ($installment->advance_return > 0) {
        $user = User::find($installment->user_id);
        $user->wallet -= $installment->advance_return;
        $user->save();

        AdvanceAdjustAccount::create($data);
      }

      $installment->save();

      if ($installment->due > 0) {
        $due = Due::firstOrCreate(
          ['account_no' => $installment->account_no],
          ['user_id' => $installment->user_id],
        );
        $due->remain += $installment->due;
        $due->status = 'unpaid';
        $due->save();

        DueAccount::create($data);
      }
      if ($installment->due_return > 0) {
        $due = Due::where('account_no', $installment->account_no)->first();
        $due->remain -= $installment->due_return;
        if ($due->remain == 0) {
          $due->status = 'paid';
        } else {
          $due->status = 'unpaid';
        }
        $due->save();

        DueReturnAccount::create($data);
      }

      //$transactions = $this->accountTransaction($installment);

      $cashin = CashIn::create([
        'user_id' => $installment->user_id,
        'cashin_category_id' => 1,
        'account_no' => $installment->account_no,
        'dps_installment_id' => $installment->id,
        'amount' => $installment->total,
        'trx_id' => $installment->trx_id,
        'date' => $installment->date,
        'created_by' => $installment->collector_id
      ]);

      return response()->json([
        "message" => "successfully saved"
      ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsCollection $dpsCollection)
    {
        //$this->authorize('view', $dpsCollection);

        return view('app.dps_collections.show', compact('dpsCollection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsCollection $dpsCollection)
    {
        //$this->authorize('update', $dpsCollection);

        $users = User::pluck('name', 'id');
        $allDps = Dps::pluck('account_no', 'id');
        $dpsInstallments = DpsInstallment::pluck('account_no', 'id');

        return view(
            'app.dps_collections.edit',
            compact(
                'dpsCollection',
                'users',
                'allDps',
                'users',
                'dpsInstallments'
            )
        );
    }

    /**
     * @param \App\Http\Requests\DpsCollectionUpdateRequest $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsCollectionUpdateRequest $request,
        DpsCollection $dpsCollection
    ) {
        //$this->authorize('update', $dpsCollection);

        $validated = $request->validated();

        $dpsCollection->update($validated);

        return redirect()
            ->route('dps-collections.edit', $dpsCollection)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsCollection $dpsCollection)
    {
        //$this->authorize('delete', $dpsCollection);

        $dpsCollection->delete();

        return redirect()
            ->route('dps-collections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
