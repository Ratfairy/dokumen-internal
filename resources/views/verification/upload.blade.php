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
                max-width:920px;
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

            .page-header{
                display:flex;
                align-items:flex-start;
                justify-content:space-between;
                gap:24px;
                margin-bottom:24px;
            }

            .page-header h1{
                margin-bottom:10px;
            }

            .page-header p{
                max-width:620px;
                margin:0;
                color:#475467;
                line-height:1.55;
            }

            .button{
                display:inline-flex;
                align-items:center;
                justify-content:center;
                min-height:40px;
                padding:10px 16px;
                border:0;
                border-radius:7px;
                color:#ffffff;
                font-weight:700;
                line-height:1.2;
                text-align:center;
                text-decoration:none;
                white-space:nowrap;
                box-shadow:0 1px 2px rgba(15,23,42,.08);
            }

            .button-secondary{
                background:#475467;
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

            @media (max-width:700px){
                .page-header{
                    flex-direction:column;
                }

                .page-header .button{
                    width:100%;
                }
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">

    </head>

    <body>

    <div class="card">

        <div class="page-header">
            <div>
                <h1>Verifikasi Keaslian PDF</h1>

                <p>
                    Upload file PDF untuk memverifikasi apakah dokumen berasal dari sistem
                    dan belum pernah dimodifikasi.
                </p>
            </div>

            <a
                href="{{ route('documents.index') }}"
                class="button button-secondary"
            >
                Master Document
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
