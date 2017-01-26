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

function DashManager(api) {
    this.api = api;

    this._gizmos = [];

    this._pendingMaps = [];

    this._fetchKeys = [];

    this._purgeStorageOnUnload = false;

    // Few 2012
    this._defaultColours = [
        '#4D4D4D',
        '#5DA5DA',
        '#FAA43A',
        '#60BD68',
        '#F17CB0',
        '#B2912F',
        '#B276B2',
        '#DECF3F',
        '#F15854'
    ];


    this.findGizmos = function() {
        var that = this;
        jQuery('.gizmo').each(function(index) {
            var gizmo = $(this);
            that.register({'id': gizmo.attr('id')});
        })
    }

    this.initFetchStorage = function() {
        var that = this;
        $( document ).ajaxComplete(function( event, xhr, settings ) {
            if (settings.url.indexOf(that.api) === 0) {
                var fetchKey = 'fetch:' + settings.url;
                sessionStorage.setItem(fetchKey, xhr.responseText);
                that._fetchKeys.push(fetchKey);
            }
        });
        if (this._purgeStorageOnUnload) {
            window.addEventListener("beforeunload", function() {
                for (var i = 0; i < that._fetchKeys.length; i++) {
                    sessionStorage.removeItem(that._fetchKeys[i]);
                }
            });
        }
    }

    this.initFetchStorage();

    this.fetchApi = function(endpoint) {
        var absoluteRegex = /^https?:\/\/|^\/\//i;

        var endpointUrl = absoluteRegex.test(endpoint) ? endpoint : this.api + '/' + endpoint;

        var fetchData = sessionStorage.getItem('fetch:' + endpointUrl);

        if (!!fetchData) {
            return {
                done: function(callback) {
                    callback.apply(this, [JSON.parse(fetchData)]);
                }
            }
        } else {
            return $.getJSON(endpointUrl);
        }
    }

    this.renderGizmo = function(gizmo) {
        var that = this;
        var element = jQuery('#' + gizmo.id);
        var body = element.find('.gizmo-body');
        var templates = element.find('script[type="x-tmpl-mustache"]');
        var isTemplated = false;
        templates.each(function(index) {
            var template = $(this).html();
            var endpoint = $(this).data('endpoint');
            isTemplated = true;
            that.fetchApi(endpoint).done(function(data) {
                var rendered = Mustache.render(template, data);
                body.append(rendered);
                that.renderGraphs(element, body, data);
                that.renderSparklines(element, body);
                that.renderMap(element, body);
                that.renderCredits(element, body, endpoint);
                element.find('.overlay').remove();
            });
        })
        this.renderGraphs(element, body);
        this.renderSparklines(element, body);
        this.renderMap(element, body);
        var sparkColour = body.css('color') || '#fff';
        element.find('.sparkline').sparkline('html', {
            lineColor: sparkColour,
            fillColor: false,
            minSpotColor: false,
            maxSpotColor: false,
            spotColor: sparkColour,
            spotRadius: 3
        });
        if (!isTemplated) {
            element.find('.overlay').remove();
        }
    }

    this.renderCredits = function(element, body, endpoint) {
        var credits = endpoint.split('/')[0] + '/credits';
        var creditsLink = $('<i class="credits-link fa fa-info-circle"></i>');
        var that = this;
        element.append(creditsLink);
        creditsLink.on('click', function(e) {
            e.preventDefault();
            that.fetchApi(credits).done(function(data) {
                var template = '{{#credits}} {{key}} : {{value}} <br />{{/credits}}';
                bootbox.dialog({
                    title: "Metadata for " + endpoint,
                    message: Mustache.render(template, data)
               });
            });
        });
    }

    this.renderSparkline = function(data, element) {
        var sparkline = $('<span class="sparkline"></span>')
        sparkline.text(data)
        sparkline.appendTo(element);
    }

    this.renderSparklines = function(element, body) {
        that = this;
        body.find('[data-sparkline]').each(function(index) {
            var datum = $(this);
            that.renderSparkline(datum.data('sparkline'), datum);
        })
    }

    this.renderSidebar = function(data, element, body) {
        var dataHolder = $('<div class="col-xs-12 col-sm-6 col-md-6 gizmo-sidebar"></div>');
        var dataTable = $('<table class="table table-condensed"></table>');
        var that = this;
        data.each(function(i) {
            var datum = $(this);
            var textColour = datum.data('colour') || that._defaultColours[i];
            var unit = datum.data('unit') || '';
            var supplement = datum.data('supp') ? ' (' + datum.data('supp') + ')' : '';
            var valueText = datum.data('value') + unit + supplement;
            var legend = '<span class="pie-legend" style="background-color:' + textColour + '"></span>';
            var row = $('<tr><td>' + legend + '</td><td>' + valueText + '</td><td>' + datum.text() + '</td></tr>');
            dataTable.append(row)
            dataHolder.append(dataTable)
            if (datum.data('sparkline')) {
                that.renderSparkline(datum.data('sparkline'), row.append('<td></td>').find('td').last());
            }
        });
        body.append(dataHolder);
    }

    this.renderPieGraph = function(holder, data, unit) {
        var that = this;
        var pieChartElement = $('<canvas class="gizmo-pie"></canvas>');
        holder.append(pieChartElement);
        var pieChartCanvas = pieChartElement.get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [];
        data.each(function(i) {
            var datum = $(this);
            var segmentColour = datum.data('colour') || that._defaultColours[i];
            var value = {
                value: datum.data('value'),
                color: segmentColour,
                label: datum.text()
            };
            PieData.push(value);
        })
        var dataUnit = unit || '';
        var pieOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            responsive: true,
            animation: false,
            maintainAspectRatio: false,
            tooltipTemplate: '<%=label%> : <%=value%>' + dataUnit
        }
        pieChart.Doughnut(PieData, pieOptions);
    }

    this.graphColours = function(colourData, n) {
        // Return n colours, from the colourData and/or default colours
        return colourData.split(',').concat(this._defaultColours).slice(0,n)
    }

    this.renderSeriesGraph = function(holder, data, colour, type, graph) {
        var seriesChartElement = $('<div class="canvas-holder"><canvas></canvas></div>');
        holder.append(seriesChartElement);
        var seriesChartCanvas = seriesChartElement.find('canvas').get(0).getContext("2d");
        var seriesChart = new Chart(seriesChartCanvas);
        var labelData = [];
        var that = this;

        var seriesData = {
            labels: [],
            datasets: []
        }

        var rawData = {'default' : []};
        if (data.jquery) {
            data.each(function(i) {
                rawData.default.push({
                    label: $(this).text(),
                    value: $(this).data('value')
                });
            });
        } else {
            rawData = data;
        }

        var i = 0;
        jQuery.each(rawData, function(j, series) {
            var dataset = []
            jQuery.each(series, function(k, sData) {
                if (i == 0) {
                    labelData.push(sData.label)
                }
                dataset.push(sData.value)
            });
            seriesData.datasets.push({
                'label': j,
                'fillColor': that.graphColours(colour, i+1)[i],
                'strokeColor': that.graphColours(colour, i+1)[i],
                'data': dataset
            });
            i++;
        })

        seriesData.labels = labelData;

        var scaleColour = graph.data('label-colour') || '#FFFFFF';

        var seriesOptions = {
            responsive: true,
            animation: true,
            datasetFill: false,
            maintainAspectRatio: false,
            pointDot: false,
            scaleShowHorizontalLines: false,
            scaleShowVerticalLines: false,
            bezierCurve: true,
            bezierCurveTension: 0.3,
            scaleShowLabels: false,
            scaleFontColor: scaleColour,
        }
        switch (type) {
            case 'bar':
                var series = seriesChart.RoundedBar(seriesData, seriesOptions);
                break;
            default:
                var series = seriesChart.Line(seriesData, seriesOptions);
        }
        if (seriesData.datasets.length > 1) {
            holder.append(series.generateLegend());
        }
    }

    this.renderTimeline = function(holder, data, colour) {
        var timelineElement = $('<ul class="gizmo-timeline"></ul>');
        holder.append(timelineElement);
        var todayInserted = false;
        var today = new Date();
        data.each(function(i) {
            var event = $(this).text();
            var date = $(this).data('date');
            if ((new Date(date)) >= today && !todayInserted) {
                todayInserted = true;
                timelineElement.append('<li class="now"></li>');
            }
            var eventElement = $('<li><span></span></li>')
            eventElement.attr('data-date', date).find('span').text(event);
            timelineElement.append(eventElement)
        })
    }

    this.renderGraphs = function(element, body, data) {
        var graphs = element.find('[data-graph-type]:visible')
        var that = this;
        var endpoint = element.find('[data-endpoint]').data('endpoint');
        graphs.each(function(i) {
            var graph = $(this);
            var graphColour = graph.data('graph-colour') || that._defaultColours[i];
            var graphHolder = graph.parent();
            var graphData = {};
            if (graph.data('graph-series')) {
                if (data) {
                    var series = graph.data('graph-series').split(',');
                    jQuery.each(series, function(i, s) {
                        graphData[s] = data[s];
                    })
                } else {
                    that.fetchApi(endpoint).done(function(data) {
                        that.renderGraphs(element, body, data);
                    });
                    return;
                }
            } else {
                graphData = graph.find('li');
            }
            if (graph.data('graph-sidebar')) {
                graphHolder = $('<div class="col-xs-12 col-sm-6 col-md-6"></div>')
                body.append(graphHolder);
                that.renderSidebar(graphData, element, body)
            }
            switch (graph.data('graph-type')) {
                case 'pie':
                    that.renderPieGraph(graphHolder, graphData, graph.data('unit'));
                    break;
                case 'line':
                case 'bar':
                    that.renderSeriesGraph(graphHolder, graphData, graphColour, graph.data('graph-type'), graph);
                    break;
                case 'timeline':
                    that.renderTimeline(graphHolder, graphData, graphColour);
                    break;
            }
            graph.remove();
        })
    }

    this.renderMap = function(element, body) {
        var map = body.find('div[data-map]');
        if (map.size() > 0) {
            this._pendingMaps.push(map);
            this._renderMaps();
        }
    }

    this._renderMaps = function() {
        if (window.google && google.maps) {
            var hiddenMaps = [];
            var that = this;
            jQuery.each(this._pendingMaps, function(i, pendingMap) {
                if (pendingMap.is(':hidden')) {
                    hiddenMaps.push(pendingMap);
                } else {
                    var coords = pendingMap.data('map').split(',');
                    var centre = {lat: parseFloat(coords[0]), lng: parseFloat(coords[1])};
                    var zoom = parseInt(pendingMap.data('map-zoom'));
                    var map = new google.maps.Map(pendingMap.get(0), {
                        'zoom': zoom,
                        'center': centre
                    });
                    // Markers can be specified by listing them below the map...
                    pendingMap.parent().find('[data-lat]').each(function(i, marker) {
                        var position = {lat: parseFloat($(marker).data('lat')), lng: parseFloat($(marker).data('lng'))};
                        new google.maps.Marker({
                            'position': position,
                            'map': map,
                            'title': $(marker).text()
                        });
                        marker.remove();
                    })
                    // ...or by specifying an endpoint and key
                    if (pendingMap.data('endpoint')) {
                        var gizmo = pendingMap.closest('.gizmo');
                        gizmo.append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

                        var endpoint = pendingMap.data('endpoint');
                        that.fetchApi(endpoint).done(function(data) {
                            var key = pendingMap.data('markers') ? pendingMap.data('markers') : 'markers';
                            var markers = data[key];
                            $.each(markers, function(i, marker) {
                                // marker
                                var position = { lat: parseFloat(marker.lat), lng: parseFloat(marker.lng) };
                                var mapMarker = new google.maps.Marker({
                                    'position': position,
                                    'map': map,
                                    'title': marker.label
                                });
                                // infowindow
                                var template = '<div><h4>{{name}}</h4><div>{{desc}}</div></div>';
                                var infowindow = new google.maps.InfoWindow({
                                    content: Mustache.render(template, marker)
                                });
                                mapMarker.addListener('click', function() {
                                    if (map.openInfoWindow) {
                                        map.openInfoWindow.close();
                                    }
                                    map.openInfoWindow = infowindow;
                                    infowindow.open(map, mapMarker);
                                });
                            });
                            that.renderCredits(gizmo, gizmo.find('.gizmo-body'), endpoint);
                            gizmo.find('.overlay').remove();
                        });
                    }
                }
            });
            this._pendingMaps = hiddenMaps;
        }
    }
}

DashManager.prototype.register = function(options) {
    this._gizmos.push(options);
}

DashManager.prototype.initGraphTypes = function() {
    Chart.types.Bar.extend({
        name: "RoundedBar",
        initialize: function (data) {
            Chart.types.Bar.prototype.initialize.apply(this, arguments);
            var that = this;

            this.datasets.forEach(function(dataset) {
                dataset.bars.forEach(function(bar) {
                    bar.draw = function() {
                        var radius = bar.width * 0.5;
                        var barHeight = Math.max(bar.height() + radius, bar.width-radius);
                        Chart.helpers.drawRoundedRectangle(
                            that.chart.ctx,
                            bar.x - radius,
                            bar.y - radius,
                            bar.width,
                            barHeight,
                            radius);
                        that.chart.ctx.fillStyle = bar.fillColor;
                        that.chart.ctx.fill();
                    }
                });
            });
        }
    });
}

DashManager.prototype.load = function() {
    var that = this;
    this.initGraphTypes();
    this.findGizmos();
    jQuery.each(this._gizmos, function(i, gizmo) {
        that.renderGizmo(gizmo);
    })
    $(document).on('shown.bs.tab', function (e) {
        that._renderMaps();
        var element = $(e.target).closest('.gizmo');
        var body = element.find('.gizmo-body');
        that.renderGraphs(element, body);
    })
}





