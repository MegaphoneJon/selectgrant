<?php
// Angular module crmSelectgrant.
// @see https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
return [
  'js' => [
    'ang/crmSelectgrant.js',
    'ang/crmSelectgrant/*.js',
    'ang/crmSelectgrant/*/*.js',
  ],
  'css' => [
    'ang/crmSelectgrant.css',
  ],
  'partials' => [
    'ang/crmSelectgrant',
  ],
  'requires' => [
    'crmUi',
    'crmUtil',
    'ngRoute',
    'afGuiEditor',
  ],
  'settings' => [],
  'basePages' => ['civicrm/admin/afform'],
];
