<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407075320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_missions ADD supervisor_id INT DEFAULT NULL, CHANGE destination2_id destination2_id INT DEFAULT NULL, CHANGE destination3_id destination3_id INT DEFAULT NULL, CHANGE destination4_id destination4_id INT DEFAULT NULL, CHANGE department_id department_id INT DEFAULT NULL, CHANGE position_id position_id INT DEFAULT NULL, CHANGE mean_trans mean_trans VARCHAR(255) DEFAULT NULL, CHANGE mstatus mstatus VARCHAR(20) DEFAULT NULL, CHANGE line_supervisor_checked line_supervisor_checked VARCHAR(10) DEFAULT NULL, CHANGE verified_by_accountant verified_by_accountant VARCHAR(255) DEFAULT NULL, CHANGE decision_from_dg decision_from_dg VARCHAR(10) DEFAULT NULL, CHANGE payment_prepared_by_accountant payment_prepared_by_accountant VARCHAR(10) DEFAULT NULL, CHANGE approval_of_df approval_of_df VARCHAR(30) DEFAULT NULL, CHANGE approval_of_csdm approval_of_csdm VARCHAR(10) DEFAULT NULL, CHANGE d1_id_num_day d1_id_num_day VARCHAR(2) DEFAULT NULL, CHANGE d2_id_num_day d2_id_num_day VARCHAR(2) DEFAULT NULL, CHANGE d3_id_num_day d3_id_num_day VARCHAR(2) DEFAULT NULL, CHANGE d4_id_num_day d4_id_num_day VARCHAR(2) DEFAULT NULL, CHANGE num_days num_days VARCHAR(2) DEFAULT NULL, CHANGE tallowance tallowance VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_missions ADD CONSTRAINT FK_63C2325319E9AC5F FOREIGN KEY (supervisor_id) REFERENCES tbl_supervisors (id)');
        $this->addSql('CREATE INDEX IDX_63C2325319E9AC5F ON tbl_missions (supervisor_id)');
        $this->addSql('ALTER TABLE tbl_allowances CHANGE level_id level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_appusers CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE locations CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE positions CHANGE level_id level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staffs CHANGE department_id department_id INT DEFAULT NULL, CHANGE designation_id designation_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE mobile_number mobile_number VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_vehicles CHANGE staff_id staff_id INT DEFAULT NULL, CHANGE position_id position_id INT DEFAULT NULL, CHANGE destination_id destination_id INT DEFAULT NULL, CHANGE transportername transportername VARCHAR(255) DEFAULT NULL, CHANGE companyname companyname VARCHAR(255) DEFAULT NULL, CHANGE platno platno VARCHAR(255) DEFAULT NULL, CHANGE tripamount tripamount VARCHAR(255) DEFAULT NULL, CHANGE tripdays tripdays VARCHAR(255) DEFAULT NULL, CHANGE totalamount totalamount VARCHAR(255) DEFAULT NULL, CHANGE ttelephone ttelephone VARCHAR(255) DEFAULT NULL, CHANGE transporterstyle transporterstyle VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_expenses CHANGE mission_id mission_id INT DEFAULT NULL, CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE locations CHANGE zone_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE positions CHANGE level_id level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staffs CHANGE department_id department_id INT DEFAULT NULL, CHANGE designation_id designation_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE mobile_number mobile_number VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tbl_allowances CHANGE level_id level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_appusers CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_expenses CHANGE mission_id mission_id INT DEFAULT NULL, CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_missions DROP FOREIGN KEY FK_63C2325319E9AC5F');
        $this->addSql('DROP INDEX IDX_63C2325319E9AC5F ON tbl_missions');
        $this->addSql('ALTER TABLE tbl_missions DROP supervisor_id, CHANGE destination2_id destination2_id INT DEFAULT NULL, CHANGE destination3_id destination3_id INT DEFAULT NULL, CHANGE destination4_id destination4_id INT DEFAULT NULL, CHANGE department_id department_id INT DEFAULT NULL, CHANGE position_id position_id INT DEFAULT NULL, CHANGE mean_trans mean_trans VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE mstatus mstatus VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE line_supervisor_checked line_supervisor_checked VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE verified_by_accountant verified_by_accountant VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE decision_from_dg decision_from_dg VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE payment_prepared_by_accountant payment_prepared_by_accountant VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE approval_of_df approval_of_df VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE approval_of_csdm approval_of_csdm VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE d1_id_num_day d1_id_num_day VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE d2_id_num_day d2_id_num_day VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE d3_id_num_day d3_id_num_day VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE d4_id_num_day d4_id_num_day VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE num_days num_days VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tallowance tallowance VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tbl_vehicles CHANGE staff_id staff_id INT DEFAULT NULL, CHANGE position_id position_id INT DEFAULT NULL, CHANGE destination_id destination_id INT DEFAULT NULL, CHANGE transportername transportername VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE companyname companyname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE platno platno VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tripamount tripamount VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tripdays tripdays VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE totalamount totalamount VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE transporterstyle transporterstyle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE ttelephone ttelephone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_bin`');
    }
}
