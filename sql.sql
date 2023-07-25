CREATE TABLE `diu_routine` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `day` VARCHAR(10) NOT NULL,
    `slot` INT NOT NULL,
    `room` VARCHAR(6) NOT NULL,
    `course` VARCHAR(10) NOT NULL,
    `teacher` VARCHAR(10) NOT NULL,
    `batch` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `off_routine_class` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `day` VARCHAR(10) NOT NULL,
    `slot` INT NOT NULL,
    `room` VARCHAR(6) NOT NULL,
    `course` VARCHAR(10) NOT NULL,
    `teacher` VARCHAR(10) NOT NULL,
    `batch` VARCHAR(5) NOT NULL,
    `classtype` VARCHAR(10) NOT NULL,
    `date` date,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;