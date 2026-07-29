<?php

use App\Http\Controllers\EmployeeController;

it('treats regular employees as till-service cards', function () {
    $controller = new EmployeeController();
    $method = new ReflectionMethod($controller, 'shouldUseTillServiceExpiry');
    $method->setAccessible(true);

    expect($method->invoke($controller, 'Regular'))->toBeTrue()
        ->and($method->invoke($controller, 'Daily Wages'))->toBeFalse()
        ->and($method->invoke($controller, ' regular '))->toBeTrue();
});
