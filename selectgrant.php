<?php

require_once 'selectgrant.civix.php';

use CRM_Selectgrant_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function selectgrant_civicrm_config(&$config): void {
  _selectgrant_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function selectgrant_civicrm_install(): void {
  _selectgrant_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function selectgrant_civicrm_enable(): void {
  _selectgrant_civix_civicrm_enable();
}
