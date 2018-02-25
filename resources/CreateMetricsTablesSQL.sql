-- Create syntax for TABLE 'metric_types'
CREATE TABLE `metric_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(65) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'metrics'
CREATE TABLE `metrics` (
  `unit_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  UNIQUE KEY `unit_id` (`unit_id`,`type`,`timestamp`),
  KEY `timestamp` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'units'
CREATE TABLE `units` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(65) DEFAULT NULL,
  `model` varchar(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;