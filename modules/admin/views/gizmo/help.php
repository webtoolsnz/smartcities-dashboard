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

use app\assets\AppAsset;

$appAssets = AppAsset::register($this);

$this->title = Yii::t('app', 'Gizmo Templates');
?>
<p>
    Templates consist of script elements and are processed by <a href="http://mustache.github.io/">Mustache</a>. eg:

<pre>
&lt;script type="x-tmpl-mustache"&gt;
  Hello, world!
&lt;/script&gt;
</pre>

<p>Gizmos that get data from an API endpoint can be configured using the 'data-endpoint' attribute.</p>
<p>Variables returned from that endpoint are available to the templates:</p>

<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="http://example.com/endpoint"&gt;
  {{salutation}}, {{scope}}!
&lt;/script&gt;
</pre>

<p>
    Example endpoint response:
</p>
<pre>
{
  "salutation": "Hello",
  "scope": "world"
}
</pre>

<p>Lists can be iterated over:</p>

<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="http://example.com/endpoint"&gt;
  {{#cannedresponses}}
    {{salutation}}, {{scope}}!
  {{/cannedresponses}}
&lt;/script&gt;
</pre>

<p>
    Example endpoint response:
</p>
<pre>
{
  "cannedresponses": [{
    "salutation": "Hello",
    "scope": "world"
  }, {
    "salutation": "Bonjour",
    "scope": "le monde"
  }, {
    "salutation": "Hola",
    "scope": "mundo"
  }]
}
</pre>

Endpoint URLs can be local or cross-domain; cross-domain endpoint responses must have the appropriate CORS headers set, eg:

<pre>
access-control-allow-origin:http://<?= Yii::$app->getRequest()->serverName ?>
</pre>

The response from endpoints should be JSON. The specific structure of the response depends on the way it is to be displayed by gadgets.

The following examples demonstrate the structure of the response, as well as how each display type uses the response data.

<h2>Graphs</h2>
Graphs can be of many types:

<!-- Line -->
<h3>Line</h3>

<div class="row">

<div class="col-md-8">
    <pre>
&lt;script type="x-tmpl-mustache" data-endpoint="licenses/alcohol"&gt;
  &lt;ul data-graph-type="line" data-graph-colour="#fdd2ce" data-graph-series="<span class="hilight">Received</span>"&gt;&lt;/ul&gt;
&lt;/script&gt;
</pre>

    <p>
    where 'data-graph-series' refers to the name of the variable in the JSON data (from the endpoint) that you wish to display in the graph.
    </p>

    <p>
        Example endpoint response:
    </p>
    <pre>
{
    "<span class="hilight">Received</span>": [{
          "label": "Jan",
          "value": 23
      }, {
          "label": "Feb",
          "value": 16
      }, {
          "label": "Mar",
          "value": 20
      },
    ...
    ]
}
</pre>

</div>

<div class="col-md-4">
    <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/line-graph.png' ?>" alt="">
</div>
</div>

<!-- Bar -->
<h3>Bar</h3>

<div class="row">
    <div class="col-md-8">
	<pre>
&lt;ul data-graph-type="bar" data-graph-colour="#660066"&gt;
	</pre>

        <p>
Has the same options as a Line graph, the only difference being that the <b>data-graph-type</b> is <b>bar</b>.
        </p>

    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/bar-graph.png' ?>" alt="">
    </div>
</div>

<!-- Pie -->
<h3>Pie</h3>

<div class="row">
    <div class="col-md-8">
	<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="building-consents/issued"&gt;
  &lt;ul data-graph-type="pie" data-graph-sidebar="true"&gt;
    {{#components}}
      &lt;li data-value="{{value}}"&gt;{{key}}&lt;/li&gt;
    {{/components}}
  &lt;/ul&gt;
&lt;/script&gt;
	</pre>

        <p>
The <b>data-graph-sidebar="true"</b> attribute specifies that a table of the values should be rendered alongside the pie graph, and may be omitted.
        </p>

        <p>
            Example endpoint response:
        </p>
        <pre>
{
	"total": 7601,
	"as_of": "29 Nov 2015 - 29 Nov 2016",
	"components": [{
		"key": "Residential dwellings",
		"value": 1897
	}, {
		"key": "Amendments",
		"value": 1716
	}, {
		"key": "Burners",
		"value": 1481
	},
    ...
    ]
}
</pre>

    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/pie-chart.png' ?>" alt="">
        <br>
        With <b>data-graph-sidebar="true"</b>
        <br>
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/pie-chart-legend.png' ?>" alt="">
    </div>
</div>

<!-- Timelines  -->
<h3>Timelines</h3>

<div class="row">
    <div class="col-md-8">
	<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="community/events"&gt;
  &lt;ul data-graph-type="timeline" data-graph-colour="#24A4D5"&gt;
  {{#events}}
      &lt;li data-date="{{when}}"&gt;{{name}}&lt;/li&gt;
  {{/events}}
  &lt;/ul&gt;
&lt;/script&gt;
	</pre>

        <p>

        </p>

        <p>
            Example endpoint response:
        </p>
        <pre>
{
	"events": [{
          "when": "2016-12-17",
          "name": "Christmas Time Tunnel"
      }, {
          "when": "2016-12-19",
          "name": "ASB Junior Christmas Classic"
      }, {
          "when": "2016-12-20",
          "name": "Comedy by Candlelight"
      },
    ...
    ]
}
</pre>

    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/timeline.png' ?>" alt="">
    </div>
</div>




<h2>Maps</h2>

<div class="row">
    <div class="col-md-8">
<pre>
&lt;div data-map="-43.530987, 172.636561" data-map-zoom="12" data-endpoint="library/locations" data-markers="points"&gt;&lt;/div&gt;
</pre>

<p>
where 'data-markers' refers to the name of the variable in the JSON data (from the endpoint) that you wish to display in the map.
</p>
<p>
    The variable will be a list of objects with the following keys/values:
    <ul>
       <li><b>name</b>: Text that will appear as a header in the popup when the marker is clicked. (optional)</li>
       <li><b>desc</b>: Text that will appear under the header in the popup when the marker is clicked. (optional)</li>
       <li><b>lat</b>: Latitude of the marker.</li>
       <li><b>lng</b>: Longitude of the marker.</li>
    </ul>
</p>
        <p>
            Example endpoint response:
        </p>
        <pre>
{
  "points": [{
      "name": "Akaroa Library",
      "desc": "Currently closed",
      "lat": -43.8100425,
      "lng": 172.9633294
    }, {
      "name": "Aranui Library",
      "lat": -43.5122822,
      "lng": 172.6978561
    }, {
      "name": "Bishopdale Library",
      "lat": -43.4894632,
      "lng": 172.5867769
    },
    ...
  ]
}
</pre>

    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/map.png' ?>" alt="">
    </div>
</div>

<h2>Tabbed Gizmos</h2>

<div class="row">
    <div class="col-md-8">
<p>These Gizmos have a 'Header' option set to 'Tabbed'.</p>

<p>Each tab is specified using a <b>tab</b> element</p>

<p>Tab attributes</p>
<ul>
    <li><b>icon</b>: If set, this will be the icon displayed in the tab chooser for this tab.</li>
    <li><b>image</b>: If set, this will the image displayed in the tab chooser for this tab. Overrides the icon option.</li>
    <li><b>name</b>: If set, this will the text displayed in the tab chooser for this tab. Overrides the icon and image options.</li>
    <li><b>scroll</b>: If set to "yes", the tab will scroll vertically if its content is too long to display all in one go.</li>
</ul>

<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="faceted/data"&gt;
	&lt;tab icon="dollar"&gt;
		First tab content
	&lt;/tab&gt;
	&lt;tab name="Info" scroll="yes"&gt;
		Second tab content
	&lt;/tab&gt;
&lt;/script&gt;
</pre>
    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/tabs.png' ?>" alt="">
    </div>
</div>

<!-- Info Boxes -->
<h2>Info Boxes</h2>

<p>These Gizmos have a 'Header' option set to 'None'. The icon on the left side is specified using the 'Icon' option.</p>
<div class="row">
    <div class="col-md-8">
<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="waste/stocktake"&gt;
  &lt;span class="info-box-number">{{percentage}}% of streets completed&lt;/span&gt;
  &lt;div class="progress"&gt;
    &lt;div class="progress-bar"style="width:{{percentage}}%">&lt;/div&gt;
  &lt;/div&gt;
  &lt;span class="progress-description"&gt;
    {{tagged}} bins tagged this week
  &lt;/span&gt;
&lt;/script&gt;
</pre>

<p>
    Example endpoint response:
</p>
<pre>
{
  "percentage": 14,
  "tagged": 670
}
</pre>
    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/info-box.png' ?>" alt="">
    </div>
</div>

<!-- Sparklines -->
<h2>Sparklines</h2>

<p>Elements with a 'data-sparkline' attribute will have a sparkline graph rendered after them using the data in the attribute.</p>

<div class="row">
    <div class="col-md-8">
<pre>
&lt;script type="x-tmpl-mustache" data-endpoint="historical/data"&gt;
  &lt;span class="info-box-number" data-sparkline="{{historical}}"&gt;{{current}}&lt;/span&gt;
&lt;/script&gt;
</pre>

<p>
    Example endpoint response:
</p>
<pre>
{
  "historical": "260, 245, 230, 227, 188, 200, 221, 201, 250, 244, 275, 285",
  "current": 285
}
</pre>
    </div>

    <div class="col-md-4">
        <img class="img-responsive" src="<?= $appAssets->baseUrl . '/img/help/sparkline.png' ?>" alt="">
    </div>
</div>