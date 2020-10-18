<?php

use Mainnet\Api\WalletApi;
use Mainnet\Configuration;

require_once(__DIR__ . '/vendor/autoload.php');

$client = new WalletApi();
$wallet = $client->createWallet(['name' => 'buyer', 'network' => 'testnet']);

$walletId = $wallet->getWalletId();
$electronCashCashaddr = 'bchtest:qz0lnjufcvwlwyzk03xwp6e28sh5qv8xughw2u9asq';
printf("walletId is: %s %s", $walletId, PHP_EOL);
$depositAddress = $client->depositAddress(['walletId' => $walletId]);
printf("cashaddr is: %s %s", $depositAddress['cashaddr'], PHP_EOL);

printf("Getting UTXOs %s", PHP_EOL);
$t = microtime(true);
print(count($client->utxos(['walletId' => $walletId])->getUtxos()) . "\t");
print((microtime(true) - $t) . "\t");
$t = microtime(true);

$r = $client->sendMax(['walletId' => $walletId, 'cashaddr' => $electronCashCashaddr]);
print(microtime(true) - $t);

$balance = $client->balance(['walletId' => $walletId]);
print($balance->getUsd() . PHP_EOL);

?>