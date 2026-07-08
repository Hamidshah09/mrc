<?php

test('mrc index preserves filter values in the form', function () {
    $response = $this->get('/mrc?search=Ali&search_type=groom_name&union_council_id=1&from=2024-01-01&to=2024-01-31');

    $response->assertOk();
    $response->assertSee('value="Ali"', false);
    $response->assertSee('value="groom_name" selected', false);
    $response->assertSee('name="from" id="from"', false);
    $response->assertSee('name="to" id="to"', false);
});
