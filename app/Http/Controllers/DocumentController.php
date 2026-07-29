<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentQrPosition;
use App\Models\Signer;
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::query()
        ->with('signer')
        ->latest()
        ->get();

    return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $signers = Signer::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('documents.create', compact('signers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_number' => [
                'required',
                'string',                'max:100',
                'unique:documents,document_number',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'document_date' => [
                'required',
                'date',
            ],

            'signer_id' => [
                'required',
                Rule::exists('signers', 'id')
                    ->where(function ($query) {
                        $query->where('is_active', true);
                    }),
            ],

            'pdf_file' => [
                'required',
                File::types(['pdf'])->max('10mb'),
            ],
        ], [
            'document_number.required' => 'Nomor dokumen wajib diisi.',
            'document_number.unique' => 'Nomor dokumen sudah digunakan.',
            'document_number.max' => 'Nomor dokumen maksimal 100 karakter.',

            'subject.required' => 'Perihal dokumen wajib diisi.',
            'subject.max' => 'Perihal maksimal 255 karakter.',

            'document_date.required' => 'Tanggal dokumen wajib diisi.',
            'document_date.date' => 'Format tanggal dokumen tidak valid.',

            'signer_id.required' => 'Penandatangan wajib dipilih.',
            'signer_id.exists' => 'Penandatangan tidak ditemukan atau sudah tidak aktif.',

            'pdf_file.required' => 'File PDF wajib dipilih.',
        ]);

        $pdfFile = $request->file('pdf_file');

        $storedPath = $pdfFile->store(
            'documents/original',
            'local'
        );

        Document::create([
            'document_number' => $validated['document_number'],
            'subject' => $validated['subject'],
            'document_date' => $validated['document_date'],
            'signer_id' => $validated['signer_id'],

            'original_file_name' => $pdfFile->getClientOriginalName(),
            'original_pdf_path' => $storedPath,

            'final_pdf_path' => null,
            'verification_token' => null,
            'sha256_hash' => null,
            'status' => 'DRAFT',
            'signed_at' => null,
            'revoked_at' => null,
            'revocation_reason' => null,
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen PDF berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load([
            'signer',
            'qrPositions'
        ]);

        return view(
            'documents.show',
            compact('document')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
    public function viewOriginal(Document $document)
    {
        $disk = Storage::disk('local');

        if ($disk->missing($document->original_pdf_path)) {
            abort(404, 'File PDF asli tidak ditemukan.');
        }

        return response()->file(
            $disk->path($document->original_pdf_path),
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
    public function generateToken(Document $document)
    {
        if ($document->status !== 'DRAFT') {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Token hanya dapat dibuat untuk dokumen berstatus Draft.'
                );
        }

        if (! empty($document->verification_token)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'success',
                    'Dokumen ini sudah mempunyai token verifikasi.'
                );
        }

        do {
            $token = Str::random(64);
        } while (
            Document::where('verification_token', $token)->exists()
        );

        $document->update([
            'verification_token' => $token,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with(
                'success',
                'Token verifikasi berhasil dibuat.'
            );
    }

    public function viewQrCode(Document $document)
    {
        if (empty($document->verification_token)) {
            abort(404, 'Token verifikasi dokumen belum dibuat.');
        }

        $logoPath = public_path('assets/logo/isa-logo.jpg');

        if (! is_file($logoPath)) {
            abort(500, 'File logo ISA tidak ditemukan.');
        }

        $verificationUrl = route(
            'verification.show',
            $document->verification_token
        );

        $builder = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->validateResult(false)
            ->data($verificationUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(400)
            ->margin(20)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath($logoPath)
            ->logoResizeToWidth(70)
            ->logoPunchoutBackground(true);

        $result = $builder->build();

        return response($result->getString(), 200)
            ->header('Content-Type', $result->getMimeType())
            ->header(
                'Content-Disposition',
                'inline; filename="qr-dokumen-'.$document->id.'.png"'
            );
    }

    public function generateFinalPdf(Document $document)
    {
        if ($document->status !== 'DRAFT') {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'PDF final hanya dapat dibuat untuk dokumen berstatus Draft.'
                );
        }

        if (empty($document->verification_token)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Buat token verifikasi terlebih dahulu.'
                );
        }

        $disk = Storage::disk('local');

        if ($disk->missing($document->original_pdf_path)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'File PDF asli tidak ditemukan.'
                );
        }

        $document->load('qrPositions');

        $logoPath = public_path('assets/logo/isa-logo.jpg');

        if (! is_file($logoPath)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'File logo ISA tidak ditemukan.'
                );
        }

        /*
        * URL yang dimasukkan ke dalam QR Code.
        */
        $verificationUrl = route(
            'verification.show',
            $document->verification_token
        );

        /*
        * Membuat gambar QR dengan logo ISA.
        */
        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->validateResult(false)
            ->data($verificationUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(600)
            ->margin(20)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath($logoPath)
            ->logoResizeToWidth(100)
            ->logoPunchoutBackground(true)
            ->build();

        /*
        * Simpan QR sementara karena FPDI memerlukan path gambar.
        */
        $disk->makeDirectory('documents/temp');

        $temporaryQrPath = 'documents/temp/qr-'
            .$document->id.'-'
            .Str::uuid()
            .'.png';

        $temporaryQrAbsolutePath = $disk->path($temporaryQrPath);

        file_put_contents(
            $temporaryQrAbsolutePath,
            $qrResult->getString()
        );

        try {
            $originalPdfAbsolutePath = $disk->path(
                $document->original_pdf_path
            );

            $pdf = new Fpdi();

            /*
            * Mencegah margin dan page break otomatis mengubah posisi halaman.
            */
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false);
            $qrPositionsByPage = $document->qrPositions->keyBy('page_number');
            $pageCount = $pdf->setSourceFile(
                $originalPdfAbsolutePath
            );

            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $templateId = $pdf->importPage($pageNumber);

                $pageSize = $pdf->getTemplateSize($templateId);

                /*
                * Mempertahankan ukuran dan orientasi halaman asli.
                */
                $pdf->AddPage(
                    $pageSize['orientation'],
                    [
                        $pageSize['width'],
                        $pageSize['height'],
                    ]
                );

                $pdf->useTemplate(
                    $templateId,
                    0,
                    0,
                    $pageSize['width'],
                    $pageSize['height']
                );

                /*
                * Tempel QR pada setiap halaman yang mempunyai
                * konfigurasi posisi QR di database.
                */
                $position = $qrPositionsByPage->get($pageNumber);

                if ($position) {

                    $qrPositionX = $position->position_x * $pageSize['width'];

                    $qrPositionY = $position->position_y * $pageSize['height'];

                    $qrWidth = $position->width * $pageSize['width'];

                    $qrHeight = $position->height * $pageSize['height'];

                    $pdf->Image(
                        $temporaryQrAbsolutePath,
                        $qrPositionX,
                        $qrPositionY,
                        $qrWidth,
                        $qrHeight,
                        'PNG'
                    );
                }
            }

            /*
            * Lokasi PDF final.
            */
            $disk->makeDirectory('documents/final');

            $finalPdfPath = 'documents/final/document-'
                .$document->id.'-'
                .Str::uuid()
                .'.pdf';

            /*
            * Output dengan mode S menghasilkan isi PDF sebagai string.
            */
            $finalPdfContent = $pdf->Output('S');

            $disk->put(
                $finalPdfPath,
                $finalPdfContent
            );

            /*
            * Hapus PDF final sebelumnya jika dokumen diproses ulang.
            */
            if (
                ! empty($document->final_pdf_path)
                && $disk->exists($document->final_pdf_path)
            ) {
                $disk->delete($document->final_pdf_path);
            }

            $document->update([
                'final_pdf_path' => $finalPdfPath,
            ]);
        } finally {
            /*
            * QR sementara selalu dihapus, termasuk jika proses PDF gagal.
            */
            if ($disk->exists($temporaryQrPath)) {
                $disk->delete($temporaryQrPath);
            }
        }

        return redirect()
            ->route('documents.show', $document)
            ->with(
                'success',
                'PDF final dengan QR Code berhasil dibuat.'
            );
    }

    public function viewFinal(Document $document)
    {
        if (empty($document->final_pdf_path)) {
            abort(404, 'PDF final belum dibuat.');
        }

        $disk = Storage::disk('local');

        if ($disk->missing($document->final_pdf_path)) {
            abort(404, 'File PDF final tidak ditemukan.');
        }

        return response()->file(
            $disk->path($document->final_pdf_path),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="dokumen-final-'
                    .$document->id
                    .'.pdf"',
            ]
        );
    }

    public function publish(Document $document)
    {
        if ($document->status !== 'DRAFT') {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Hanya dokumen berstatus Draft yang dapat diterbitkan.'
                );
        }

        if (empty($document->verification_token)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Token verifikasi belum dibuat.'
                );
        }

        if (empty($document->final_pdf_path)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Buat PDF final dengan QR Code terlebih dahulu.'
                );
        }

        $disk = Storage::disk('local');

        if ($disk->missing($document->final_pdf_path)) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'File PDF final tidak ditemukan.'
                );
        }

        $document->load('signer');

        if (! $document->signer) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Data penandatangan tidak ditemukan.'
                );
        }

        if (! $document->signer->is_active) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Penandatangan sudah tidak aktif.'
                );
        }

        /*
        * Hash dihitung dari PDF final yang sudah memiliki QR Code.
        */
        $finalPdfAbsolutePath = $disk->path(
            $document->final_pdf_path
        );

        $sha256Hash = hash_file(
            'sha256',
            $finalPdfAbsolutePath
        );

        if ($sha256Hash === false) {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Gagal menghitung hash PDF final.'
                );
        }

        /*
        * Simpan snapshot data penandatangan agar dokumen lama
        * tidak berubah ketika master penandatangan diedit.
        */
        $document->update([
            'signer_name' => $document->signer->name,
            'signer_employee_number' => $document->signer->employee_number,
            'signer_position' => $document->signer->position,
            'signer_work_unit' => $document->signer->work_unit,
            'signer_institution' => $document->signer->institution,

            'sha256_hash' => $sha256Hash,
            'signed_at' => now(),
            'status' => 'PUBLISHED',

            'revoked_at' => null,
            'revocation_reason' => null,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with(
                'success',
                'Dokumen berhasil diterbitkan.'
            );
    }

    public function revokeForm(Document $document)
    {
        if ($document->status !== 'PUBLISHED') {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Hanya dokumen yang sudah diterbitkan yang dapat dicabut.'
                );
        }

        return view(
            'documents.revoke',
            compact('document')
        );
    }

    public function revoke(Request $request, Document $document)
    {
        if ($document->status !== 'PUBLISHED') {
            return redirect()
                ->route('documents.show', $document)
                ->with(
                    'error',
                    'Hanya dokumen yang sudah diterbitkan yang dapat dicabut.'
                );
        }

        $validated = $request->validate([
            'revocation_reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
        ], [
            'revocation_reason.required' =>
                'Alasan pencabutan wajib diisi.',

            'revocation_reason.min' =>
                'Alasan pencabutan minimal 10 karakter.',

            'revocation_reason.max' =>
                'Alasan pencabutan maksimal 1000 karakter.',
        ]);

        $document->update([
            'status' => 'REVOKED',
            'revoked_at' => now(),
            'revocation_reason' =>
                $validated['revocation_reason'],
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with(
                'success',
                'Dokumen berhasil dicabut.'
            );
    }

    public function verifyFileForm()
    {
        return view('verification.upload');
    }

    public function verifyFile(Request $request)
    {
        $request->validate([
        'pdf' => 'required|file|mimes:pdf',
        ]);

        $hash = hash_file(
            'sha256',
            $request->file('pdf')->getRealPath()
        );

        $document = Document::where('sha256_hash', $hash)->first();

        $status = 'not_found';

        if ($document) {

            if ($document->status === 'published') {
                $status = 'published';
            } elseif ($document->status === 'revoked') {
                $status = 'revoked';
            } else {
                $status = 'draft';
            }

        }

        return view('verification.file-result', [
            'document' => $document,
            'hash' => $hash,
            'status' => $status,
        ]);
    }

    public function downloadVerifiedPdf($token)
    {
        $document = Document::where(
            'verification_token',
            $token
        )->first();

        // Token tidak ditemukan
        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        if ($document->status === 'DRAFT') {

            return redirect()
                ->route('verification.show', $token)
                ->with(
                    'warning',
                    'Dokumen belum diterbitkan sehingga PDF Final belum tersedia.'
                );

        }

        if ($document->status === 'REVOKED') {

            return redirect()
                ->route('verification.show', $token)
                ->with(
                    'error',
                    'Dokumen telah dicabut sehingga PDF Final tidak dapat diunduh.'
                );

        }

        $disk = Storage::disk('local');

        if ($disk->missing($document->final_pdf_path)) {

            abort(
                404,
                'File PDF Final tidak ditemukan.'
            );
        }

        return $disk->download(
            $document->final_pdf_path,
            basename($document->final_pdf_path)
        );
    }

    public function qrEditor(Document $document)
    {
        return view('documents.qr-editor', compact('document'));
    }

    public function saveQrPosition(Request $request, Document $document)
    {
        $request->validate([
            'page'   => 'required|integer|min:1',
            'x'      => 'required|numeric|between:0,1',
            'y'      => 'required|numeric|between:0,1',
            'width'  => 'required|numeric|between:0,1',
            'height' => 'required|numeric|between:0,1',
        ]);

        DocumentQrPosition::updateOrCreate(

        [
            'document_id' => $document->id,
            'page_number' => $request->page,
            'sort_order' => 1,
        ],

        [
            'position_x' => $request->x,
            'position_y' => $request->y,
            'width' => $request->width,
            'height' => $request->height,
        ]

    );

        return response()->json([
            'success' => true,
            'message' => 'Posisi QR berhasil disimpan.'
        ]);
    }

}
