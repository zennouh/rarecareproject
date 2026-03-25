<?php

namespace App\Controller\Patient;

use App\Entity\Patient;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ShowPatientController extends AbstractController
{
    #[Route('/api/patients/{id}', name: 'patient_show', methods: ['GET'], requirements: ['id' => '\\d+'])]
    #[OA\Tag(name: 'Patients')]
    #[OA\Get(
        summary: 'Afficher un patient',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Patient trouve',
                content: new OA\JsonContent(
                    required: ['patient'],
                    properties: [
                        new OA\Property(
                            property: 'patient',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'Alice Doe'),
                                new OA\Property(property: 'sexe', type: 'integer', example: 1),
                                new OA\Property(property: 'birthday', type: 'string', format: 'date-time', example: '1995-08-22T00:00:00+00:00'),
                                new OA\Property(property: 'userId', type: 'integer', example: 7),
                                new OA\Property(property: 'seekName', type: 'string', example: 'Alice profile'),
                                new OA\Property(property: 'city', type: 'string', example: 'Paris'),
                                new OA\Property(property: 'age', type: 'integer', nullable: true, example: 30)
                            ]
                        )
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(response: 404, description: 'Patient non trouve')
        ]
    )]
    public function __invoke(#[MapEntity(message: 'Patient non trouve')] Patient $patient): JsonResponse
    {
        return $this->json([
            'patient' => $patient,
        ]);
    }
}
