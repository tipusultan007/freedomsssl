<?php

namespace App\Http\Controllers;

use App\Models\SpecialDpsCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpecialDpsCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function dataDpsCollection(Request $request,$account)
    {

        $totalData = SpecialDpsCollection::where('account_no', $account)->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = SpecialDpsCollection::with('user','manager')
                ->offset($start)
                ->limit($limit)
                ->orderBy('date', 'desc')
                ->get();

        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $date                           = new Carbon($post->date);
                $nestedData['id']               = $post->id;
                $nestedData['dps_id']           = $post->special_dps_id;
                $nestedData['name']             = $post->user->name;
                $nestedData['account_no']       = $post->account_no;
                $nestedData['dps_amount']       = $post->dps_amount;
                $nestedData['date']             = $date->format('d/m/Y');
                $nestedData['late_fee']         = $post->late_fee;
                $nestedData['other_fee']        = $post->other_fee;
                $nestedData['advance']          = $post->advance;
                $nestedData['advance_return']   = $post->advance_return;
                $nestedData['dps_balance']      = $post->dps_balance;
                $nestedData['month']            = $post->month.'-'.$post->year;
                $nestedData['collector']        = $post->manager->name;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
