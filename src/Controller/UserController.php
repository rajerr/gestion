<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/user", name="user_index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/Admin/User/create", name="usercreate")
     */
  
    public function createUser(Request $request, \Swift_Mailer $mailler, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $user = $form->getData();
            $password = $user->getPassword();
            $user->setPassword($encoder->encodePassword($user, $password));
            $user ->setStatut(0);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $message = (new \Swift_Message('Hello Email de validation'))
            ->setFrom('rajerr2013@gmail.com')
            ->setTo( $user->getEmail())
            ->setBody(
                $this->renderView(
                    'user/mail.html.twig',
                    ['id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'password' => $password]
                ),
                'text/html'
            );

            $mailler->send($message);
            return $this->render('user/verifie.html.twig');
            return $this->render('user/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $user->getUsername()
            ]);
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
        
    }


    /**
     * @Route("/User/{id}/activer", name="useractive")
     */

     public function activeUser(UserRepository $userrepos, EntityManagerInterface $manager, $id)
     {
        $statut=$userrepos->find($id);
        $statut->setStatut(true);
        $manager->persist($statut);
        $manager->flush();
        return $this->render('login');

     }
}
