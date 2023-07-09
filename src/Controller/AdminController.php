<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/vehicule/update/{id}', name:"admin_vehicule_update")]
    #[Route('/admin/vehicule/new', name:"admin_vehicule_new")]
    public function formVehicule(Request $request, EntityManagerInterface $manager, VehiculeRepository $repo, $id = null)
    {
        if($id == null)
        {
            $vehicule = new Vehicule;
        }else{
            $vehicule = $repo->find($id);
        }


        $form = $this->createForm(VehiculeType::class, $vehicule);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $vehicule->setDateEnregistrement(new \DateTime);
            $manager->persist($vehicule);
            $manager->flush();
            return $this->redirectToRoute('app_admin');

        }

        return $this->render('admin/formVehicule.html.twig',[
            'form' => $form,
            'editMode' => $vehicule->getIdVehicule()!=null
        ]);
    }

    #[Route("/admin/vehicule/gestion", name:"admin_vehicule_gestion")]
    public function gestionVehicule(VehiculeRepository $repo)
    {
        $vehicules = $repo->findAll();
        return $this->render('admin/gestionVehicule.html.twig' , [
            'vehicules' => $vehicules
        ]);
    }

    #[Route('/admin/vehicule/delete/{id}', name: 'admin_vehicule_delete')]
    public function deleteVehicule(Vehicule $vehicule, EntityManagerInterface $manager)
    {
        $manager->remove($vehicule);
        $manager->flush();
        return $this->redirectToRoute('admin_vehicule_gestion');
    }

    #[Route('/admin/user/update/{id}', name:"admin_user_update")]
    #[Route('/admin/user/new', name:"admin_user_new")]
    public function formUser(Request $request, EntityManagerInterface $manager, UserRepository $repo, $id = null)
    {
        if($id == null)
        {
            $user = new User;
        }else{
            $user = $repo->find($id);
        }


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setDateEnregistrement(new \DateTime);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_admin');

        }

        return $this->render('admin/formUser.html.twig',[
            'form' => $form,
            'editMode' => $user->getId()!=null
        ]);
    }

    #[Route("/admin/user/gestion", name:"admin_user_gestion")]
    public function gestionUser(UserRepository $repo)
    {
        $users = $repo->findAll();
        return $this->render('admin/gestionUser.html.twig' , [
            'users' => $users
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
    public function deleteUser(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('admin_user_gestion');
    }

    #[Route("/admin/commande/gestion", name:"admin_commande_gestion")]
    public function gestionCommande(CommandeRepository $repo)
    {
        $commandes = $repo->findAll();
        return $this->render('admin/gestionCommande.html.twig' , [
            'commandes' => $commandes
        ]);
    }
}
