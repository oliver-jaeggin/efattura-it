<?php
include 'db_connect.php';

// create database tables
$sql_user = "CREATE TABLE IF NOT EXISTS user(
							id_user INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
							username VARCHAR(64) NOT NULL,
							psw VARCHAR(64) NOT NULL,
							u_country_code VARCHAR(64) NOT NULL,
							u_country VARCHAR(255) NOT NULL,
							u_state VARCHAR(64) NULL,
							u_cap VARCHAR(64) NOT NULL,
							u_city VARCHAR(255) NOT NULL,
							u_street VARCHAR(255) NOT NULL,
							u_street_nr VARCHAR(64) NOT NULL,
							u_vat_nr VARCHAR(64) NOT NULL,
							u_cf VARCHAR(64) NOT NULL,
							u_company_name VARCHAR(255) NULL,
							u_name VARCHAR(255) NULL,
							u_surname VARCHAR(255) NULL,
							u_email VARCHAR(255) NULL,
							u_pec VARCHAR(255) NULL,
							u_tel VARCHAR(64) NULL,
							u_web VARCHAR(255) NULL
		        )";
$res_user = $mysqli->query($sql_user);

$sql_client = "CREATE TABLE IF NOT EXISTS clients(
								id_client INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
								cl_country_code VARCHAR(64) NOT NULL,
								cl_country VARCHAR(255) NOT NULL,
								cl_state VARCHAR(64) NULL,
								cl_cap VARCHAR(64) NOT NULL,
								cl_city VARCHAR(255) NOT NULL,
								cl_street VARCHAR(255) NOT NULL,
								cl_street_nr VARCHAR(64) NOT NULL,
								cl_vat_nr VARCHAR(64) NULL,
								cl_cf VARCHAR(64) NULL,
								cl_destination_code VARCHAR(7) NULL,
								cl_company_name VARCHAR(255) NULL,
								cl_name VARCHAR(255) NULL,
								cl_surname VARCHAR(255) NULL,
								cl_display_name VARCHAR(255) NULL,
								cl_email VARCHAR(255) NULL,
								cl_pec VARCHAR(255) NULL,
								cl_template VARCHAR(64) NULL
							)";
$res_client = $mysqli->query($sql_client);

$sql_invoice = "CREATE TABLE IF NOT EXISTS invoices(
								id_inv INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
								inv_number VARCHAR(64) NOT NULL,
								inv_date DATE NULL,
								inv_currency VARCHAR(64) NULL,
								inv_client_id INT NULL,
								id_items TEXT NULL,
								subtotal VARCHAR(64) NULL,
								stamp VARCHAR(64) NULL,
								provision VARCHAR(64) NULL,
								discount VARCHAR(64) NULL,
								total VARCHAR(64) NULL,
								total_rounded VARCHAR(64) NULL,
								exchange_rate VARCHAR(64) NULL,
								total_eur VARCHAR(64) NULL,
								paid INT NULL
							)";
$res_invoice = $mysqli->query($sql_invoice);

$sql_items = "CREATE TABLE IF NOT EXISTS items(
							id_item INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
							item_id_inv INT NULL,
							item_description VARCHAR(255) NULL,
							item_qty VARCHAR(64) NULL,
							item_price VARCHAR(64) NULL,
							item_tax VARCHAR(64) NULL,
							item_total VARCHAR(64) NULL
						)";
$res_items = $mysqli->query($sql_items);