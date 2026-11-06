<?php
require __DIR__ . '/order_functions.php';
// Cookies and sessions must be handled before HTML output.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $orderSummary = order();
    $visitStamp = date('l, F j, Y g:i a');
    setcookie('lastVisit', $visitStamp, ['expires'=>time()+86400, 'path'=>'/', 'samesite'=>'Lax']);
} else {
    $orderSummary = 'Dessert: ' . h(sessionValue('dessert')) . '<br>'
        . 'Drink: ' . h(sessionValue('drink')) . '<br>'
        . 'Drink size: ' . h(sessionValue('drinkSize'));
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Chez Session | Receipt</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header><div class="brand">CHEZ SESSION</div><nav><a href="index.php">Menu</a><a class="current" href="process_order.php">Receipt</a><a href="forget_order.php">Forget order</a></nav></header>
<main class="narrow"><div class="section-number">ORDER RECEIPT</div><h1>Your receipt</h1><p>Here is a summary of your order.</p>
<div class="panel receipt"><h2>Order summary</h2><div class="receipt-card"><?= $orderSummary ?></div></div>
<div class="panel"><div class="insight-card"><h3>Order feedback</h3><p><?= h(completionMessage()) ?></p><p class="insight-note"><?= h(pairingSuggestion()) ?></p></div>
<div class="insight-card pricing-grid"><div><h3>Estimated total</h3><p class="price-figure"><?= h(formattedTotal()) ?></p></div><div><h3>Order profile</h3><p><?= h(orderProfile()) ?></p></div><p class="insight-note full-width-note"><?= h(pricingNote()) ?></p></div></div>
<div class="actions"><a class="button-link" href="index.php">Order again</a><a class="button-link secondary-link" href="forget_order.php">Forget order</a></div></main>
<footer>Chez Session | Web Programming Homework 3</footer></body></html>
