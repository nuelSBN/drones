CREATE DATABASE `c2116544_drones`;
CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isActive` tinyint NOT NULL,
  `dateCreated` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `dateUpdate` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_78a916df40e02a9deb1c4b75ed` (`username`),
  UNIQUE KEY `IDX_e12875dfb3b1d92d7d7c5377e2` (`email`)
);

CREATE TABLE `drones` (
  `serialNumber` varchar(36) NOT NULL,
  `model` enum('lightweight','middleweight','cruiserweight','heavyweight') NOT NULL,
  `state` enum('idle','loading','loaded','delivering','delivered','returning') NOT NULL,
  `weightLimit` float NOT NULL,
  `currentLoad` float NOT NULL DEFAULT '0',
  `batteryLevel` float NOT NULL,
  `dateCreated` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `dateUpdated` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `userId` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`serialNumber`),
  KEY `FK_e027af8e28f473914ea160efd32` (`userId`),
  CONSTRAINT `FK_e027af8e28f473914ea160efd32` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
);


CREATE TABLE `loginSessions` (
  `sessionId` varchar(255) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)