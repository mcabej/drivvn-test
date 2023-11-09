<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108205907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // create default color values
        $this->addSql("INSERT INTO color (id, name) 
            VALUES
            (1, 'red'),
            (2, 'blue'),
            (3, 'white'),
            (4, 'black')
        ");
    }

    public function down(Schema $schema): void
    {        
        $this->addSql("DELETE FROM color");
    }
}
