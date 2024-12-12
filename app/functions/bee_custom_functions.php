<?php

/**
 * The first test function of the MVC framework creation course
 *
 * @return void
 */
function in_custom()
{
  return 'I am inside custom functions';
}

/**
 * Loads the different currencies supported in the test project
 *
 * @return void
 */
function get_coins()
{
  return
    [
      'MXN',
      'USD',
      'CAD',
      'EUR',
      'ARS',
      'AUD',
      'JPY'
    ];
}