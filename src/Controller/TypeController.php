<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tache;
use App\Entity\Freelancer;
use App\Entity\Reservation;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
class TypeController extends AbstractController
{
    //pour afficher la liste des tâche selon la catégorie
    /**
     * @Route("/type/{cat}", name="type")
     */
    public function index(Request $request,$cat)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Tache::class);
        $listetache =$repo->findBy(['type' => $cat]);
        return $this->render('dashboard/dashboard.html.twig', [
            'taches' => $listetache,
        ]);
    }


    //pour supprimer une tâche
    /**
     * @Route("delete/{id}", name="tache-delete")
     */
    public function deleteUser(Request $request,$id) {
        $wantedUser = $this->getDoctrine()->getRepository(Tache::class)->find($id);
        if (!$wantedUser) {
            throw $this->createNotFoundException("User with id ".id." not found in the database !");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($wantedUser);
        $entityManager->flush();
        return($this->redirectToRoute('ins'));
    }

    //afficher les données d'une tâche
    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(Request $request,$id)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Tache::class);
        $listetache =$repo->find( $id);
        return $this->render('details/details.html.twig', [
            'identifiant' => $listetache,
        ]);
    } 


    //afficher la page de modification d'une tâche et remplir les champs
    /**
     * @Route("/modification/{id}", name="modification")
     */
    public function modification(Request $request,$id)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Tache::class);
        $listetache =$repo->find( $id);
        return $this->render('modification/modification.html.twig', [
            'identifiant' => $listetache,
        ]);
    } 




    //pour modifier une tâche
    /**
     * @route("/modif" , name="modif")
     */
    public function modif (Request $request )
    {
        $params = $request->query->all();
        $id = $request->get('id');
        $type = $request->get('type');
        $description = $request->get('description');
        $image = $request->get('image');
        $technologie = $request->get('technologie');
        $cout = $request->get('cout');
        $em = $this->getDoctrine()->getRepository(Tache::class)->find($id);
        $entity=$this->getDoctrine()->getManager();
        $em->setType($type);
        $em->setDescription($description);
        $em->setImage($image);
        $em->setTechnologie($technologie);
        $em->setCout($cout);
        $entity->persist($em);
        $entity->flush();
        return $this->redirectToRoute("ins");       
    } 

    //pour afficher la page qui permet d'ajouter une tâche
    /**
    * @route("/aff_ajout" , name="aff_ajout")
    */
   public function aff_ajout (Request $request )
   {

        return $this->render('ajouter/ajouter.html.twig', [
        'identifiant' => '$listetache',
    ]);}


    //pour ajouter une tâche a partir du dashboard de l'admin
    /**
    * @route("/ajout" , name="ajout")
    */
   public function ajout (Request $request )
   {
        if($request->isMethod('POST'))
        {
        $type = $request->request->get('type');
        $description = $request->request->get('description');
        $image = $request->request->get('image');
        $technologie = $request->request->get('technologie');
        $cout = $request->request->get('cout');
        $em = $this->getDoctrine()->getManager();
        $tache = new Tache();
        $tache->setType($type);
        $tache->setDescription($description);
        $tache->setImage($image);
        $tache->setTechnologie($technologie);
        $tache->setCout($cout);
        $em->persist($tache);
        $em->flush();
        return $this->redirectToRoute("ins");
        }
        return $this->render('ajouter/ajouter.html.twig');
   }

    //pour afficher la liste des freelancers dans le dashboard de l'admin
    /**
     * @Route("/freelancer", name="freelancer")
     */
    public function freelancer(Request $request)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Freelancer::class);
        $listefreelancers =$repo->findAll();
        return $this->render('dashboardfreelancer/dashboardfreelancer.html.twig', [
            'freelancers' => $listefreelancers,
        ]);
    }


    //pour afficher la page d'ajout d'un freelancer
    /**
    * @route("/aff_ajout_fr" , name="aff_ajout_fr")
    */
   public function aff_ajout_fr (Request $request )
   {
        return $this->render('ajouterfreelancer/ajouterfreelancer.html.twig', [
        'identifiant' => '$listetache',
    ]);}



    //pour ajouter un freelancer a partir du dashboard de l'admin
    /**
    * @route("/ajout_free" , name="ajout_free")
    */
   public function ajout_free (Request $request ,UserPasswordEncoderInterface $passwordEncoder)
   {
        if($request->isMethod('POST'))
        {
        
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $domaine = $request->request->get('domaine');
        $email = $request->request->get('email');
        $mdp = $request->request->get('mdp');
        $image = $request->request->get('image');
        $username = $request->request->get('username');
        $em = $this->getDoctrine()->getManager();    
        $freelancer = new Freelancer();     
        $freelancer->setNom($nom);
        $freelancer->setPrenom($prenom);
        $freelancer->setDomaine($domaine);
        $freelancer->setEmail($email);
        $freelancer->setImage($image);
        $freelancer->setUsername($username);
        $password = $passwordEncoder->encodePassword($freelancer, $mdp);
        $freelancer->setMdp($password);
        $em->persist($freelancer);    
        $em->flush();
        return $this->redirectToRoute("freelancer");
        }
        return $this->render('ajouterfreelancer/ajouterfreelancer.html.twig');
   }

    //pour consulter les données d'un freelancer a partir du dashboard de l'admin
    /**
     * @Route("/details_free/{id}", name="details_free")
     */
    public function details_free(Request $request,$id)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Freelancer::class);
        $listetache =$repo->find( $id);
        return $this->render('detailsfreelancer/detailsfreelancer.html.twig', [
            'freelancers' => $listetache,
        ]);
    } 



    //pour supprimer un freelancer a partir du dashboard de l'admin
    /**
     * @Route("freelancerdelete/{id}", name="freelancerdelete")
     */
    public function freelancerdelete(Request $request,$id) {
        $wantedUser = $this->getDoctrine()->getRepository(Freelancer::class)->find($id);
        if (!$wantedUser) {
            throw $this->createNotFoundException("User with id ".id." not found in the database !");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($wantedUser);

        $entityManager->flush();

        return($this->redirectToRoute('freelancer'));
        

    }

    //pour modifier les données d'un freelancer a partir du dashboard de l'admin
    /**
     * @route("/modiffreelancer" , name="modiffreelancer")
     */
    public function modiffreelancer (Request $request )
    {
        $params = $request->query->all();
        $id = $request->get('id');
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $domaine = $request->get('domaine');
        $email = $request->get('email');
        $mdp = $request->get('mdp');
        $username = $request->get('username');
        $em = $this->getDoctrine()->getRepository(Freelancer::class)->find($id);
        $entity=$this->getDoctrine()->getManager();
        $em->setNom($nom);
        $em->setPrenom($prenom);
        $em->setDomaine($domaine);
        $em->setEmail($email);
        $em->setMdp($mdp);
        $em->setUsername($username);
        $entity->persist($em);
        $entity->flush();
        return $this->redirectToRoute("freelancer");    
    } 



    //afficher la page de modification du freelancer et remplir les champs
    /**
     * @Route("/modificationfreelancer/{id}", name="affmodificationfreelancer")
     */
    public function modificationfreelancer(Request $request,$id)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Freelancer::class);
        $listetache =$repo->find( $id);
        return $this->render('modificationfreelancer/modificationfreelancer.html.twig', [
            'freelancer' => $listetache,
        ]);
    } 

    //pour afficher la page d'acceil du freelancer
    /**
     * @Route("/homefreelancer", name="homefreelancer")
     */
    public function homefreelancer(Request $request)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Tache::class);
        $listefreelancers =$repo->findAll();
        return $this->render('homefreelancer/homefreelancer.html.twig', [
            'taches' => $listefreelancers,
        ]);
    }

    //pour afficher la page de l'inscription
    /**
    * @route("/aff_register" , name="aff_register")
    */
   public function aff_register ()
   {
        return $this->render('register/register.html.twig', [
        'identifiant' => '$listetache',
    ]);}


    //pour faire l'inscription d'un nouveau freelancer
    /**
    * @route("/register" , name="register")
    */
   public function register (Request $request,UserPasswordEncoderInterface $passwordEncoder )
   {
        if($request->isMethod('POST'))
        {   
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $domaine = $request->request->get('domaine');
        $email = $request->request->get('email');
        $image = $request->request->get('image');
        $username = $request->request->get('username');
        $mdp = $request->request->get('mdp');
        $em = $this->getDoctrine()->getManager();
        $freelancer = new Freelancer();
        $freelancer->setNom($nom);
        $freelancer->setPrenom($prenom);
        $freelancer->setDomaine($domaine);
        $freelancer->setEmail($email);
        $freelancer->setImage($image);
        $freelancer->setUsername($username);   
        $password = $passwordEncoder->encodePassword($freelancer, $mdp);
        $freelancer->setMdp($password);
        $em->persist($freelancer);  
        $em->flush();
        return $this->redirectToRoute("homefreelancer");
        }
        return $this->render('register/register.html.twig');
   }

    //pour connecter
    /**
    * @Route("/", name="login")
    */

    public function login(AuthenticationUtils $authenticationUtils)
    {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername= $authenticationUtils->getLastUsername();

    return $this->render('login/login.html.twig', [
    'last_username' =>$lastUsername,
    'error'         =>$error,
    ]);
    }


    //pour faire le logout
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    return $this->redirectToRoute("login");

    throw new \Exception('this should not be reached!');
    }


    //pour réserver une tâche
    /**
    * @route("/reserver/{id}" , name="reserver")
    */
   public function reserver (Request $request,UserInterface $user,$id)
   {

        if($request->isMethod('POST'))
        {

        $em = $this->getDoctrine()->getManager();
        $ti=$this->getDoctrine()->getRepository(Tache::class)->find($id);
        $Reservation = new Reservation();    
        $Reservation->setFreelancer($user);
        $Reservation->setIdTache($ti);
        $em->persist($Reservation); 
        $em->flush();
        return $this->redirectToRoute("homefreelancer");
        }
        return $this->render('homefreelancer/homefreelancer.html.twig');
   }

   //pour afficher la table des réservations
    /**
     * @Route("/aff_Reserv" ,name="aff_Reserv");
    */
    public function aff_Reserv(UserInterface $user)
    {
        
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Reservation::class);
        $ti =$repo->findBy(['freelancer' => $user->getId()]);
        return $this->render('reservations/reservations.html.twig',[
            'ti' => $ti,
        ]);
    }


    //pour afficher la page de modification du compte freelancer
    /**
     * @Route("/affmodificationfreelancer" ,name="affmodificationfreelancer");
    */
    public function affmodificationfreelancer(UserInterface $user)
    {
        return $this->render('modificationcomptefreelancer/modificationcomptefreelancer.html.twig',[
            'ti' => '$ti',
        ]);
    }




    //pour modifier les données d'un compte freelancer 
    /**
     * @route("/modiffcptfreelancer" , name="modiffcptfreelancer")
     */
    public function modiffcptfreelancer (Request $request,UserPasswordEncoderInterface $passwordEncoder ,UserInterface $user)
    {
        $params = $request->query->all();
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $domaine = $request->get('domaine');
        $email = $request->get('email');
        $username = $request->get('username');
        $mdp = $request->get('mdp');
        $em = $this->getDoctrine()->getRepository(Freelancer::class)->find($user->getId());
        $entity=$this->getDoctrine()->getManager();
        $em->setNom($nom);
        $em->setPrenom($prenom);
        $em->setDomaine($domaine);
        $em->setEmail($email);
        $em->setUsername($username);
        $password = $passwordEncoder->encodePassword($user, $mdp);
        $em->setMdp($password);
        $entity->persist($em);
        $entity->flush();
        return $this->redirectToRoute("homefreelancer");    
    } 



    








    
}
