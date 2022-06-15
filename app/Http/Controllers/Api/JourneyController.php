<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\JourneyRequest;
use App\Http\Resources\JourneyCollection;
use App\Services\AnalysisRouteService;
use App\Services\ParseRouteService;

class JourneyController extends BaseController
{
    private ParseRouteService $parseRouteService;
    private AnalysisRouteService $analysisRouteService;

    /**
     * JourneyController constructor.
     */
    public function __construct(ParseRouteService $parseRouteService, AnalysisRouteService $analysisRouteService)
    {
        $this->parseRouteService = $parseRouteService;
        $this->analysisRouteService = $analysisRouteService;
    }

    /**
     * @param JourneyRequest $request
     * @return JourneyCollection
     */
    public function index(JourneyRequest $request): JourneyCollection
    {
        $airSegments = $this->parseRouteService->parseFile($request);
        return new JourneyCollection($this->analysisRouteService->parseCities($airSegments));
    }
}
