<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Penandatangan</title>

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
            max-width: 800px;
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
            margin-bottom: 25px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 15px;
        }

        input[type="text"]:focus {
            border-color: #2563eb;
            outline: none;
        }

        .required {
            color: #dc2626;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: normal;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 14px;
        }

        .alert-error {
            margin-bottom: 20px;
            padding: 14px;
            border: 1px solid #fecaca;
            border-radius: 5px;
            background-color: #fef2f2;
            color: #991b1b;
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
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            background-color: #2563eb;
            color: #ffffff;
        }

        .button-secondary {
            background-color: #6b7280;
            color: #ffffff;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
</head>

<body>
    <div class="container">
        <h1>Tambah Penandatangan</h1>

        <p class="description">
            Masukkan data pejabat atau pegawai yang akan menandatangani dokumen.
        </p>

        @if ($errors->any())
            <div class="alert-error">
                Data belum dapat disimpan. Periksa kembali form di bawah.
            </div>
        @endif

        <form action="{{ route('signers.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">
                    Nama <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    maxlength="150"
                    autofocus
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="employee_number">
                    Nomor Pegawai
                </label>

                <input
                    type="text"
                    id="employee_number"
                    name="employee_number"
                    value="{{ old('employee_number') }}"
                    maxlength="50"
                    placeholder="Contoh: NIP, NIK, atau nomor karyawan"
                >

                @error('employee_number')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="position">
                    Jabatan <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="position"
                    name="position"
                    value="{{ old('position') }}"
                    maxlength="150"
                >

                @error('position')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="work_unit">
                    Unit Kerja <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="work_unit"
                    name="work_unit"
                    value="{{ old('work_unit') }}"
                    maxlength="150"
                >

                @error('work_unit')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="institution">
                    Instansi <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="institution"
                    name="institution"
                    value="{{ old('institution', 'PT Ito Seisakusho Armada') }}"
                    maxlength="200"
                >

                @error('institution')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox-group">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                >

                <label for="is_active">
                    Penandatangan aktif
                </label>
            </div>

            <div class="actions">
                <button type="submit" class="button button-primary">
                    Simpan
                </button>

                <a href="{{ route('signers.index') }}"
                   class="button button-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>
