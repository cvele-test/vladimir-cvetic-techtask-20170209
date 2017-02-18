<?php

namespace App\Controllers;

use App\Services\LunchService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Response\Serializer;

class LunchController
{
    /**
     * @var LunchService
     */
    protected $lunchService;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @param LunchService $lunchService
     * @param Serializer   $serializer
     */
    public function __construct(LunchService $lunchService, Serializer $serializer)
    {
        $this->lunchService = $lunchService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function lunch(Request $request): Response
    {
        $ingredients = $this->getDataFromRequest($request);
        $recipes = $this->lunchService->findLunchOptions($ingredients);

        $response = new Response();
        $response->setContent($this->serializer->serialize($recipes, true));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * fetches ingredient data from request.
     *
     * @param Request $request
     *
     * @return array
     */
    private function getDataFromRequest(Request $request): array
    {
        if ($request->getMethod() == 'GET') {
            $requestBase = $request->query;
        } else {
            $requestBase = $request->request;
        }

        return $requestBase->get('ingredient');
    }
}
