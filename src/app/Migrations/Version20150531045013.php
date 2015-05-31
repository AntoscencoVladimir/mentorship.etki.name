<?php

namespace Etki\Projects\MentorshipEtkiName\Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

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
class Version20150531045013 extends AbstractMigration
{
    /**
     * Name of the managed table.
     *
     * @since 0.1.0
     */
    const MANAGED_TABLE_NAME = 'application';
    /**
     * Name of referenced table.
     *
     * @since 0.1.0
     */
    const REFERENCED_TABLE_NAME = 'applicant';
    /**
     * Name of the column that references other table.
     *
     * @since 0.1.0
     */
    const FOREIGN_KEY_COLUMN = 'applicant_id';
    /**
     * Name of referenced column in other table.
     *
     * @since 0.1.0
     */
    const REFERENCED_COLUMN = 'id';
    /**
     * Name of the foreign key index.
     *
     * @since 0.1.0
     */
    const FOREIGN_KEY_NAME = 'fk_applications_ref_applicant';

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
        $referencedTable = $schema->getTable(self::REFERENCED_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $referencedTable,
            [self::FOREIGN_KEY_COLUMN,],
            [self::REFERENCED_COLUMN,],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'RESTRICT',
            ],
            self::FOREIGN_KEY_NAME
        );
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
        $table = $schema->getTable(self::MANAGED_TABLE_NAME);
        $table->removeForeignKey(self::FOREIGN_KEY_NAME);
    }
}
