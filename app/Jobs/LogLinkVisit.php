<?php

namespace App\Jobs;

use App\Models\Link;
use App\Repositories\LinkVisitRepositoryInterface;
use App\Repositories\LinkRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogLinkVisit implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Link $link,
        public ?string $ipAddress
    ) {}

    public function handle(
        LinkVisitRepositoryInterface $visitRepository,
        LinkRepositoryInterface $linkRepository
    ): void {
        $visitRepository->logVisit($this->link->id, $this->ipAddress);
        $linkRepository->incrementClicks($this->link);
    }
}
