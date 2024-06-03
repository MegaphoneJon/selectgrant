<?php
namespace Civi\Afform\Behavior;

use Civi\Afform\AbstractBehavior;
use Civi\Afform\Event\AfformPrefillEvent;
use Civi\Core\HookInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use CRM_Selectgrant_ExtensionUtil as E;

/**
 * @service selectgrant
 */
class SelectGrant extends AbstractBehavior implements EventSubscriberInterface, HookInterface {

  public static function getSubscribedEvents() {
    return [
      'civi.afform.prefill' => ['onAfformPrefill', 100],
    ];
  }

  public static function getEntities():array {
    return ['Grant'];
  }

  public static function getTitle():string {
    return E::ts('Grant Prefill');
  }

  public static function getDescription():string {
    return E::ts('Find the latest grant, optionally filtering by type and status.');
  }

  public static function getTemplate(): ?string {
    // return '~/behaviors/selectGrantBehavior.html';
    // This is for testing when we put the files in core.
    return '~/afGuiEditor/behaviors/selectGrantBehavior.html';
  }

  public static function getModes(string $contactType):array {
    $modes[] = [
      'name' => 'selectlatest',
      'label' => 'Select Latest Grant of Organization1',
    ];
    return $modes;
  }

  public static function onAfformPrefill(AfformPrefillEvent $event): void {
    if ('Grant' === $event->getEntityType()) {
      $entity = $event->getEntity();
      $contactId = $event->getEntityIds('Organization1')[0];
      if ($entity['select-grant'] === 'selectlatest') {
        $grantQuery = \Civi\Api4\Grant::get(TRUE)
          ->addWhere('contact_id', '=', $contactId);
        if (isset($entity['select-grant-grant-type'])) {
          // This garbage is because sometimes the value is saved as [object Object] but I think array conversion is broken.
          foreach ($entity['select-grant-grant-type'] as $type) {
            if (is_numeric($type)) {
              $types[] = $type;
            }
          }
          if (isset($types)) {
            $grantQuery->addWhere('grant_type_id', 'IN', $types);
          }
        }
        if (isset($entity['select-grant-grant-status'])) {
          // This garbage is because sometimes the value is saved as [object Object] but I think array conversion is broken.
          foreach ($entity['select-grant-grant-status'] as $status) {
            if (is_numeric($status)) {
              $statuses[] = $status;
            }
          }
          if (isset($statuses)) {
            $grantQuery->addWhere('status_id', 'IN', $statuses);
          }
        }
        $grant = $grantQuery->execute()->first();
        if ($grant['id']) {
          $event->getApiRequest()->loadEntity($entity, [$grant['id']]);
        }
      }
    }
  }

  /**
   * This is necessary because autocompletes don't filter on fields not visible for security.
   */
  public function on_civi_api_prepare(\Civi\API\Event\PrepareEvent $event): void {
    $apiRequest = $event->getApiRequest();
    if (
      // APIv3 requests are not an object so check that first
      is_object($apiRequest) &&
      // We're only interested in Autocomplete actions
      is_a($apiRequest, 'Civi\Api4\Generic\AutocompleteAction') &&
      $apiRequest->getFormName() === 'afformAdmin' &&
      $apiRequest->getEntityName() === 'OptionValue'
    ) {
      $clientFilters = $apiRequest->getFilters();
      if (isset($clientFilters['option_group_id.name'])) {
        $apiRequest->addFilter('option_group_id.name', $clientFilters['option_group_id.name']);
        $apiRequest->addFilter('is_active', $clientFilters['is_active']);
      }
    }
  }

}
