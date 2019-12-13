<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tache;
 
class inscriptionController extends AbstractController
{
    
    
    /**
     * @Route("/ins" ,name="ins");
    */
    public function number()
    {
        
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Tache::class);
        $listetache =$repo->findAll();
        return $this->render('dashboard/dashboard.html.twig',[
            'taches' => $listetache,
        ]);
    }

    
}
?>
