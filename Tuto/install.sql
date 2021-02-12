CREATE USER 'iamroot'@'localhost' IDENTIFIED BY 'iamroot';
GRANT ALL PRIVILEGES ON * . * TO 'iamroot'@'localhost';
FLUSH PRIVILEGES;

CREATE DATABASE ocpoo;

CREATE TABLE IF NOT EXISTS `personnages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `forcePerso` int(11) DEFAULT NULL,
  `degats` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
