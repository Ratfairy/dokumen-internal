<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Hasil Verifikasi PDF</title>

        <style>
            body{
                font-family:Arial,sans-serif;
                background:#f5f7fb;
                padding:40px;
            }

            .card{
                max-width:920px;
                margin:auto;
                background:white;
                border-radius:10px;
                padding:35px;
                box-shadow:0 5px 15px rgba(0,0,0,.08);
            }

            .result-actions{
                display:flex;
                align-items:center;
                gap:12px;
                flex-wrap:wrap;
                margin-top:25px;
            }

            .success{
                background:#e8f8ee;
                color:#0d6832;
                border:1px solid #a6e7bd;
                padding:20px;
                border-radius:8px;
                margin-bottom:25px;
            }

            .warning{
                background:#fff7e6;
                color:#ad6800;
                border:1px solid #ffd591;
                padding:20px;
                border-radius:8px;
                margin-bottom:25px;
            }

            .info{
                background:#e6f4ff;
                color:#0958d9;
                border:1px solid #91caff;
                padding:20px;
                border-radius:8px;
                margin-bottom:25px;
            }

            .danger{
                background:#fdecec;
                color:#a31212;
                border:1px solid #f5b5b5;
                padding:20px;
                border-radius:8px;
                margin-bottom:25px;
            }

            table{
                width:100%;
                border-collapse:collapse;
                margin-top:20px;
            }

            td{
                padding:10px;
                vertical-align:top;
                border-bottom:1px solid #eee;
            }

            td:first-child{
                width:220px;
                font-weight:bold;
            }

            .hash{
                word-break:break-all;
                font-family:monospace;
                background:#f4f4f4;
                padding:10px;
                border-radius:6px;
            }

            .button{
                display:inline-flex;
                align-items:center;
                justify-content:center;
                min-height:40px;
                padding:10px 16px;
                background:#2563eb;
                color:white;
                font-weight:700;
                line-height:1.2;
                text-decoration:none;
                border-radius:7px;
                box-shadow:0 1px 2px rgba(15,23,42,.08);
            }

            .button-secondary{
                background:#475467;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
    </head>

    <body>

    <div class="card">

        @if($status == 'published')

            <div class="success">
                <h2>Dokumen ASLI</h2>
                <p>File identik dengan dokumen yang telah diterbitkan oleh sistem.</p>
            </div>

        @elseif($status == 'revoked')

            <div class="warning">
                <h2>Dokumen Asli tetapi Sudah Dicabut</h2>
                <p>File ini memang berasal dari sistem, namun status dokumen sudah dicabut.</p>
            </div>

        @elseif($status == 'draft')

            <div class="info">
                <h2>Dokumen Ditemukan</h2>
                <p>File cocok dengan data di sistem, tetapi dokumen belum diterbitkan.</p>
            </div>

        @elseif($status == 'not_found')

            <div class="danger">
                <h2>Dokumen Tidak Valid</h2>
                <p>
                    Hash PDF tidak ditemukan di database.<br>
                    Kemungkinan file telah dimodifikasi atau bukan berasal dari sistem.
                </p>
            </div>

        @endif

        @if($document)

        <table>

            <tr>
                <td>Nomor Dokumen</td>
                <td>{{ $document->document_number }}</td>
            </tr>

            <tr>
                <td>Perihal</td>
                <td>{{ $document->subject }}</td>
            </tr>

            <tr>
                <td>Status</td>
                <td>{{ ucfirst($document->status) }}</td>
            </tr>

            <tr>
                <td>Hash SHA-256</td>
                <td>
                    <div class="hash">
                        {{ $hash }}
                    </div>
                </td>
            </tr>

        </table>

        @else

            <p><strong>Hash SHA-256 File Upload</strong></p>

            <div class="hash">
                {{ $hash }}
            </div>

        @endif

        <div class="result-actions">
            <a href="{{ route('verify.file.form') }}" class="button">
                Verifikasi Lagi
            </a>

            <a
                href="{{ route('documents.index') }}"
                class="button button-secondary"
            >
                Master Document
            </a>
        </div>

    </div>

    </body>
</html>
