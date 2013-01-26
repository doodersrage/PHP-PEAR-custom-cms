<?php
/**
 *  This Script Demonstrates how we can use the CSV_Reader class
 */
 
require_once ('csv_reader.php');
 
$read     =     new CSV_Reader;

$read->strFilePath     =     'read_it.csv';
$read->strOutPutMode   =     1;  // 1 will show as HTML 0 will return an array
/**
 * You must run this script to Set the essesntial Configuration
 */ 
$read->setDefaultConfiguration();
$read->readTheCsv();
$read->printOutPut(); // You can run this script or directly acces $read->arrOutPut to get the outpuy