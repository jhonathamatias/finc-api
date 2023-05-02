<?php

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Defaulte date for São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Default Language for dates
setlocale(LC_ALL, 'pt');

// Desativa cache auto do php
session_cache_limiter('');