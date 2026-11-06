<?php
// Station 3: PHP session and order helpers.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
function desserts(): array { return ['Cheesecake', 'Chocolate Cake', 'Carrot Cake', 'Tiramisu']; }
function drinks(): array { return ['Coffee', 'Hot Chocolate', 'Root Beer', 'Tea', 'Milk']; }
function sizes(): array { return ['Small', 'Medium', 'Large']; }
function order(): string {
    // Validate submitted data against menu choices to avoid storing arbitrary input.
    $dessert = $_POST['dessert'] ?? 'none';
    $drink = $_POST['drink'] ?? 'none';
    $drinkSize = $_POST['drinkSize'] ?? '';
    $_SESSION['dessert'] = is_string($dessert) && in_array($dessert, desserts(), true) ? $dessert : '(not selected)';
    $_SESSION['drink'] = is_string($drink) && in_array($drink, drinks(), true) ? $drink : '(not selected)';
    $_SESSION['drinkSize'] = is_string($drinkSize) && in_array($drinkSize, sizes(), true) ? $drinkSize : '(not selected)';
    return 'Dessert: ' . h($_SESSION['dessert']) . '<br>'
       . 'Drink: ' . h($_SESSION['drink']) . '<br>'
       . 'Drink size: ' . h($_SESSION['drinkSize']);
}
function sessionValue(string $key): string { return $_SESSION[$key] ?? '(not selected)'; }
function completedChoiceCount(): int {
    $count = 0;
    foreach (['dessert', 'drink', 'drinkSize'] as $key) {
        if (sessionValue($key) !== '(not selected)') $count++;
    }
    return $count;
}
function completionMessage(): string {
    $count = completedChoiceCount();
    if ($count === 3) return 'Your order is complete and ready to submit.';
    if ($count === 0) return 'Start by choosing a dessert, a drink, and a size.';
    return "You have completed {$count} of 3 order choices.";
}
function pairingSuggestion(): string {
    $dessert = sessionValue('dessert');
    $drink = sessionValue('drink');
    if ($dessert === '(not selected)' || $drink === '(not selected)') return 'Select both a dessert and a drink to see a suggested pairing.';
    if ($dessert === 'Cheesecake' && $drink === 'Coffee') return 'Suggested pairing: Cheesecake and coffee create a classic cafe-style combo.';
    if ($dessert === 'Chocolate Cake' && $drink === 'Milk') return 'Suggested pairing: Chocolate cake and milk make a rich and familiar dessert pairing.';
    if ($dessert === 'Tiramisu' && $drink === 'Coffee') return 'Suggested pairing: Tiramisu and coffee reinforce the espresso flavor profile.';
    if ($dessert === 'Carrot Cake' && $drink === 'Tea') return 'Suggested pairing: Carrot cake and tea create a lighter and balanced combination.';
    return "Suggested pairing: {$dessert} with {$drink} gives the order a custom bistro feel.";
}
function dessertPrice(): float {
    $prices = ['Cheesecake'=>4.25, 'Chocolate Cake'=>4.50, 'Carrot Cake'=>4.00, 'Tiramisu'=>4.75];
    return $prices[sessionValue('dessert')] ?? 0.0;
}
function drinkPrice(): float {
    $base = ['Coffee'=>2.25, 'Hot Chocolate'=>2.75, 'Root Beer'=>2.50, 'Tea'=>2.00, 'Milk'=>1.75];
    $extra = ['Small'=>0.0, 'Medium'=>0.60, 'Large'=>1.15];
    $drink = sessionValue('drink');
    if (!isset($base[$drink])) return 0.0;
    return $base[$drink] + ($extra[sessionValue('drinkSize')] ?? 0.0);
}
function estimatedTotal(): float { return dessertPrice() + drinkPrice(); }
function formattedTotal(): string { return '$' . number_format(estimatedTotal(), 2); }
function pricingNote(): string {
    if (sessionValue('drink') !== '(not selected)' && sessionValue('drinkSize') === '(not selected)') return 'Choose a drink size to finalize the drink price.';
    if (completedChoiceCount() === 0) return 'Your estimated total will update as soon as you begin building the order.';
    return 'The estimate is based on the current dessert, drink, and drink size selections.';
}
function orderProfile(): string {
    $total = estimatedTotal();
    if ($total >= 6.5) return 'Full cafe combo';
    if ($total >= 4.0) return 'Balanced dessert break';
    if ($total > 0) return 'Light snack order';
    return 'No selections yet';
}
function dessertSelected(string $dessert): string { return sessionValue('dessert') === $dessert ? 'selected' : ''; }
function drinkSelected(string $drink): string { return sessionValue('drink') === $drink ? 'selected' : ''; }
function drinkSizeSelected(string $drinkSize): string { return sessionValue('drinkSize') === $drinkSize ? 'checked' : ''; }
?>
