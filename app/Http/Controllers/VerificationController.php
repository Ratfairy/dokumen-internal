<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Menampilkan informasi verifikasi berdasarkan token.
     */
    public function show(string $token): View
    {
        $document = Document::query()
            ->with('signer')
            ->where('verification_token', $token)
            ->firstOrFail();

        return view(
            'verification.show',
            compact('document')
        );
    }
}