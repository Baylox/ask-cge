<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250811225450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A128F72F');
        $this->addSql('ALTER TABLE card CHANGE lane_id lane_id INT NOT NULL, CHANGE sort_order position SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A128F72F FOREIGN KEY (lane_id) REFERENCES lane (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lane DROP FOREIGN KEY FK_DF07E54EE7EC5785');
        $this->addSql('ALTER TABLE lane ADD position INT NOT NULL, DROP sort_order, CHANGE board_id board_id INT NOT NULL');
        $this->addSql('ALTER TABLE lane ADD CONSTRAINT FK_DF07E54EE7EC5785 FOREIGN KEY (board_id) REFERENCES board (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A128F72F');
        $this->addSql('ALTER TABLE card CHANGE lane_id lane_id INT DEFAULT NULL, CHANGE position sort_order SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A128F72F FOREIGN KEY (lane_id) REFERENCES lane (id)');
        $this->addSql('ALTER TABLE lane DROP FOREIGN KEY FK_DF07E54EE7EC5785');
        $this->addSql('ALTER TABLE lane ADD sort_order SMALLINT NOT NULL, DROP position, CHANGE board_id board_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lane ADD CONSTRAINT FK_DF07E54EE7EC5785 FOREIGN KEY (board_id) REFERENCES board (id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
