<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'short_code' => $this->short_code,
            'short_url' => url('/' . $this->short_code),
            'clicks_count' => $this->clicks_count,
            'created_at' => $this->created_at,
        ];
    }
}