<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Ui\Http\Controllers;

use App\Api\Application\Commands\PostItemTransformToCommand;
use App\Api\Application\Queries\GetCartQuery;
use App\Api\Application\Queries\GetCartResponse;
use App\Api\Domain\Exceptions\ItemNotExistException;
use App\Api\Domain\Exceptions\ItemParameterNotFound;
use App\Machine\Application\Commands\ChargeCommand;
use App\Machine\Application\Commands\InsertCoinCommand;
use App\Machine\Application\Commands\ReturnWalletCommand;
use App\Machine\Application\Commands\ReturnWalletResponse;
use App\Machine\Application\Commands\SelectItemCommand;
use App\Machine\Application\Commands\SelectItemResponse;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Constraints\Json;

class ApiController extends AbstractController
{
    public function getCart(Request $request)
    {
        $request = new GetCartQuery(Uuid::fromString($request->get('cart_id')));
        $envelope = $this->dispatchMessage($request);
        /** @var GetCartResponse $response */
        $response = $envelope->last(HandledStamp::class)->getResult();
        if ($response->getErrorCode() > 0) {
            return new JsonResponse([], $response->getErrorCode());
        }

        return new JsonResponse($response->getResponse());
    }

    public function postItem(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        try {
            $command = PostItemTransformToCommand::transform($content);
        } catch (ItemParameterNotFound $e) {
            return new JsonResponse([], response::HTTP_BAD_REQUEST);
        }

        $this->dispatchMessage($command);

        return new JsonResponse([], response::HTTP_CREATED);
    }

    public function insertCoin(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        //return new JsonResponse($this->getParameter('machine.id'));
        $command = new InsertCoinCommand(
            Uuid::fromString($this->getParameter('machine.id')),
            $content['coin005'],
            $content['coin010'],
            $content['coin025'],
            $content['coin100']
        );
        $this->dispatchMessage($command);
        return new JsonResponse(['menssage' => 'Success']);
    }

    public function returnWallet()
    {
        $command = new ReturnWalletCommand(Uuid::fromString($this->getParameter('machine.id')));
        $envelope = $this->dispatchMessage($command);

        /** @var ReturnWalletResponse $returnWalletResponse */
        $returnWalletResponse = $envelope->last(HandledStamp::class)->getResult();

        $response = [
            'Amount' => number_format($returnWalletResponse->getTotalAmount()/100,2),
            'coin005' => $returnWalletResponse->getCoin005(),
            'coin010' => $returnWalletResponse->getCoin010(),
            'coin025' => $returnWalletResponse->getCoin025(),
            'coin100' => $returnWalletResponse->getCoin100()
        ];

        return new JsonResponse($response);
    }

    public function selectItem(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $command = new SelectItemCommand(
            Uuid::fromString($this->getParameter('machine.id')),
            $content['position']
        );

        $envelope = $this->dispatchMessage($command);
        /** @var SelectItemResponse $selectItemResponse */
        $selectItemResponse = $envelope->last(HandledStamp::class)->getResult();

        return new JsonResponse(['message' => $selectItemResponse->getMessage()], $selectItemResponse->getStatus());
    }

    public function charge(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $command = new ChargeCommand(
            Uuid::fromString($this->getParameter('machine.id')),
            (int)$content['coin005'],
            (int)$content['coin010'],
            (int)$content['coin025'],
            (int)$content['coin100'],
            (int)$content['stock01'],
            (int)$content['stock02'],
            (int)$content['stock03']
        );
        $this->dispatchMessage($command);

        return new JsonResponse("Ok");
    }
}