/* 

TODO:
*/

drop database glacierhull;
create database glacierhull;
use glacierhull;

CREATE TABLE Ship 
(
shipName VARCHAR(64) PRIMARY KEY,
constructionDate DATE,
renovationDate DATE,
inspectionDate DATE
) ENGINE=InnoDB;

INSERT INTO Ship (shipName,constructionDate,renovationDate,inspectionDate)
	values('S.S. Ese','1999-5-30','1999-5-30','1999-5-30'),
	('The Krusty Bucket','1994-3-21','1996-3-1','1997-6-12'),
	('The Salty Spitoon','2000-2-12','2001-3-15','2001-5-12'),
	('S.S. Gourmet','2015-7-13','2015-7-13','2015-7-13'),
	('Bessie','1946-8-12','1966-6-06','1966-6-06');

CREATE TABLE Cabin
(
cabinNum INT PRIMARY KEY,
shipName VARCHAR(64) NOT NULL,
capacity INT NOT NULL,
type VARCHAR(16) NOT NULL,
FOREIGN KEY (shipName) REFERENCES Ship(shipName)
) ENGINE=InnoDB;

INSERT INTO Cabin (cabinNum,shipName,capacity,type)
	values('1','S.S. Gourmet','8','Suite'),
	('2','Bessie','4','Inside'),
	('3','S.S. Ese','4','Outside'),
	('4','The Krusty Bucket','8','Suite'),
	('5','The Salty Spitoon','4','Outside');

CREATE TABLE Port
(
portID INT AUTO_INCREMENT PRIMARY KEY,
location VARCHAR(64) NOT NULL
) ENGINE=InnoDB;

INSERT INTO Port (location)
	values('Bermuda 1'),
	('Bermuda 2'),
	('Bermuda 3'),
	('Bermuda 4'),
	('Bermuda 5');

CREATE TABLE Item
(
itemID INT AUTO_INCREMENT PRIMARY KEY,
type VARCHAR(16) NOT NULL
) ENGINE=InnoDB;

/* only 3 data values inserted since this is just for referencing during transactions */

INSERT INTO Item (type)
	values('Amenity'),
	('Reservation'),
	('Excursion');

CREATE TABLE Customer
(
customerID INT AUTO_INCREMENT PRIMARY KEY,
firstName VARCHAR(30) NOT NULL,
middleName VARCHAR(30),
lastName VARCHAR(30) NOT NULL,
emergencyContactID INT,
phoneNum VARCHAR(16) NOT NULL,
passportNum VARCHAR(16) NOT NULL,
previousCruisesCount INT UNSIGNED NOT NULL,
emailAddress VARCHAR(64) NOT NULL,
passwordHash VARCHAR(64) NOT NULL,
passwordSalt VARCHAR(64) NOT NULL,
creditCardNum VARCHAR(20) NOT NULL,
disabilityAssistance BIT NOT NULL
) ENGINE=InnoDB;

INSERT into Customer (firstName,middleName,lastName,phoneNum,passportNum,previousCruisesCount,emailAddress,passwordHash,passwordSalt,creditCardNum,disabilityAssistance)
	values('James','Thurgood','Marshall','555-5555','123','0','nobody@nowhere.net','hash','salt','abignumber','0'),
	('Joseph','James','Jones','666-3412','456','2','slamdunk@nba.org','ALKJFDKJF','3485jjj','44304500888888888','1'),
	('Cody','Dee','Fuller','383-3495','999','8','cfuller@wowway.net','JSDIFJEH','asdf87','3473888837519387','0'),
	('Caleb','Joshua','Ugent','837-3813','274','0','cugent@gmail.com','38YGH','385GHH','2395352717369999','1'),
	('Jack','Thomas','Mann','735-2731','318','4','netmaster292@gmail.com,','ADFHIEY','DFJGHII','57289837644153848','1');

CREATE TABLE Discount
(
discountCode VARCHAR(16) PRIMARY KEY,
flatReduction DECIMAL(6, 2),
percentageReduction FLOAT(4, 2),
summary VARCHAR(64)
) ENGINE=InnoDB;

INSERT INTO Discount (discountCode,flatReduction,percentageReduction,summary)
	values('RETURN','250.00','0.0','For previous cruisers'),
	('ITSHAPPENING','0.0','2.5','Social Media Promotional'),
	('SODAPASS','0.0','100.00','Soda Pass'),
	('TURNUPTURNUP','0.0','5.0','Spring Break'),
	('WEREGOINGDOWN','1000.00','0.0','For Bessie Only');

CREATE TABLE Transaction
(
transactionID INT AUTO_INCREMENT PRIMARY KEY,
customerID INT NOT NULL,
itemID INT NOT NULL,
transactTime DATETIME NOT NULL,
amountPaid DECIMAL(7, 2) NOT NULL,
discountCode VARCHAR(16),
FOREIGN KEY (customerID) REFERENCES Customer(customerID),
FOREIGN KEY (itemID) REFERENCES Item(itemID),
FOREIGN KEY (discountCode) REFERENCES Discount(discountCode)
) ENGINE=InnoDB;

INSERT INTO Transaction (customerID,itemID,transactTime,amountPaid,discountCode)
	values('1','2','2004-05-23T14:25:10.487','3000.00',NULL),
	('2','2','2006-09-12T09:30:23.008','1200.00',NULL),
	('3','2','2008-02-23T17:23:12.374','1500.00',NULL),
	('4','2','2010-07-30T23:59:59.999','1250.00',NULL),
	('5','2','2016-07-14T00:14:08.384','800.00','ITSHAPPENING');

CREATE TABLE EmergencyContact
(
emergencyContactID INT AUTO_INCREMENT PRIMARY KEY,
customerID INT NOT NULL,
firstName VARCHAR(30) NOT NULL,
middleName VARCHAR(30),
lastName VARCHAR(30) NOT NULL,
relationship VARCHAR(30),
phoneNum VARCHAR(16) NOT NULL,
emailAddress VARCHAR(64),
FOREIGN KEY (customerID) REFERENCES Customer(customerID)
) ENGINE=InnoDB;

INSERT INTO EmergencyContact (customerID,firstName,middleName,lastName,relationship,phoneNum,emailAddress)
	values('1','Michael','J.','Fox','Brother','815-666-6666','mjf@gmail.com'),
	('2','James','Earl','Jones','Father','303-374-8457','jjones@gmail.com'),
	('3','James','Earl','Ray','Uncle','773-381-3314','jray@kennedy.com'),
	('4','Lee','Harvey','Oswald','Husband','773-882-1374','leeoswald@yahoo.com'),
	('5','Joanne','Quincy','Adams','Mother','779-283-1882','america@america.net');

CREATE TABLE Route 
(
routeID INT UNSIGNED NOT NULL,
portID INT NOT NULL,
stayLengthDays INT UNSIGNED NOT NULL,
queue INT NOT NULL,
FOREIGN KEY (portID) REFERENCES Port(portID)
) ENGINE=InnoDB;

/* 
Since Route(routeID) isn't a primary key we need to
create an index on it in order to use it as a foreign key 
in Cruise
//
http://stackoverflow.com/questions/4063141/mysql-foreign-key-error-1005-errno-150
//
*/

CREATE INDEX RIndex
ON Route (routeID);

INSERT INTO Route (routeID,portID,stayLengthDays,queue)
	values('1','1','1','1'),
	('1','2','1','1'),
	('1','3','1','1'),
	('2','4','1','2'),
	('2','5','2','1');
	
CREATE TABLE Cruise
(
cruiseID INT AUTO_INCREMENT PRIMARY KEY,
routeID INT UNSIGNED NOT NULL,
shipName VARCHAR(64) NOT NULL,
startPortID INT NOT NULL,
endPortID INT NOT NULL,
startDateTime DATETIME NOT NULL,
endDateTime DATETIME NOT NULL,
FOREIGN KEY (shipName) REFERENCES Ship(shipName),
FOREIGN KEY (startPortID) REFERENCES Port(portID),
FOREIGN KEY (endPortID) REFERENCES Port(portID),
FOREIGN KEY (routeID) REFERENCES Route(routeID)
) ENGINE=InnoDB;

INSERT INTO Cruise (routeID,shipName,startPortID,endPortID,startDateTime,endDateTime)
	values('1','S.S. Ese','1','3','2016-03-13-T22:32:22','2016-03-18-T23:50:33'),
	('1','Bessie','1','3','2016-09-13T12:00:00','2016-09-20T12:00:00'),
	('1','S.S. Gourmet','1','3','2017-10-10T12:00:00','2017-10-20T12:00:00'),
	('2','The Krusty Bucket','3','5','2011-05-30T12:00:00','2011-06-07T12:00:00'),
	('2','The Salty Spitoon','3','5','2018-06-10T12:00:00','2018-06-17T12:00:00');

CREATE TABLE Listing
(
listingNum INT AUTO_INCREMENT PRIMARY KEY,
cruiseID INT NOT NULL,
cabinNum INT NOT NULL,
priceFirstTwoPassengers DECIMAL(7, 2) NOT NULL,
priceExtraPassengers DECIMAL(7, 2) NOT NULL,
FOREIGN KEY (cruiseID) REFERENCES Cruise(cruiseID),
FOREIGN KEY (cabinNum) REFERENCES Cabin(cabinNum)
) ENGINE=InnoDB;

INSERT INTO Listing (cruiseID,cabinNum,priceFirstTwoPassengers,priceExtraPassengers)
	values('1','1','1000.00','150.00'),
	('2','2','1500.00','200.00'),
	('3','3','2000.00','300.00'),
	('4','4','1000.00','150.00'),
	('5','5','1250.00','125.00');

CREATE TABLE Reservation
(
reservationNum INT AUTO_INCREMENT PRIMARY KEY,
customerID INT NOT NULL,
itemID INT NOT NULL,
transactionID INT NOT NULL,
listingNum INT NOT NULL,
FOREIGN KEY (customerID) REFERENCES Customer(customerID),
FOREIGN KEY (itemID) REFERENCES Item(itemID),
FOREIGN KEY (transactionID) REFERENCES Transaction(transactionID),
FOREIGN KEY (listingNum) REFERENCES Listing(listingNum)
) ENGINE=InnoDB;

INSERT INTO Reservation (customerID,itemID,transactionID,listingNum)
	values('1','2','1','1'),
	('2','2','2','2'),
	('3','2','3','3'),
	('4','2','4','4'),
	('5','2','5','5');

CREATE TABLE Passenger
(
customerID INT,
cabinNum INTEGER,
FOREIGN KEY (cabinNum) REFERENCES Cabin(cabinNum),
CONSTRAINT PKPassenger PRIMARY KEY (customerID),
CONSTRAINT FKPassenger FOREIGN KEY (customerID) REFERENCES Customer(customerID) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO Passenger (customerID,cabinNum)
	values('1','1'),
	('2','2'),
	('3','3'),
	('4','5'),
	('5','4');

CREATE TABLE Amenity
(
amenityID INT AUTO_INCREMENT PRIMARY KEY,
shipName VARCHAR(64) NOT NULL,
itemID INT NOT NULL,
price DECIMAL(6, 2) NOT NULL,
description VARCHAR(200),
currentAvailability BIT NOT NULL,
FOREIGN KEY (shipName) REFERENCES Ship(shipName),
FOREIGN KEY (itemID) REFERENCES Item(itemID)
) ENGINE=InnoDB;

INSERT INTO Amenity (shipName,itemID,price,description,currentAvailability)
	values('The Krusty Bucket','1','27.50','Imported Beer','1'),
	('The Krusty Bucket','1','4.50','Can of Soda','1'),
	('S.S. Gourmet','1','50.00','Casino Cover Charge','1'),
	('The Salty Spitoon','1','10.00','Domestic Beer','1'),
	('S.S. Ese','1','70.00','Wine','1');

CREATE TABLE Excursion (
excursionID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
itemID int NOT NULL,
excName varchar(64) NOT NULL,
excDescription varchar(200) DEFAULT NULL,
maxCapacity int NOT NULL,
price decimal(6,2) NOT NULL,
portID int NOT NULL,
FOREIGN KEY (itemID) REFERENCES Item(itemID),
FOREIGN KEY (portID) REFERENCES Port(portID)
) ENGINE=InnoDB;

INSERT INTO Excursion (itemID,excName,excDescription,maxCapacity,price,portID)
	values('3','dogsledding','trip to huskie training grounds','15','250.00','1'),
	('3','lumberjack show','exciting lumbersports event','200','500.00', '2'),
	('3','drowning','the ship sinks here','1000','1500.00','5'),
	('3','candlelit vigil','remembering previous cruises','1000','200.00','3'),
	('3','Bermudan night','once in a lifetime opportunity to enjoy fine Bermudan culture','1000','125.00','4');

CREATE TABLE ExcursionOccurrence
(
excursionID INT NOT NULL,
numParticipants INT UNSIGNED NOT NULL DEFAULT 0,
cruiseID INT NOT NULL,
FOREIGN KEY (excursionID) REFERENCES Excursion(excursionID),
FOREIGN KEY (cruiseID) REFERENCES Cruise(cruiseID)
) ENGINE=InnoDB;

INSERT INTO ExcursionOccurrence (excursionID,numParticipants,cruiseID)
	values('3','1000','4'),
	('2','5','3'),
	('1','2','1'),
	('4','1000','5'),
	('5','1000','5');

CREATE TABLE PortLog
(
cruiseID INT NOT NULL,
portID INT NOT NULL,
arrivedDateTime DATETIME,
departedDateTime DATETIME,
FOREIGN KEY (cruiseID) REFERENCES Cruise(cruiseID),
FOREIGN KEY (portID) REFERENCES Port(portID)
) ENGINE=InnoDB;

INSERT INTO PortLog (cruiseID,portID,arrivedDateTime,departedDateTime)
	values('1','1','2012-12-12T12:00:00','2012-12-13T00:00:00'),
	('2','3','2012-12-13T12:00:00','2012-14-14T00:00:00'),
	('3','2','2012-12-14T12:00:00','2012-12-15T00:00:00'),
	('4','3','2012-12-14T12:00:00','2012-12-15T00:00:00'),
	('5','4','2012-12-14T12:00:00','2012-12-15T00:00:00');