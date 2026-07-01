<?php

namespace App\Repositories;

use App\Models\LinkVisit;

class LinkVisitRepository implements LinkVisitRepositoryInterface
{
    public function logVisit(int $linkId, ?string $ipAddress): LinkVisit
    {
        return LinkVisit::create([
            'link_id' => $linkId,
            'ip_address' => $ipAddress,
        ]);
    }
}