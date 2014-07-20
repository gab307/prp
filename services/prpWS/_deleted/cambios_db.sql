CREATE TABLE `prp`.`prp_token` (
  `user_id` INT  NOT NULL,
  `request_token` TEXT  NOT NULL,
  `ip` TEXT  NOT NULL,
  `last_update` TIMESTAMP  NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `idx_token_ip`()
)
ENGINE = MyISAM;

