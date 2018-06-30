<?php

function create($class, $attrs = [], $times = null)
{
    return factory($class, $times)->create($attrs);
}

function make($class, $attrs = [], $times = null)
{
    return factory($class, $times)->make($attrs);
}
