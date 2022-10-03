CREATE SCHEMA `sistema_tarefas` ;

CREATE TABLE `sistema_tarefas`.`tarefa` (
  `id` INT UNSIGNED NOT NULL,
  `ordem` INT NOT NULL UNIQUE,
  `nome` VARCHAR(45) NOT NULL,
  `custo` DOUBLE NOT NULL,
  `prazo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TRIGGER nome_da_trigger
    BEFORE UPDATE ON sistema_tarefas.tarefa
    FOR EACH ROW BEGIN
    (UPDATE tarefa SET ordem = OLD.ordem WHERE ordem = OLD.ordem AND id <> OLD.id)
END

CREATE TRIGGER nome_da_trigger
    BEFORE UPDATE ON sistema_tarefas.tarefa
    FOR EACH ROW BEGIN
    SET NEW.ordem = (SELECT IF(MAX(ordem) + 1,MAX(ordem) + 1,1) as t FROM tarefa WHERE 1);
END

delimiter $$
CREATE TRIGGER updateEmployees
    BEFORE UPDATE ON employees
    FOR EACH ROW
BEGIN
    IF OLD.meta = 'del' THEN
        NEW.meta = 'del'
END IF;
END$$
delimiter ;