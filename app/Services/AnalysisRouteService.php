<?php
declare(strict_types=1);

namespace App\Services;

use App\Services\DTO\AirSegment;
use App\Services\DTO\City;
use Illuminate\Support\Collection;

/**
 * Class AnalysisRouteService
 * @package App\Services
 */
class AnalysisRouteService
{
    private $cityCollection;

    /**
     * AnalysisRouteService constructor.
     */
    public function __construct()
    {
        $this->cityCollection = collect();
    }

    /**
     * @param Collection $airSegments
     * @return Collection
     */
    public function parseCities(Collection $airSegments): Collection
    {
        $airSegments->each(function (AirSegment $segment) {
            /** @var City $lastCity */
            $lastCity = $this->cityCollection->last();
            if (!is_null($lastCity)) {
                if ($lastCity->getName() !== $segment->getBoardCity()) {
                    $lastCity->setIsBreakingPoint(true);
                    $boardCity = new City($segment->getBoardCity(), $segment->getDepartureDate());
                    $this->cityCollection->push($boardCity);
                }
                $lastCity->setHours($segment->getArrivalDate()->diffInHours($lastCity->getDate()));
                $offCity = new City($segment->getOffCity(), $segment->getArrivalDate());
            } else {
                $boardCity = new City($segment->getBoardCity(), $segment->getDepartureDate());
                $offCity = new City($segment->getOffCity(), $segment->getArrivalDate());
                $this->cityCollection->push($boardCity);
            }
            $this->cityCollection->push($offCity);
        });
        return $this->cityCollection;
    }
}
