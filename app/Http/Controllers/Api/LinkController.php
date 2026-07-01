<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Resources\LinkResource;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;

class LinkController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    public function store(StoreLinkRequest $request): JsonResponse
    {
        $link = $this->linkService->createShortLink(
            $request->validated('original_url'),
            auth()->check() ? auth()->id() : null
        );

        return response()->json([
            'data' => new LinkResource($link),
            'message' => 'Short link created successfully.'
        ], 201);
    }
}