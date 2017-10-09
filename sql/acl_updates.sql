SELECT act.acltype, act.category, act.name, act.aclaccess, ra.access_override
FROM
  acl_roles_actions AS ra
  INNER JOIN acl_actions AS act ON ra.action_id = act.id
WHERE ra.role_id = '98021176-dc7a-9683-0630-59bf7fafe49d'
      AND ra.deleted = 0
      AND act.deleted = 0
      AND act.name IN ('import', 'export', 'massupdate')
ORDER BY act.category;

# Import+Export+MassUpdate(-99) === DISABLED
UPDATE acl_roles_actions AS ra
  INNER JOIN acl_actions AS act ON ra.action_id = act.id
SET ra.access_override = '-99'
WHERE ra.role_id = '98021176-dc7a-9683-0630-59bf7fafe49d'
      AND ra.deleted = 0
      AND act.deleted = 0
      AND act.name IN ('import', 'export', 'massupdate');

# Delete+Edit+List+View(75) === OWNER
UPDATE acl_roles_actions AS ra
  INNER JOIN acl_actions AS act ON ra.action_id = act.id
SET ra.access_override = '75'
WHERE ra.role_id = '98021176-dc7a-9683-0630-59bf7fafe49d'
      AND ra.deleted = 0
      AND act.deleted = 0
      AND act.name IN ('delete', 'edit', 'list', 'view');


# Access(-98) === NO ACCESS
UPDATE acl_roles_actions AS ra
  INNER JOIN acl_actions AS act ON ra.action_id = act.id
SET ra.access_override = '-98'
WHERE ra.role_id = '98021176-dc7a-9683-0630-59bf7fafe49d'
      AND ra.deleted = 0
      AND act.deleted = 0
      AND act.name = 'access';

