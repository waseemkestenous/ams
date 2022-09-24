DROP TABLE IF EXISTS `companyusers_view`;

CREATE VIEW `companyusers_view`  AS SELECT `usercompanies`.`userco_id` AS `userco_id`, `usercompanies`.`userco_user_id` AS `userco_user_id`, `usercompanies`.`userco_co_id` AS `userco_co_id`, `usercompanies`.`userco_notes` AS `userco_notes`, `usercompanies`.`userco_lock` AS `userco_lock`, `usercompanies`.`userco_timestamp` AS `userco_timestamp`, `usercompanies`.`userco_reguser_id` AS `userco_reguser_id`, `users`.`user_name` AS `user_name`, `users`.`user_user_id` AS `user_user_id`, `users`.`user_lock` AS `user_lock` FROM (`usercompanies` join `users` on((`users`.`user_id` = `usercompanies`.`userco_user_id`))) ;

DROP TABLE IF EXISTS `usercompanies_view`;

CREATE VIEW `usercompanies_view`  AS SELECT `companies`.`co_id` AS `co_id`, `companies`.`co_name` AS `co_name`, `companies`.`co_email` AS `co_email`, `companies`.`co_tel` AS `co_tel`, `companies`.`co_address` AS `co_address`, `companies`.`co_notes` AS `co_notes`, `companies`.`co_lock` AS `co_lock`, `companies`.`co_user_id` AS `co_user_id`, `companies`.`co_timestamp` AS `co_timestamp`, `usercompanies`.`userco_user_id` AS `userco_user_id`, `usercompanies`.`userco_lock` AS `userco_lock` FROM (`companies` left join `usercompanies` on((`companies`.`co_id` = `usercompanies`.`userco_co_id`))) ;

