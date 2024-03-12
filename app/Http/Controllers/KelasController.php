<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Kelas::all();

        return view('class', ['data' => $data]);
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

        $name = $request->input('name');
        $department = $request->input('department');
        $faculty = $request->input('faculty');
        $level = $request->input('level');

        $data = Kelas::create([
            'name' => $name,
            'department' => $department,
            'faculty' => $faculty,
            'level' => $level
        ]);

        return redirect()->route('class')
                ->with('success', 'Kelas berhasil ditambahkan.');
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
        $Kelas = Kelas::findOrFail($id);

        return view('home', $Kelas);
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
        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'department' => $request->input('department'),
            'faculty' => $request->input('faculty'),
            'level' => $request->input('level'),
            'name' => $request->input('name')
        ]);

        Session::flash('success', 'kelas berhasil diperbarui.');
        return redirect()->route('kelas.index')
            ->with('success', 'kelas berhasil diperbarui.');
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
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();
    }
}
