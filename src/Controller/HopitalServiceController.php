<?php

namespace App\Controller;

use App\Entity\HopitalService;
use App\Form\HopitalServiceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HopitalServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HopitalServiceController extends AbstractController
{
    /**
     * @Route("/hopitalservice/index", name="hopital_service_index")
     * methods={"GET"},
     * "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SOUSADMIN')",
     * "security_message"="vous n'avez pas le droit pour faire cette action.",
     * 
     */
    public function getHopitalToService(HopitalServiceRepository $repos)
    {

        $service = $repos->findAll();
        return $this->render('hopital_service/index.html.twig', [
            'controller_name' => 'HopitalServiceController',
        ]);
    }



    /**
     * @Route("/hopitalservice/create", name="hopital_service_create")
     * "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SOUSADMIN')",
     * "security_message"="vous n'avez pas le droit pour faire cette action.",
     * 
     */
    public function createHopitalToService(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $hopitalService = new HopitalService();

        $form = $this->createForm(HopitalServiceType::class, $hopitalService);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $hopitalService = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //$hopitalService ->getId();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hopitalService);
            $manager->flush();
            return $this->render('hopital_service/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $hopitalService->getId()
            ]);
        }
        return $this->render('hopital_service/create_hopital_service.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
