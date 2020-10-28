<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\HopitalType;
use App\Repository\UserRepository;
use App\Repository\HopitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HopitalController extends AbstractController
{
    /**
     * @Route("/hopital/index", name="hopital_index")
     * methods={"GET"},
     * is_granted('ROLE_ADMIN')
     */
    public function getHopital(HopitalRepository $hopitalrepos)
    {
        $hopital = $hopitalrepos->findBy(['statut'=>true]);
        foreach($hopital as $key=>$value){
            $hopital = ["key"=>"value"];

            return $this->render('hopital/index.html.twig', [
                'controller_name' => 'HopitalController',
            ]);
        }
    }


    /**
     * @Route("/hopital/update", name="hopital_update")
     * methods={"POST"},
     * is_granted('ROLE_ADMIN')
     */
    public function updateHopital(HopitalRepository $hopitalrepos, $id)
    {
        $hopital = $hopitalrepos->findOneById($id);
            return $this->render('hopital/update_hopital.html.twig', [
                'controller_name' => 'HopitalController',
            ]);
    }
    
     /**
     * @Route("/hopital/create", name="hopital_create")
     * methods={"POST"},
     * is_granted('ROLE_ADMIN')
     */
    public function createHopital(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $hopital = new Hopital();

        $form = $this->createForm(HopitalType::class, $hopital);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $hopital = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $user = $this->get('security.token_storage')->getToken()->getUser();
            // $hopital -> setUser($user);
            $hopital -> setStatut(true);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hopital);
            $manager->flush();
            return $this->render('hopital/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $hopital->getNom()
            ]);
        }
        return $this->render('hopital/create_hopital.html.twig', [
            'form' => $form->createView()
        ]);
        
    }


    /**
     * @Route("/hopital/index", name="hopital_user")
     * methods={"GET"},
     * is_granted('ROLE_ADMIN')
     */
    public function getHopitalByUser(HopitalRepository $hopitalrepos, UserRepository $userrepos, $id)
    {
        $user = $userrepos->findBy(['user_id'=>$id]);
        $hopital = $hopitalrepos->findBy(['statut'=>true]);
        dd($user);
        return $this->render('hopital/index.html.twig', [
            'controller_name' => 'HopitalController',
        ]);
    }
}
