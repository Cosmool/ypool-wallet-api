<?php
require('wallet.ypool.php');

$api = new YPoolWallet("your api key","your secret");

// get balance for bitcoin
var_dump($api->getBalance(YPoolCurrencies::BITCOIN));

// send 0.12345 litecoins to a target address (the token is optional, but protects from accidentally calling the same function twice)
var_dump($api->sendCoins(YPoolCurrencies::LITECOIN,"target address", 0.12345,"some token"));

// get all your dogecoin receive addresses
var_dump($api->getAddresses(YPoolCurrencies::DOGECOIN));

// generate a new receive address (token is also optional here)
var_dump($api->generateAddress(YPoolCurrencies::PRIMECOIN,"some token"));

// check a transaction by its id
var_dump($api->checkTransaction("transaction id"));

// check a transaction by its history id
var_dump($api->checkTransaction("history id",true));

// check the address statistics for one of your receive addresses
var_dump($api->checkAddressStatistic(YPoolCurrencies::RIECOIN,"your recv address"));

?>