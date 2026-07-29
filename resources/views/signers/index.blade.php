<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Master Penandatangan</title>

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
            max-width: 1200px;
            margin: 0 auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 26px;
        }

        .description {
            margin-top: 0;
            margin-bottom: 24px;
            color: #6b7280;
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

        .status-active {
            font-weight: bold;
            color: #15803d;
        }

        .status-inactive {
            font-weight: bold;
            color: #b91c1c;
        }

        .empty-data {
            padding: 30px;
            color: #6b7280;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .header-actions .description {
            margin-bottom: 0;
        }

        .button-add {
            display: inline-block;
            flex-shrink: 0;
            padding: 11px 16px;
            border-radius: 5px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .button-secondary {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 5px;
            background-color: #6b7280;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .alert-success {
            margin-bottom: 20px;
            padding: 14px;
            border: 1px solid #bbf7d0;
            border-radius: 5px;
            background-color: #f0fdf4;
            color: #166534;
        }
        .button-edit {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 4px;
            background-color: #f59e0b;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .action-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .inline-form {
            display: inline;
            margin: 0;
        }

        .button-status {
            padding: 7px 12px;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        .button-disable {
            background-color: #dc2626;
        }

        .button-enable {
            background-color: #16a34a;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
</head>

<body>
    <div class="container">
        <h1>Master Penandatangan</h1>

    <div class="header-actions">
        <p class="description">
            Daftar pejabat atau pegawai yang dapat dipilih sebagai penandatangan dokumen.
        </p>

        <div class="navigation-left">
                <a
                    href="{{ route('documents.index') }}"
                    class="button button-secondary"
                >
                    Master Document
                </a>
            </div>

        <a href="{{ route('signers.create') }}" class="button-add">
            + Tambah Penandatangan
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
                    <th>Nama</th>
                    <th>Nomor Pegawai</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Instansi</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 220px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($signers as $signer)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $signer->name }}
                        </td>

                        <td>
                            {{ $signer->employee_number ?: '-' }}
                        </td>

                        <td>
                            {{ $signer->position }}
                        </td>

                        <td>
                            {{ $signer->work_unit }}
                        </td>

                        <td>
                            {{ $signer->institution }}
                        </td>

                        <td class="text-center">
                            @if ($signer->is_active)
                                <span class="status-active">Aktif</span>
                            @else
                                <span class="status-inactive">Tidak aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-group">
                                <a
                                    href="{{ route('signers.edit', $signer) }}"
                                    class="button-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('signers.toggle-status', $signer) }}"
                                    method="POST"
                                    class="inline-form"
                                    onsubmit="return confirm(
                                        '{{ $signer->is_active
                                            ? 'Yakin ingin menonaktifkan penandatangan ini?'
                                            : 'Yakin ingin mengaktifkan penandatangan ini?' }}'
                                    )"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="button-status
                                            {{ $signer->is_active
                                                ? 'button-disable'
                                                : 'button-enable' }}"
                                    >
                                        {{ $signer->is_active
                                            ? 'Nonaktifkan'
                                            : 'Aktifkan' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center empty-data">
                            Belum ada data penandatangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

