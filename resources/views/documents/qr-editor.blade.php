@extends('layouts.app')

@section('content')
<div class="container">
    <h2>QR Placement Editor</h2>

    <hr>

    <p>
        Dokumen:
        <strong>{{ $document->document_number }}</strong>
    </p>

    <p>
        Judul:
        <strong>{{ $document->subject }}</strong>
    </p>
</div>
@endsection