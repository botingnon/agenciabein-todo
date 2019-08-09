<?php
/**
 * Bootstrap Restler
 *
 * @category Api
 * @package  Bossabox
 * @author   Valdir Botingnon <valdir.botingnon@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:3000/doc
 */
require_once '../vendor/autoload.php';

use Luracast\Restler\Restler;
use Luracast\Restler\Resources;

Resources::$useFormatAsExtension = false;

\Luracast\Restler\Defaults::setProperty('cacheDirectory', dirname(__FILE__) . '/../cache');

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

require '../lib/rb.php';
\R::setup(
    'mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DBNAME'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASS')
);

$r = new Restler();
$r->addAPIClass('Todo\Api\Task');
$r->addAPIClass('Resources');
$r->handle();
