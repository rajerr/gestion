<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use App\Repository\HopitalServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HopitalRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin_index")
     */
    public function index(MedecinRepository $medecinrepos)
    {
        $medecins = $medecinrepos->findBy(['statut'=>true]);
        return $this->render('medecin/index.html.twig', compact('medecins'));
    }



    /**
     * @Route("/hopital/medecin", name="medecin_sous_admin")
     */
    public function getMedecinByHopital(MedecinRepository $medecinrepos, HopitalServiceRepository $repos, HopitalRepository $hopitalrepos)
    {
        $medecins = $medecinrepos->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $hopital = $hopitalrepos->findByUser($user);
        $hopitalervices = $repos->findByHopital(['statut'=>true]);
        
        // dd($hopitalervices);
        foreach($hopitalervices as $s){
            foreach($hopital as $h){
                foreach($medecins as $m){
                    if($s->getHopital()->getId() == $h->getId()){
                        if($s->getMedecin()->getUsername() == $m->getUsername()){
                            return $this->render('medecin/index.html.twig', compact('medecins'));
                        }
                    }
                }
            }
        }
        return $this->render('medecin/error.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }


     /**
     * @Route("/medecin/create", name="medecin_create")
     */
    public function create(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $medecin = new Medecin();

        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medecin = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($medecin);
            $manager->flush();
            return $this->render('succes.html.twig');
            return $this->render('medecin/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $medecin->getUsername()
            ]);
        }
        return $this->render('medecin/create_medecin.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
