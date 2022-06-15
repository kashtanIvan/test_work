<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\DTO\City;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JourneyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $maxHours = $this->resource->max(fn ($item) => $item->getHours());
        $endPoint = $this->resource->first(fn ($item) => $item->getHours() == $maxHours);
        return [
            'endPoint' => $endPoint->getName(),
            'round_trip' => $this->getRoundTrip()
        ];
    }

    /**
     * @return string
     */
    private function getRoundTrip(): string
    {
        $result = '';
        $breakPoints = [];
        $countElement = $this->resource->count() - 1;
        $this->resource->each(function ($item, $key) use (&$result, &$breakPoints, $countElement) {
            /** @var City $item */
            if ($item->isBreakingPoint()) {
                $result .= ' - ' . $item->getName() . ' back ';
                $breakPoints[] = $item->getName();
            } else {
                $hasBreakingNext = $this->resource->get($key+1);
                $hasBreakingNext = !is_null($hasBreakingNext) && $hasBreakingNext->isBreakingPoint();
                $result .= $item->getName() . ($countElement == $key || $hasBreakingNext ? '' :' - ') ;
            }
        });
        if (count($breakPoints)) {
            $result .= ' ' . implode(', ', $breakPoints) . ' - Breaking Point';
        }
        return $result;
    }
}
