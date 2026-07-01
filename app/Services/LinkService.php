<?php

namespace App\Services;

use App\Models\Link;
use App\Repositories\LinkRepositoryInterface;
use App\Repositories\LinkVisitRepositoryInterface;
use Illuminate\Support\Str;

class LinkService
{
    public function __construct(
        protected LinkRepositoryInterface $linkRepository,
        protected LinkVisitRepositoryInterface $visitRepository
    ) {}

    public function createShortLink(string $originalUrl, ?int $userId = null): Link
    {
        $shortCode = $this->generateUniqueCode();

        return $this->linkRepository->create([
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
            'clicks_count' => 0,
        ]);
    }

    public function processVisit(string $shortCode, ?string $ipAddress): ?string
    {
        $link = $this->linkRepository->findByShortCode($shortCode);

        if (!$link) {
            return null;
        }

        // Dispatch job for tracking
        \App\Jobs\LogLinkVisit::dispatch($link, $ipAddress);

        return $link->original_url;
    }

    protected function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while ($this->linkRepository->findByShortCode($code) !== null);

        return $code;
    }
}