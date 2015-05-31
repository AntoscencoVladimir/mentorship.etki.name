<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MentorshipMasterBundle:Default:index.html.twig', array('name' => $name));
    }
}
