<?php

namespace App\Controller\Patient;

use App\Message\Patient as MessagePatient;
use App\Repository\PatientRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ListPatientController extends AbstractController
{
    public function __construct(private PatientRepository $patientRepository)
    {
    }

    #[Route('/api/patients', name: 'patient_list', methods: ['GET'])]
    #[OA\Tag(name: 'Patients')]
    #[OA\Get(
        summary: 'Liste des patients avec pagination',
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', schema: new OA\Schema(type: 'integer', default: 1, minimum: 1)),
            new OA\Parameter(name: 'limit', in: 'query', schema: new OA\Schema(type: 'integer', default: 5, minimum: 1)),
            new OA\Parameter(name: 'search', in: 'query', schema: new OA\Schema(type: 'string', default: ''))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des patients',
                content: new OA\JsonContent(
                    required: ['patients', 'pagination'],
                    properties: [
                        new OA\Property(
                            property: 'patients',
                            type: 'array',
                            items: new OA\Items(
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
                        ),
                        new OA\Property(
                            property: 'pagination',
                            properties: [
                                new OA\Property(property: 'currentPage', type: 'integer'),
                                new OA\Property(property: 'limit', type: 'integer'),
                                new OA\Property(property: 'totalItems', type: 'integer'),
                                new OA\Property(property: 'totalPages', type: 'integer')
                            ],
                            type: 'object'
                        )
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function __invoke(
        #[MapQueryParameter(name: 'page', filter: FILTER_VALIDATE_INT)] ?int $page,
        #[MapQueryParameter(name: 'limit', filter: FILTER_VALIDATE_INT)] ?int $limit,
        #[MapQueryParameter(name: 'search')] ?string $search,
        MessageBusInterface $messageBus
    ): JsonResponse {
        $page = $page ?? 1;
        $limit = $limit ?? 5;
        $search = $search ?? '';

        $patients = $this->patientRepository->paginatePatients($search, $page, $limit);

        $paginationInfo = [
            'currentPage' => $page,
            'limit' => $limit,
            'totalItems' => count($patients),
            'totalPages' => ceil(count($patients) / $limit),
        ];

        $messageBus->dispatch(new MessagePatient(1));

        return $this->json([
            'patients' => iterator_to_array($patients),
            'pagination' => $paginationInfo,
        ]);
    }
}
