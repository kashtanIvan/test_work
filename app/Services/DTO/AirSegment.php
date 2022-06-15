<?php
declare(strict_types=1);

namespace App\Services\DTO;

use Carbon\Carbon;

class AirSegment
{
    const FIRST_ELEMENT = 'first';
    const MIDDLE_ELEMENT = 'middle';
    const LAST_ELEMENT = 'last';

    /** @var string $boardCity */
    private $boardCity;

    /** @var string $boardPoint */
    private $boardPoint;

    /** @var string $offCity */
    private $offCity;

    /** @var string $offPoint */
    private $offPoint;

    /** @var Carbon $departureDate */
    private $departureDate;

    /** @var Carbon $arrivalDate */
    private $arrivalDate;

    private $spentHoursInOffCity = 0;
    private $isBreakPoint = false;
    private $position;

    /**
     * AirSegment constructor.
     */
    public function __construct(array $params)
    {
        $this->boardCity = $this->getCityFromParam($params['Board']['@attributes']['City']);
        $this->boardPoint = $params['Board']['@attributes']['Point'];
        $this->offCity = $this->getCityFromParam($params['Off']['@attributes']['City']);
        $this->offPoint = $params['Off']['@attributes']['Point'];
        $this->departureDate = Carbon::createFromTimeString("{$params['Departure']['@attributes']['Date']} {$params['Departure']['@attributes']['Time']}");
        $this->arrivalDate = Carbon::createFromTimeString("{$params['Arrival']['@attributes']['Date']} {$params['Arrival']['@attributes']['Time']}");
    }

    public function getPieceRoundTripMessage(): string
    {
        return match ($this->position) {
            self::FIRST_ELEMENT => $this->getBoardCity() . ' - ' . $this->getOffCity() . ' - ',
            self::MIDDLE_ELEMENT => $this->getOffCity() . ' - ',
            self::LAST_ELEMENT => $this->getOffCity()
        };
    }

    /**
     * @param $string
     * @return string
     */
    private function getCityFromParam($string)
    {
        $city = explode('/', $string);
        return $city[0];
    }

    /**
     * @return string
     */
    public function getBoardCity(): string
    {
        return $this->boardCity;
    }

    /**
     * @return string
     */
    public function getBoardPoint(): string
    {
        return $this->boardPoint;
    }

    /**
     * @return string
     */
    public function getOffCity(): string
    {
        return $this->offCity;
    }

    /**
     * @return string
     */
    public function getOffPoint(): string
    {
        return $this->offPoint;
    }

    /**
     * @return Carbon
     */
    public function getDepartureDate(): Carbon
    {
        return $this->departureDate;
    }

    /**
     * @return Carbon
     */
    public function getArrivalDate(): Carbon
    {
        return $this->arrivalDate;
    }

    /**
     * @return int
     */
    public function getSpentHoursInOffCity(): int
    {
        return $this->spentHoursInOffCity;
    }

    /**
     * @param int $spentHoursInOffCity
     */
    public function setSpentHoursInOffCity(int $spentHoursInOffCity): void
    {
        $this->spentHoursInOffCity = $spentHoursInOffCity;
    }

    /**
     * @return bool
     */
    public function getIsBreakPoint(): bool
    {
        return $this->isBreakPoint;
    }

    /**
     * @param bool $isBreakPoint
     */
    public function setIsBreakPoint(bool $isBreakPoint): void
    {
        $this->isBreakPoint = $isBreakPoint;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }
}
