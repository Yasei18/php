<?php

const DB_HOST = 'localhost';
const DB_NAME = 'RegisterUser';
const DB_USER = 'root';
const DB_PASS = '';

function getDB(): bool|mysqli {
    return mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}