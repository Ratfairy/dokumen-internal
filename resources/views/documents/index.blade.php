<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Dokumen</title>

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
            max-width: 1300px;
            margin: 0 auto;
            padding: 28px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .description {
            margin-top: 0;
            margin-bottom: 24px;
            color: #6b7280;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .navigation-left {
            display: flex;
            gap: 10px;
        }

        .button-primary {
            background-color: #2563eb;
            color: #ffffff;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .button-secondary {
            background-color: #6b7280;
            color: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #d1d5db;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
        }

        .text-center {
            text-align: center;
        }

        .empty-data {
            padding: 35px;
            color: #6b7280;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-draft {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-published {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-revoked {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .alert-success {
            margin-bottom: 20px;
            padding: 14px;
            border: 1px solid #bbf7d0;
            border-radius: 5px;
            background-color: #f0fdf4;
            color: #166534;
        }
        .button-detail {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 4px;
            background-color: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
</head>

<body>
    <div class="container">
        <h1>Daftar Dokumen</h1>

        <p class="description">
            Daftar PDF yang diunggah dan diproses untuk mendapatkan QR Code verifikasi.
        </p>

        <div class="navigation">
            <div class="navigation-left">
                <a
                    href="{{ route('signers.index') }}"
                    class="button button-secondary"
                >
                    Master Penandatangan
                </a>

                <a
                    href="{{ route('verify.file.form') }}"
                    class="button button-verification"
                >
                    Verifikasi Dokumen
                </a>
                
            </div>

            <a
                href="{{ route('documents.create') }}"
                class="button button-primary"
            >
                + Upload Dokumen
            </a>
        </div>
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">No.</th>
                    <th>Nomor Dokumen</th>
                    <th>Perihal</th>
                    <th style="width: 130px;">Tanggal</th>
                    <th>Penandatangan</th>
                    <th style="width: 130px;">Status</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($documents as $document)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $document->document_number }}
                        </td>

                        <td>
                            {{ $document->subject }}
                        </td>

                        <td>
                            {{ $document->document_date->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $document->signer->name }}
                        </td>

                       <td class="text-center">
                            @if ($document->status === 'PUBLISHED')
                                <span class="status status-published">
                                    Terbit
                                </span>
                            @elseif ($document->status === 'REVOKED')
                                <span class="status status-revoked">
                                    Dicabut
                                </span>
                            @else
                                <span class="status status-draft">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a
                                href="{{ route('documents.show', $document) }}"
                                class="button-detail"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center empty-data">
                            Belum ada dokumen yang diunggah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
