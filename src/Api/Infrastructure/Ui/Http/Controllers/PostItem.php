<?php

declare(strict_types=1);

namespace App\Api\Infrastructure\Ui\Http\Controllers;

use App\Api\Application\Commands\PostItemTransformToCommand;
use App\Api\Domain\Exceptions\ItemParameterNotFound;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostItem extends AbstractController
{
    public function __invoke(Request $request)
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
}
