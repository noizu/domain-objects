
CREATE TABLE `sites` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `moderated_string_actions` (
  `id` smallint(20) NOT NULL AUTO_INCREMENT,
  `mod_action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `moderated_string_types` (
  `id` smallint(20) NOT NULL AUTO_INCREMENT,
  `string_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `moderated_string_change_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `moderated_string_id` bigint(20) NOT NULL,
  `string` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `action_id` smallint(20) NOT NULL,
  `event_time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `autoflag` binary(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `moderated_string_change_logs_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `moderated_string_actions` (`id`),
  CONSTRAINT `moderated_string_change_logs_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `moderated_strings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `str_type` smallint(6) NOT NULL,
  `approved_text_id` bigint(20) DEFAULT NULL,
  `pending_text_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approved_idx` (`approved_text_id`),
  KEY `pending_idx` (`pending_text_id`),
  KEY `type_idx` (`str_type`),
  CONSTRAINT `approved_idx` FOREIGN KEY (`approved_text_id`) REFERENCES `moderated_string_change_logs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pending_idx` FOREIGN KEY (`pending_text_id`) REFERENCES `moderated_string_change_logs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `type_idx` FOREIGN KEY (`str_type`) REFERENCES `moderated_string_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE moderated_string_change_logs ADD FOREIGN KEY moderated_string_change_logs_ibfk_1 (`moderated_string_id`) REFERENCES `moderated_strings` (`id`);

CREATE TABLE `email_templates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `friendly_name` bigint(20) NOT NULL,
  `subject` bigint(20) NOT NULL,
  `template` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `friendly_name` (`friendly_name`),
  KEY `subject` (`subject`),
  KEY `template` (`template`),
  CONSTRAINT `email_templates_ibfk_1` FOREIGN KEY (`friendly_name`) REFERENCES `moderated_strings` (`id`),
  CONSTRAINT `email_templates_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `moderated_strings` (`id`),
  CONSTRAINT `email_templates_ibfk_3` FOREIGN KEY (`template`) REFERENCES `moderated_strings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `email_template_queue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_template_id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `sent_subject_id` bigint(20) DEFAULT NULL,
  `sent_template_id` bigint(20) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '0 - Not Ready,  1 Sent, 2 - Pending, 3 - Error, 4 - Processing, 5 - Halt',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email_template_id` (`email_template_id`),
  KEY `sent_subject_id` (`sent_subject_id`),
  KEY `sent_template_id` (`sent_template_id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `email_template_queue_ibfk_1` FOREIGN KEY (`email_template_id`) REFERENCES `email_templates` (`id`),
  CONSTRAINT `email_template_queue_ibfk_4` FOREIGN KEY (`sent_subject_id`) REFERENCES `moderated_string_change_logs` (`id`),
  CONSTRAINT `email_template_queue_ibfk_5` FOREIGN KEY (`sent_template_id`) REFERENCES `moderated_string_change_logs` (`id`),
  CONSTRAINT `email_template_queue_ibfk_6` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  CONSTRAINT `email_template_queue_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `email_template_queue_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_template_queue_id` bigint(20) NOT NULL,
  `data` varchar(1024) DEFAULT NULL COMMENT 'Email Specific Data prepared when email is created.',
  `sent_data` varchar(1024) DEFAULT NULL COMMENT 'Any User or Site data that was sent with template',
  `errors` varchar(1024) DEFAULT NULL COMMENT 'Errors Raised while processing Email',
  PRIMARY KEY (`id`),
  KEY `email_template_queue_id` (`email_template_queue_id`),
  CONSTRAINT `email_template_queue_data_ibfk_1` FOREIGN KEY (`email_template_queue_id`) REFERENCES `email_template_queue` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
