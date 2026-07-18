<?php

namespace App\Http\Resources\LabResults;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
