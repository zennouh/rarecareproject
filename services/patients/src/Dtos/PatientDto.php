<?php

namespace App\Dtos;

use Symfony\Component\Validator\Constraints as Assert;

class PatientDto
{
    public function __construct(

        #[
            Assert\Length(
                min: 2,
                max: 255,
                minMessage: 'Le nom du patient doit comporter au moins {{ limit }} caractères',
                maxMessage: 'Le nom du patient ne peut pas dépasser {{ limit }} caractères',
                groups: ['create']
            ),
            Assert\NotBlank(message: 'Le nom du patient est obligatoire', groups: ['create'])
        ]

        public string $name,
        #[Assert\NotBlank(message: 'Le sexe du patient est obligatoire', groups: ['create'])]
        #[Assert\Choice(choices: [0, 1], message: 'Le sexe du patient doit être 0 (femme) ou 1 (homme)', groups: ['create'])]
        public int $sexe,

        #[Assert\NotBlank(message: 'La date de naissance du patient est obligatoire', groups: ['create'])]
        #[Assert\Date(message: 'La date de naissance du patient n\'est pas valide', groups: ['create'])]
        public string $birthday,

        #[Assert\NotBlank(message: 'LID de lutilisateur est obligatoire', groups: ['create'])]
        public int $userId,
        #[Assert\NotBlank(message: 'Le nom de la recherche est obligatoire', groups: ['create'])]
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Le nom de la recherche doit comporter au moins {{ limit }} caractères',
            maxMessage: 'Le nom de la recherche ne peut pas dépasser {{ limit }} caractères',
            groups: ['create']
        )]
        public string $seekName,
        #[Assert\NotBlank(message: 'La ville est obligatoire', groups: ['create'])]
        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'La ville doit comporter au moins {{ limit }} caractères',
            maxMessage: 'La ville ne peut pas dépasser {{ limit }} caractères',
            groups: ['create']
        )]
        public string $city
    ) {}
}
