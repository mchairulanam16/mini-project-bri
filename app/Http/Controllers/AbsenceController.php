<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Code;
use App\Models\Kelas;
use App\Models\Absence;
use Illuminate\Http\Request;
use App\Exports\AbsenceExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $data = Absence::all();
        // $data = Absence::with('user')
        // ->with('code')
        // ->with('kelas')
        // ->with('subject')
        // ->get();

        return view('report', ['data' => $data]);
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
        $validator = $request->validate([
            'kelas_id' => 'required',
            'subject_id' => 'required',
            'code' => 'required',
            'teaching_role' => 'required'
        ]);

        $user = Auth::user()->id;
        $date = Carbon::now()->timezone('Asia/Bangkok');
        $today = $date->toDateString();
        $time = $date->toTimeString();
        $findcode = Code::where('name', $request->code)->first();
        $idcode = $findcode->id;
        $cekcode = $findcode->user_id;
        if($cekcode == $user || $cekcode = null) {
            return redirect()->back()->with('error', 'Tidak bisa gunakan kode sendiri.');
        }

        $findcode->update([
            'id_used_by' => $user
        ]);

        $data = Absence::create([
            'kelas_id' => $request->kelas,
            'subject_id' =>$request->subject,
            'user_id' => $user,
            'code_id' => $idcode,
            'teaching_role' => $request->role,
            'date' => $today,
            'start' => $time,
        ]);

        return redirect()->back()
        ->with('success', 'Berhasil Clock In');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $user = Auth::user()->id;

        $data = Absence::with(['user', 'code', 'kelas', 'subject'])
            ->where('user_id', $user)
            ->get();

        return view('history', ['data' => $data]);
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
    public function update()
    {
        $carbon = Carbon::now()->timezone('Asia/Bangkok');
        $today = $carbon->toDateString();
        $idLogin = Auth::user()->id;
        $isCheckin = Absence::where('user_id', $idLogin)->where('date', $today)->where('end', null)->first();

        $start = $isCheckin->start;
        $keluar = Carbon::now()->timezone('Asia/Bangkok')->toTimeString();
        $duration = $carbon->diffInMinutes($start);
        $isCheckin->end = $keluar;
        $isCheckin->duration = $duration;
        $isCheckin->save();

        return redirect()->back()
        ->with('success', 'Berhasil Clock Out');
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

    public function export(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('start_date');

        $startDateTime = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();

        return Excel::download(new AbsenceExport($startDateTime, $endDateTime), 'Report.xlsx');
    }
}
