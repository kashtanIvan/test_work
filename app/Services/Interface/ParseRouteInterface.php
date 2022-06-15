<?php
declare(strict_types=1);

namespace App\Services\Interface;

use App\Http\Requests\Api\JourneyRequest;
use App\Services\DTO\AirSegment;
use Illuminate\Support\Collection;

interface ParseRouteInterface
{
    /**
     * @param JourneyRequest $request
     * @return \Illuminate\Support\Collection<AirSegment>
     */
    public function parseFile(JourneyRequest $request): Collection;
}
