<?php
/**
 * Whips up a new factory and persists it to the database.
 * @param  [type] $class      The desired model
 * @param  array  $attributes Optional attributes
 * @return Facades\Tests\Setup\ProjectFactory
 */
function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

/**
 * Whips up a new factory.
 * @param  [type] $class      The desired model
 * @param  array  $attributes Optional attributes
 * @return Facades\Tests\Setup\ProjectFactory
 */
function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}
