<?php

namespace App\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;


class TestJob extends Job implements ShouldQueue
{
    protected int $id;

    public function __construct($id)
    {
        $this->id = $id;
        // echo "TestJob created with id: " . $this->id;
        // echo("TestJob created with id: " . $this->id);
    }

    public function handle() {}
}
