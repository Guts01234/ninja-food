<?php

namespace App\Repositories;

use App\Models\Link;

interface LinkRepositoryInterface
{
    public function create(array $data): Link;
    public function findByShortCode(string $code): ?Link;
    public function incrementClicks(Link $link): void;
}