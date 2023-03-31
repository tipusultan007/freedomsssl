<?php

namespace App\Http\Controllers;

use App\Models\Dps;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DpsCollection;
use App\Models\DpsInstallment;
use App\Http\Requests\DpsCollectionStoreRequest;
use App\Http\Requests\DpsCollectionUpdateRequest;

class DpsCollectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsCollection::class);

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

    public function dataDpsCollection(Request $request,$account)
    {

        $totalData = DpsCollection::where('account_no', $account)->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = DpsCollection::join('users', 'users.id', '=', 'dps_collections.user_id')
                ->join('users as collector', 'collector.id', '=', 'dps_collections.collector_id')
                ->where('dps_collections.account_no', $account)
                ->select('dps_collections.*', 'users.name', 'collector.name as c_name')
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps_collections.id', 'desc')
                ->get();

        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                //$show = route('dps-collections.show', $post->id);
                //$edit = route('dps-collections.edit', $post->id);

                $date                           = new Carbon($post->date);
                $nestedData['id']               = $post->id;
                $nestedData['dps_id']           = $post->dps_id;
                $nestedData['trx_id']           = $post->trx_id;
                $nestedData['name']             = $post->name;
                $nestedData['account_no']       = $post->account_no;
                $nestedData['dps_amount']       = $post->dps_amount;
                $nestedData['date']             = $date->format('d/m/Y');
                $nestedData['late_fee']         = $post->late_fee;
                $nestedData['other_fee']        = $post->other_fee;
                $nestedData['advance']          = $post->advance;
                $nestedData['advance_return']   = $post->advance_return;
                $nestedData['dps_balance']      = $post->dps_balance;
                $nestedData['month']            = $post->month.'-'.$post->year;
                $nestedData['collector']        = $post->c_name;
                $nestedData['collection_id']    = $post->collection_id;
                $data[]                         = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DpsCollection::class);

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
    public function store(DpsCollectionStoreRequest $request)
    {
        $this->authorize('create', DpsCollection::class);

        $validated = $request->validated();

        $dpsCollection = DpsCollection::create($validated);

        return redirect()
            ->route('dps-collections.edit', $dpsCollection)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsCollection $dpsCollection)
    {
        $this->authorize('view', $dpsCollection);

        return view('app.dps_collections.show', compact('dpsCollection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsCollection $dpsCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsCollection $dpsCollection)
    {
        $this->authorize('update', $dpsCollection);

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
        $this->authorize('update', $dpsCollection);

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
        $this->authorize('delete', $dpsCollection);

        $dpsCollection->delete();

        return redirect()
            ->route('dps-collections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
