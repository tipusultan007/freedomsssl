<?php

namespace App\Http\Controllers;

use App\Models\FdrPackage;
use Illuminate\Http\Request;
use App\Http\Requests\FdrPackageStoreRequest;
use App\Http\Requests\FdrPackageUpdateRequest;

class FdrPackageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', FdrPackage::class);

        $search = $request->get('search', '');

        $fdrPackages = FdrPackage::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.fdr_packages.index', compact('fdrPackages', 'search'));
    }

    public function allPackages(Request $request)
    {
        $totalData = FdrPackage::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
       // $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = FdrPackage::offset($start)
                ->limit($limit)
                ->orderBy('id','asc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  FdrPackage::where('name','LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('id','asc')
                ->get();

            $totalFiltered = FdrPackage::where('name','LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $edit =  route('fdr-packages.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['amount'] = $post->amount;
                $nestedData['one'] = $post->one;
                $nestedData['two'] = $post->two;
                $nestedData['three'] = $post->three;
                $nestedData['four'] = $post->four;
                $nestedData['five'] = $post->five;
                $nestedData['five_half'] = $post->five_half;
                $nestedData['six'] = $post->six;
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
        //$this->authorize('create', FdrPackage::class);

        return view('app.fdr_packages.create');
    }

    /**
     * @param \App\Http\Requests\FdrPackageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', FdrPackage::class);

        //$validated = $request->validated();

        $fdrPackage = FdrPackage::create($request->all());

      /*  return redirect()
            ->route('fdr-packages.edit', $fdrPackage)
            ->withSuccess(__('crud.common.created'));*/
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrPackage $fdrPackage)
    {
        //$this->authorize('view', $fdrPackage);

        return view('app.fdr_packages.show', compact('fdrPackage'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrPackage $fdrPackage)
    {
        //$this->authorize('update', $fdrPackage);

        //return view('app.fdr_packages.edit', compact('fdrPackage'));
    }

    /**
     * @param \App\Http\Requests\FdrPackageUpdateRequest $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,
        FdrPackage $fdrPackage
    ) {
        //$this->authorize('update', $fdrPackage);

        //$validated = $request->validated();

        $fdrPackage->update($request->all());

      /*  return redirect()
            ->route('fdr-packages.edit', $fdrPackage)
            ->withSuccess(__('crud.common.saved'));*/
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrPackage $fdrPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FdrPackage $fdrPackage)
    {
        //$this->authorize('delete', $fdrPackage);

        $fdrPackage->delete();

        return redirect()
            ->route('fdr-packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
