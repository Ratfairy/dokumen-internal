    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Detail Dokumen</title>

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
            }

            .card {
                margin-bottom: 24px;
                padding: 28px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            }

            h1,
            h2 {
                margin-top: 0;
            }

            .description {
                color: #6b7280;
                line-height: 1.6;
            }

            .detail-grid {
                display: grid;
                grid-template-columns: 220px 1fr;
                gap: 14px 20px;
                margin-top: 24px;
            }

            .detail-label {
                font-weight: bold;
                color: #374151;
            }

            .detail-value {
                word-break: break-word;
            }

            .status {
                display: inline-block;
                padding: 5px 11px;
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

            .actions {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 26px;
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
                text-align: center;
                text-decoration: none;
                cursor: pointer;
                transition:
                    background-color 0.2s ease,
                    transform 0.1s ease,
                    box-shadow 0.2s ease;
            }

            .button:hover {
                transform: translateY(-1px);
            }

            .button:active {
                transform: translateY(0);
            }

            .button-primary {
                background-color: #2563eb;
            }

            .button-primary:hover {
                background-color: #1d4ed8;
            }

            .button-secondary {
                background-color: #6b7280;
            }

            .button-secondary:hover {
                background-color: #4b5563;
            }

            .button-success {
                background-color: #16a34a;
            }

            .button-success:hover {
                background-color: #15803d;
            }

            .button-verification {
                background-color: #0f766e;
            }

            .button-verification:hover {
                background-color: #115e59;
            }

            .button-qr {
                background-color: #7c3aed;
            }

            .button-qr:hover {
                background-color: #6d28d9;
            }

            .button-generate-final {
                background-color: #be123c;
            }

            .button-generate-final:hover {
                background-color: #9f1239;
            }

            .button-final {
                background-color: #0369a1;
            }

            .button-final:hover {
                background-color: #075985;
            }

            .button-publish {
                background-color: #16a34a;
                color: #ffffff;
                box-shadow: 0 2px 5px rgba(22, 163, 74, 0.25);
            }

            .button-publish:hover {
                background-color: #15803d;
                box-shadow: 0 4px 8px rgba(22, 163, 74, 0.30);
            }

            .button-publish:active {
                background-color: #166534;
            }

            .button-revoke {
                background-color: #dc2626;
                color: #ffffff;
                box-shadow: 0 2px 5px rgba(220, 38, 38, 0.25);
            }

            .button-revoke:hover {
                background-color: #b91c1c;
                box-shadow: 0 4px 8px rgba(220, 38, 38, 0.30);
            }

            .button-revoke:active {
                background-color: #991b1b;
            }

            .inline-form {
                display: inline-block;
                margin: 0;
            }

            .alert-success {
                margin-bottom: 20px;
                padding: 14px;
                border: 1px solid #bbf7d0;
                border-radius: 5px;
                background-color: #f0fdf4;
                color: #166534;
            }

            .alert-error {
                margin-bottom: 20px;
                padding: 14px;
                border: 1px solid #fecaca;
                border-radius: 5px;
                background-color: #fef2f2;
                color: #991b1b;
            }

            .token-value {
                display: inline-block;
                max-width: 100%;
                padding: 8px 10px;
                border: 1px solid #d1d5db;
                border-radius: 5px;
                background-color: #f9fafb;
                font-family: Consolas, monospace;
                font-size: 13px;
                word-break: break-all;
            }

            .qr-note {
                max-width: 650px;
                margin: 0 auto;
                color: #6b7280;
                line-height: 1.6;
            }

            .pdf-preview {
                width: 100%;
                height: 750px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                background-color: #f9fafb;
            }
            .pdf-editor{
                width:100%;
                min-height:800px;

                border:1px solid #d1d5db;
                border-radius:6px;

                background:#f8fafc;

                overflow:auto;

                position:relative;
            }

            #pdf-pages{
                display:flex;
                flex-direction:column;
                gap:30px;
                padding:20px;
                align-items:center;
            }

            .pdf-page{
                position:relative;

                background:white;

                box-shadow:0 2px 10px rgba(0,0,0,.15);
            }

            .pdf-page canvas{
                display:block;
            }

            .qr-overlay{

                position:absolute;

                width:120px;

                height:120px;

                right:30px;

                bottom:30px;

                cursor:move;

                border:2px dashed #2563eb;

                background:rgba(37,99,235,.08);

                display:flex;

                align-items:center;

                justify-content:center;

                user-select:none;

                z-index:999;

            }


            .qr-overlay:hover{

                background:rgba(37,99,235,.18);

            }

            .pdf-toolbar{

                display:flex;

                justify-content:center;

                align-items:center;

                gap:20px;

                margin-bottom:20px;

            }

            #page-info{

                font-size:18px;

                font-weight:bold;

                min-width:150px;

                text-align:center;

            }

            .pdf-zoom-toolbar{

                display:flex;

                justify-content:center;

                align-items:center;

                gap:20px;

                margin-bottom:20px;

            }

            #zoom-info{

                width:80px;

                text-align:center;

                font-weight:bold;

                font-size:18px;

            }

            @media (max-width: 700px) {
                body {
                    padding: 15px;
                }

                .card {
                    padding: 20px;
                }

                .detail-grid {
                    grid-template-columns: 1fr;
                    gap: 5px;
                }

                .detail-label {
                    margin-top: 8px;
                }

                .detail-value {
                    margin-bottom: 12px;
                }

                .pdf-preview {
                    height: 550px;
                }

                .actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .actions .button,
                .actions form,
                .actions form button {
                    width: 100%;
                }
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/css/app-ui.css') }}">
    </head>

    <body>
        <div class="container">

            {{-- DETAIL DOKUMEN --}}
            <div class="card">
                <h1>Detail Dokumen</h1>

                <p class="description">
                    Periksa metadata dan file PDF sebelum dokumen diproses.
                </p>

                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="detail-grid">

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
                        Penandatangan
                    </div>

                    <div class="detail-value">
                        {{ $document->signer_name
                            ?: $document->signer->name }}
                    </div>

                    <div class="detail-label">
                        Nomor Pegawai
                    </div>

                    <div class="detail-value">
                        {{ $document->signer_employee_number
                            ?: ($document->signer->employee_number ?: '-') }}
                    </div>

                    <div class="detail-label">
                        Jabatan
                    </div>

                    <div class="detail-value">
                        {{ $document->signer_position
                            ?: $document->signer->position }}
                    </div>

                    <div class="detail-label">
                        Unit Kerja
                    </div>

                    <div class="detail-value">
                        {{ $document->signer_work_unit
                            ?: $document->signer->work_unit }}
                    </div>

                    <div class="detail-label">
                        Instansi
                    </div>

                    <div class="detail-value">
                        {{ $document->signer_institution
                            ?: $document->signer->institution }}
                    </div>

                    <div class="detail-label">
                        Nama File Asli
                    </div>

                    <div class="detail-value">
                        {{ $document->original_file_name }}
                    </div>

                    <div class="detail-label">
                        Status
                    </div>

                    <div class="detail-value">
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
                    </div>

                    <div class="detail-label">
                        Token Verifikasi
                    </div>

                    <div class="detail-value">
                        @if ($document->verification_token)
                            <span class="token-value">
                                {{ $document->verification_token }}
                            </span>
                        @else
                            <span>- Belum dibuat -</span>
                        @endif
                    </div>

                    <div class="detail-label">
                        Hash SHA-256
                    </div>

                    <div class="detail-value">
                        @if ($document->sha256_hash)
                            <span class="token-value">
                                {{ $document->sha256_hash }}
                            </span>
                        @else
                            <span>- Belum dibuat -</span>
                        @endif
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

                    @if ($document->status === 'REVOKED')
                        <div class="detail-label">
                            Dicabut pada
                        </div>

                        <div class="detail-value">
                            @if ($document->revoked_at)
                                {{ $document->revoked_at
                                    ->setTimezone(config('app.timezone'))
                                    ->format('d/m/Y H:i') }} WIB
                            @else
                                -
                            @endif
                        </div>

                        <div class="detail-label">
                            Alasan Pencabutan
                        </div>

                        <div class="detail-value">
                            {{ $document->revocation_reason ?: '-' }}
                        </div>
                    @endif
                </div>

                <div class="actions">

                    {{-- BUAT TOKEN --}}
                    @if (
                        $document->status === 'DRAFT'
                        && empty($document->verification_token)
                    )
                        <form
                            action="{{ route(
                                'documents.generate-token',
                                $document
                            ) }}"
                            method="POST"
                            class="inline-form"
                            onsubmit="return confirm(
                                'Buat token verifikasi untuk dokumen ini?'
                            )"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="button button-success"
                            >
                                Buat Token Verifikasi
                            </button>
                        </form>
                    @endif

                    {{-- BUAT PDF FINAL --}}
                    @if (
                        $document->status === 'DRAFT'
                        && $document->verification_token
                    )
                        <form
                            action="{{ route(
                                'documents.generate-final-pdf',
                                $document
                            ) }}"
                            method="POST"
                            class="inline-form"
                            onsubmit="return confirm(
                                'Buat PDF final dan tempelkan QR Code pada halaman terakhir?'
                            )"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="button button-generate-final"
                            >
                                {{ $document->final_pdf_path
                                    ? 'Buat Ulang PDF Final'
                                    : 'Buat PDF Final + QR' }}
                            </button>
                        </form>
                    @endif

                    {{-- TERBITKAN DOKUMEN --}}
                    @if (
                        $document->status === 'DRAFT'
                        && $document->verification_token
                        && $document->final_pdf_path
                    )
                        <form
                            action="{{ route(
                                'documents.publish',
                                $document
                            ) }}"
                            method="POST"
                            class="inline-form"
                            onsubmit="return confirm(
                                'Yakin ingin menerbitkan dokumen ini? Setelah diterbitkan, PDF final tidak dapat dibuat ulang.'
                            )"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="button button-publish"
                            >
                                Terbitkan Dokumen
                            </button>
                        </form>
                    @endif

                    {{-- CABUT DOKUMEN --}}
                    @if ($document->status === 'PUBLISHED')
                        <a
                            href="{{ route(
                                'documents.revoke-form',
                                $document
                            ) }}"
                            class="button button-revoke"
                        >
                            Cabut Dokumen
                        </a>
                    @endif

                    {{-- BUKA PDF FINAL --}}
                    @if ($document->final_pdf_path)
                        <a
                            href="{{ route(
                                'documents.final',
                                $document
                            ) }}"
                            class="button button-final"
                            target="_blank"
                        >
                            Buka PDF Final
                        </a>
                    @endif

                    {{-- KEMBALI --}}
                    <a
                        href="{{ route('documents.index') }}"
                        class="button button-secondary"
                    >
                        Kembali
                    </a>

                    {{-- HALAMAN VERIFIKASI --}}
                    @if ($document->verification_token)
                        <a
                            href="{{ route(
                                'verification.show',
                                $document->verification_token
                            ) }}"
                            class="button button-verification"
                            target="_blank"
                        >
                            Buka Halaman Verifikasi
                        </a>
                    @endif
                </div>
            </div>

            {{-- PREVIEW PDF FINAL --}}
            @if ($document->final_pdf_path)
                <div class="card">
                    <h2>Preview PDF Final dengan QR Code</h2>

                    <p class="description">
                        Periksa posisi QR Code pada dokumen final.
                    </p>

                    <iframe
                        src="{{ route(
                            'documents.final',
                            $document
                        ) }}"
                        class="pdf-preview"
                        title="Preview PDF Final"
                    ></iframe>
                </div>
            @endif

            {{-- QR PLACEMENT EDITOR --}}
            <div class="card">

                <h2>QR Placement Editor</h2>

                <p class="description">
                    Atur posisi QR Code pada dokumen sebelum membuat PDF Final.
                </p>

                <div class="pdf-toolbar">

                    <button
                        id="btn-prev"
                        class="button button-secondary"
                        type="button"
                    >
                        Sebelumnya
                    </button>

                    <span id="page-info">
                        Halaman 1 / 1
                    </span>

                    <button
                        id="btn-next"
                        class="button button-secondary"
                        type="button"
                    >
                        Berikutnya
                    </button>

                </div>

                <div class="pdf-zoom-toolbar">

                    <button
                        id="btn-zoom-out"
                        class="button button-secondary"
                        type="button"
                    >
                        -
                    </button>

                    <span id="zoom-info">
                        100%
                    </span>

                    <button
                        id="btn-zoom-in"
                        class="button button-secondary"
                        type="button"
                    >
                        +
                    </button>

                </div>

                <div style="text-align:center;margin-bottom:20px;">

                    <button
                        id="btn-save-position"
                        type="button"
                        class="button button-success">

                        Simpan Posisi QR

                    </button>

                </div>

                <div class="pdf-editor">

                    <div id="pdf-pages">

                    </div>

                </div>

            </div>
        </div>

        <div
            id="qr-save-loading"
            class="app-loading-backdrop"
            aria-hidden="true"
        >
            <div class="app-loading-card">
                <div class="app-spinner"></div>
                <p class="app-loading-title">Menyimpan posisi QR</p>
                <p class="app-loading-text">Mohon tunggu sebentar.</p>
            </div>
        </div>

        <div
            id="qr-save-toast"
            class="app-toast"
            role="status"
            aria-live="polite"
        ></div>
    </body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
    </script>

    <script>
    const pdfUrl = "{{ route('documents.original', $document) }}";

    let qrStates = @json($document->qrPositions);

    let pdf = null;
    let currentPage = 1;
    let scale = 1.5;
    let activeQr = null;
    let activePage = null;
    let isDragging = false;
    let isResizing = false;
    let resizeMode = null;
    let startX = 0;
    let startY = 0;
    let startWidth = 0;
    let startHeight = 0;
    let startLeft = 0;
    let startTop = 0;
    let toastTimeout = null;

    function setQrSaving(isSaving) {
        const loading = document.getElementById("qr-save-loading");
        const saveButton = document.getElementById("btn-save-position");

        loading.classList.toggle("is-visible", isSaving);
        loading.setAttribute("aria-hidden", isSaving ? "false" : "true");
        saveButton.disabled = isSaving;
    }

    function showQrToast(type, message) {
        const toast = document.getElementById("qr-save-toast");

        clearTimeout(toastTimeout);

        toast.textContent = message;
        toast.className = `app-toast is-visible is-${type}`;

        toastTimeout = setTimeout(function () {
            toast.className = "app-toast";
        }, 3500);
    }


    document
        .getElementById("btn-save-position")
        .addEventListener("click", async function () {

            const qr = document.querySelector(".qr-overlay");

            if (! qr) {
                showQrToast("error", "QR belum tampil. Tunggu PDF selesai dimuat.");
                return;
            }

            const pageWidth = qr.parentElement.clientWidth;
            const pageHeight = qr.parentElement.clientHeight;

            setQrSaving(true);

            try {
                const response = await fetch(
                    "{{ route('documents.save-qr-position', $document) }}",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },

                        body: JSON.stringify({
                            page: currentPage,
                            x: Number(qr.dataset.x) / pageWidth,
                            y: Number(qr.dataset.y) / pageHeight,
                            width: Number(qr.dataset.size) / pageWidth,
                            height: Number(qr.dataset.size) / pageHeight
                        })
                    }
                );

                const data = await response.json();

                if (! response.ok || ! data.success) {
                    throw new Error(
                        data.message || "Posisi QR gagal disimpan."
                    );
                }

                const savedQr = {
                    page_number: currentPage,
                    position_x: Number(qr.dataset.x) / pageWidth,
                    position_y: Number(qr.dataset.y) / pageHeight,
                    width: Number(qr.dataset.size) / pageWidth,
                    height: Number(qr.dataset.size) / pageHeight
                };

                const index = qrStates.findIndex(q =>
                    Number(q.page_number) === currentPage
                );

                if (index >= 0) {
                    qrStates[index] = savedQr;
                } else {
                    qrStates.push(savedQr);
                }

                showQrToast(
                    "success",
                    data.message || "Posisi QR berhasil disimpan."
                );
            } catch (error) {
                showQrToast(
                    "error",
                    error.message || "Posisi QR gagal disimpan."
                );
            } finally {
                setQrSaving(false);
            }
        });

    async function loadPdf() {

        pdf = await pdfjsLib.getDocument(pdfUrl).promise;

        renderPage(currentPage);

    }

    async function renderPage(pageNumber){

        const container = document.getElementById("pdf-pages");

        container.innerHTML = "";

        const page = await pdf.getPage(pageNumber);

        const viewport = page.getViewport({
            scale
        });

        const pageDiv = document.createElement("div");

        pageDiv.className = "pdf-page";

        const canvas = document.createElement("canvas");

        const context = canvas.getContext("2d");

        canvas.width = viewport.width;

        canvas.height = viewport.height;

        pageDiv.appendChild(canvas);

        const qr = document.createElement("div");

        qr.className = "qr-overlay";

        qr.innerHTML = `
            <span>QR</span>
        `;

        const currentQr = qrStates.find(q =>
            Number(q.page_number) === pageNumber
        );

        const left = currentQr
            ? Number(currentQr.position_x) * viewport.width
            : 650;

        const top = currentQr
            ? Number(currentQr.position_y) * viewport.height
            : 300;

        const size = currentQr
            ? Number(currentQr.width) * viewport.width
            : 120;

        qr.style.left = left + "px";
        qr.style.top = top + "px";

        qr.style.width = size + "px";
        qr.style.height = size + "px";

        qr.dataset.x = left;
        qr.dataset.y = top;
        qr.dataset.size = size;

        pageDiv.appendChild(qr);


        container.appendChild(pageDiv);

        qr.addEventListener("mousemove", function(e){
            const edge = 8;
            const rect = qr.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const nearLeft = x <= edge;
            const nearRight = x >= rect.width - edge;
            const nearTop = y <= edge;
            const nearBottom = y >= rect.height - edge;

            if(nearTop && nearLeft){
            qr.style.cursor = "nw-resize";
            }
            else if(nearTop && nearRight){
                qr.style.cursor = "ne-resize";
            }
            else if(nearBottom && nearLeft){
                qr.style.cursor = "sw-resize";
            }
            else if(nearBottom && nearRight){
                qr.style.cursor = "se-resize";
            }
            else if(nearLeft){
                qr.style.cursor = "w-resize";
            }
            else if(nearRight){
                qr.style.cursor = "e-resize";
            }
            else if(nearTop){
                qr.style.cursor = "n-resize";
            }
            else if(nearBottom){
                qr.style.cursor = "s-resize";
            }
            else{
                qr.style.cursor = "move";
            }
        });

        qr.addEventListener("mousedown", function(e){
            activeQr = qr;
            activePage = pageDiv;
            startX = e.clientX;
            startY = e.clientY;
            startWidth = qr.offsetWidth;
            startHeight = qr.offsetHeight;
            startLeft = parseFloat(qr.style.left);
            startTop = parseFloat(qr.style.top);
            

            switch(qr.style.cursor){
            case "e-resize":
                isResizing = true;
                resizeMode = "right";
                break;
            case "w-resize":
                isResizing = true;
                resizeMode = "left";
                break;
            case "n-resize":
                isResizing = true;
                resizeMode = "top";
                break;
            case "s-resize":
                isResizing = true;
                resizeMode = "bottom";
                break;
            case "nw-resize":
                isResizing = true;
                resizeMode = "top-left";
                break;
            case "ne-resize":
                isResizing = true;
                resizeMode = "top-right";
                break;
            case "sw-resize":
                isResizing = true;
                resizeMode = "bottom-left";
                break;
            case "se-resize":
                isResizing = true;
                resizeMode = "bottom-right";
                break;
            default:
                isDragging = true;
                resizeMode = null;
        }

        });


        await page.render({

            canvasContext: context,

            viewport

        }).promise;

        document.getElementById("page-info").textContent =
            `Halaman ${pageNumber} / ${pdf.numPages}`;
        
        document.getElementById("zoom-info").textContent =
            `${Math.round(scale / 1.5 * 100)}%`;

    } 

    document.addEventListener("mousemove", function(e){

        if((!isDragging && !isResizing) || !activeQr){
            return;
        }

        if (isResizing) {
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            resizeQr(
                activeQr,
                activePage,
                resizeMode,
                dx,
                dy
            );

            return;
        }

        const dx = e.clientX - startX;

        const dy = e.clientY - startY;

        const pageWidth = activePage.clientWidth;
        const pageHeight = activePage.clientHeight;

        const qrWidth = activeQr.offsetWidth;
        const qrHeight = activeQr.offsetHeight;

        let x = startLeft + dx;
        let y = startTop + dy;

        x = Math.max(0, Math.min(x, pageWidth - qrWidth));
        y = Math.max(0, Math.min(y, pageHeight - qrHeight));

        activeQr.style.left = x + "px";
        activeQr.style.top = y + "px";

    });

    document.addEventListener("mouseup", function(){

        if((!isDragging && !isResizing) || !activeQr){
            return;
        }

        activeQr.dataset.x = parseFloat(activeQr.style.left);
        activeQr.dataset.y = parseFloat(activeQr.style.top);

        isDragging = false;
        isResizing = false;
        resizeMode = null;
        activeQr = null;
        activePage = null;
    });

    function applyQrRect(qr, page, left, top, size){

        const pageWidth = page.clientWidth;
        const pageHeight = page.clientHeight;

        if(left < 0){
            return;
        }

        if(top < 0){
            return;
        }

        if(left + size > pageWidth){
            return;
        }

        if(top + size > pageHeight){
            return;
        }

        qr.style.left = left + "px";
        qr.style.top = top + "px";

        qr.style.width = size + "px";
        qr.style.height = size + "px";

        qr.dataset.x = left;
        qr.dataset.y = top;
        qr.dataset.size = size;

    }

    function resizeQr(qr, page, mode, dx, dy) {

        const minSize = 60;

        let left = startLeft;
        let top = startTop;

        let right = startLeft + startWidth;
        let bottom = startTop + startHeight;

        if (mode.includes("left")) {
            left = startLeft + dx;
        }

        if (mode.includes("right")) {
            right = startLeft + startWidth + dx;
        }

        if (mode.includes("top")) {
            top = startTop + dy;
        }

        if (mode.includes("bottom")) {
            bottom = startTop + startHeight + dy;
        }

        let width = right - left;
        let height = bottom - top;

        let size = Math.max(minSize, Math.max(width, height));

        if (mode.includes("left")) {
            left = right - size;
        }

        if (mode.includes("top")) {
            top = bottom - size;
        }

        if (mode.includes("right")) {
            right = left + size;
        }

        if (mode.includes("bottom")) {
            bottom = top + size;
        }

        applyQrRect(
            qr,
            page,
            left,
            top,
            size
        );
    }

    document.getElementById("btn-zoom-in").onclick = () => {

        scale += 0.25;

        renderPage(currentPage);

    };

    document.getElementById("btn-zoom-out").onclick = () => {

        if(scale <= 0.5){

            return;

        }

        scale -= 0.25;

        renderPage(currentPage);

    };

    document.getElementById("btn-prev").onclick = () => {

        if(currentPage <= 1){

            return;

        }

        currentPage--;

        renderPage(currentPage);

    };

    document.getElementById("btn-next").onclick = () => {

        if(currentPage >= pdf.numPages){

            return;

        }

        currentPage++;

        renderPage(currentPage);

    };

    loadPdf();

    </script>

    </html>
