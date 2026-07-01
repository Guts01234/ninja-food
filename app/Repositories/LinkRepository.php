<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository implements LinkRepositoryInterface
{
    public function create(array $data): Link
    {
        return Link::create($data);
    }

    public function findByShortCode(string $code): ?Link
    {
        return \Illuminate\Support\Facades\Cache::remember(
            "link_short_code:{$code}",
            now()->addDays(7),
            fn () => Link::where('short_code', $code)->first()
        );
    }

    public function incrementClicks(Link $link): void
    {
        $link->increment('clicks_count');
    }
}