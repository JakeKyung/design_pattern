<?php
/**
 * Create by Jake 2023/01/31.
 * 전략 설계 패턴은 객체가 주어진 컨텍스트 기반으로 동작을 변경할 수 있도록 하는 행동 설계 패턴이다.
 * 이 패턴은 객체의 동작을 다른 전략으로 분리하고 런타임 객체가 이러한 전략들 사이를 전환할 수 있도록 하는 것을 포함한다.
 * 객체 자체를 수정하지 않고도 객체의 동작을 변경할 수 있기 때문에 코드의 유연성과 유지보수성을 향상시킬 수 있다.
 */
interface CalculateTotalCostStrategy {
    public function calculate(array $items);
}

class DiscountCodeStrategy implements CalculateTotalCostStrategy {
    public function calculate(array $items) {
        $discountPercent = 10;
        $discountCost = array_sum($items)/$discountPercent;
        // logic to apply discount code
        return array_sum($items) - $discountCost;
    }
}

class ShippingCostStrategy implements CalculateTotalCostStrategy {
    public function calculate(array $items) {
        $shippingCost = 3000;
        $totalCost = array_sum($items);
        // logic to calculate shipping costs
        return $totalCost < 30000 ? $totalCost + $shippingCost : $totalCost;
    }
}

class ShoppingCart {
    private $strategy;

    public function __construct(CalculateTotalCostStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function calculateTotalCost(array $items) {
        return $this->strategy->calculate($items);
    }
}

$items = array(10000, 5000, 20000);

$shoppingCart = new ShoppingCart(new DiscountCodeStrategy());
echo $shoppingCart->calculateTotalCost($items);
// output: 31500

$shoppingCart = new ShoppingCart(new ShippingCostStrategy());
echo $shoppingCart->calculateTotalCost($items);
// output: 35000

$items = array(10000, 3000, 5000);

$shoppingCart = new ShoppingCart(new DiscountCodeStrategy());
echo $shoppingCart->calculateTotalCost($items);
// output: 16200

$shoppingCart = new ShoppingCart(new ShippingCostStrategy());
echo $shoppingCart->calculateTotalCost($items);
// output: 21000