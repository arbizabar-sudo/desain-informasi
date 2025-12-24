<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->in(__FILE__);

it('returns debug notify page', function () {
    $res = $this->get('/debug/notify');
    $res->assertStatus(200)->assertSee('Simulate Notification');
});
