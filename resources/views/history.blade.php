@extends('layouts.master')

@section('content')
<div class="card-body">
<div class="table-responsive">
    <table class="table table-editable table-nowrap align-middle table-edits">
        <thead class="table-light">
            <tr>
                <th>id</th>
                <th>kelas</th>
                <th>materi</th>
                <th>asisten</th>
                <th>kode</th>
                <th>peran jaga</th>
                <th>tanggal</th>
                <th>mulai</th>
                <th>selesai</th>
                <th>durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->kelas->name }}</td>
                <td>{{ $item->subject->name }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->code->name }}</td>
                <td>{{ $item->teaching_role }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->mulai }}</td>
                <td>{{ $item->selesai }}</td>
                <td>{{ $item->durasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
