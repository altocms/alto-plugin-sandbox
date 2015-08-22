<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

/**
 * @package plugin Sandbox
 */

//define('TOPIC_STATUS_SANDBOX', 20);

$config = array();

// Если закомментировано или задано false, то рейтинг пользователя не учитывается
// Если задано число, то для пользователей с заданным рейтингом и выше публикации минуют песочницу
$config['user_rating_out'] = 3; //false;

// Рейтинг топика для выхода из песочницы
$config['topic_rating_out'] = 1;

// Вывод в виджете прямого эфира раздельный
$config['widget_stream_split'] = true;

return $config;

// EOF