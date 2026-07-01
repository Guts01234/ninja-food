<?php

namespace App\Repositories;

use App\Models\LinkVisit;

interface LinkVisitRepositoryInterface
{
    public function logVisit(int $linkId, ?string $ipAddress): LinkVisit;
}