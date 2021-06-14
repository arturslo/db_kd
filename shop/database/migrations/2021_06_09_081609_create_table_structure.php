<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<< EOF

CREATE TABLE Client (
  ClientId INT NOT NULL AUTO_INCREMENT,
  Firstname VARCHAR(100) NOT NULL,
  Lastname VARCHAR(100) NOT NULL,
  Email VARCHAR(100) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (ClientId),
  UNIQUE KEY (Email)
);

CREATE TABLE Basket (
  BasketId INT NOT NULL AUTO_INCREMENT,
  ClientId INT NOT NULL,
  PRIMARY KEY (BasketId),
  FOREIGN KEY (ClientId) REFERENCES Client(ClientId)
);

CREATE TABLE `Order` (
  OrderNo CHAR(30) NOT NULL,
  BasketId INT NOT NULL,
  CreatedAt TIMESTAMP NOT NULL,
  Status ENUM('PENDING', 'PAID', 'CANCELED', 'COMPLETED') NOT NULL,
  PRIMARY KEY (OrderNo),
  FOREIGN KEY (BasketId) REFERENCES Basket(BasketId)
);

CREATE TABLE ProductType (
  ProductTypeId INT NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  PRIMARY KEY (ProductTypeId)
);

CREATE TABLE Product (
  ProductNo CHAR(30) NOT NULL,
  ProductTypeId INT NOT NULL,
  ProductName VARCHAR(255) NOT NULL,
  ABV DECIMAL(3,1) NOT NULL,
  Price DECIMAL(18,2) NOT NULL,
  PRIMARY KEY (ProductNo),
  FOREIGN KEY (ProductTypeId) REFERENCES ProductType(ProductTypeId)
);

CREATE TABLE WarehouseRecord (
  WarehouseRecordId INT NOT NULL AUTO_INCREMENT,
  ProductNo CHAR(30) NOT NULL,
  AmountChange INT NOT NULL,
  Comment VARCHAR(255) NOT NULL,
  PRIMARY KEY (WarehouseRecordId),
  FOREIGN KEY (ProductNo) REFERENCES Product(ProductNo)
);

CREATE TABLE BankPayment (
  BankPaymentId CHAR(50) NOT NULL,
  OrderNo CHAR(30) NOT NULL,
  Amount DECIMAL(18,2) NOT NULL,
  Status CHAR(30) NOT NULL,
  PRIMARY KEY (BankPaymentId),
  FOREIGN KEY (OrderNo) REFERENCES `Order`(OrderNo)
);

CREATE TABLE User (
  UserId INT NOT NULL AUTO_INCREMENT,
  Firstname VARCHAR(100) NOT NULL,
  Lastname VARCHAR(100) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (UserId),
  UNIQUE KEY (Email)
);

CREATE TABLE Message (
  MessageId INT NOT NULL AUTO_INCREMENT,
  OrderNo CHAR(30) NOT NULL,
  Text TEXT NOT NULL,
  PRIMARY KEY (MessageId),
  FOREIGN KEY (OrderNo) REFERENCES `Order`(OrderNo)
);

CREATE TABLE BasketProduct (
  BasketId INT NOT NULL,
  ProductNo CHAR(30) NOT NULL,
  Quantity INT NOT NULL,
  PRIMARY KEY (BasketId, ProductNo),
  FOREIGN KEY (BasketId) REFERENCES Basket(BasketId),
  FOREIGN KEY (ProductNo) REFERENCES Product(ProductNo)
);

EOF;

        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_structure');
    }
}
