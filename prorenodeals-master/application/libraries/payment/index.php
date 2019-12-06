<?php
include_once './payments/CreatePayment.php';

$create_payment = new CreatePayment();
echo $create_payment->make_payment();