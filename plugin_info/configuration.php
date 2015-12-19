<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
require_once dirname(__FILE__) . '/../vendor/autoload.php';
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}

try {
    $host = config::byKey('influxdbHost', 'influxdb', 0);
    $port = config::byKey('influxdbPort', 'influxdb', 0);
    $dbName = config::byKey('influxdbDatabase', 'influxdb', 0);
    log::add('influxdb', 'debug', "Connexion à InfluxDB: host=$host, port=$port, base=$dbName");
    $client = new InfluxDB\Client($host, $port);
    $database = $client->selectDB($dbName);
    if (!$database->exists()) {
        log::add('influxdb', 'error', "La base de données InfluxDB '$dbName' n'existe pas");
    }
} catch (Exception $e) {
    log::add('influxdb', 'error', displayExeption($e));
}
?>
<form class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Adresse du serveur}}</label>
            <div class="col-lg-2">
                <input class="configKey form-control" data-l1key="influxdbHost" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Port du serveur}}</label>
            <div class="col-lg-2">
                <input class="configKey form-control" data-l1key="influxdbPort" placeholder="8086" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Nom de la base de données}}</label>
            <div class="col-lg-2">
                <input class="configKey form-control" data-l1key="influxdbDatabase" placeholder="jeedom" />
            </div>
        </div>
  </fieldset>
</form>

