<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    public function __invoke(string $shortCode, Request $request)
    {
        $originalUrl = $this->linkService->processVisit($shortCode, $request->ip());

        if (!$originalUrl) {
            abort(404);
        }

        return redirect()->away($originalUrl);
    }
}