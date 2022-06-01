<?php

require __DIR__ . '/vendor/autoload.php';

const BUSINESS_ACCOUNT = 'business';
const PRIVATE_ACCOUNT = 'private';

const DATE_INDEX = 0;
const USER_ID_INDEX = 1;
const USER_TYPE_INDEX = 2; //BUSINESS_ACCOUNT OR PRIVATE_ACCOUNT
const TRANSACTION_TYPE_INDEX = 3; // WITHDRAW OR DEPOSIT
const AMOUNT_INDEX = 4;
const CURRENCY_INDEX = 5;

$csvFile = $argv[1] ?? null;

$operations = [];
$file = fopen($csvFile, 'r');
while (! feof($file)) $operations[] = fgetcsv($file);
fclose($file);

$records = \App\Service\Records::getInstance();
foreach ($operations as $operation) {

    if ($operation[USER_TYPE_INDEX] === PRIVATE_ACCOUNT) {
        $account = new \App\PrivateAccount($operation[USER_ID_INDEX]);
    }

    if ($operation[USER_TYPE_INDEX] === BUSINESS_ACCOUNT) {
        $account = new \App\BusinessAccount($operation[USER_ID_INDEX]);
    }

    $transaction = new \App\Service\Transaction(
        $account,
        $operation[TRANSACTION_TYPE_INDEX],
        $operation[AMOUNT_INDEX],
        $operation[CURRENCY_INDEX],
        $operation[DATE_INDEX]
    );

    echo number_format($records->add($transaction), 2, '.', '') . PHP_EOL;
}