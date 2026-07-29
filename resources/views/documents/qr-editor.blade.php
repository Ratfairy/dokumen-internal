<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>QR Placement Editor</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f8;
            color: #1f2937;
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
            padding: 28px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .description {
            margin-top: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .details {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 12px 18px;
            margin: 24px 0;
        }

        .label {
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 5px;
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
</head>

<body>
    <div class="container">
        <h1>QR Placement Editor</h1>

        <p class="description">
            Editor QR utama tersedia di halaman detail dokumen.
        </p>

        <div class="details">
            <div class="label">Nomor Dokumen</div>
            <div>{{ $document->document_number }}</div>

            <div class="label">Perihal</div>
            <div>{{ $document->subject }}</div>
        </div>

        <a
            href="{{ route('documents.show', $document) }}"
            class="button"
        >
            Buka Detail Dokumen
        </a>
    </div>
</body>
</html>
