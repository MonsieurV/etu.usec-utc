<?php

namespace USEC\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('USECStudentBundle:Default:index.html.twig');
    }
    
    public function studiesAction()
    {
    	return $this->render('USECStudentBundle:Default:studies.html.twig');
    }
}
