<?php

namespace Tests\Unit;

use App\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /** @test */
    function computed_fullname_attribute()
    {
        $employee = new Employee(['first_name' => 'Maximiliano', 'last_name' => 'Monge']);

        $actual = $employee->fullname;

        $this->assertSame('Maximiliano Monge', $actual);
    }
}
