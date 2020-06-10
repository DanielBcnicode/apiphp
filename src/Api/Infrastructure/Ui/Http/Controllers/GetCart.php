<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Ui\Http\Controllers;

use App\Api\Application\Queries\GetCartQuery;
use App\Api\Application\Queries\GetCartResponse;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetCart extends AbstractController
{
    public function __invoke(Request $request)
    {
        if (!Uuid::isValid($request->get('cart_id'))) {
            return new JsonResponse([], response::HTTP_BAD_REQUEST);
        }
        $request = new GetCartQuery(Uuid::fromString($request->get('cart_id')));
        $envelope = $this->dispatchMessage($request);
        /** @var GetCartResponse $response */
        $response = $envelope->last(HandledStamp::class)->getResult();
        if ($response->getErrorCode() > 0) {
            return new JsonResponse([], $response->getErrorCode());
        }

        return new JsonResponse($response->getResponse());
    }
}
