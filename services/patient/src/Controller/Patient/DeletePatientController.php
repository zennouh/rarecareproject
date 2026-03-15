<?php

namespace App\Controller\Patient;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class DeletePatientController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/api/patients/{id}', name: 'patient_delete', methods: ['DELETE'], requirements: ['id' => '\\d+'])]
    #[OA\Tag(name: 'Patients')]
    #[OA\Delete(
        summary: 'Supprimer un patient',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Patient supprime',
                content: new OA\JsonContent(
                    required: ['message'],
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Patient supprime avec succes')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(response: 404, description: 'Patient non trouve')
        ]
    )]
    public function __invoke(#[MapEntity(message: 'Patient non trouve')] Patient $patient): JsonResponse
    {
        $this->entityManager->remove($patient);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Patient supprimé avec succès',
        ]);
    }
}
