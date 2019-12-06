CreatePayment.php
<?
require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
$card = new CreditCard();
$card->setType("visa")
  ->setNumber("4417119669820331")
  ->setExpireMonth("11")
  ->setExpireYear("2019")
  ->setCvv2("012")
  ->setFirstName("Joe")
  ->setLastName("Shopper");
  
  $fi = new FundingInstrument();
$fi->setCreditCard($card);
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
  ->setFundingInstruments(array($fi));
  
  $item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
  ->setCurrency('USD')
  ->setQuantity(1)
  ->setPrice('7.50');
$item2 = new Item();
$item2->setName('Granola bars')
  ->setCurrency('USD')
  ->setQuantity(5)
  ->setPrice('2.00');

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping('1.20')
  ->setTax('1.30')
  ->setSubtotal('17.50');
  $amount = new Amount();
$amount->setCurrency("USD")
  ->setTotal("20.00")
  ->setDetails($details);
  $transaction = new Transaction();
$transaction->setAmount($amount)
  ->setItemList($itemList)
  ->setDescription("Payment description");
  $payment = new Payment();
$payment->setIntent("sale")
  ->setPayer($payer)
  ->setTransactions(array($transaction));
  try {
  $payment->create($apiContext);
} catch (PayPal\Exception\PPConnectionException $ex) {
  echo "Exception: " . $ex->getMessage() . PHP_EOL;
  var_dump($ex->getData());
  exit(1);
}
?>
<html>
<head>
  <title>Direct Credit card payments</title>
</head>
<body>
  <div>
    Created payment:
    <?php echo $payment->getId();?>
  </div>
  <pre><?php var_dump($payment->toArray());?></pre>
  <a href='../index.html'>Back</a>
</body>
</html>