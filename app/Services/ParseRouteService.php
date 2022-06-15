<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Api\JourneyRequest;
use App\Services\DTO\AirSegment;
use App\Services\Interface\ParseRouteInterface;
use Illuminate\Support\Collection;

class ParseRouteService implements ParseRouteInterface
{
    private $airSegmentCollect;

    /**
     * ParseRouteService constructor.
     */
    public function __construct()
    {
        $this->airSegmentCollect = collect();
    }

    /**
     * @param JourneyRequest $request
     * @return Collection <AirSegment>
     */
    public function parseFile(JourneyRequest $request): Collection
    {
        $file = json_encode(simplexml_load_string($request->file->get()));
        $file = (json_decode($file, true));
        foreach ($file['AirSegments']['AirSegment'] as $params) {
            $air = new AirSegment($params);
            $this->airSegmentCollect->push($air);
        }
        return $this->airSegmentCollect->sortBy(fn ($item) => $item->getDepartureDate());
    }
}
