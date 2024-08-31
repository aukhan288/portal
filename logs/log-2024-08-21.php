<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2024-08-21 00:05:46 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:06:11 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:07:47 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:11:42 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:12:23 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:13:43 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:13:51 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:15:57 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:17:01 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:17:07 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:17:10 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:17:15 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:18:52 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:19:31 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:20:02 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:20:08 --> 404 Page Not Found: /index
ERROR - 2024-08-21 00:20:09 --> Query error: Column 'status' in where clause is ambiguous - Invalid query: SELECT `duedate` as `date`, `number`, `id`, `clientid`, `hash`, CASE tblclients.company WHEN ' ' THEN (SELECT CONCAT(firstname, ' ', lastname) FROM tblcontacts WHERE userid = tblclients.userid and is_primary = 1) ELSE tblclients.company END as company
FROM `tblinvoices`
LEFT JOIN `tblclients` ON `tblclients`.`userid`=`tblinvoices`.`clientid`
WHERE `status` NOT IN(2, 5)
AND (`duedate` BETWEEN "2024-07-29" AND "2024-09-09")
