<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service/index", name="service_index")
     * methods={"GET"},
     * 
     */
    public function getService(ServiceRepository $servicerepos)
    {
        $service = $servicerepos->findBy(['statut'=>true]);
        dd($service);
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }


/**
     * @Route("/service/create", name="service_create")
     */
    public function createService(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $service = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $service -> setStatut(true);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();
            return $this->render('service/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $service->getNom()
            ]);
        }
        return $this->render('service/create_service.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

}
