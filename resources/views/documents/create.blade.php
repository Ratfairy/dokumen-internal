<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload Dokumen</title>

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
            max-width: 850px;
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
            margin-bottom: 26px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            background-color: #ffffff;
            font-family: inherit;
            font-size: 15px;
        }

        input:focus,
        select:focus {
            border-color: #2563eb;
            outline: none;
        }

        .required {
            color: #dc2626;
        }

        .help-text {
            margin-top: 7px;
            color: #6b7280;
            font-size: 13px;
        }

        .alert-warning {
            margin-bottom: 22px;
            padding: 14px;
            border: 1px solid #fde68a;
            border-radius: 5px;
            background-color: #fffbeb;
            color: #92400e;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 28px;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            background-color: #2563eb;
            color: #ffffff;
        }

        .button-primary:disabled {
            background-color: #93c5fd;
            cursor: not-allowed;
        }

        .button-secondary {
            background-color: #6b7280;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload Dokumen</h1>

        <p class="description">
            Upload dokumen PDF yang akan diproses dan diberi QR Code verifikasi.
        </p>

        @if ($signers->isEmpty())
            <div class="alert-warning">
                Belum ada penandatangan aktif. Aktifkan atau tambahkan
                penandatangan terlebih dahulu.
            </div>
        @endif

        <form
            action="{{ route('documents.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label for="document_number">
                    Nomor Dokumen
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="document_number"
                    name="document_number"
                    value="{{ old('document_number') }}"
                    maxlength="100"
                    placeholder="Contoh: 001/ISA/VII/2026"
                    autofocus
                >

                @error('document_number')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">
                    Perihal
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    maxlength="255"
                    placeholder="Contoh: Surat Keterangan"
                >

                @error('subject')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="document_date">
                    Tanggal Dokumen
                    <span class="required">*</span>
                </label>

                <input
                    type="date"
                    id="document_date"
                    name="document_date"
                    value="{{ old('document_date', now()->format('Y-m-d')) }}"
                >

                @error('document_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="signer_id">
                    Penandatangan
                    <span class="required">*</span>
                </label>

                <select
                    id="signer_id"
                    name="signer_id"
                    {{ $signers->isEmpty() ? 'disabled' : '' }}
                >
                    <option value="">
                        -- Pilih Penandatangan --
                    </option>

                    @foreach ($signers as $signer)
                        <option
                            value="{{ $signer->id }}"
                            {{ old('signer_id') == $signer->id ? 'selected' : '' }}
                        >
                            {{ $signer->name }}
                            — {{ $signer->position }}
                        </option>
                    @endforeach
                </select>

                @error('signer_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pdf_file">
                    File PDF
                    <span class="required">*</span>
                </label>

                <input
                    type="file"
                    id="pdf_file"
                    name="pdf_file"
                    accept="application/pdf,.pdf"
                >

                <div class="help-text">
                    File harus berformat PDF. Siapkan area kosong pada halaman
                    terakhir untuk penempatan QR Code.
                </div>

                @error('pdf_file')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button
                    type="submit"
                    class="button button-primary"
                >
                    Simpan Dokumen
                </button>

                <a
                    href="{{ route('documents.index') }}"
                    class="button button-secondary"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>