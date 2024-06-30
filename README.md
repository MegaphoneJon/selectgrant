# Select Grant
This is an extension that implements a FormBuilder behavior to allow an existing grant on an existing contact to be pre-filled on a form.  It's not in usable condition as-is - the contact is hard-coded to Organization1, and there is a [patch you must make to FormBuilder](https://chat.civicrm.org/civicrm/pl/491oze1jsfdejxgx3by1xrwrky) or your selections won't save.


This is an [extension for CiviCRM](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/), licensed under [AGPL-3.0](LICENSE.txt).

## Getting Started
When you add a Grant entity in the FormBuilder entity, you'll see a "Grant Autofill" section in its options.  It will pull the most recent grant, optionally filtered by type and status.
