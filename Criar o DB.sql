CREATE SCHEMA `sistema_tarefas` ;

CREATE TABLE `sistema_tarefas`.`tarefa` (
  `id` INT UNSIGNED NOT NULL,
  `ordem` INT NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `custo` DOUBLE NOT NULL,
  `prazo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));