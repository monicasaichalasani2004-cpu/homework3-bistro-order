<?php
require __DIR__ . '/order_functions.php';
// Read the cookie before writing new response output.
$welcomeBack = isset($_COOKIE['lastVisit'])
    ? 'Welcome back! Your last visit was ' . h((string)$_COOKIE['lastVisit']) . '.'
    : 'First time at Chez Session? Welcome in!';
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Chez Session | Order</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header><div class="brand">CHEZ SESSION</div><nav><a class="current" href="index.php">Menu</a><a href="process_order.php">Receipt</a><a href="forget_order.php">Forget order</a></nav></header>
<main><section class="hero"><p class="eyebrow">WEB PROGRAMMING · HOMEWORK 03</p><h1>Bistro Order Form</h1><p>Choose a dessert, drink, and size. Your order will stay saved while your PHP session is active.</p><p class="welcome-note"><?= $welcomeBack ?></p></section>
<div class="two-col"><section class="panel"><div class="section-number">YOUR ORDER</div><h2>Place an order</h2>
<form action="process_order.php" method="post">
<label for="dessert">Dessert</label><select id="dessert" name="dessert"><option value="none">Choose a dessert</option><?php foreach (desserts() as $item): ?><option value="<?= h($item) ?>" <?= dessertSelected($item) ?>><?= h($item) ?></option><?php endforeach; ?></select>
<label for="drink">Drink</label><select id="drink" name="drink"><option value="none">Choose a drink</option><?php foreach (drinks() as $item): ?><option value="<?= h($item) ?>" <?= drinkSelected($item) ?>><?= h($item) ?></option><?php endforeach; ?></select>
<fieldset><legend>Drink size</legend><div class="sizes"><?php foreach (sizes() as $item): ?><label class="size"><input type="radio" name="drinkSize" value="<?= h($item) ?>" <?= drinkSizeSelected($item) ?>> <?= h($item) ?></label><?php endforeach; ?></div></fieldset>
<button type="submit">Submit order</button></form></section>
<aside class="panel side"><div class="section-number">ORDER DETAILS</div><h2>Order information</h2>
<div class="insight-card"><h3>Order status</h3><p><?= h(completionMessage()) ?></p><p class="insight-note"><?= h(pairingSuggestion()) ?></p></div>
<div class="insight-card pricing-grid"><div><h3>Estimated total</h3><p class="price-figure"><?= h(formattedTotal()) ?></p></div><div><h3>Order profile</h3><p><?= h(orderProfile()) ?></p></div></div><p class="note">Estimates reflect your last saved session order; submit the form to update.</p>
</aside></div></main><footer>Chez Session | Web Programming Homework 3</footer></body></html>
