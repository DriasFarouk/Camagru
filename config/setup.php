<?php
include('database.php');
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
	$bdd->query("DROP DATABASE IF EXISTS camagru");
	$bdd->query("CREATE DATABASE camagru");
	$bdd->query("use camagru");

	//users
	$bdd->query("CREATE TABLE users(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				login TEXT NOT NULL,
				password TEXT NOT NULL,
				email TEXT NOT NULL,
				confirmed BIT NOT NULL,
				notification BIT NOT NULL)");

	//images
	$bdd->query("CREATE TABLE images(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				creator INT UNSIGNED NOT NULL,
				creation INT UNSIGNED NOT NULL)");

	//comments
	$bdd->query("CREATE TABLE comments(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				creator INT UNSIGNED NOT NULL,
				creation INT UNSIGNED NOT NULL,
				image INT UNSIGNED NOT NULL,
				comment TEXT NOT NULL)");

	//likes
	$bdd->query("CREATE TABLE likes(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				creator INT UNSIGNED NOT NULL,
				image INT UNSIGNED NOT NULL)");

	header('Location: /index.php');
}
catch (Exception $e)
{
	header("Location: /error.php");
	exit;
}
?>
