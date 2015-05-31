<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Controller;

use Doctrine\ORM\EntityManager;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Form\Type\ApplicantType;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicantRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\LinkRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Service\FormEntityDataExtractor;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Service\SimpleDoctrineCacheCleaner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * The heart of whole app, main controller.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Controller
 * @author  Etki <etki@etki.name>
 */
class MasterController extends Controller
{
    /**
     * Session key for form PRG processing.
     *
     * @since 0.1.0
     */
    const APPLICANT_SESSION_KEY = 'applicant_form';
    /**
     * This action serves the default homepage.
     *
     * @param string $language
     *
     * @return Response
     * @since 0.1.0
     */
    public function indexAction($language = 'ru')
    {
        if (!in_array($language, ['ru',/* 'en',*/], true)) {
            throw $this->createNotFoundException();
        }
        $templateName = sprintf(
            'MentorshipMasterBundle:Master:index-%s.html.twig',
            $language
        );
        /** @type EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        /** @type ApplicantRepository $applicantRepository */
        $applicantRepository
            = $entityManager->getRepository('MentorshipMasterBundle:Applicant');
        $context = [
            'links' => (new LinkRepository())->findAll(),
            'active_applicants' => $applicantRepository->getActiveApplicants(),
            'counter' => $applicantRepository->getApplicantCount(),
        ];
        return $this->render($templateName, $context);
    }

    /**
     * Displays form.
     *
     * @return Response
     * @since 0.1.0
     */
    public function formAction()
    {
        /** @type Session $session */
        $session = $this->get('session');
        $flashBag = $session->getFlashBag();
        $applicantData = $flashBag->get(self::APPLICANT_SESSION_KEY, []);
        $applicant = new Applicant;
        if ($applicantData) {
            $applicant->unserialize(reset($applicantData));
        }
        $options = [
            'action' => $this->generateUrl('application_form_processor'),
        ];
        $form = $this->createForm(new ApplicantType, $applicant, $options);
        if ($applicantData) {
            $key = 'name.etki.mentorship.master.form_entity_data_extractor';
            /** @type FormEntityDataExtractor $extractor */
            $extractor = $this->get($key);
            $form->submit($extractor->extractEntityData($form, $applicant));
        }
        $template = 'MentorshipMasterBundle:Master:form.html.twig';
        return $this->render($template, ['form' => $form->createView(),]);
    }

    /**
     * FOrm processor.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @since 0.1.0
     */
    public function formProcessorAction(Request $request)
    {
        $applicant = new Applicant;
        $form = $this->createForm(new ApplicantType, $applicant);
        $form->handleRequest($request);
        if (!$form->isValid()) {
            /** @type Session $session */
            $session = $this->get('session');
            $session->getFlashBag()->add(
                self::APPLICANT_SESSION_KEY,
                $applicant->serialize()
            );
            return $this->redirectToRoute('application_form');
        }
        /** @type EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $entityManager->persist($applicant);
        $entityManager->flush($applicant);
        $key = 'name.etki.mentorship.master.doctrine_result_cache_cleaner';
        /** @type SimpleDoctrineCacheCleaner $cleaner */
        $cleaner = $this->get($key);
        $cleaner->purgeCache();
        return $this->redirectToRoute('application_success_message');
    }

    /**
     * Returns successful response to form submit.
     *
     * @return Response
     * @since 0.1.0
     */
    public function formSuccessAction()
    {
        $template = 'MentorshipMasterBundle:Master:form-success.html.twig';
        return $this->render($template);
    }
}
