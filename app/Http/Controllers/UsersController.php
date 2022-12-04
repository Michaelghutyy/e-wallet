<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $query = User::all();
            return DataTables::of($query)
            ->addColumn('action', function($item) {
                return '
                        <a class="btn btn-inverse-info btn-rounded" href="' . route('users.edit', $item->id) . '">
                                <i class="mdi mdi-pencil"></i> Ubah
                        </a>
                        <button class="btn btn-inverse-danger btn-rounded delete-data" data-id="' . $item->id . '">
                                <i class="mdi mdi-cup"></i> Hapus
                        </button>
                        ';
            })
			->editColumn('created_at', function($item) {
				return '
					' . Carbon::parse($item->created_at)->format('d M Y') . '
				';
			})
            ->rawColumns(['action', 'created_at'])
            ->addIndexColumn()
            ->make();
        }
        return view('pages.users.index');
    }

   	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('pages.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		$all = $request->all();
		$all['password'] = Hash::make($request->password);

		User::create($all);
		return redirect()->route('users.index')->with('message', 'Data Berhasil Ditambahkan');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\User  $User
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $User)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\User  $User
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return view('pages.users.edit', [
			'data' => User::findOrFail($id),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\User  $User
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, UserRequest $request)
	{
		
		$all = $request->all();
		$all['password'] = Hash::make($request->password);
		User::findOrFail($id)->update($all);
		return redirect()->route('users.index')->with('message', 'Data Berhasil Diperbarui');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\User  $User
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$data = User::findOrFail($id)->delete();
		return response()->json($data);
	}
}
