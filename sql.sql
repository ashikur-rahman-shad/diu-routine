CREATE TABLE `diu_routine` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `day` VARCHAR(10) NOT NULL,
    `slot` INT NOT NULL,
    `room` VARCHAR(6) NOT NULL,
    `course` VARCHAR(10) NOT NULL,
    `teacher` VARCHAR(10) NOT NULL,
    `batch` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`id`)
);
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
);
CREATE TABLE `slot_time` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `slot` INT NOT NULL,
    `start` VARCHAR(8) NOT NULL,
    `end` VARCHAR(8) NOT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `teachers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `initial` VARCHAR(10) NOT NULL UNIQUE,
    `email` VARCHAR(50),
    `password` VARCHAR(50),
    `name` VARCHAR(50),
    `department` VARCHAR(50),
    PRIMARY KEY (`id`)
);
CREATE TABLE `rooms` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `room` VARCHAR(10) NOT NULL UNIQUE,
    `department` VARCHAR(50),
    PRIMARY KEY (`id`)
);
/* Checking codes */
SELECT DISTINCT `slot`,
    `start`,
    `end`
FROM slot_time
WHERE slot NOT IN (
        SELECT DISTINCT slot
        FROM (
                SELECT *,
                    NULL as `date`,
                    NULL as `classtype`
                FROM diu_routine
                UNION
                SELECT *
                FROM off_routine_class
            ) AS temp
        WHERE day LIKE 'Sunday'
            and (
                teacher = 'KBB'
                or (
                    batch = 40
                    and course REGEXP '^[A-Z]+[0-9]+[D]?[1]?$'
                )
            )
    );

    