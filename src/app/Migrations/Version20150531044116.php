<?php

namespace Etki\Projects\MentorshipEtkiName\Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * This migration introduces mentoring records table.
 *
 * @SuppressWarnings(PHPMD.ShortMethodName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\Application\Migrations
 * @author  Etki <etki@etki.name>
 */
class Version20150531044116 extends AbstractMigration
{
    /**
     * Name of the managed table.
     *
     * @since 0.1.0
     */
    const MANAGED_TABLE_NAME = 'application';
    /**
     * Name of the primary key index.
     *
     * @since 0.1.0
     */
    const PRIMARY_KEY_INDEX_NAME = 'pk_application';

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
        $table = $schema->createTable(self::MANAGED_TABLE_NAME);
        $table->addColumn('id', Type::INTEGER, ['autoincrement' => true,]);
        $table->addColumn('started_at', Type::DATE);
        $table->addColumn('finished_at', Type::DATE, ['notnull' => false,]);
        $table->addColumn('applicant_id', Type::INTEGER);
        $table->setPrimaryKey(['id',], self::PRIMARY_KEY_INDEX_NAME);
    }

    /**
     * Rolls back migration.
     *
     * @param Schema $schema Schema to alter.
     *
     * @return void
     * @since 0.1.0
     */
    public function down(Schema $schema)
    {
        $schema->dropTable(self::MANAGED_TABLE_NAME);
    }
}
