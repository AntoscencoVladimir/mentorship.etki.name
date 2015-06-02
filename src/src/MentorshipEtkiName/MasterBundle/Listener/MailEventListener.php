<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Listener;

use Swift_Mailer as SwiftMailer;
use Swift_Message as SwiftMessage;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Event\ApplicationEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Interlayer for listening to application events and send out emails.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Listener
 * @author  Etki <etki@etki.name>
 */
class MailEventListener
{
    /**
     * Swift mailer instance.
     *
     * @type SwiftMailer
     * @since 0.1.0
     */
    private $mailService;
    /**
     * Templating engine (twig, actually).
     *
     * @type EngineInterface
     * @since 0.1.0
     */
    private $templateEngine;
    /**
     * Sender address.
     *
     * @type string
     * @since 0.1.0
     */
    private $sender;
    /**
     * Admin email address.
     *
     * @type string
     * @since 0.1.0
     */
    private $adminEmail;

    /**
     * Initializer.
     *
     * @param SwiftMailer     $mailService    Mailer.
     * @param EngineInterface $templateEngine Templating engine.
     * @param string          $sender         Sender email address.
     * @param string          $adminEmail     Admin email address.
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
        $this->adminEmail = $adminEmail;
    }

    /**
     * Application event listener
     *
     * @param ApplicationEvent $event Application event.
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
     * @param Applicant $applicant Applicant instance.
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
        $message->setTo($this->adminEmail);
        $message->setFrom([$this->sender => 'Etki // Robot',]);
        $this->mailService->send($message);
    }
}
