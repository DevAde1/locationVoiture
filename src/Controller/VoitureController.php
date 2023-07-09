<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(): Response
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }
    #[Route('/vehicule', name: 'app_vehicules')]
    public function vehicules(VehiculeRepository $repo)
    {
        $vehicules =$repo->findAll();
        return $this->render('voiture/vehicule.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

}
