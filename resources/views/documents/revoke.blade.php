<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cabut Dokumen</title>

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
            max-width: 750px;
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
            margin-bottom: 24px;
            color: #6b7280;
            line-height: 1.6;
        }

        .warning {
            margin-bottom: 24px;
            padding: 15px;
            border: 1px solid #fecaca;
            border-radius: 6px;
            background-color: #fef2f2;
            color: #991b1b;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 12px 18px;
            margin-bottom: 25px;
        }

        .detail-label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            min-height: 150px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-family: inherit;
            font-size: 15px;
            resize: vertical;
        }

        textarea:focus {
            border-color: #dc2626;
            outline: none;
        }

        .error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .button-danger {
            background-color: #dc2626;
        }

        .button-secondary {
            background-color: #6b7280;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .actions {
                flex-direction: column;
            }

            .actions .button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
</head>

<body>
    <div class="container">
        <h1>Cabut Dokumen</h1>

        <p class="description">
            Pencabutan menandai dokumen sebagai tidak berlaku.
            PDF final dan riwayat dokumen tetap disimpan.
        </p>

        <div class="warning">
            Tindakan ini tidak menghapus dokumen. Setelah dicabut,
            halaman verifikasi akan menampilkan status
            <strong>Dokumen Dicabut</strong>.
        </div>

        <div class="detail-grid">
            <div class="detail-label">
                Nomor Dokumen
            </div>

            <div>
                {{ $document->document_number }}
            </div>

            <div class="detail-label">
                Perihal
            </div>

            <div>
                {{ $document->subject }}
            </div>

            <div class="detail-label">
                Penandatangan
            </div>

            <div>
                {{ $document->signer_name
                    ?: $document->signer->name }}
            </div>

            <div class="detail-label">
                Tanggal Terbit
            </div>

            <div>
                {{ $document->signed_at
                    ->setTimezone(config('app.timezone'))
                    ->format('d/m/Y H:i') }} WIB
            </div>
        </div>

        <form
            action="{{ route('documents.revoke', $document) }}"
            method="POST"
            onsubmit="return confirm(
                'Yakin ingin mencabut dokumen ini?'
            )"
        >
            @csrf

            <div class="form-group">
                <label for="revocation_reason">
                    Alasan Pencabutan
                </label>

                <textarea
                    id="revocation_reason"
                    name="revocation_reason"
                    maxlength="1000"
                    placeholder="Tuliskan alasan dokumen dicabut..."
                    autofocus
                >{{ old('revocation_reason') }}</textarea>

                @error('revocation_reason')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="actions">
                <button
                    type="submit"
                    class="button button-danger"
                >
                    Cabut Dokumen
                </button>

                <a
                    href="{{ route('documents.show', $document) }}"
                    class="button button-secondary"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</body>
</html>
