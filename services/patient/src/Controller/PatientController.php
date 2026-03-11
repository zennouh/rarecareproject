<?php

namespace App\Controller;

use App\Dtos\PatientDto as DtosPatientDto;
use App\Entity\Patient;
use App\Message\Patient as MessagePatient;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use PatientDto;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/patients')]
final class PatientController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PatientRepository $patientRepository
    ) {}


    #[Route('', name: 'patient_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(validationGroups: ['create'])] DtosPatientDto $patientDto
    ): JsonResponse {
        $patient = new Patient();
        $patient->setName($patientDto->name);
        $patient->setSexe($patientDto->sexe);
        $patient->setBirthday($patientDto->birthday);
        $patient->setUserId($patientDto->userId);
        $patient->setSeekName($patientDto->seekName);
        $patient->setCity($patientDto->city);


        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Patient créé avec succès',
            'patient' => $patient
        ], 201);
    }


    #[Route('', name: 'patient_list', methods: ['GET'])]
    public function list(
        #[MapQueryParameter(name: 'page', filter: FILTER_VALIDATE_INT)] ?int $page,
        #[MapQueryParameter(name: 'limit', filter: FILTER_VALIDATE_INT)] ?int $limit,
        #[MapQueryParameter(name: 'search')] ?string $search,
        MessageBusInterface $messageBus,
    ): JsonResponse {
        $page = $page ?? 2;
        $limit = $limit ?? 5;
        $search = $search ?? '';
        $patients = $this->patientRepository->paginatePatients($search, $page, $limit);
        $paginationInfo = [
            'currentPage' => $page,
            'limit' => $limit,
            'totalItems' => count($patients),
            'totalPages' => ceil(count($patients) / $limit)
        ];

        $messageBus->dispatch(new MessagePatient(1));

        return $this->json([
            'patients' => iterator_to_array($patients),
            'pagination' => $paginationInfo
        ]);
    }


    #[Route(
        '/{id}',
        name: 'patient_show',
        methods: ['GET'],
        requirements: ['id' => '\d+']
    )]
    public function show(#[MapEntity(message: 'Patient non trouvé')] Patient $patient): JsonResponse
    {
        if (!$patient) {
            return $this->json(['error' => 'Patient non trouvé'], 404);
        }

        return $this->json([
            'patient' => $patient
        ]);
    }


    #[Route(
        '/{id}',
        name: 'patient_update',
        methods: ['PUT'],
        requirements: ['id' => '\d+']
    )]
    public function update(
        #[MapEntity(message: 'Patient non trouvé')] Patient $patient,
        #[MapRequestPayload] DtosPatientDto $patientDto
    ): JsonResponse {

        if (isset($patientDto->name)) {
            $patient->setName($patientDto->name);
        }
        if (isset($patientDto->sexe)) {
            $patient->setSexe($patientDto->sexe);
        }
        if (isset($patientDto->birthday)) {
            $patient->setBirthday($patientDto->birthday);
        }
        if (isset($patientDto->userId)) {
            $patient->setUserId($patientDto->userId);
        }
        if (isset($patientDto->seekName)) {
            $patient->setSeekName($patientDto->seekName);
        }
        if (isset($patientDto->city)) {
            $patient->setCity($patientDto->city);
        }

        $this->entityManager->flush();

        return $this->json([
            'message' => 'Patient modifié avec succès',
            'patient' => $patient
        ], 200);
    }


    #[Route('/{id}', name: 'patient_delete', methods: ['DELETE'])]
    public function delete(#[MapEntity(message: 'Patient non trouvé')] Patient $patient): JsonResponse
    {

        $this->entityManager->remove($patient);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Patient supprimé avec succès'
        ], 200);
    }
}
