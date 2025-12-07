-- Create consultation_messages table
-- Run this SQL in your database if the migration doesn't work

CREATE TABLE IF NOT EXISTS `consultation_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('customer','consultant') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultation_messages_consultation_id_created_at_index` (`consultation_id`,`created_at`),
  KEY `consultation_messages_sender_id_sender_type_index` (`sender_id`,`sender_type`),
  CONSTRAINT `consultation_messages_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consultation_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

