use cwmsdb;
CREATE TABLE IF NOT EXISTS `tblvehicletypes`(
    id int PRIMARY KEY AUTO_INCREMENT,
    vehicle_name VARCHAR(32)
);

INSERT INTO `tblvehicletypes` VALUES
(null,'TRUCKS'),(null,'MOTORCYCLE');

select * from `tblwashservice`;
select * from `tblcarwashbooking`;
ALTER TABLE `tblcarwashbooking` CHANGE COLUMN `packageType` `packageType` VARCHAR(64);
ALTER TABLE `tblwashservice` CHANGE COLUMN `service` `service` VARCHAR(64);

ALTER TABLE `tblwashservice` CONVERT TO CHARACTER SET latin1;
ALTER TABLE `tblcarwashbooking` CONVERT TO CHARACTER SET latin1;

ALTER TABLE `tblcarwashbooking`
ADD CONSTRAINT `fk_packageType`
FOREIGN KEY (`packageType`) REFERENCES `tblwashservice` (`id`)
ON UPDATE CASCADE
ON DELETE RESTRICT;

SHOW CREATE TABLE tblwashservice;

-- Payment types table
USE cwmsdb;
DROP TABLE tblpaymenttypes;
SELECT * FROM tblcustomers;
DROP TABLE transactions;


CREATE TABLE IF NOT EXISTS `tblpaymenttypes`(
    `id` INT(6) ZEROFILL PRIMARY KEY AUTO_INCREMENT,
    `paymentType` VARCHAR(32),
    `description` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `tblcustomers`(
    `customerId` INT(6) ZEROFILL PRIMARY KEY AUTO_INCREMENT,
    `customerName` VARCHAR(64) NOT NULL,
    `customerEmail` VARCHAR(20) UNIQUE,
    `customerPhone` VARCHAR(10) UNIQUE,
    `address` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `transactions`(
    `paymentId` INT(6) ZEROFILL PRIMARY KEY AUTO_INCREMENT,
    `paymentTypeId` INT(6) ZEROFILL,
    `customerId` INT(6) ZEROFILL,
    `customerName` VARCHAR(64),
    `customerEmail` VARCHAR(20),
    `customerPhone` VARCHAR(10),
    `paymentType` VARCHAR(32),
    `cardNo` VARCHAR(19),
    `cvv` INT(3),
    `transactionResponse` VARCHAR(999),
    `amount` DECIMAL(10, 2),
    `date` DATETIME,
    `currency` VARCHAR(3),
    `status` VARCHAR(20),
    `description` VARCHAR(255),    
    `address` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `transactions`
ADD CONSTRAINT fk_customerInfo
FOREIGN KEY (`customerId`)
REFERENCES `tblcustomers`(`customerId`) ON UPDATE CASCADE;

ALTER TABLE `transactions`
ADD CONSTRAINT fk_paymentInfo
FOREIGN KEY (`paymentTypeId`)
REFERENCES `tblpaymenttypes`(`id`) ON UPDATE CASCADE;


-- amount: This column would store the amount of the transaction.
-- date: This column would store the date and time of the transaction.
-- currency: This column would store the currency of the transaction.
-- status: This column would store the status of the transaction, such as "pending," "completed," or "failed."
-- description: This column would store a description of the transaction.
-- payerId: This column would store the ID of the person who initiated the transaction.
-- payerName: This column would store the name of the person who initiated the transaction.
-- address: This column would store the address associated with the payment method used for the transaction.
-- phone: This column would store 

