<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Listener;

use Doctrine\ORM\Event\PostFlushEventArgs;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Service\SimpleDoctrineCacheCleaner;

/**
 * Simple doctrine event listener.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Listener
 * @author  Etki <etki@etki.name>
 */
class DoctrineListener
{
    /**
     * Cache cleaner.
     *
     * @type SimpleDoctrineCacheCleaner
     * @since 0.1.0
     */
    private $cacheCleaner;

    /**
     * Initializer.
     *
     * @param SimpleDoctrineCacheCleaner $cleaner Cleaner instance.
     *
     * @since 0.1.0
     */
    public function __construct(SimpleDoctrineCacheCleaner $cleaner)
    {
        $this->cacheCleaner = $cleaner;
    }

    /**
     * Event handler.
     *
     * @param PostFlushEventArgs $eventArgs Event arguments.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return void
     * @since 0.1.0
     */
    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        $this->cacheCleaner->purgeCache();
    }
}
