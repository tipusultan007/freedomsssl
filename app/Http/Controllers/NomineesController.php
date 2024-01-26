<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nominees;
use Illuminate\Http\Request;
use App\Http\Requests\NomineesStoreRequest;
use App\Http\Requests\NomineesUpdateRequest;

class NomineesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', Nominees::class);

        $search = $request->get('search', '');

        $allNominees = Nominees::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.all_nominees.index', compact('allNominees', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$this->authorize('create', Nominees::class);

        $users = User::pluck('name', 'id');

        return view('app.all_nominees.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\NomineesStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NomineesStoreRequest $request)
    {
        //$this->authorize('create', Nominees::class);

        $validated = $request->validated();

        $nominees = Nominees::create($validated);

        return redirect()
            ->route('all-nominees.edit', $nominees)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Nominees $nominees)
    {
        //$this->authorize('view', $nominees);

        return view('app.all_nominees.show', compact('nominees'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Nominees $nominees)
    {
        //$this->authorize('update', $nominees);

        $users = User::pluck('name', 'id');

        return view('app.all_nominees.edit', compact('nominees', 'users'));
    }

    /**
     * @param \App\Http\Requests\NomineesUpdateRequest $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function update(NomineesUpdateRequest $request, Nominees $nominees)
    {
        //$this->authorize('update', $nominees);

        $validated = $request->validated();

        $nominees->update($validated);

        return redirect()
            ->route('all-nominees.edit', $nominees)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nominees $nominees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Nominees $nominees)
    {
        //$this->authorize('delete', $nominees);

        $nominees->delete();

        return redirect()
            ->route('all-nominees.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
