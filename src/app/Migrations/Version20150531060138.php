<?php

namespace Etki\Projects\MentorshipEtkiName\Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * This migration fixes invalid type of `title` applicant field.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\Application\Migrations
 * @author  Etki <etki@etki.name>
 */
class Version20150531060138 extends AbstractMigration
{
    /**
     * Name of the altered table.
     *
     * @since 0.1.0
     */
    const MANAGED_TABLE_NAME = 'applicant';
    /**
     * Name of the column.
     *
     * @since 0.1.0
     */
    const MANAGED_COLUMN_NAME = 'title';
    /**
     * Invalid column type.
     *
     * @since 0.1.0
     */
    const INVALID_COLUMN_TYPE = Type::INTEGER;
    /**
     * Correct column type.
     *
     * @since 0.1.0
     */
    const CORRECT_COLUMN_TYPE = Type::STRING;
    /**
     * Column length.
     *
     * @since 0.1.0
     */
    const COLUMN_LENGTH = 64;

    /**
     * Applies migration.
     *
     * @param Schema $schema Schema to alter.
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     *
     * @return void
     * @since 0.1.0
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable(self::MANAGED_TABLE_NAME);
        $table->changeColumn(
            self::MANAGED_COLUMN_NAME,
            [
                'type' => Type::getType(self::CORRECT_COLUMN_TYPE),
                'length' => self::COLUMN_LENGTH,
            ]
        );
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
        $table->changeColumn(
            self::MANAGED_COLUMN_NAME,
            [
                'type' => Type::getType(self::INVALID_COLUMN_TYPE),
                'length' => self::COLUMN_LENGTH,
            ]
        );
    }
}
