START TRANSACTION;
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE cazulo.banco DROP FOREIGN KEY Fk_BancoUsuarioAtualizacao;
ALTER TABLE cazulo.banco DROP FOREIGN KEY Fk_BancoUsuarioEncerramento;
ALTER TABLE `banco` DROP INDEX `Fk_BancoUsuarioAtualizacao`;
ALTER TABLE `banco` DROP INDEX `Fk_BancoUsuarioEncerramento`;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;


