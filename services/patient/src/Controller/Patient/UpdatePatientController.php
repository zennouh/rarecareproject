<?php

namespace App\Controller\Patient;

use App\Dtos\PatientDto as DtosPatientDto;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class UpdatePatientController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/api/patients/{id}', name: 'patient_update', methods: ['PUT'], requirements: ['id' => '\\d+'])]
    #[OA\Tag(name: 'Patients')]
    #[OA\Put(
        summary: 'Modifier un patient',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'sexe', 'birthday', 'userId', 'seekName', 'city'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', minLength: 2, maxLength: 255, example: 'Alice Doe'),
                    new OA\Property(property: 'sexe', type: 'integer', enum: [0, 1], example: 1),
                    new OA\Property(property: 'birthday', type: 'string', format: 'date', example: '1995-08-22'),
                    new OA\Property(property: 'userId', type: 'integer', example: 7),
                    new OA\Property(property: 'seekName', type: 'string', minLength: 5, maxLength: 255, example: 'Alice profile'),
                    new OA\Property(property: 'city', type: 'string', minLength: 2, maxLength: 255, example: 'Paris')
                ],
                type: 'object'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Patient modifie',
                content: new OA\JsonContent(
                    required: ['message', 'patient'],
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Patient modifie avec succes'),
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
            new OA\Response(response: 422, description: 'Erreur de validation')
        ]
    )]
    public function __invoke(
        #[MapEntity(message: 'Patient non trouve')] Patient $patient,
        #[MapRequestPayload] DtosPatientDto $patientDto
    ): JsonResponse {
        if ($patientDto->name) {
            $patient->setName($patientDto->name);
        }

        if ($patientDto->sexe) {
            $patient->setSexe($patientDto->sexe);
        }

        if ($patientDto->birthday) {
            $patient->setBirthday($patientDto->birthday);
        }

        if ($patientDto->userId) {
            $patient->setUserId($patientDto->userId);
        }

        if ($patientDto->seekName) {
            $patient->setSeekName($patientDto->seekName);
        }

        if ($patientDto->city) {
            $patient->setCity($patientDto->city);
        }

        $this->entityManager->flush();

        return $this->json([
            'message' => 'Patient modifié avec succès',
            'patient' => $patient,
        ]);
    }
}
