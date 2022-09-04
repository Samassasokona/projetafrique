<?php

namespace App\Controller;

use App\Classe\Mailjet;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager){
            $this->entityManager = $entityManager; 
    }

    /**
     * @Route("/inscription", name="register")
     */
    
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);

    
        
        if ($form->isSubmitted()&& $form->isValid()){
        // encode the plain password
        $user = $form->getData();

        $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

        if (!$search_email){

        $password = $encoder->encodePassword($user,$user->getPassword());
       
            $user->setPassword($password);
    

            $this->entityManager->persist($user); 
            $this->entityManager->flush(); 

            $mailjet = new Mailjet();
            $content = "Bonjour".$user->getprenom()."<br/>Bienvenue sur la première Boutique dédiée au artiste africains.<br><br/> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus tenetur facere soluta at id vitae! Quod, maiores minus ducimus, ipsa facere veritatis eius, quia culpa accusantium excepturi nobis distinctio voluptatum!";
            $mailjet->send($user->getEmail(), $user->getprenom(), 'Bienvenue sur investir en Afrique', $content);
            
        $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte ";
        } else {
        $notification = "L'email que vous avez renseigné existe déja.";
        }
    }

        return $this->render('register/index.html.twig',[
            'form'=> $form->createView(),
            'notification'=> $notification
        ]);
          
    }
}

