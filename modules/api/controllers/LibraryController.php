<?php
/**
 * This file is part of webtoolsnz\smartcities-dashboard
 *
 * @copyright Copyright (c) 2017 Webtools Ltd
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/webtoolsnz/smartcities-dashboard
 * @package webtoolsnz/smartcities-dashboard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace app\modules\api\controllers;

use app\helpers\FunctionalHelper;



class LibraryController extends BaseController
{
    public function actionCredits() {
        return '{
            "credits" : [
                {
                    "key" : "dummy data",
                    "value" : "yes"
                }
            ]
        }';
    }


    public function actionLocations()
    {
        $data = [
            'markers' => [
                ["name" => "Akaroa Library",                        "lat" => -43.8100425,             "lng" => 172.96332940000002,],
                ["name" => "Aranui Library",                        "lat" => -43.5122822,             "lng" => 172.69785609999997,],
                ["name" => "Bishopdale Library",                    "lat" => -43.4894632,             "lng" => 172.58677690000002,],
                ["name" => "Central Library Manchester",            "lat" => -43.5382477,             "lng" => 172.64003920000005,],
                ["name" => "Central Library Peterborough",          "lat" => -43.52503366647045,      "lng" => 172.635697619574,],
                ["name" => "Diamond Harbour Library",               "lat" => -43.62638526764924,      "lng" => 172.74048398108982,],
                ["name" => "Fendalton Library",                     "lat" => -43.51377964438659,      "lng" => 172.59094516959226,],
                ["name" => "Hornby Library",                        "lat" => -43.544733822426984,     "lng" => 172.5233243306884,],
                ["name" => "Linwood Library",                       "lat" => -43.53267437780561,      "lng" => 172.67606462485355,],
                ["name" => "Little River Library",                  "lat" => -43.7805517,             "lng" => 172.77813809999998,],
                ["name" => "Lyttelton Library",                     "lat" => -43.60258524910379,      "lng" => 172.7207104653229,],
                ["name" => "Mobile Library",                        "lat" => -43.5320544,             "lng" => 172.63622540000006,],
                ["name" => "New Brighton Library",                  "lat" => -43.507026585933026,     "lng" => 172.72910501744389,],
                ["name" => "Outreach",                              "lat" => -43.49419041016871,      "lng" => 172.6070864509262,],
                ["name" => "Papanui Library",                       "lat" => -43.481759,              "lng" => 172.70699969999998,],
                ["name" => "Parklands Library",                     "lat" => -43.47744119266485,      "lng" => 172.61662970614316,],
                ["name" => "Redwood Library",                       "lat" => -43.50513951970527,      "lng" => 172.66294997297666,],
                ["name" => "Shirley Library",                       "lat" => -43.56136966293645,      "lng" => 172.6379706375733,],
                ["name" => "South Library",                         "lat" => -43.55637409399257,      "lng" => 172.6181724601105,],
                ["name" => "Spreydon Library",                      "lat" => -43.5816721,             "lng" => 172.5693387,],
                ["name" => "Te HÄpua Halswell Centre",             "lat" => -43.5358429,             "lng" => 172.56357000000003,],
                ["name" => "Upper Riccarton Library",               "lat" => -43.8100425,             "lng" => 172.96332940000002,],
            ]
        ];

        return json_encode($data);
    }

}
