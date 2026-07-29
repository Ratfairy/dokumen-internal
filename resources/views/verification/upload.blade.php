<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Verifikasi Keaslian PDF</title>

        <style>
            body{
                font-family: Arial, sans-serif;
                background:#f5f7fb;
                margin:40px;
            }

            .card{
                max-width:700px;
                margin:auto;
                background:white;
                border-radius:10px;
                padding:30px;
                box-shadow:0 4px 12px rgba(0,0,0,.08);
            }

            h1{
                margin-top:0;
                color:#12345b;
            }

            .form-group{
                margin-top:20px;
            }

            input[type=file]{
                width:100%;
                padding:10px;
            }

            button{
                margin-top:20px;
                background:#2563eb;
                color:white;
                border:none;
                padding:12px 25px;
                border-radius:6px;
                cursor:pointer;
            }

            button:hover{
                background:#1d4ed8;
            }

            .error{
                margin-top:15px;
                color:#b91c1c;
                background:#fef2f2;
                border:1px solid #fecaca;
                border-radius:6px;
                padding:12px;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">

    </head>

    <body>

    <div class="card">

        <h1>Verifikasi Keaslian PDF</h1>

        <p>
            Upload file PDF untuk memverifikasi apakah dokumen berasal dari sistem
            dan belum pernah dimodifikasi.
        </p>

        <div class="actions">
            <a
                href="{{ route('documents.index') }}"
                class="button button-secondary"
            >
                Kembali ke Daftar Dokumen
            </a>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            action="{{ route('verify.file') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <input
                    type="file"
                    name="pdf"
                    accept=".pdf"
                    required>
            </div>

            <button type="submit">
                Verifikasi PDF
            </button>

        </form>

    </div>

    </body>
</html>
