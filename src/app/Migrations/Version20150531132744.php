<?php

namespace Etki\Projects\MentorshipEtkiName\Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Adds extra fields to applicant table.
 *
 * @SuppressWarnings(PHPMD.ShortMethodName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\Application\Migrations
 * @author  Etki <etki@etki.name>
 */
class Version20150531132744 extends AbstractMigration
{
    /**
     * Name of the managed table.
     *
     * @since 0.1.0
     */
    const MANAGED_TABLE_NAME = 'applicant';
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
        $table = $schema->getTable(self::MANAGED_TABLE_NAME);
        $table->addColumn('is_active', Type::BOOLEAN);
        $table->addColumn('story', Type::TEXT);
        $table->addColumn('email', Type::STRING, ['length' => 64,]);
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
        $table = $schema->getTable(self::MANAGED_TABLE_NAME);
        $table->dropColumn('email');
        $table->dropColumn('story');
        $table->dropColumn('is_active');
    }
}
