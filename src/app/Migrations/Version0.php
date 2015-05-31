<?php

namespace Etki\Projects\MentorshipEtkiName\Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Introduces applicant table.
 *
 * @SuppressWarnings(PHPMD.ShortMethodName)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\Application\Migrations
 * @author  Etki <etki@etki.name>
 */
class Version0 extends AbstractMigration
{
    /**
     * List of unsupported platforms that can't be used.
     *
     * @type string[]
     * @since 0.1.0
     */
    private static $unsupportedPlatforms = ['sqlite',];

    /**
     * Applies migration.
     *
     * @param Schema $schema Schema to alter.
     *
     * @return void
     * @since 0.1.0
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            in_array(
                $this->platform->getName(),
                static::$unsupportedPlatforms,
                true
            ),
            'This set of migrations uses dynamic foreign key setting and is ' .
            'incompatible with SQLite'
        );
        $this->writeExplanation();
    }

    /**
     * Rolls migration back.
     *
     * @param Schema $schema Schema to alter.
     *
     * @return void
     * @since 0.1.0
     */
    public function down(Schema $schema)
    {
        $this->writeExplanation();
    }

    /**
     * Tells end user that he has nothing to worry about.
     *
     * @return void
     * @since 0.1.0
     */
    private function writeExplanation()
    {
        $message = 'This migration is added for requirements compliance ' .
            'check and doesn\'t produce any schema changes.' . PHP_EOL .
            'Don\'t worry about "Migration did not result in any SQL ' .
            'statements" message.';
        $this->write($message);
    }
}
