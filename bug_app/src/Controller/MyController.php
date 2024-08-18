<?php

namespace App\Controller;

use App\Dto\DtoImpl;
use App\Dto\Wrapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MyController extends AbstractController
{
    #[Route('/', name: 'bug')]
    public function index(SerializerInterface $serializer): Response
    {
        $json = '{ "dto": { "id": 1 }}';
        $className = Wrapper::class . '<' . DtoImpl::class . '>';

        /** @var Wrapper<DtoImpl> $result */
        $result = $serializer->deserialize($json, $className, 'json');

        $id = $result->dto->id;

        return new Response($id, 200);
    }
}