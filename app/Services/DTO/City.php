<?php
declare(strict_types=1);

namespace App\Services\DTO;

use Carbon\Carbon;

class City
{
    /** @var string $name */
    private string $name;

    /** @var int $hours */
    private int $hours = 0;

    /** @var bool $isBreakingPoint */
    private bool $isBreakingPoint = false;

    /**
     * @var Carbon|null $date
     */
    private ?Carbon $date;

    /**
     * City constructor.
     * @param $name
     * @param $date
     */
    public function __construct($name, $date)
    {
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return $this->hours;
    }

    /**
     * @param int $hours
     */
    public function setHours(int $hours): void
    {
        $this->hours = $hours;
    }

    /**
     * @return bool
     */
    public function isBreakingPoint(): bool
    {
        return $this->isBreakingPoint;
    }

    /**
     * @param bool $isBreakingPoint
     */
    public function setIsBreakingPoint(bool $isBreakingPoint): void
    {
        $this->isBreakingPoint = $isBreakingPoint;
    }

    /**
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon|null $date
     */
    public function setDate(?Carbon $date): void
    {
        $this->date = $date;
    }
}
