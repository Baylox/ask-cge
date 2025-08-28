<?php

namespace App;

class DateRange
{
    private \DateTimeInterface $from;
    private \DateTimeInterface $to;

    public function __construct(\DateTimeInterface $from, \DateTimeInterface $to)
    {
        $this->from = $from;
        $this->to = $to;
    }


    public function getFrom(): \DateTimeInterface
    {
        return $this->from;
    }

    public function getTo(): \DateTimeInterface
    {
        return $this->to;
    }
}
