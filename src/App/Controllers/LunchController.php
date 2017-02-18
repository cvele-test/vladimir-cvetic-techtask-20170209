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
     */
    public function __construct(LunchService $lunchService, Serializer $serializer)
    {
        $this->lunchService = $lunchService;
        $this->serializer = $serializer;
    }

    /**
     * @param  Request      $request
     * @return Response
     */
    public function lunch(Request $request): Response
    {
        $ingredients = $request->query->get("ingredient");
        $recipes = $this->lunchService->findLunchOptions($ingredients);

        $response = new Response();
        $response->setContent($this->serializer->serialize($recipes, true));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function getDataFromRequest(Request $request): array
    {
        return [
            "ingredients" => $request->request->get("ingredient")
        ];
    }
}
