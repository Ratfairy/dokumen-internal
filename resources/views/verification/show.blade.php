<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Verifikasi Dokumen</title>

        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 30px 15px;
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f3f6fa;
                color: #1f2937;
            }

            .container {
                max-width: 750px;
                margin: 0 auto;
            }

            .card {
                overflow: hidden;
                background-color: #ffffff;
                border-radius: 14px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .header {
                padding: 30px;
                text-align: center;
                background-color: #0f766e;
                color: #ffffff;
            }

            .header h1 {
                margin: 0 0 8px;
                font-size: 30px;
            }

            .header p {
                margin: 0;
                opacity: 0.9;
            }

            .content {
                padding: 30px;
            }

            .status-box {
                margin-bottom: 28px;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
            }

            .status-valid {
                border: 1px solid #86efac;
                background-color: #f0fdf4;
                color: #166534;
            }

            .status-draft {
                border: 1px solid #fde68a;
                background-color: #fffbeb;
                color: #92400e;
            }

            .status-revoked {
                border: 1px solid #fecaca;
                background-color: #fef2f2;
                color: #991b1b;
            }

            .status-title {
                margin-bottom: 6px;
                font-size: 23px;
                font-weight: bold;
            }

            .status-description {
                margin: 0;
            }
            
            .alert-box {
                margin-bottom: 25px;
                padding: 18px;
                border-radius: 8px;
            }

            .alert-warning {
                background-color: #fffbeb;
                border: 1px solid #fde68a;
                color: #92400e;
            }

            .alert-error {
                background-color: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
            }

            .alert-title {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 6px;
            }
            .details {
                display: grid;
                grid-template-columns: 200px 1fr;
                gap: 15px 20px;
            }

            .detail-label {
                font-weight: bold;
                color: #4b5563;
            }

            .detail-value {
                word-break: break-word;
            }

            .hash-value {
                padding: 9px 11px;
                border: 1px solid #d1d5db;
                border-radius: 5px;
                background-color: #f9fafb;
                font-family: Consolas, monospace;
                font-size: 12px;
                word-break: break-all;
            }

            .footer {
                padding: 20px 30px;
                border-top: 1px solid #e5e7eb;
                background-color: #f9fafb;
                color: #6b7280;
                text-align: center;
                font-size: 13px;
            }

            .download-section {
                margin-top: 30px;
                text-align: center;
            }

            .download-btn {
                display: inline-block;
                padding: 12px 24px;
                background-color: #16a34a;
                color: #ffffff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
                transition: background-color .2s;
            }

            .download-btn:hover {
                background-color: #15803d;
            }

            @media (max-width: 600px) {
                body {
                    padding: 15px 10px;
                }

                .header,
                .content {
                    padding: 22px;
                }

                .header h1 {
                    font-size: 25px;
                }

                .details {
                    grid-template-columns: 1fr;
                    gap: 5px;
                }

                .detail-value {
                    margin-bottom: 12px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="card">
                <div class="header">
                    <h1>Verifikasi Dokumen</h1>

                    <p>
                        PT Ito Seisakusho Armada
                    </p>
                </div>

                <div class="content">
                    @if(session('warning'))
                    <div class="alert-box alert-warning">
                        <div class="alert-title">
                            ⚠ PDF Final Belum Tersedia
                        </div>

                        <div>
                            {{ session('warning') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-box alert-error">
                        <div class="alert-title">
                            ❌ PDF Final Tidak Tersedia
                        </div>

                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                    @if ($document->status === 'PUBLISHED')
                        <div class="status-box status-valid">
                            <div class="status-title">
                                Dokumen Valid
                            </div>

                            <p class="status-description">
                                Dokumen telah diterbitkan dan tercatat
                                dalam sistem.
                            </p>
                        </div>
                    @elseif ($document->status === 'REVOKED')
                        <div class="status-box status-revoked">
                            <div class="status-title">
                                Dokumen Dicabut
                            </div>

                            <p class="status-description">
                                Dokumen ini sudah tidak berlaku.
                            </p>
                        </div>
                    @else
                        <div class="status-box status-draft">
                            <div class="status-title">
                                Belum Diterbitkan
                            </div>

                            <p class="status-description">
                                Token ditemukan, tetapi dokumen masih
                                berstatus Draft.
                            </p>
                        </div>
                    @endif

                    <div class="details">
                        <div class="detail-label">
                            Nomor Dokumen
                        </div>

                        <div class="detail-value">
                            {{ $document->document_number }}
                        </div>

                        <div class="detail-label">
                            Perihal
                        </div>

                        <div class="detail-value">
                            {{ $document->subject }}
                        </div>

                        <div class="detail-label">
                            Tanggal Dokumen
                        </div>

                        <div class="detail-value">
                            {{ $document->document_date->format('d/m/Y') }}
                        </div>

                        <div class="detail-label">
                            Nama
                        </div>

                        <div class="detail-value">
                            {{ $document->signer_name ?: $document->signer->name }}
                        </div>

                        <div class="detail-label">
                            Jabatan
                        </div>

                        <div class="detail-value">
                            {{ $document->signer_position ?: $document->signer->position }}
                        </div>

                        <div class="detail-label">
                            Unit Kerja
                        </div>

                        <div class="detail-value">
                            {{ $document->signer_work_unit ?: $document->signer->work_unit }}
                        </div>

                        <div class="detail-label">
                            Instansi
                        </div>

                        <div class="detail-value">
                            {{ $document->signer_institution ?: $document->signer->institution }}
                        </div>

                        <div class="detail-label">
                            Ditandatangani pada
                        </div>

                        <div class="detail-value">
                            @if ($document->signed_at)
                                {{ $document->signed_at
                                    ->setTimezone(config('app.timezone'))
                                    ->format('d/m/Y H:i') }} WIB
                            @else
                                -
                            @endif
                        </div>

                        <div class="detail-label">
                            Hash SHA-256
                        </div>

                        <div class="detail-value">
                            @if ($document->sha256_hash)
                                <div class="hash-value">
                                    {{ $document->sha256_hash }}
                                </div>
                            @else
                                -
                            @endif
                        </div>

                        @if ($document->status === 'REVOKED')
                            <div class="detail-label">
                                Dicabut pada
                            </div>

                            <div class="detail-value">
                                {{ $document->revoked_at
                                    ->setTimezone(config('app.timezone'))
                                    ->format('d/m/Y H:i') }} WIB
                            </div>

                            <div class="detail-label">
                                Alasan Pencabutan
                            </div>

                            <div class="detail-value">
                                {{ $document->revocation_reason }}
                            </div>
                        @endif
                    </div>
                    @if ($document->status === 'PUBLISHED')
                        <div class="download-section">
                            <a
                                href="{{ route('verify.download', $document->verification_token) }}"
                                class="download-btn"
                            >
                                📄 Unduh Dokumen Resmi
                            </a>
                        </div>
                    @endif
                </div>
                

                <div class="footer">
                    Halaman ini hanya digunakan untuk memeriksa
                    status dan informasi dokumen.
                </div>
            </div>
        </div>
    </body>
</html>