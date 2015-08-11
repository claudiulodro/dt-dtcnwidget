<?php
/*----------------------------------------
$Id: update-quiet.php,v 1.7 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

update-quiet.php - updates all feeds without producing output
----------------------------------------*/

ob_start();
$SUPPRESS_AUTH = 1;
require_once('init.php');

$feeds = RF_Feed::_retrieve_all();

for($i = 0; $i < count($feeds); $i++)
{
	$feeds[$i]->update();
}

ob_end_clean();
?>
