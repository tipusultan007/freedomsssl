<?php

namespace App\Http\Controllers;

use App\Models\DpsPackage;
use App\Models\DpsPackageValue;
use Illuminate\Http\Request;
use App\Http\Requests\DpsPackageStoreRequest;
use App\Http\Requests\DpsPackageUpdateRequest;
use Illuminate\Support\Facades\DB;

class DpsPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ////$this->authorize('view-any', DpsPackage::class);

        $search = $request->get('search', '');

        $dpsPackages = DpsPackage::orderBy('amount','asc')->get();

        return view('app.dps_packages.index', compact('dpsPackages', 'search'));
    }

    public function dataDpsPackages(Request $request)
    {
        $totalData = DpsPackage::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {
            $posts = DpsPackage::offset($start)
                ->limit($limit)
                ->orderBy('name','asc')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = DpsPackage::where('name','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('name','asc')
                ->get();

            $totalFiltered = DpsPackage::where('name','LIKE',"%{$search}%")->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('dps-packages.show',$post->id);
                $edit =  route('dps-packages.edit',$post->id);


                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['amount'] = $post->amount;
                $nestedData['data'] = json_encode($post->data);

                $data[] = $nestedData;
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
        ////$this->authorize('create', DpsPackage::class);

        return view('app.dps_packages.create');
    }

    /**
     * @param \App\Http\Requests\DpsPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////$this->authorize('create', DpsPackage::class);

        $data = $request->all();
        $years = $request->year;
        $principal_profits = $request->principal_profit;
        $dpsPackage = DpsPackage::create($data);
        foreach ($years as $key => $row)
        {
            $dpsPackageValue = new DpsPackageValue();
            $dpsPackageValue->dps_package_id = $dpsPackage->id;
            $dpsPackageValue->year = $row;
            $dpsPackageValue->amount = $principal_profits[$key];
            $dpsPackageValue->save();
        }

        return json_encode($dpsPackage);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsPackage $dpsPackage)
    {
        ////$this->authorize('view', $dpsPackage);

        return view('app.dps_packages.show', compact('dpsPackage'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsPackage $dpsPackage)
    {
        ////$this->authorize('update', $dpsPackage);

        return view('app.dps_packages.edit', compact('dpsPackage'));
    }

    /**
     * @param \App\Http\Requests\DpsPackageUpdateRequest $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsPackageUpdateRequest $request,
        DpsPackage $dpsPackage
    ) {
        ////$this->authorize('update', $dpsPackage);

        $validated = $request->validated();

        $dpsPackage->update($validated);

        return redirect()
            ->route('dps-packages.edit', $dpsPackage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsPackage $dpsPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DpsPackage $dpsPackage)
    {
        ////$this->authorize('delete', $dpsPackage);

        DpsPackageValue::where('dps_package_id',$dpsPackage->id)->delete();

        $dpsPackage->delete();

        return redirect()
            ->route('dps-packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
