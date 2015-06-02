<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Listener;

use Swift_Mailer as SwiftMailer;
use Swift_Message as SwiftMessage;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Event\ApplicationEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 *
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Listener
 * @author  Etki <etki@etki.name>
 */
class MailEventListener
{
    /**
     *
     *
     * @type SwiftMailer
     * @since 0.1.0
     */
    private $mailService;
    /**
     *
     *
     * @since
     */
    private $templateEngine;
    private $sender;

    /**
     * Initializer.
     *
     * @param SwiftMailer     $mailService    Mailer.
     * @param EngineInterface $templateEngine Templating engine.
     * @param string          $sender
     * @param string          $adminEMail
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        SwiftMailer $mailService,
        EngineInterface $templateEngine,
        $sender,
        $adminEmail
    ) {
        $this->mailService = $mailService;
        $this->templateEngine = $templateEngine;
        $this->sender = $sender;
    }

    /**
     *
     *
     * @param ApplicationEvent $event
     *
     * @return void
     * @since 0.1.0
     */
    public function onApplication(ApplicationEvent $event)
    {
        $this->sendApplicationAdminEmail($event->getApplicant());
        $this->sendApplicationConfirmationEmail($event->getApplicant());
    }

    /**
     * Sends confirmation email to applicant.
     *
     * @param Applicant $applicant
     *
     * @return void
     * @since 0.1.0
     */
    private function sendApplicationConfirmationEmail(Applicant $applicant)
    {
        $message = SwiftMessage::newInstance(
            'Уведомление',
            $this->templateEngine->render(
                '::email/application-confirmation.html.twig',
                ['applicant' => $applicant,]
            ),
            'text/html',
            'UTF-8'
        );
        $message->setTo($applicant->getEmail());
        $message->setFrom([$this->sender => 'Etki // Robot',]);
        $this->mailService->send($message);
    }

    /**
     * Sends notice about new applicant.
     *
     * @param Applicant $applicant Applicant instance.
     *
     * @return void
     * @since 0.1.0
     */
    private function sendApplicationAdminEmail(Applicant $applicant)
    {
        $message = SwiftMessage::newInstance(
            'Уведомление',
            $this->templateEngine->render(
                '::email/application-admin-notice.html.twig',
                ['applicant' => $applicant,]
            ),
            'text/html',
            'UTF-8'
        );
        $message->setTo($applicant->getEmail());
        $message->setFrom([$this->sender => 'Etki // Robot',]);
        $this->mailService->send($message);
    }
}
