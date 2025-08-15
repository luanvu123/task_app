!                  t.image.path &&
                                ((o = t.image.width || 20),
                                (e = t.image.height || 20),
                                (r = this.annoCtx.addImage({
                                    x: a + t.image.offsetX - o / 2,
                                    y: s + t.image.offsetY - e / 2,
                                    width: o,
                                    height: e,
                                    path: t.image.path,
                                    appendTo: ".apexcharts-point-annotations",
                                }))),
                            t.mouseEnter &&
                                r.node.addEventListener(
                                    "mouseenter",
                                    t.mouseEnter.bind(this, t)
                                ),
                            t.mouseLeave &&
                                r.node.addEventListener(
                                    "mouseleave",
                                    t.mouseLeave.bind(this, t)
                                ),
                            t.click &&
                                r.node.addEventListener(
                                    "click",
                                    t.click.bind(this, t)
                                ));
                    },
                },
                {
                    key: "drawPointAnnotations",
                    value: function () {
                        var i = this,
                            t = this.w,
                            a = this.annoCtx.graphics.group({
                                class: "apexcharts-point-annotations",
                            });
                        return (
                            t.config.annotations.points.map(function (t, e) {
                                i.addPointAnnotation(t, a.node, e);
                            }),
                            a
                        );
                    },
                },
            ]),
            U);
    function U(t) {
        a(this, U),
            (this.w = t.w),
            (this.annoCtx = t),
            (this.helpers = new s(this.annoCtx));
    }
    function q(t) {
        a(this, q),
            (this.w = t.w),
            (this.annoCtx = t),
            (this.helpers = new s(this.annoCtx)),
            (this.axesUtils = new w(this.annoCtx));
    }
    function Z(t) {
        a(this, Z), (this.ctx = t), (this.w = t.w);
    }
    function $(t) {
        a(this, $),
            (this.ctx = t),
            (this.w = t.w),
            (this.tooltipKeyFormat = "dd MMM");
    }
    function J(t) {
        a(this, J),
            (this.ctx = t),
            (this.w = t.w),
            (this.months31 = [1, 3, 5, 7, 8, 10, 12]),
            (this.months30 = [2, 4, 6, 9, 11]),
            (this.daysCntOfYear = [
                0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334,
            ]);
    }
    function Q(t) {
        a(this, Q),
            (this.w = t.w),
            (this.annoCtx = t),
            (this.invertAxis = this.annoCtx.invertAxis),
            (this.helpers = new s(this.annoCtx));
    }
    function K(t) {
        a(this, K), (this.w = t.w), (this.annoCtx = t);
    }
    function tt(t) {
        a(this, tt), (this.ctx = t), (this.w = t.w);
    }
    function et(t) {
        a(this, et), (this.ctx = t), (this.w = t.w);
    }
    function it(t) {
        a(this, it), (this.ctx = t), (this.w = t.w);
    }
    function at(t) {
        a(this, at), (this.ctx = t), (this.w = t.w), this.setEasingFunctions();
    }
    function o() {
        a(this, o);
    }
    function st(t) {
        var e = t.isTimeline,
            i = t.ctx,
            a = t.seriesIndex,
            s = t.dataPointIndex,
            o = t.y1,
            r = t.y2,
            n = (t = t.w).globals.seriesRangeStart[a][s],
            l = t.globals.seriesRangeEnd[a][s],
            h = t.globals.labels[s],
            c = t.config.series[a].name || "",
            d = t.globals.ttKeyFormatter,
            g = t.config.tooltip.y.title.formatter,
            u = { w: t, seriesIndex: a, dataPointIndex: s, start: n, end: l },
            g =
                ("function" == typeof g && (c = g(c, u)),
                null != (g = t.config.series[a].data[s]) &&
                    g.x &&
                    (h = t.config.series[a].data[s].x),
                e ||
                    ("datetime" === t.config.xaxis.type &&
                        (h = new f(i).xLabelFormat(
                            t.globals.ttKeyFormatter,
                            h,
                            h,
                            {
                                i: void 0,
                                dateFormatter: new y(i).formatDate,
                                w: t,
                            }
                        ))),
                "function" == typeof d && (h = d(h, u)),
                Number.isFinite(o) && Number.isFinite(r) && ((n = o), (l = r)),
                ""),
            s = "",
            e = t.globals.colors[a];
        return (
            (s =
                void 0 === t.config.tooltip.x.formatter
                    ? "datetime" === t.config.xaxis.type
                        ? ((g = (d = new y(i)).formatDate(
                              d.getDate(n),
                              t.config.tooltip.x.format
                          )),
                          d.formatDate(d.getDate(l), t.config.tooltip.x.format))
                        : ((g = n), l)
                    : ((g = t.config.tooltip.x.formatter(n)),
                      t.config.tooltip.x.formatter(l))),
            {
                start: n,
                end: l,
                startVal: g,
                endVal: s,
                ylabel: h,
                color: e,
                seriesName: c,
            }
        );
    }
    function ot(t) {
        var e = t.color,
            i = t.seriesName,
            a = t.ylabel,
            s = t.start,
            o = t.end,
            r = t.seriesIndex,
            n = t.dataPointIndex,
            s = (l = t.ctx.tooltip.tooltipLabels.getFormatters(r)).yLbFormatter(
                s
            ),
            o = l.yLbFormatter(o),
            l = l.yLbFormatter(t.w.globals.series[r][n]),
            n = '<span class="value start-value">\n  '
                .concat(
                    s,
                    '\n  </span> <span class="separator">-</span> <span class="value end-value">\n  '
                )
                .concat(o, "\n  </span>");
        return (
            '<div class="apexcharts-tooltip-rangebar"><div> <span class="series-name" style="color: ' +
            e +
            '">' +
            (i || "") +
            '</span></div><div> <span class="category">' +
            a +
            ": </span> " +
            (!t.w.globals.comboCharts ||
            "rangeArea" === t.w.config.series[r].type ||
            "rangeBar" === t.w.config.series[r].type
                ? n
                : "<span>".concat(l, "</span>")) +
            " </div></div>"
        );
    }
    function rt(t) {
        var e = (function (t) {
                for (
                    var e,
                        i,
                        a,
                        s,
                        o = (function (t) {
                            for (
                                var e = [],
                                    i = t[0],
                                    a = t[1],
                                    s = (e[0] = Ke(i, a)),
                                    o = 1,
                                    r = t.length - 1;
                                o < r;
                                o++
                            )
                                (i = a),
                                    (a = t[o + 1]),
                                    (e[o] = 0.5 * (s + (s = Ke(i, a))));
                            return (e[o] = s), e;
                        })(t),
                        r = t.length - 1,
                        n = [],
                        l = 0;
                    l < r;
                    l++
                )
                    (a = Ke(t[l], t[l + 1])),
                        Math.abs(a) < 1e-6
                            ? (o[l] = o[l + 1] = 0)
                            : 9 <
                                  (s =
                                      (e = o[l] / a) * e +
                                      (i = o[l + 1] / a) * i) &&
                              ((s = (3 * a) / Math.sqrt(s)),
                              (o[l] = s * e),
                              (o[l + 1] = s * i));
                for (var h = 0; h <= r; h++)
                    (s =
                        (t[Math.min(r, h + 1)][0] - t[Math.max(0, h - 1)][0]) /
                        (6 * (1 + o[h] * o[h]))),
                        n.push([s || 0, o[h] * s || 0]);
                return n;
            })(t),
            i = t[1],
            a = t[0],
            s = [],
            o = e[1],
            r = e[0];
        s.push(a, [
            a[0] + r[0],
            a[1] + r[1],
            i[0] - o[0],
            i[1] - o[1],
            i[0],
            i[1],
        ]);
        for (var n = 2, l = e.length; n < l; n++) {
            var h = t[n],
                c = e[n];
            s.push([h[0] - c[0], h[1] - c[1], h[0], h[1]]);
        }
        return s;
    }
    var nt,
        lt,
        ht,
        ct,
        dt,
        gt = {
            name: "en",
            options: {
                months: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                shortMonths: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                days: [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                ],
                shortDays: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                toolbar: {
                    exportToSVG: "Download SVG",
                    exportToPNG: "Download PNG",
                    exportToCSV: "Download CSV",
                    menu: "Menu",
                    selection: "Selection",
                    selectionZoom: "Selection Zoom",
                    zoomIn: "Zoom In",
                    zoomOut: "Zoom Out",
                    pan: "Panning",
                    reset: "Reset Zoom",
                },
            },
        },
        d =
            (t(Qe, [
                {
                    key: "init",
                    value: function () {
                        return {
                            annotations: {
                                yaxis: [this.yAxisAnnotation],
                                xaxis: [this.xAxisAnnotation],
                                points: [this.pointAnnotation],
                                texts: [],
                                images: [],
                                shapes: [],
                            },
                            chart: {
                                animations: {
                                    enabled: !0,
                                    easing: "easeinout",
                                    speed: 800,
                                    animateGradually: {
                                        delay: 150,
                                        enabled: !0,
                                    },
                                    dynamicAnimation: {
                                        enabled: !0,
                                        speed: 350,
                                    },
                                },
                                background: "",
                                locales: [gt],
                                defaultLocale: "en",
                                dropShadow: {
                                    enabled: !1,
                                    enabledOnSeries: void 0,
                                    top: 2,
                                    left: 2,
                                    blur: 4,
                                    color: "#000",
                                    opacity: 0.35,
                                },
                                events: {
                                    animationEnd: void 0,
                                    beforeMount: void 0,
                                    mounted: void 0,
                                    updated: void 0,
                                    click: void 0,
                                    mouseMove: void 0,
                                    mouseLeave: void 0,
                                    xAxisLabelClick: void 0,
                                    legendClick: void 0,
                                    markerClick: void 0,
                                    selection: void 0,
                                    dataPointSelection: void 0,
                                    dataPointMouseEnter: void 0,
                                    dataPointMouseLeave: void 0,
                                    beforeZoom: void 0,
                                    beforeResetZoom: void 0,
                                    zoomed: void 0,
                                    scrolled: void 0,
                                    brushScrolled: void 0,
                                },
                                foreColor: "#373d3f",
                                fontFamily: "Helvetica, Arial, sans-serif",
                                height: "auto",
                                parentHeightOffset: 15,
                                redrawOnParentResize: !0,
                                redrawOnWindowResize: !0,
                                id: void 0,
                                group: void 0,
                                nonce: void 0,
                                offsetX: 0,
                                offsetY: 0,
                                selection: {
                                    enabled: !1,
                                    type: "x",
                                    fill: { color: "#24292e", opacity: 0.1 },
                                    stroke: {
                                        width: 1,
                                        color: "#24292e",
                                        opacity: 0.4,
                                        dashArray: 3,
                                    },
                                    xaxis: { min: void 0, max: void 0 },
                                    yaxis: { min: void 0, max: void 0 },
                                },
                                sparkline: { enabled: !1 },
                                brush: {
                                    enabled: !1,
                                    autoScaleYaxis: !0,
                                    target: void 0,
                                    targets: void 0,
                                },
                                stacked: !1,
                                stackOnlyBar: !0,
                                stackType: "normal",
                                toolbar: {
                                    show: !0,
                                    offsetX: 0,
                                    offsetY: 0,
                                    tools: {
                                        download: !0,
                                        selection: !0,
                                        zoom: !0,
                                        zoomin: !0,
                                        zoomout: !0,
                                        pan: !0,
                                        reset: !0,
                                        customIcons: [],
                                    },
                                    export: {
                                        csv: {
                                            filename: void 0,
                                            columnDelimiter: ",",
                                            headerCategory: "category",
                                            headerValue: "value",
                                            categoryFormatter: void 0,
                                            valueFormatter: void 0,
                                        },
                                        png: { filename: void 0 },
                                        svg: { filename: void 0 },
                                    },
                                    autoSelected: "zoom",
                                },
                                type: "line",
                                width: "100%",
                                zoom: {
                                    enabled: !0,
                                    type: "x",
                                    autoScaleYaxis: !1,
                                    zoomedArea: {
                                        fill: {
                                            color: "#90CAF9",
                                            opacity: 0.4,
                                        },
                                        stroke: {
                                            color: "#0D47A1",
                                            opacity: 0.4,
                                            width: 1,
                                        },
                                    },
                                },
                            },
                            plotOptions: {
                                line: { isSlopeChart: !1 },
                                area: { fillTo: "origin" },
                                bar: {
                                    horizontal: !1,
                                    columnWidth: "70%",
                                    barHeight: "70%",
                                    distributed: !1,
                                    borderRadius: 0,
                                    borderRadiusApplication: "around",
                                    borderRadiusWhenStacked: "last",
                                    rangeBarOverlap: !0,
                                    rangeBarGroupRows: !1,
                                    hideZeroBarsWhenGrouped: !1,
                                    isDumbbell: !1,
                                    dumbbellColors: void 0,
                                    isFunnel: !1,
                                    isFunnel3d: !0,
                                    colors: {
                                        ranges: [],
                                        backgroundBarColors: [],
                                        backgroundBarOpacity: 1,
                                        backgroundBarRadius: 0,
                                    },
                                    dataLabels: {
                                        position: "top",
                                        maxItems: 100,
                                        hideOverflowingLabels: !0,
                                        orientation: "horizontal",
                                        total: {
                                            enabled: !1,
                                            formatter: void 0,
                                            offsetX: 0,
                                            offsetY: 0,
                                            style: {
                                                color: "#373d3f",
                                                fontSize: "12px",
                                                fontFamily: void 0,
                                                fontWeight: 600,
                                            },
                                        },
                                    },
                                },
                                bubble: {
                                    zScaling: !0,
                                    minBubbleRadius: void 0,
                                    maxBubbleRadius: void 0,
                                },
                                candlestick: {
                                    colors: {
                                        upward: "#00B746",
                                        downward: "#EF403C",
                                    },
                                    wick: { useFillColor: !0 },
                                },
                                boxPlot: {
                                    colors: {
                                        upper: "#00E396",
                                        lower: "#008FFB",
                                    },
                                },
                                heatmap: {
                                    radius: 2,
                                    enableShades: !0,
                                    shadeIntensity: 0.5,
                                    reverseNegativeShade: !1,
                                    distributed: !1,
                                    useFillColorAsStroke: !1,
                                    colorScale: {
                                        inverse: !1,
                                        ranges: [],
                                        min: void 0,
                                        max: void 0,
                                    },
                                },
                                treemap: {
                                    enableShades: !0,
                                    shadeIntensity: 0.5,
                                    distributed: !1,
                                    reverseNegativeShade: !1,
                                    useFillColorAsStroke: !1,
                                    borderRadius: 4,
                                    dataLabels: { format: "scale" },
                                    colorScale: {
                                        inverse: !1,
                                        ranges: [],
                                        min: void 0,
                                        max: void 0,
                                    },
                                },
                                radialBar: {
                                    inverseOrder: !1,
                                    startAngle: 0,
                                    endAngle: 360,
                                    offsetX: 0,
                                    offsetY: 0,
                                    hollow: {
                                        margin: 5,
                                        size: "50%",
                                        background: "transparent",
                                        image: void 0,
                                        imageWidth: 150,
                                        imageHeight: 150,
                                        imageOffsetX: 0,
                                        imageOffsetY: 0,
                                        imageClipped: !0,
                                        position: "front",
                                        dropShadow: {
                                            enabled: !1,
                                            top: 0,
                                            left: 0,
                                            blur: 3,
                                            color: "#000",
                                            opacity: 0.5,
                                        },
                                    },
                                    track: {
                                        show: !0,
                                        startAngle: void 0,
                                        endAngle: void 0,
                                        background: "#f2f2f2",
                                        strokeWidth: "97%",
                                        opacity: 1,
                                        margin: 5,
                                        dropShadow: {
                                            enabled: !1,
                                            top: 0,
                                            left: 0,
                                            blur: 3,
                                            color: "#000",
                                            opacity: 0.5,
                                        },
                                    },
                                    dataLabels: {
                                        show: !0,
                                        name: {
                                            show: !0,
                                            fontSize: "16px",
                                            fontFamily: void 0,
                                            fontWeight: 600,
                                            color: void 0,
                                            offsetY: 0,
                                            formatter: function (t) {
                                                return t;
                                            },
                                        },
                                        value: {
                                            show: !0,
                                            fontSize: "14px",
                                            fontFamily: void 0,
                                            fontWeight: 400,
                                            color: void 0,
                                            offsetY: 16,
                                            formatter: function (t) {
                                                return t + "%";
                                            },
                                        },
                                        total: {
                                            show: !1,
                                            label: "Total",
                                            fontSize: "16px",
                                            fontWeight: 600,
                                            fontFamily: void 0,
                                            color: void 0,
                                            formatter: function (t) {
                                                return (
                                                    t.globals.seriesTotals.reduce(
                                                        function (t, e) {
                                                            return t + e;
                                                        },
                                                        0
                                                    ) /
                                                        t.globals.series
                                                            .length +
                                                    "%"
                                                );
                                            },
                                        },
                                    },
                                    barLabels: {
                                        enabled: !1,
                                        margin: 5,
                                        useSeriesColors: !0,
                                        fontFamily: void 0,
                                        fontWeight: 600,
                                        fontSize: "16px",
                                        formatter: function (t) {
                                            return t;
                                        },
                                        onClick: void 0,
                                    },
                                },
                                pie: {
                                    customScale: 1,
                                    offsetX: 0,
                                    offsetY: 0,
                                    startAngle: 0,
                                    endAngle: 360,
                                    expandOnClick: !0,
                                    dataLabels: {
                                        offset: 0,
                                        minAngleToShowLabel: 10,
                                    },
                                    donut: {
                                        size: "65%",
                                        background: "transparent",
                                        labels: {
                                            show: !1,
                                            name: {
                                                show: !0,
                                                fontSize: "16px",
                                                fontFamily: void 0,
                                                fontWeight: 600,
                                                color: void 0,
                                                offsetY: -10,
                                                formatter: function (t) {
                                                    return t;
                                                },
                                            },
                                            value: {
                                                show: !0,
                                                fontSize: "20px",
                                                fontFamily: void 0,
                                                fontWeight: 400,
                                                color: void 0,
                                                offsetY: 10,
                                                formatter: function (t) {
                                                    return t;
                                                },
                                            },
                                            total: {
                                                show: !1,
                                                showAlways: !1,
                                                label: "Total",
                                                fontSize: "16px",
                                                fontWeight: 400,
                                                fontFamily: void 0,
                                                color: void 0,
                                                formatter: function (t) {
                                                    return t.globals.seriesTotals.reduce(
                                                        function (t, e) {
                                                            return t + e;
                                                        },
                                                        0
                                                    );
                                                },
                                            },
                                        },
                                    },
                                },
                                polarArea: {
                                    rings: {
                                        strokeWidth: 1,
                                        strokeColor: "#e8e8e8",
                                    },
                                    spokes: {
                                        strokeWidth: 1,
                                        connectorColors: "#e8e8e8",
                                    },
                                },
                                radar: {
                                    size: void 0,
                                    offsetX: 0,
                                    offsetY: 0,
                                    polygons: {
                                        strokeWidth: 1,
                                        strokeColors: "#e8e8e8",
                                        connectorColors: "#e8e8e8",
                                        fill: { colors: void 0 },
                                    },
                                },
                            },
                            colors: void 0,
                            dataLabels: {
                                enabled: !0,
                                enabledOnSeries: void 0,
                                formatter: function (t) {
                                    return null !== t ? t : "";
                                },
                                textAnchor: "middle",
                                distributed: !1,
                                offsetX: 0,
                                offsetY: 0,
                                style: {
                                    fontSize: "12px",
                                    fontFamily: void 0,
                                    fontWeight: 600,
                                    colors: void 0,
                                },
                                background: {
                                    enabled: !0,
                                    foreColor: "#fff",
                                    borderRadius: 2,
                                    padding: 4,
                                    opacity: 0.9,
                                    borderWidth: 1,
                                    borderColor: "#fff",
                                    dropShadow: {
                                        enabled: !1,
                                        top: 1,
                                        left: 1,
                                        blur: 1,
                                        color: "#000",
                                        opacity: 0.45,
                                    },
                                },
                                dropShadow: {
                                    enabled: !1,
                                    top: 1,
                                    left: 1,
                                    blur: 1,
                                    color: "#000",
                                    opacity: 0.45,
                                },
                            },
                            fill: {
                                type: "solid",
                                colors: void 0,
                                opacity: 0.85,
                                gradient: {
                                    shade: "dark",
                                    type: "horizontal",
                                    shadeIntensity: 0.5,
                                    gradientToColors: void 0,
                                    inverseColors: !0,
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                    stops: [0, 50, 100],
                                    colorStops: [],
                                },
                                image: {
                                    src: [],
                                    width: void 0,
                                    height: void 0,
                                },
                                pattern: {
                                    style: "squares",
                                    width: 6,
                                    height: 6,
                                    strokeWidth: 2,
                                },
                            },
                            forecastDataPoints: {
                                count: 0,
                                fillOpacity: 0.5,
                                strokeWidth: void 0,
                                dashArray: 4,
                            },
                            grid: {
                                show: !0,
                                borderColor: "#e0e0e0",
                                strokeDashArray: 0,
                                position: "back",
                                xaxis: { lines: { show: !1 } },
                                yaxis: { lines: { show: !0 } },
                                row: { colors: void 0, opacity: 0.5 },
                                column: { colors: void 0, opacity: 0.5 },
                                padding: {
                                    top: 0,
                                    right: 10,
                                    bottom: 0,
                                    left: 12,
                                },
                            },
                            labels: [],
                            legend: {
                                show: !0,
                                showForSingleSeries: !1,
                                showForNullSeries: !0,
                                showForZeroSeries: !0,
                                floating: !1,
                                position: "bottom",
                                horizontalAlign: "center",
                                inverseOrder: !1,
                                fontSize: "12px",
                                fontFamily: void 0,
                                fontWeight: 400,
                                width: void 0,
                                height: void 0,
                                formatter: void 0,
                                tooltipHoverFormatter: void 0,
                                offsetX: -20,
                                offsetY: 4,
                                customLegendItems: [],
                                labels: { colors: void 0, useSeriesColors: !1 },
                                markers: {
                                    size: 6,
                                    fillColors: void 0,
                                    strokeWidth: 2,
                                    shape: void 0,
                                    radius: 2,
                                    offsetX: 0,
                                    offsetY: 0,
                                    customHTML: void 0,
                                    onClick: void 0,
                                },
                                itemMargin: { horizontal: 5, vertical: 4 },
                                onItemClick: { toggleDataSeries: !0 },
                                onItemHover: { highlightDataSeries: !0 },
                            },
                            markers: {
                                discrete: [],
                                size: 0,
                                colors: void 0,
                                strokeColors: "#fff",
                                strokeWidth: 2,
                                strokeOpacity: 0.9,
                                strokeDashArray: 0,
                                fillOpacity: 1,
                                shape: "circle",
                                radius: 2,
                                offsetX: 0,
                                offsetY: 0,
                                showNullDataPoints: !0,
                                onClick: void 0,
                                onDblClick: void 0,
                                hover: { size: void 0, sizeOffset: 3 },
                            },
                            noData: {
                                text: void 0,
                                align: "center",
                                verticalAlign: "middle",
                                offsetX: 0,
                                offsetY: 0,
                                style: {
                                    color: void 0,
                                    fontSize: "14px",
                                    fontFamily: void 0,
                                },
                            },
                            responsive: [],
                            series: void 0,
                            states: {
                                normal: { filter: { type: "none", value: 0 } },
                                hover: {
                                    filter: { type: "lighten", value: 0.1 },
                                },
                                active: {
                                    allowMultipleDataPointsSelection: !1,
                                    filter: { type: "darken", value: 0.5 },
                                },
                            },
                            title: {
                                text: void 0,
                                align: "left",
                                margin: 5,
                                offsetX: 0,
                                offsetY: 0,
                                floating: !1,
                                style: {
                                    fontSize: "14px",
                                    fontWeight: 900,
                                    fontFamily: void 0,
                                    color: void 0,
                                },
                            },
                            subtitle: {
                                text: void 0,
                                align: "left",
                                margin: 5,
                                offsetX: 0,
                                offsetY: 30,
                                floating: !1,
                                style: {
                                    fontSize: "12px",
                                    fontWeight: 400,
                                    fontFamily: void 0,
                                    color: void 0,
                                },
                            },
                            stroke: {
                                show: !0,
                                curve: "smooth",
                                lineCap: "butt",
                                width: 2,
                                colors: void 0,
                                dashArray: 0,
                                fill: {
                                    type: "solid",
                                    colors: void 0,
                                    opacity: 0.85,
                                    gradient: {
                                        shade: "dark",
                                        type: "horizontal",
                                        shadeIntensity: 0.5,
                                        gradientToColors: void 0,
                                        inverseColors: !0,
                                        opacityFrom: 1,
                                        opacityTo: 1,
                                        stops: [0, 50, 100],
                                        colorStops: [],
                                    },
                                },
                            },
                            tooltip: {
                                enabled: !0,
                                enabledOnSeries: void 0,
                                shared: !0,
                                hideEmptySeries: !1,
                                followCursor: !1,
                                intersect: !1,
                                inverseOrder: !1,
                                custom: void 0,
                                fillSeriesColor: !1,
                                theme: "light",
                                cssClass: "",
                                style: { fontSize: "12px", fontFamily: void 0 },
                                onDatasetHover: { highlightDataSeries: !1 },
                                x: {
                                    show: !0,
                                    format: "dd MMM",
                                    formatter: void 0,
                                },
                                y: {
                                    formatter: void 0,
                                    title: {
                                        formatter: function (t) {
                                            return t ? t + ": " : "";
                                        },
                                    },
                                },
                                z: { formatter: void 0, title: "Size: " },
                                marker: { show: !0, fillColors: void 0 },
                                items: { display: "flex" },
                                fixed: {
                                    enabled: !1,
                                    position: "topRight",
                                    offsetX: 0,
                                    offsetY: 0,
                                },
                            },
                            xaxis: {
                                type: "category",
                                categories: [],
                                convertedCatToNumeric: !1,
                                offsetX: 0,
                                offsetY: 0,
                                overwriteCategories: void 0,
                                labels: {
                                    show: !0,
                                    rotate: -45,
                                    rotateAlways: !1,
                                    hideOverlappingLabels: !0,
                                    trim: !1,
                                    minHeight: void 0,
                                    maxHeight: 120,
                                    showDuplicates: !0,
                                    style: {
                                        colors: [],
                                        fontSize: "12px",
                                        fontWeight: 400,
                                        fontFamily: void 0,
                                        cssClass: "",
                                    },
                                    offsetX: 0,
                                    offsetY: 0,
                                    format: void 0,
                                    formatter: void 0,
                                    datetimeUTC: !0,
                                    datetimeFormatter: {
                                        year: "yyyy",
                                        month: "MMM 'yy",
                                        day: "dd MMM",
                                        hour: "HH:mm",
                                        minute: "HH:mm:ss",
                                        second: "HH:mm:ss",
                                    },
                                },
                                group: {
                                    groups: [],
                                    style: {
                                        colors: [],
                                        fontSize: "12px",
                                        fontWeight: 400,
                                        fontFamily: void 0,
                                        cssClass: "",
                                    },
                                },
                                axisBorder: {
                                    show: !0,
                                    color: "#e0e0e0",
                                    width: "100%",
                                    height: 1,
                                    offsetX: 0,
                                    offsetY: 0,
                                },
                                axisTicks: {
                                    show: !0,
                                    color: "#e0e0e0",
                                    height: 6,
                                    offsetX: 0,
                                    offsetY: 0,
                                },
                                stepSize: void 0,
                                tickAmount: void 0,
                                tickPlacement: "on",
                                min: void 0,
                                max: void 0,
                                range: void 0,
                                floating: !1,
                                decimalsInFloat: void 0,
                                position: "bottom",
                                title: {
                                    text: void 0,
                                    offsetX: 0,
                                    offsetY: 0,
                                    style: {
                                        color: void 0,
                                        fontSize: "12px",
                                        fontWeight: 900,
                                        fontFamily: void 0,
                                        cssClass: "",
                                    },
                                },
                                crosshairs: {
                                    show: !0,
                                    width: 1,
                                    position: "back",
                                    opacity: 0.9,
                                    stroke: {
                                        color: "#b6b6b6",
                                        width: 1,
                                        dashArray: 3,
                                    },
                                    fill: {
                                        type: "solid",
                                        color: "#B1B9C4",
                                        gradient: {
                                            colorFrom: "#D8E3F0",
                                            colorTo: "#BED1E6",
                                            stops: [0, 100],
                                            opacityFrom: 0.4,
                                            opacityTo: 0.5,
                                        },
                                    },
                                    dropShadow: {
                                        enabled: !1,
                                        left: 0,
                                        top: 0,
                                        blur: 1,
                                        opacity: 0.4,
                                    },
                                },
                                tooltip: {
                                    enabled: !0,
                                    offsetY: 0,
                                    formatter: void 0,
                                    style: {
                                        fontSize: "12px",
                                        fontFamily: void 0,
                                    },
                                },
                            },
                            yaxis: this.yAxis,
                            theme: {
                                mode: "",
                                palette: "palette1",
                                monochrome: {
                                    enabled: !1,
                                    color: "#008FFB",
                                    shadeTo: "light",
                                    shadeIntensity: 0.65,
                                },
                            },
                        };
                    },
                },
            ]),
            Qe),
        ut =
            (t(Je, [
                {
                    key: "drawAxesAnnotations",
                    value: function () {
                        var t = this.w;
                        if (t.globals.axisCharts) {
                            for (
                                var e =
                                        this.yAxisAnnotations.drawYAxisAnnotations(),
                                    i =
                                        this.xAxisAnnotations.drawXAxisAnnotations(),
                                    a =
                                        this.pointsAnnotations.drawPointAnnotations(),
                                    s = t.config.chart.animations.enabled,
                                    o = [e, i, a],
                                    r = [i.node, e.node, a.node],
                                    n = 0;
                                n < 3;
                                n++
                            )
                                t.globals.dom.elGraphical.add(o[n]),
                                    !s ||
                                        t.globals.resized ||
                                        t.globals.dataChanged ||
                                        ("scatter" !== t.config.chart.type &&
                                            "bubble" !== t.config.chart.type &&
                                            1 < t.globals.dataPoints &&
                                            r[n].classList.add(
                                                "apexcharts-element-hidden"
                                            )),
                                    t.globals.delayedElements.push({
                                        el: r[n],
                                        index: 0,
                                    });
                            this.helpers.annotationsBackground();
                        }
                    },
                },
                {
                    key: "drawImageAnnos",
                    value: function () {
                        var i = this;
                        this.w.config.annotations.images.map(function (t, e) {
                            i.addImage(t, e);
                        });
                    },
                },
                {
                    key: "drawTextAnnos",
                    value: function () {
                        var i = this;
                        this.w.config.annotations.texts.map(function (t, e) {
                            i.addText(t, e);
                        });
                    },
                },
                {
                    key: "addXaxisAnnotation",
                    value: function (t, e, i) {
                        this.xAxisAnnotations.addXaxisAnnotation(t, e, i);
                    },
                },
                {
                    key: "addYaxisAnnotation",
                    value: function (t, e, i) {
                        this.yAxisAnnotations.addYaxisAnnotation(t, e, i);
                    },
                },
                {
                    key: "addPointAnnotation",
                    value: function (t, e, i) {
                        this.pointsAnnotations.addPointAnnotation(t, e, i);
                    },
                },
                {
                    key: "addText",
                    value: function (t, e) {
                        var i = t.x,
                            a = t.y,
                            s = t.text,
                            o = t.textAnchor,
                            r = t.foreColor,
                            n = t.fontSize,
                            l = t.fontFamily,
                            h = t.fontWeight,
                            c = t.cssClass,
                            d = t.backgroundColor,
                            g = t.borderWidth,
                            u = t.strokeDashArray,
                            p = t.borderRadius,
                            f = t.borderColor,
                            x = t.appendTo,
                            x = void 0 === x ? ".apexcharts-svg" : x,
                            b = t.paddingLeft,
                            b                     value: function (t) {
                        var i = t.w,
                            t = i.globals.dom.baseEl.querySelectorAll(
                                ".apexcharts-yaxis-annotations, .apexcharts-xaxis-annotations, .apexcharts-point-annotations"
                            );
                        i.globals.memory.methodsToExec.map(function (t, e) {
                            ("addText" !== t.label &&
                                "addAnnotation" !== t.label) ||
                                i.globals.memory.methodsToExec.splice(e, 1);
                        }),
                            (t = N.listToArray(t)),
                            Array.prototype.forEach.call(t, function (t) {
                                for (; t.firstChild; )
                                    t.removeChild(t.firstChild);
                            });
                    },
                },
                {
                    key: "removeAnnotation",
                    value: function (t, i) {
                        var a = t.w,
                            t = a.globals.dom.baseEl.querySelectorAll(
                                ".".concat(i)
                            );
                        t &&
                            (a.globals.memory.methodsToExec.map(function (
                                t,
                                e
                            ) {
                                t.id === i &&
                                    a.globals.memory.methodsToExec.splice(e, 1);
                            }),
                            Array.prototype.forEach.call(t, function (t) {
                                t.parentElement.removeChild(t);
                            }));
                    },
                },
            ]),
            Je),
        n =
            (t($e, [
                {
                    key: "hideYAxis",
                    value: function () {
                        (this.opts.yaxis[0].show = !1),
                            (this.opts.yaxis[0].title.text = ""),
                            (this.opts.yaxis[0].axisBorder.show = !1),
                            (this.opts.yaxis[0].axisTicks.show = !1),
                            (this.opts.yaxis[0].floating = !0);
                    },
                },
                {
                    key: "line",
                    value: function () {
                        return {
                            chart: { animations: { easing: "swing" } },
                            dataLabels: { enabled: !1 },
                            stroke: { width: 5, curve: "straight" },
                            markers: { size: 0, hover: { sizeOffset: 6 } },
                            xaxis: { crosshairs: { width: 1 } },
                        };
                    },
                },
                {
                    key: "sparkline",
                    value: function (t) {
                        return (
                            this.hideYAxis(),
                            N.extend(t, {
                                grid: {
                                    show: !1,
                                    padding: {
                                        left: 0,
                                        right: 0,
                                        top: 0,
                                        bottom: 0,
                                    },
                                },
                                legend: { show: !1 },
                                xaxis: {
                                    labels: { show: !1 },
                                    tooltip: { enabled: !1 },
                                    axisBorder: { show: !1 },
                                    axisTicks: { show: !1 },
                                },
                                chart: {
                                    toolbar: { show: !1 },
                                    zoom: { enabled: !1 },
                                },
                                dataLabels: { enabled: !1 },
                            })
                        );
                    },
                },
                {
                    key: "slope",
                    value: function () {
                        return (
                            this.hideYAxis(),
                            {
                                chart: {
                                    toolbar: { show: !1 },
                                    zoom: { enabled: !1 },
                                },
                                dataLabels: {
                                    enabled: !0,
                                    formatter: function (t, e) {
                                        e =
                                            e.w.config.series[e.seriesIndex]
                                                .name;
                                        return null !== t ? e + ": " + t : "";
                                    },
                                    background: { enabled: !1 },
                                    offsetX: -5,
                                },
                                grid: {
                                    xaxis: { lines: { show: !0 } },
                                    yaxis: { lines: { show: !1 } },
                                },
                                xaxis: {
                                    position: "top",
                                    labels: {
                                        style: {
                                            fontSize: 14,
                                            fontWeight: 900,
                                        },
                                    },
                                    tooltip: { enabled: !1 },
                                    crosshairs: { show: !1 },
                                },
                                markers: { size: 8, hover: { sizeOffset: 1 } },
                                legend: { show: !1 },
                                tooltip: {
                                    shared: !1,
                                    intersect: !0,
                                    followCursor: !0,
                                },
                                stroke: { width: 5, curve: "straight" },
                            }
                        );
                    },
                },
                {
                    key: "bar",
                    value: function () {
                        return {
                            chart: {
                                stacked: !1,
                                animations: { easing: "swing" },
                            },
                            plotOptions: {
                                bar: { dataLabels: { position: "center" } },
                            },
                            dataLabels: {
                                style: { colors: ["#fff"] },
                                background: { enabled: !1 },
                            },
                            stroke: { width: 0, lineCap: "round" },
                            fill: { opacity: 0.85 },
                            legend: { markers: { shape: "square", radius: 2 } },
                            tooltip: { shared: !1, intersect: !0 },
                            xaxis: {
                                tooltip: { enabled: !1 },
                                tickPlacement: "between",
                                crosshairs: {
                                    width: "barWidth",
                                    position: "back",
                                    fill: { type: "gradient" },
                                    dropShadow: { enabled: !1 },
                                    stroke: { width: 0 },
                                },
                            },
                        };
                    },
                },
                {
                    key: "funnel",
                    value: function () {
                        return (
                            this.hideYAxis(),
                            z(
                                z({}, this.bar()),
                                {},
                                {
                                    chart: {
                                        animations: {
                                            easing: "linear",
                                            speed: 800,
                                            animateGradually: { enabled: !1 },
                                        },
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: !0,
                                            borderRadiusApplication: "around",
                                            borderRadius: 0,
                                            dataLabels: { position: "center" },
                                        },
                                    },
                                    grid: {
                                        show: !1,
                                        padding: { left: 0, right: 0 },
                                    },
                                    xaxis: {
                                        labels: { show: !1 },
                                        tooltip: { enabled: !1 },
                                        axisBorder: { show: !1 },
                                        axisTicks: { show: !1 },
                                    },
                                }
                            )
                        );
                    },
                },
                {
                    key: "candlestick",
                    value: function () {
                        var a = this;
                        return {
                            stroke: { width: 1, colors: ["#333"] },
                            fill: { opacity: 1 },
                            dataLabels: { enabled: !1 },
                            tooltip: {
                                shared: !0,
                                custom: function (t) {
                                    var e = t.seriesIndex,
                                        i = t.dataPointIndex,
                                        t = t.w;
                                    return a._getBoxTooltip(
                                        t,
                                        e,
                                        i,
                                        ["Open", "High", "", "Low", "Close"],
                                        "candlestick"
                                    );
                                },
                            },
                            states: { active: { filter: { type: "none" } } },
                            xaxis: { crosshairs: { width: 1 } },
                        };
                    },
                },
                {
                    key: "boxPlot",
                    value: function () {
                        var a = this;
                        return {
                            chart: {
                                animations: {
                                    dynamicAnimation: { enabled: !1 },
                                },
                            },
                            stroke: { width: 1, colors: ["#24292e"] },
                            dataLabels: { enabled: !1 },
                            tooltip: {
                                shared: !0,
                                custom: function (t) {
                                    var e = t.seriesIndex,
                                        i = t.dataPointIndex,
                                        t = t.w;
                                    return a._getBoxTooltip(
                                        t,
                                        e,
                                        i,
                                        [
                                            "Minimum",
                                            "Q1",
                                            "Median",
                                            "Q3",
                                            "Maximum",
                                        ],
                                        "boxPlot"
                                    );
                                },
                            },
                            markers: {
                                size: 5,
                                strokeWidth: 1,
                                strokeColors: "#111",
                            },
                            xaxis: { crosshairs: { width: 1 } },
                        };
                    },
                },
                {
                    key: "rangeBar",
                    value: function () {
                        return {
                            chart: { animations: { animateGradually: !1 } },
                            stroke: { width: 0, lineCap: "square" },
                            plotOptions: {
                                bar: {
                                    borderRadius: 0,
                                    dataLabels: { position: "center" },
                                },
                            },
                            dataLabels: {
                                enabled: !1,
                                formatter: function (t, e) {
                                    e.ctx;
                                    function i() {
                                        var t =
                                            o.globals.seriesRangeStart[a][s];
                                        return (
                                            o.globals.seriesRangeEnd[a][s] - t
                                        );
                                    }
                                    var a = e.seriesIndex,
                                        s = e.dataPointIndex,
                                        o = e.w;
                                    return !o.globals.comboCharts ||
                                        "rangeBar" ===
                                            o.config.series[a].type ||
                                        "rangeArea" === o.config.series[a].type
                                        ? i()
                                        : t;
                                },
                                background: { enabled: !1 },
                                style: { colors: ["#fff"] },
                            },
                            markers: { size: 10 },
                            tooltip: {
                                shared: !1,
                                followCursor: !0,
                                custom: function (t) {
                                    return t.w.config.plotOptions &&
                                        t.w.config.plotOptions.bar &&
                                        t.w.config.plotOptions.bar.horizontal
                                        ? ((i = st(
                                              z(
                                                  z({}, (e = t)),
                                                  {},
                                                  { isTimeline: !0 }
                                              )
                                          )),
                                          (a = i.color),
                                          (s = i.seriesName),
                                          (o = i.ylabel),
                                          (r = i.startVal),
                                          (i = i.endVal),
                                          ot(
                                              z(
                                                  z({}, e),
                                                  {},
                                                  {
                                                      color: a,
                                                      seriesName: s,
                                                      ylabel: o,
                                                      start: r,
                                                      end: i,
                                                  }
                                              )
                                          ))
                                        : ((a = st((e = t))),
                                          (s = a.color),
                                          (o = a.seriesName),
                                          (r = a.ylabel),
                                          (i = a.start),
                                          (a = a.end),
                                          ot(
                                              z(
                                                  z({}, e),
                                                  {},
                                                  {
                                                      color: s,
                                                      seriesName: o,
                                                      ylabel: r,
                                                      start: i,
                                                      end: a,
                                                  }
                                              )
                                          ));
                                    var e, i, a, s, o, r;
                                },
                            },
                            xaxis: {
                                tickPlacement: "between",
                                tooltip: { enabled: !1 },
                                crosshairs: { stroke: { width: 0 } },
                            },
                        };
                    },
                },
                {
                    key: "dumbbell",
                    value: function (t) {
                        var e;
                        return (
                            (null != (e = t.plotOptions.bar) && e.barHeight) ||
                                (t.plotOptions.bar.barHeight = 2),
                            (null != (e = t.plotOptions.bar) &&
                                e.columnWidth) ||
                                (t.plotOptions.bar.columnWidth = 2),
                            t
                        );
                    },
                },
                {
                    key: "area",
                    value: function () {
                        return {
                            stroke: {
                                width: 4,
                                fill: {
                                    type: "solid",
                                    gradient: {
                                        inverseColors: !1,
                                        shade: "light",
                                        type: "vertical",
                                        opacityFrom: 0.65,
                                        opacityTo: 0.5,
                                        stops: [0, 100, 100],
                                    },
                                },
                            },
                            fill: {
                                type: "gradient",
                                gradient: {
                                    inverseColors: !1,
                                    shade: "light",
                                    type: "vertical",
                                    opacityFrom: 0.65,
                                    opacityTo: 0.5,
                                    stops: [0, 100, 100],
                                },
                            },
                            markers: { size: 0, hover: { sizeOffset: 6 } },
                            tooltip: { followCursor: !1 },
                        };
                    },
                },
                {
                    key: "rangeArea",
                    value: function () {
                        return {
                            stroke: { curve: "straight", width: 0 },
                            fill: { type: "solid", opacity: 0.6 },
                            markers: { size: 0 },
                            states: {
                                hover: { filter: { type: "none" } },
                                active: { filter: { type: "none" } },
                            },
                            tooltip: {
                                intersect: !1,
                                shared: !0,
                                followCursor: !0,
                                custom: function (t) {
                                    return (
                                        (e = st((t = t))),
                                        (i = e.color),
                                        (a = e.seriesName),
                                        (s = e.ylabel),
                                        (o = e.start),
                                        (e = e.end),
                                        ot(
                                            z(
                                                z({}, t),
                                                {},
                                                {
                                                    color: i,
                                                    seriesName: a,
                                                    ylabel: s,
                                                    start: o,
                                                    end: e,
                                                }
                                            )
                                        )
                                    );
                                    var e, i, a, s, o;
                                },
                            },
                        };
                    },
                },
                {
                    key: "brush",
                    value: function (t) {
                        return N.extend(t, {
                            chart: {
                                toolbar: {
                                    autoSelected: "selection",
                                    show: !1,
                                },
                                zoom: { enabled: !1 },
                            },
                            dataLabels: { enabled: !1 },
                            stroke: { width: 1 },
                            tooltip: { enabled: !1 },
                            xaxis: { tooltip: { enabled: !1 } },
                        });
                    },
                },
                {
                    key: "stacked100",
                    value: function (i) {
                        (i.dataLabels = i.dataLabels || {}),
                            (i.dataLabels.formatter =
                                i.dataLabels.formatter || void 0);
                        var t = i.dataLabels.formatter;
                        return (
                            i.yaxis.forEach(function (t, e) {
                                (i.yaxis[e].min = 0), (i.yaxis[e].max = 100);
                            }),
                            "bar" === i.chart.type &&
                                (i.dataLabels.formatter =
                                    t ||
                                    function (t) {
                                        return "number" == typeof t && t
                                            ? t.toFixed(0) + "%"
                                            : t;
                                    }),
                            i
                        );
                    },
                },
                {
                    key: "stackedBars",
                    value: function () {
                        var t = this.bar();
                        return z(
                            z({}, t),
                            {},
                            {
                                plotOptions: z(
                                    z({}, t.plotOptions),
                                    {},
                                    {
                                        bar: z(
                                            z({}, t.plotOptions.bar),
                                            {},
                                            {
                                                borderRadiusApplication: "end",
                                                borderRadiusWhenStacked: "last",
                                            }
                                        ),
                                    }
                                ),
                            }
                        );
                    },
                },
                {
                    key: "convertCatToNumeric",
                    value: function (t) {
                        return (t.xaxis.convertedCatToNumeric = !0), t;
                    },
                },
                {
                    key: "convertCatToNumericXaxis",
                    value: function (t, e, i) {
                        (t.xaxis.type = "numeric"),
                            (t.xaxis.labels = t.xaxis.labels || {}),
                            (t.xaxis.labels.formatter =
                                t.xaxis.labels.formatter ||
                                function (t) {
                                    return N.isNumber(t) ? Math.floor(t) : t;
                                });
                        var a = t.xaxis.labels.formatter,
                            s =
                                t.xaxis.categories && t.xaxis.categories.length
                                    ? t.xaxis.categories
                                    : t.labels;
                        return (
                            (s =
                                i && i.length
                                    ? i.map(function (t) {
                                          return Array.isArray(t)
                                              ? t
                                              : String(t);
                                      })
                                    : s) &&
                                s.length &&
                                (t.xaxis.labels.formatter = function (t) {
                                    return N.isNumber(t)
                                        ? a(s[Math.floor(t) - 1])
                                        : a(t);
                                }),
                            (t.xaxis.categories = []),
                            (t.labels = []),
                            (t.xaxis.tickAmount =
                                t.xaxis.tickAmount || "dataPoints"),
                            t
                        );
                    },
                },
                {
                    key: "bubble",
                    value: function () {
                        return {
                            dataLabels: { style: { colors: ["#fff"] } },
                            tooltip: { shared: !1, intersect: !0 },
                            xaxis: { crosshairs: { width: 0 } },
                            fill: {
                                type: "solid",
                                gradient: {
                                    shade: "light",
                                    inverse: !0,
                                    shadeIntensity: 0.55,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.8,
                                },
                            },
                        };
                    },
                },
                {
                    key: "scatter",
                    value: function () {
                        return {
                            dataLabels: { enabled: !1 },
                            tooltip: { shared: !1, intersect: !0 },
                            markers: {
                                size: 6,
                                strokeWidth: 1,
                                hover: { sizeOffset: 2 },
                            },
                        };
                    },
                },
                {
                    key: "heatmap",
                    value: function () {
                        return {
                            chart: { stacked: !1 },
                            fill: { opacity: 1 },
                            dataLabels: { style: { colors: ["#fff"] } },
                            stroke: { colors: ["#fff"] },
                            tooltip: {
                                followCursor: !0,
                                marker: { show: !1 },
                                x: { show: !1 },
                            },
                            legend: {
                                position: "top",
                                markers: { shape: "square" },
                            },
                            grid: { padding: { right: 20 } },
                        };
                    },
                },
                {
                    key: "treemap",
                    value: function () {
                        return {
                            chart: { zoom: { enabled: !1 } },
                            dataLabels: {
                                style: {
                                    fontSize: 14,
                                    fontWeight: 600,
                                    colors: ["#fff"],
                                },
                            },
                            stroke: { show: !0, width: 2, colors: ["#fff"] },
                            legend: { show: !1 },
                            fill: { opacity: 1, gradient: { stops: [0, 100] } },
                            tooltip: { followCursor: !0, x: { show: !1 } },
                            grid: { padding: { left: 0, right: 0 } },
                            xaxis: {
                                crosshairs: { show: !1 },
                                tooltip: { enabled: !1 },
                            },
                        };
                    },
                },
                {
                    key: "pie",
                    value: function () {
                        return {
                            chart: { toolbar: { show: !1 } },
                            plotOptions: {
                                pie: { donut: { labels: { show: !1 } } },
                            },
                            dataLabels: {
                                formatter: function (t) {
                                    return t.toFixed(1) + "%";
                                },
                                style: { colors: ["#fff"] },
                                background: { enabled: !1 },
                                dropShadow: { enabled: !0 },
                            },
                            stroke: { colors: ["#fff"] },
                            fill: {
                                opacity: 1,
                                gradient: { shade: "light", stops: [0, 100] },
                            },
                            tooltip: { theme: "dark", fillSeriesColor: !0 },
                            legend: { position: "right" },
                        };
                    },
                },
                {
                    key: "donut",
                    value: function () {
                        return {
                            chart: { toolbar: { show: !1 } },
                            dataLabels: {
                                formatter: function (t) {
                                    return t.toFixed(1) + "%";
                                },
                                style: { colors: ["#fff"] },
                                background: { enabled: !1 },
                                dropShadow: { enabled: !0 },
                            },
                            stroke: { colors: ["#fff"] },
                            fill: {
                                opacity: 1,
                                gradient: {
                                    shade: "light",
                                    shadeIntensity: 0.35,
                                    stops: [80, 100],
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                },
                            },
                            tooltip: { theme: "dark", fillSeriesColor: !0 },
                            legend: { position: "right" },
                        };
                    },
                },
                {
                    key: "polarArea",
                    value: function () {
                        return {
                            chart: { toolbar: { show: !1 } },
                            dataLabels: {
                                formatter: function (t) {
                                    return t.toFixed(1) + "%";
                                },
                                enabled: !1,
                            },
                            stroke: { show: !0, width: 2 },
                            fill: { opacity: 0.7 },
                            tooltip: { theme: "dark", fillSeriesColor: !0 },
                            legend: { position: "right" },
                        };
                    },
                },
                {
                    key: "radar",
                    value: function () {
                        return (
                            (this.opts.yaxis[0].labels.offsetY =
                                this.opts.yaxis[0].labels.offsetY || 6),
                            {
                                dataLabels: {
                                    enabled: !1,
                                    style: { fontSize: "11px" },
                                },
                                stroke: { width: 2 },
                                markers: {
                                    size: 3,
                                    strokeWidth: 1,
                                    strokeOpacity: 1,
                                },
                                fill: { opacity: 0.2 },
                                tooltip: {
                                    shared: !1,
                                    intersect: !0,
                                    followCursor: !0,
                                },
                                grid: { show: !1 },
                                xaxis: {
                                    labels: {
                                        formatter: function (t) {
                                            return t;
                                        },
                                        style: {
                                            colors: ["#a8a8a8"],
                                            fontSize: "11px",
                                        },
                                    },
                                    tooltip: { enabled: !1 },
                                    crosshairs: { show: !1 },
                                },
                            }
                        );
                    },
                },
                {
                    key: "radialBar",
                    value: function () {
                        return {
                            chart: {
                                animations: {
                                    dynamicAnimation: {
                                        enabled: !0,
                                        speed: 800,
                                    },
                                },
                                toolbar: { show: !1 },
                            },
                            fill: {
                                gradient: {
                                    shade: "dark",
                                    shadeIntensity: 0.4,
                                    inverseColors: !1,
                                    type: "diagonal2",
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                    stops: [70, 98, 100],
                                },
                            },
                            legend: { show: !1, position: "right" },
                            tooltip: { enabled: !1, fillSeriesColor: !0 },
                        };
                    },
                },
                {
                    key: "_getBoxTooltip",
                    value: function (t, e, i, a, s) {
                        var o = t.globals.seriesCandleO[e][i],
                            r = t.globals.seriesCandleH[e][i],
                            n = t.globals.seriesCandleM[e][i],
                            l = t.globals.seriesCandleL[e][i],
                            h = t.globals.seriesCandleC[e][i];
                        return t.config.series[e].type &&
                            t.config.series[e].type !== s
                            ? '<div class="apexcharts-custom-tooltip">\n          '
                                  .concat(
                                      t.config.series[e].name ||
                                          "series-" + (e + 1),
                                      ": <strong>"
                                  )
                                  .concat(
                                      t.globals.series[e][i],
                                      "</strong>\n        </div>"
                                  )
                            : '<div class="apexcharts-tooltip-box apexcharts-tooltip-'.concat(
                                  t.config.chart.type,
                                  '">'
                              ) +
                                  "<div>".concat(
                                      a[0],
                                      ': <span class="value">'
                                  ) +
                                  o +
                                  "</span></div>" +
                                  "<div>".concat(
                                      a[1],
                                      ': <span class="value">'
                                  ) +
                                  r +
                                  "</span></div>" +
                                  (n
                                      ? "<div>".concat(
                                            a[2],
                                            ': <span class="value">'
                                        ) +
                                        n +
                                        "</span></div>"
                                      : "") +
                                  "<div>".concat(
                                      a[3],
                                      ': <span class="value">'
                                  ) +
                                  l +
                                  "</span></div>" +
                                  "<div>".concat(
                                      a[4],
                                      ': <span class="value">'
                                  ) +
                                  h +
                                  "</span></div></div>";
                    },
                },
            ]),
            $e),
        p =
            (t(Ze, [
                {
                    key: "init",
                    value: function (t) {
                        var e,
                            i,
                            t = t.responsiveOverride,
                            a = this.opts,
                            s = new d(),
                            o = new n(a),
                            s =
                                ((this.chartType = a.chart.type),
                                (a = this.extendYAxis(a)),
                                (a = this.extendAnnotations(a)),
                                s.init()),
                            r = {},
                            t =
                                (a &&
                                    "object" === v(a) &&
                                    ((i = {}),
                                    (i =
                                        -1 !==
                                        [
                                            "line",
                                            "area",
                                            "bar",
                                            "candlestick",
                                            "boxPlot",
                                            "rangeBar",
                                            "rangeArea",
                                            "bubble",
                                            "scatter",
                                            "heatmap",
                                            "treemap",
                                            "pie",
                                            "polarArea",
                                            "donut",
                                            "radar",
                                            "radialBar",
                                        ].indexOf(a.chart.type)
                                            ? o[a.chart.type]()
                                            : o.line()),
                                    null != (e = a.plotOptions) &&
                                        null != (e = e.bar) &&
                                        e.isFunnel &&
                                        (i = o.funnel()),
                                    a.chart.stacked &&
                                        "bar" === a.chart.type &&
                                        (i = o.stackedBars()),
                                    null != (e = a.chart.brush) &&
                                        e.enabled &&
                                        (i = o.brush(i)),
                                    null != (e = a.plotOptions) &&
                                        null != (e = e.line) &&
                                        e.isSlopeChart &&
                                        (i = o.slope()),
                                    null !=
                                        (e = (a =
                                            a.chart.stacked &&
                                            "100%" === a.chart.stackType
                                                ? o.stacked100(a)
                                                : a).plotOptions) &&
                                        null != (e = e.bar) &&
                                        e.isDumbbell &&
                                        (a = o.dumbbell(a)),
                                    this.checkForDarkTheme(window.Apex),
                                    this.checkForDarkTheme(a),
                                    (a.xaxis =
                                        a.xaxis || window.Apex.xaxis || {}),
                                    t || (a.xaxis.convertedCatToNumeric = !1),
                                    ((null !=
                                        (e = (a =
                                            this.checkForCatToNumericXAxis(
                                                this.chartType,
                                                i,
                                                a
                                            )).chart.sparkline) &&
                                        e.enabled) ||
                                        (null != (t = window.Apex.chart) &&
                                            null != (e = t.sparkline) &&
                                            e.enabled)) &&
                                        (i = o.sparkline(i)),
                                    (r = N.extend(s, i))),
                                N.extend(r, window.Apex)),
                            s = N.extend(t, a);
                        return this.handleUserInputErrors(s);
                    },
                },
                {
                    key: "checkForCatToNumericXAxis",
                    value: function (t, e, i) {
                        var a = new n(i),
                            s =
                                ("bar" === t || "boxPlot" === t) &&
                                (null == (s = i.plotOptions) ||
                                null == (s = s.bar)
                                    ? void 0
                                    : s.horizontal),
                            o =
                                "datetime" !== i.xaxis.type &&
                                "numeric" !== i.xaxis.type,
                            e =
                                i.xaxis.tickPlacement ||
                                (e.xaxis && e.xaxis.tickPlacement);
                        return (i =
                            s ||
                            "pie" === t ||
                            "polarArea" === t ||
                            "donut" === t ||
                            "radar" === t ||
                            "radialBar" === t ||
                            "heatmap" === t ||
                            !o ||
                            "between" === e
                                ? i
                                : a.convertCatToNumeric(i));
                    },
                },
                {
                    key: "extendYAxis",
                    value: function (i, t) {
                        var a = new d(),
                            e =
                                ((void 0 === i.yaxis ||
                                    !i.yaxis ||
                                    (Array.isArray(i.yaxis) &&
                                        0 === i.yaxis.length)) &&
                                    (i.yaxis = {}),
                                i.yaxis.constructor !== Array &&
                                    window.Apex.yaxis &&
                                    window.Apex.yaxis.constructor !== Array &&
                                    (i.yaxis = N.extend(
                                        i.yaxis,
                                        window.Apex.yaxis
                                    )),
                                i.yaxis.constructor !== Array
                                    ? (i.yaxis = [N.extend(a.yAxis, i.yaxis)])
                                    : (i.yaxis = N.extendArray(
                                          i.yaxis,
                                          a.yAxis
                                      )),
                                !1),
                            s =
                                (i.yaxis.forEach(function (t) {
                                    t.logarithmic && (e = !0);
                                }),
                                i.series);
                        return (
                            t && !s && (s = t.config.series),
                            e &&
                                s.length !== i.yaxis.length &&
                                s.length &&
                                (i.yaxis = s.map(function (t, e) {
                                    return (
                                        t.name ||
                                            (s[e].name = "series-".concat(
                                                e + 1
                                            )),
                                        i.yaxis[e]
                                            ? ((i.yaxis[e].seriesName =
                                                  s[e].name),
                                              i.yaxis[e])
                                            : (((t = N.extend(
                                                  a.yAxis,
                                                  i.yaxis[0]
                                              )).show = !1),
                                              t)
                                    );
                                })),
                            e &&
                                1 < s.length &&
                                s.length !== i.yaxis.length &&
                                console.warn(
                                    "A multi-series logarithmic chart should have equal number of series and y-axes"
                                ),
                            i
                        );
                    },
                },
                {
                    key: "extendAnnotations",
                    value: function (t) {
                        return (
                            void 0 === t.annotations &&
                                ((t.annotations = {}),
                                (t.annotations.yaxis = []),
                                (t.annotations.xaxis = []),
                                (t.annotations.points = [])),
                            (t = this.extendYAxisAnnotations(t)),
                            (t = this.extendXAxisAnnotations(t)),
                            this.extendPointAnnotations(t)
                        );
                    },
                },
                {
                    key: "extendYAxisAnnotations",
                    value: function (t) {
                        var e = new d();
                        return (
                            (t.annotations.yaxis = N.extendArray(
                                void 0 !== t.annotations.yaxis
                                    ? t.annotations.yaxis
                                    : [],
                                e.yAxisAnnotation
                            )),
                            t
                        );
                    },
                },
                {
                    key: "extendXAxisAnnotations",
                    value: function (t) {
                        var e = new d();
                        return (
                            (t.annotations.xaxis = N.extendArray(
                                void 0 !== t.annotations.xaxis
                                    ? t.annotations.xaxis
                                    : [],
                                e.xAxisAnnotation
                            )),
                            t
                        );
                    },
                },
                {
                    key: "extendPointAnnotations",
                    value: function (t) {
                        var e = new d();
                        return (
                            (t.annotations.points = N.extendArray(
                                void 0 !== t.annotations.points
                                    ? t.annotations.points
                                    : [],
                                e.pointAnnotation
                            )),
                            t
                        );
                    },
                },
                {
                    key: "checkForDarkTheme",
                    value: function (t) {
                        t.theme &&
                            "dark" === t.theme.mode &&
                            (t.tooltip || (t.tooltip = {}),
                            "light" !== t.tooltip.theme &&
                                (t.tooltip.theme = "dark"),
                            t.chart.foreColor ||
                                (t.chart.foreColor = "#f6f7f8"),
                            t.theme.palette || (t.theme.palette = "palette4"));
                    },
                },
                {
                    key: "handleUserInputErrors",
                    value: function (t) {
                        if (t.tooltip.shared && t.tooltip.intersect)
                            throw new Error(
                                "tooltip.shared cannot be enabled when tooltip.intersect is true. Turn off any other option by setting it to false."
                            );
                        if (
                            "bar" === t.chart.type &&
                            t.plotOptions.bar.horizontal
                        ) {
                            if (1 < t.yaxis.length)
                                throw new Error(
                                    "Multiple Y Axis for bars are not supported. Switch to column chart by setting plotOptions.bar.horizontal=false"
                                );
                            t.yaxis[0].reversed && (t.yaxis[0].opposite = !0),
                                (t.xaxis.tooltip.enabled = !1),
                                (t.yaxis[0].tooltip.enabled = !1),
                                (t.chart.zoom.enabled = !1);
                        }
                        return (
                            ("bar" !== t.chart.type &&
                                "rangeBar" !== t.chart.type) ||
                                (t.tooltip.shared &&
                                    "barWidth" === t.xaxis.crosshairs.width &&
                                    1 < t.series.length &&
                                    (t.xaxis.crosshairs.width = "tickWidth")),
                            ("candlestick" !== t.chart.type &&
                                "boxPlot" !== t.chart.type) ||
                                (t.yaxis[0].reversed &&
                                    (console.warn(
                                        "Reversed y-axis in ".concat(
                                            t.chart.type,
                                            " chart is not supported."
                                        )
                                    ),
                                    (t.yaxis[0].reversed = !1))),
                            t
                        );
                    },
                },
            ]),
            Ze),
        pt =
            (t(qe, [
                {
                    key: "initGlobalVars",
                    value: function (t) {
                        (t.series = []),
                            (t.seriesCandleO = []),
                            (t.seriesCandleH = []),
                            (t.seriesCandleM = []),
                            (t.seriesCandleL = []),
                            (t.seriesCandleC = []),
                            (t.seriesRangeStart = []),
                            (t.seriesRangeEnd = []),
                            (t.seriesRange = []),
                            (t.seriesPercent = []),
                            (t.seriesGoals = []),
                            (t.seriesX = []),
                            (t.seriesZ = []),
                            (t.seriesNames = []),
                            (t.seriesTotals = []),
                            (t.seriesLog = []),
                            (t.seriesColors = []),
                            (t.stackedSeriesTotals = []),
                            (t.seriesXvalues = []),
                            (t.seriesYvalues = []),
                            (t.labels = []),
                            (t.hasXaxisGroups = !1),
                            (t.groups = []),
                            (t.barGroups = []),
                            (t.lineGroups = []),
                            (t.areaGroups = []),
                            (t.hasSeriesGroups = !1),
                            (t.seriesGroups = []),
                            (t.categoryLabels = []),
                            (t.timescaleLabels = []),
                            (t.noLabelsProvided = !1),
                            (t.resizeTimer = null),
                            (t.selectionResizeTimer = null),
                            (t.delayedElements = []),
                            (t.pointsArray = []),
                            (t.dataLabelsRects = []),
                            (t.isXNumeric = !1),
                            (t.skipLastTimelinelabel = !1),
                            (t.skipFirstTimelinelabel = !1),
                            (t.isDataXYZ = !1),
                            (t.isMultiLineX = !1),
                            (t.isMultipleYAxis = !1),
                            (t.maxY = -Number.MAX_VALUE),
                            (t.minY = Number.MIN_VALUE),
                            (t.minYArr = []),
                            (t.maxYArr = []),
                            (t.maxX = -Number.MAX_VALUE),
                            (t.minX = Number.MAX_VALUE),
                            (t.initialMaxX = -Number.MAX_VALUE),
                            (t.initialMinX = Number.MAX_VALUE),
                            (t.maxDate = 0),
                            (t.minDate = Number.MAX_VALUE),
                            (t.minZ = Number.MAX_VALUE),
                            (t.maxZ = -Number.MAX_VALUE),
                            (t.minXDiff = Number.MAX_VALUE),
                            (t.yAxisScale = []),
                            (t.xAxisScale = null),
                            (t.xAxisTicksPositions = []),
                            (t.yLabelsCoords = []),
                            (t.yTitleCoords = []),
                            (t.barPadForNumericAxis = 0),
                            (t.padHorizontal = 0),
                            (t.xRange = 0),
                            (t.yRange = []),
                            (t.zRange = 0),
                            (t.dataPoints = 0),
                            (t.xTickAmount = 0),
                            (t.multiAxisTickAmount = 0);
                    },
                },
                {
                    key: "globalVars",
                    value: function (t) {
                        return {
                            chartID: null,
                            cuid: null,
                            events: {
                                beforeMount: [],
                                mounted: [],
                                updated: [],
                                clicked: [],
                                selection: [],
                                dataPointSelection: [],
                                zoomed: [],
                                scrolled: [],
                            },
                            colors: [],
                            clientX: null,
                            clientY: null,
                            fill: { colors: [] },
                            stroke: { colors: [] },
                            dataLabels: { style: { colors: [] } },
                            radarPolygons: { fill: { colors: [] } },
                            markers: {
                                colors: [],
                                size: t.markers.size,
                                largestSize: 0,
                            },
                            animationEnded: !1,
                            isTouchDevice:
                                "ontouchstart" in window ||
                                navigator.msMaxTouchPoints,
                            isDirty: !1,
                            isExecCalled: !1,
                            initialConfig: null,
                            initialSeries: [],
                            lastXAxis: [],
                            lastYAxis: [],
                            columnSeries: null,
                            labels: [],
                            timescaleLabels: [],
                            noLabelsProvided: !1,
                            allSeriesCollapsed: !1,
                            collapsedSeries: [],
                            collapsedSeriesIndices: [],
                            ancillaryCollapsedSeries: [],
                            ancillaryCollapsedSeriesIndices: [],
                            risingSeries: [],
                            dataFormatXNumeric: !1,
                            capturedSeriesIndex: -1,
                            capturedDataPointIndex: -1,
                            selectedDataPoints: [],
                            goldenPadding: 35,
                            invalidLogScale: !1,
                            ignoreYAxisIndexes: [],
                            maxValsInArrayIndex: 0,
                            radialSize: 0,
                            selection: void 0,
                            zoomEnabled:
                                "zoom" === t.chart.toolbar.autoSelected &&
                                t.chart.toolbar.tools.zoom &&
                                t.chart.zoom.enabled,
                                       i
                            ) {
                                return i.indexOf(t) === e;
                            })),
                            {
                                minY: i.minY,
                                maxY: i.maxY,
                                minYArr: i.minYArr,
                                maxYArr: i.maxYArr,
                                yAxisScale: i.yAxisScale,
                            }
                        );
                    },
                },
                {
                    key: "setXRange",
                    value: function () {
                        var t,
                            e = this.w.globals,
                            i = this.w.config,
                            a =
                                "numeric" === i.xaxis.type ||
                                "datetime" === i.xaxis.type ||
                                ("category" === i.xaxis.type &&
                                    !e.noLabelsProvided) ||
                                e.noLabelsProvided ||
                                e.isXNumeric;
                        if (e.isXNumeric)
                            for (var s = 0; s < e.series.length; s++)
                                if (e.labels[s])
                                    for (var o = 0; o < e.labels[s].length; o++)
                                        null !== e.labels[s][o] &&
                                            N.isNumber(e.labels[s][o]) &&
                                            ((e.maxX = Math.max(
                                                e.maxX,
                                                e.labels[s][o]
                                            )),
                                            (e.initialMaxX = Math.max(
                                                e.maxX,
                                                e.labels[s][o]
                                            )),
                                            (e.minX = Math.min(
                                                e.minX,
                                                e.labels[s][o]
                                            )),
                                            (e.initialMinX = Math.min(
                                                e.minX,
                                                e.labels[s][o]
                                            )));
                        if (
                            (e.noLabelsProvided &&
                                0 === i.xaxis.categories.length &&
                                ((e.maxX = e.labels[e.labels.length - 1]),
                                (e.initialMaxX = e.labels[e.labels.length - 1]),
                                (e.minX = 1),
                                (e.initialMinX = 1)),
                            e.isXNumeric ||
                                e.noLabelsProvided ||
                                e.dataFormatXNumeric)
                        ) {
                            if (
                                (void 0 === i.xaxis.tickAmount
                                    ? ((t = Math.round(e.svgWidth / 150)),
                                      (t =
                                          "numeric" === i.xaxis.type &&
                                          e.dataPoints < 30
                                              ? e.dataPoints - 1
                                              : t) > e.dataPoints &&
                                          0 !== e.dataPoints &&
                                          (t = e.dataPoints - 1))
                                    : "dataPoints" === i.xaxis.tickAmount
                                    ? (1 < e.series.length &&
                                          (t =
                                              e.series[e.maxValsInArrayIndex]
                                                  .length - 1),
                                      e.isXNumeric && (t = e.maxX - e.minX - 1))
                                    : (t = i.xaxis.tickAmount),
                                (e.xTickAmount = t),
                                void 0 !== i.xaxis.max &&
                                    "number" == typeof i.xaxis.max &&
                                    (e.maxX = i.xaxis.max),
                                void 0 !== i.xaxis.min &&
                                    "number" == typeof i.xaxis.min &&
                                    (e.minX = i.xaxis.min),
                                void 0 !== i.xaxis.range &&
                                    (e.minX = e.maxX - i.xaxis.range),
                                e.minX !== Number.MAX_VALUE &&
                                    e.maxX !== -Number.MAX_VALUE)
                            )
                                if (
                                    i.xaxis.convertedCatToNumeric &&
                                    !e.dataFormatXNumeric
                                ) {
                                    for (
                                        var r = [], n = e.minX - 1;
                                        n < e.maxX;
                                        n++
                                    )
                                        r.push(n + 1);
                                    e.xAxisScale = {
                                        result: r,
                                        niceMin: r[0],
                                        niceMax: r[r.length - 1],
                                    };
                                } else
                                    e.xAxisScale = this.scales.setXScale(
                                        e.minX,
                                        e.maxX
                                    );
                            else
                                (e.xAxisScale = this.scales.linearScale(
                                    0,
                                    t,
                                    t,
                                    0,
                                    i.xaxis.stepSize
                                )),
                                    e.noLabelsProvided &&
                                        0 < e.labels.length &&
                                        ((e.xAxisScale =
                                            this.scales.linearScale(
                                                1,
                                                e.labels.length,
                                                t - 1,
                                                0,
                                                i.xaxis.stepSize
                                            )),
                                        (e.seriesX = e.labels.slice()));
                            a && (e.labels = e.xAxisScale.result.slice());
                        }
                        return (
                            e.isBarHorizontal &&
                                e.labels.length &&
                                (e.xTickAmount = e.labels.length),
                            this._handleSingleDataPoint(),
                            this._getMinXDiff(),
                            { minX: e.minX, maxX: e.maxX }
                        );
                    },
                },
                {
                    key: "setZRange",
                    value: function () {
                        var t = this.w.globals;
                        if (t.isDataXYZ)
                            for (var e = 0; e < t.series.length; e++)
                                if (void 0 !== t.seriesZ[e])
                                    for (
                                        var i = 0;
                                        i < t.seriesZ[e].length;
                                        i++
                                    )
                                        null !== t.seriesZ[e][i] &&
                                            N.isNumber(t.seriesZ[e][i]) &&
                                            ((t.maxZ = Math.max(
                                                t.maxZ,
                                                t.seriesZ[e][i]
                                            )),
                                            (t.minZ = Math.min(
                                                t.minZ,
                                                t.seriesZ[e][i]
                                            )));
                    },
                },
                {
                    key: "_handleSingleDataPoint",
                    value: function () {
                        var t,
                            e,
                            i = this.w.globals,
                            a = this.w.config;
                        i.minX === i.maxX &&
                            ((t = new y(this.ctx)),
                            "datetime" === a.xaxis.type
                                ? ((e = t.getDate(i.minX)),
                                  a.xaxis.labels.datetimeUTC
                                      ? e.setUTCDate(e.getUTCDate() - 2)
                                      : e.setDate(e.getDate() - 2),
                                  (i.minX = new Date(e).getTime()),
                                  (e = t.getDate(i.maxX)),
                                  a.xaxis.labels.datetimeUTC
                                      ? e.setUTCDate(e.getUTCDate() + 2)
                                      : e.setDate(e.getDate() + 2),
                                  (i.maxX = new Date(e).getTime()))
                                : ("numeric" !== a.xaxis.type &&
                                      ("category" !== a.xaxis.type ||
                                          i.noLabelsProvided)) ||
                                  ((i.minX = i.minX - 2),
                                  (i.initialMinX = i.minX),
                                  (i.maxX = i.maxX + 2),
                                  (i.initialMaxX = i.maxX)));
                    },
                },
                {
                    key: "_getMinXDiff",
                    value: function () {
                        var a = this.w.globals;
                        a.isXNumeric &&
                            a.seriesX.forEach(function (t, e) {
                                1 === t.length &&
                                    t.push(
                                        a.seriesX[a.maxValsInArrayIndex][
                                            a.seriesX[a.maxValsInArrayIndex]
                                                .length - 1
                                        ]
                                    );
                                var i = t.slice();
                                i.sort(function (t, e) {
                                    return t - e;
                                }),
                                    i.forEach(function (t, e) {
                                        0 < e &&
                                            0 < (t = t - i[e - 1]) &&
                                            (a.minXDiff = Math.min(
                                                t,
                                                a.minXDiff
                                            ));
                                    }),
                                    (1 !== a.dataPoints &&
                                        a.minXDiff !== Number.MAX_VALUE) ||
                                        (a.minXDiff = 0.5);
                            });
                    },
                },
                {
                    key: "_setStackedMinMax",
                    value: function () {
                        var t,
                            s,
                            o,
                            r = this,
                            n = this.w.globals;
                        n.series.length &&
                            ((t = n.seriesGroups).length ||
                                (t = [
                                    this.w.globals.seriesNames.map(function (
                                        t
                                    ) {
                                        return t;
                                    }),
                                ]),
                            (s = {}),
                            (o = {}),
                            t.forEach(function (a) {
                                (s[a] = []),
                                    (o[a] = []),
                                    r.w.config.series
                                        .map(function (t, e) {
                                            return -1 <
                                                a.indexOf(n.seriesNames[e])
                                                ? e
                                                : null;
                                        })
                                        .filter(function (t) {
                                            return null !== t;
                                        })
                                        .forEach(function (t) {
                                            for (
                                                var e, i = 0;
                                                i <
                                                n.series[n.maxValsInArrayIndex]
                                                    .length;
                                                i++
                                            )
                                                void 0 === s[a][i] &&
                                                    ((s[a][i] = 0),
                                                    (o[a][i] = 0)),
                                                    ((r.w.config.chart
                                                        .stacked &&
                                                        !n.comboCharts) ||
                                                        (r.w.config.chart
                                                            .stacked &&
                                                            n.comboCharts &&
                                                            (!r.w.config.chart
                                                                .stackOnlyBar ||
                                                                "bar" ===
                                                                    (null ==
                                                                        (e =
                                                                            r.w
                                                                                .config
                                                                                .series) ||
                                                                    null ==
                                                                        (e =
                                                                            e[
                                                                                t
                                                                            ])
                                                                        ? void 0
                                                                        : e.type) ||
                                                                "column" ===
                                                                    (null ==
                                                                        (e =
                                                                            r.w
                                                                                .config
                                                                                .series) ||
                                                                    null ==
                                                                        (e =
                                                                            e[
                                                                                t
                                                                            ])
                                                                        ? void 0
                                                                        : e.type)))) &&
                                                        null !==
                                                            n.series[t][i] &&
                                                        N.isNumber(
                                                            n.series[t][i]
                                                        ) &&
                                                        (0 < n.series[t][i]
                                                            ? (s[a][i] +=
                                                                  parseFloat(
                                                                      n.series[
                                                                          t
                                                                      ][i]
                                                                  ) + 1e-4)
                                                            : (o[a][i] +=
                                                                  parseFloat(
                                                                      n.series[
                                                                          t
                                                                      ][i]
                                                                  )));
                                        });
                            }),
                            Object.entries(s).forEach(function (t) {
                                var i = O(t, 1)[0];
                                s[i].forEach(function (t, e) {
                                    (n.maxY = Math.max(n.maxY, s[i][e])),
                                        (n.minY = Math.min(n.minY, o[i][e]));
                                });
                            }));
                    },
                },
            ]),
            Re),
        kt =
            (t(Fe, [
                {
                    key: "drawYaxis",
                    value: function (t) {
                        var e = this,
                            i = this.w,
                            a = new W(this.ctx),
                            s = i.config.yaxis[t].labels.style,
                            o = s.fontSize,
                            r = s.fontFamily,
                            n = s.fontWeight,
                            l = a.group({
                                class: "apexcharts-yaxis",
                                rel: t,
                                transform:
                                    "translate(" +
                                    i.globals.translateYAxisX[t] +
                                    ", 0)",
                            });
                        if (!this.axesUtils.isYAxisHidden(t)) {
                            var h,
                                c,
                                d,
                                g,
                                u,
                                p = a.group({
                                    class: "apexcharts-yaxis-texts-g",
                                }),
                                f =
                                    (l.add(p),
                                    i.globals.yAxisScale[t].result.length - 1),
                                x = i.globals.gridHeight / f,
                                b = i.globals.yLabelFormatters[t],
                                m = i.globals.yAxisScale[t].result.slice(),
                                m = this.axesUtils.checkForReversedLabels(t, m),
                                v = "";
                            if (i.config.yaxis[t].labels.show) {
                                var y =
                                    i.globals.translateY +
                                    i.config.yaxis[t].labels.offsetY;
                                i.globals.isBarHorizontal
                                    ? (y = 0)
                                    : "heatmap" === i.config.chart.type &&
                                      (y -= x / 2),
                                    (y +=
                                        parseInt(
                                            i.config.yaxis[t].labels.style
                                                .fontSize,
                                            10
                                        ) / 3);
                                for (var w = f; 0 <= w; w--)
                                    (g = d = u = g = d = c = void 0),
                                        (c = m[(h = w)]),
                                        (c = b(c, h, i)),
                                        (d = i.config.yaxis[t].labels.padding),
                                        i.config.yaxis[t].opposite &&
                                            0 !== i.config.yaxis.length &&
                                            (d *= -1),
                                        (g = "end"),
                                        i.config.yaxis[t].opposite &&
                                            (g = "start"),
                                        "left" ===
                                        i.config.yaxis[t].labels.align
                                            ? (g = "start")
                                            : "center" ===
                                              i.config.yaxis[t].labels.align
                                            ? (g = "middle")
                                            : "right" ===
                                                  i.config.yaxis[t].labels
                                                      .align && (g = "end"),
                                        (u = e.axesUtils.getYAxisForeColor(
                                            s.colors,
                                            t
                                        )),
                                        (d = a.drawText({
                                            x: d,
                                            y: y,
                                            text: c,
                                            textAnchor: g,
                                            fontSize: o,
                                            fontFamily: r,
                                            fontWeight: n,
                                            maxWidth:
                                                i.config.yaxis[t].labels
                                                    .maxWidth,
                                            foreColor: Array.isArray(u)
                                                ? u[h]
                                                : u,
                                            isPlainText: !1,
                                            cssClass:
                                                "apexcharts-yaxis-label " +
                                                s.cssClass,
                                        })),
                                        h === f && (v = d),
                                        p.add(d),
                                        ((g = document.createElementNS(
                                            i.globals.SVGNS,
                                            "title"
                                        )).textContent = Array.isArray(c)
                                            ? c.join(" ")
                                            : c),
                                        d.node.appendChild(g),
                                        0 !== i.config.yaxis[t].labels.rotate &&
                                            ((u = a.rotateAroundCenter(v.node)),
                                            (h = a.rotateAroundCenter(d.node)),
                                            d.node.setAttribute(
                                                "transform",
                                                "rotate("
                                                    .concat(
                                                        i.config.yaxis[t].labels
                                                            .rotate,
                                                        " "
                                                    )
                                                    .concat(u.x, " ")
                                                    .concat(h.y, ")")
                                            )),
                                        (y += x);
                            }
                            void 0 !== i.config.yaxis[t].title.text &&
                                ((S = a.group({
                                    class: "apexcharts-yaxis-title",
                                })),
                                (A = 0),
                                i.config.yaxis[t].opposite &&
                                    (A = i.globals.translateYAxisX[t]),
                                (A = a.drawText({
                                    x: A,
                                    y:
                                        i.globals.gridHeight / 2 +
                                        i.globals.translateY +
                                        i.config.yaxis[t].title.offsetY,
                                    text: i.config.yaxis[t].title.text,
                                    textAnchor: "end",
                                    foreColor:
                                        i.config.yaxis[t].title.style.color,
                                    fontSize:
                                        i.config.yaxis[t].title.style.fontSize,
                                    fontWeight:
                                        i.config.yaxis[t].title.style
                                            .fontWeight,
                                    fontFamily:
                                        i.config.yaxis[t].title.style
                                            .fontFamily,
                                    cssClass:
                                        "apexcharts-yaxis-title-text " +
                                        i.config.yaxis[t].title.style.cssClass,
                                })),
                                S.add(A),
                                l.add(S));
                            var k,
                                A = i.config.yaxis[t].axisBorder,
                                S = 31 + A.offsetX;
                            i.config.yaxis[t].opposite && (S = -31 - A.offsetX),
                                A.show &&
                                    ((k = a.drawLine(
                                        S,
                                        i.globals.translateY + A.offsetY - 2,
                                        S,
                                        i.globals.gridHeight +
                                            i.globals.translateY +
                                            A.offsetY +
                                            2,
                                        A.color,
                                        0,
                                        A.width
                                    )),
                                    l.add(k)),
                                i.config.yaxis[t].axisTicks.show &&
                                    this.axesUtils.drawYAxisTicks(
                                        S,
                                        f,
                                        A,
                                        i.config.yaxis[t].axisTicks,
                                        t,
                                        x,
                                        l
                                    );
                        }
                        return l;
                    },
                },
                {
                    key: "drawYaxisInversed",
                    value: function (t) {
                        var e = this.w,
                            i = new W(this.ctx),
                            a = i.group({
                                class: "apexcharts-xaxis apexcharts-yaxis-inversed",
                            }),
                            s = i.group({
                                class: "apexcharts-xaxis-texts-g",
                                transform: "translate("
                                    .concat(e.globals.translateXAxisX, ", ")
                                    .concat(e.globals.translateXAxisY, ")"),
                            }),
                            o =
                                (a.add(s),
                                e.globals.yAxisScale[t].result.length - 1),
                            r = e.globals.gridWidth / o + 0.1,
                            n = r + e.config.xaxis.labels.offsetX,
                            l = e.globals.xLabelFormatter,
                            h = e.globals.yAxisScale[t].result.slice(),
                            c = e.globals.timescaleLabels,
                            d =
                                (0 < c.length &&
                                    ((this.xaxisLabels = c.slice()),
                                    (o = (h = c.slice()).length)),
                                (h = this.axesUtils.checkForReversedLabels(
                                    t,
                                    h
                                )),
                                c.length);
                        if (e.config.xaxis.labels.show)
                            for (
                                var g = d ? 0 : o;
                                d ? g < d : 0 <= g;
                                d ? g++ : g--
                            ) {
                                var u = h[g],
                                    p =
                                        ((u = l(u, g, e)),
                                        e.globals.gridWidth +
                                            e.globals.padHorizontal -
                                            (n -
                                                r +
                                                e.config.xaxis.labels.offsetX)),
                                    f =
                                        (c.length &&
                                            ((p = (f = this.axesUtils.getLabel(
                                                h,
                                                c,
                                                p,
                                                g,
                                                this.drawnLabels,
                                                this.xaxisFontSize
                                            )).x),
                                            (u = f.text),
                                            this.drawnLabels.push(f.text),
                                            0 === g &&
                                                e.globals
                                                    .skipFirstTimelinelabel &&
                                                (u = ""),
                                            g === h.length - 1) &&
                                            e.globals.skipLastTimelinelabel &&
                                            (u = ""),
                                        i.drawText({
                                            x: p,
                                            y:
                                                this.xAxisoffX +
                                                e.config.xaxis.labels.offsetY +
                                                30 -
                                                ("top" ===
                                                e.config.xaxis.position
                                                    ? e.globals.xAxisHeight +
                                                      e.config.xaxis.axisTicks
                                                          .height -
                                                      2
                                                    : 0),
                                            text: u,
                                            textAnchor: "middle",
                                            foreColor: Array.isArray(
                                                this.xaxisForeColors
                                            )
                                                ? this.xaxisForeColors[t]
                                                : this.xaxisForeColors,
                                            fontSize: this.xaxisFontSize,
                                            fontFamily: this.xaxisFontFamily,
                                            fontWeight:
                                                e.config.xaxis.labels.style
                                                    .fontWeight,
                                            isPlainText: !1,
                                            cssClass:
                                                "apexcharts-xaxis-label " +
                                                e.config.xaxis.labels.style
                                                    .cssClass,
                                        })),
                                    p =
                                        (s.add(f),
                                        f.tspan(u),
                                        document.createElementNS(
                                            e.globals.SVGNS,
                                            "title"
                                        ));
                                (p.textContent = u),
                                    f.node.appendChild(p),
                                    (n += r);
                            }
                        return (
                            this.inversedYAxisTitleText(a),
                            this.inversedYAxisBorder(a),
                            a
                        );
                    },
                },
                {
                    key: "inversedYAxisBorder",
                    value: function (t) {
                        var e,
                            i = this.w,
                            a = new W(this.ctx),
                            s = i.config.xaxis.axisBorder;
                        s.show &&
                            ((e = 0),
                            "bar" === i.config.chart.type &&
                                i.globals.isXNumeric &&
                                (e -= 15),
                            (a = a.drawLine(
                                i.globals.padHorizontal + e + s.offsetX,
                                this.xAxisoffX,
                                i.globals.gridWidth,
                                this.xAxisoffX,
                                s.color,
                                0,
                                s.height
                            )),
                            (this.elgrid &&
                            this.elgrid.elGridBorders &&
                            i.config.grid.show
                                ? this.elgrid.elGridBorders
                                : t
                            ).add(a));
                    },
                },
                {
                    key: "inversedYAxisTitleText",
                    value: function (t) {
                        var e,
                            i = this.w,
                            a = new W(this.ctx);
                        void 0 !== i.config.xaxis.title.text &&
                            ((e = a.group({
                                class: "apexcharts-xaxis-title apexcharts-yaxis-title-inversed",
                            })),
                            (a = a.drawText({
                                x:
                                    i.globals.gridWidth / 2 +
                                    i.config.xaxis.title.offsetX,
                                y:
                                    this.xAxisoffX +
                                    parseFloat(this.xaxisFontSize) +
                                    parseFloat(
                                        i.config.xaxis.title.style.fontSize
                                    ) +
                                    i.config.xaxis.title.offsetY +
                                    20,
                                text: i.config.xaxis.title.text,
                                textAnchor: "middle",
                                fontSize: i.config.xaxis.title.style.fontSize,
                                fontFamily:
                                    i.config.xaxis.title.style.fontFamily,
                                fontWeight:
                                    i.config.xaxis.title.style.fontWeight,
                                foreColor: i.config.xaxis.title.style.color,
                                cssClass:
                                    "apexcharts-xaxis-title-text " +
                                    i.config.xaxis.title.style.cssClass,
                            })),
                            e.add(a),
                            t.add(e));
                    },
                },
                {
                    key: "yAxisTitleRotate",
                    value: function (t, e) {
                        var i = this.w,
                            a = new W(this.ctx),
                            s = { width: 0, height: 0 },
                            o = { width: 0, height: 0 },
                            r = i.globals.dom.baseEl.querySelector(
                                " .apexcharts-yaxis[rel='".concat(
                                    t,
                                    "'] .apexcharts-yaxis-texts-g"
                                )
                            ),
                            r =
                                (null !== r && (s = r.getBoundingClientRect()),
                                i.globals.dom.baseEl.querySelector(
                                    ".apexcharts-yaxis[rel='".concat(
                                        t,
                                        "'] .apexcharts-yaxis-title text"
                                    )
                                ));
                        null !== r && (o = r.getBoundingClientRect()),
                            null !== r &&
                                ((s = this.xPaddingForYAxisTitle(t, s, o, e)),
                                r.setAttribute("x", s.xPos - (e ? 10 : 0))),
                            null !== r &&
                                ((o = a.rotateAroundCenter(r)),
                                r.setAttribute(
                                    "transform",
                                    "rotate("
                                        .concat(
                                            e
                                                ? -1 *
                                                      i.config.yaxis[t].title
                                                          .rotate
                                                : i.config.yaxis[t].title
                                                      .rotate,
                                            " "
                                        )
                                        .concat(o.x, " ")
                                        .concat(o.y, ")")
                                ));
                    },
                },
                {
                    key: "xPaddingForYAxisTitle",
                    value: function (t, e, i, a) {
                        var s = this.w,
                            o = 0,
                            r = 10;
                        return void 0 === s.config.yaxis[t].title.text || t < 0
                            ? { xPos: o, padd: 0 }
                            : (a
                                  ? (o =
                                        e.width +
                                        s.config.yaxis[t].title.offsetX +
                                        i.width / 2 +
                                        r / 2)
                                  : ((o =
                                        -1 * e.width +
                                        s.config.yaxis[t].title.offsetX +
                                        r / 2 +
                                        i.width / 2),
                                    s.globals.isBarHorizontal &&
                                        (o =
                                            -1 * e.width -
                                            s.config.yaxis[t].title.offsetX -
                                            (r = 25))),
                              { xPos: o, padd: r });
                    },
                },
                {
                    key: "setYAxisXPosition",
                    value: function (s, o) {
                        var r,
                            n = this.w,
                            l = 0,
                            h = 18,
                            c = 1;
                        1 < n.config.yaxis.length && (this.multipleYs = !0),
                            n.config.yaxis.map(function (t, e) {
                                var i =
                                        -1 <
                                            n.globals.ignoreYAxisIndexes.indexOf(
                                                e
                                            ) ||
                                        !t.show ||
                                        t.floating ||
                                        0 === s[e].width,
                                    a = s[e].width + o[e].width;
                                t.opposite
                                    ? n.globals.isBarHorizontal
                                        ? ((l =
                                              n.globals.gridWidth +
                                              n.globals.translateX -
                                              1),
                                          (n.globals.translateYAxisX[e] =
                                              l - t.labels.offsetX))
                                        : ((l =
                                              n.globals.gridWidth +
                                              n.globals.translateX +
                                              c),
                                          i || (c = c + a + 20),
                                          (n.globals.translateYAxisX[e] =
                                              l - t.labels.offsetX + 20))
                                    : ((r = n.globals.translateX - h),
                                      i || (h = h + a + 20),
                                      (n.globals.translateYAxisX[e] =
                                          r + t.labels.offsetX));
                            });
                    },
                },
                {
                    key: "setYAxisTextAlignments",
                    value: function () {
                        var o = this.w,
                            t =
                                o.globals.dom.baseEl.getElementsByClassName(
                                    "apexcharts-yaxis"
                                );
                        (t = N.listToArray(t)).forEach(function (t, e) {
                            var i,
                                a,
                                s = o.config.yaxis[e];
                            s &&
                                !s.floating &&
                                void 0 !== s.labels.align &&
                                ((i = o.globals.dom.baseEl.querySelector(
                                    ".apexcharts-yaxis[rel='".concat(
                                        e,
                                        "'] .apexcharts-yaxis-texts-g"
                                    )
                                )),
                                (e = o.globals.dom.baseEl.querySelectorAll(
                                    ".apexcharts-yaxis[rel='".concat(
                                        e,
                                        "'] .apexcharts-yaxis-label"
                                    )
                                )),
                                (e = N.listToArray(e)),
                                (a = i.getBoundingClientRect()),
                                "left" === s.labels.align
                                    ? (e.forEach(function (t, e) {
                                          t.setAttribute(
                                              "text-anchor",
                                              "start"
                                          );
                                      }),
                                      s.opposite ||
                                          i.setAttribute(
                                              "transform",
                                              "translate(-".concat(
                                                  a.width,
                                                  ", 0)"
                                              )
                                          ))
                                    : "center" === s.labels.align
                                    ? (e.forEach(function (t, e) {
                                          t.setAttribute(
                                              "text-anchor",
                                              "middle"
                                          );
                                      }),
                                      i.setAttribute(
                                          "transform",
                                          "translate(".concat(
                                              (a.width / 2) *
                                                  (s.opposite ? 1 : -1),
                                              ", 0)"
                                          )
                                      ))
                                    : "right" === s.labels.align &&
                                      (e.forEach(function (t, e) {
                                          t.setAttribute("text-anchor", "end");
                                      }),
                                      s.opposite) &&
                                      i.setAttribute(
                                          "transform",
                                          "translate(".concat(a.width, ", 0)")
                                      ));
                        });
                    },
                },
            ]),
            Fe),
        At =
            (t(Ye, [
                {
                    key: "addEventListener",
                    value: function (t, e) {
                        var i = this.w;
                        i.globals.events.hasOwnProperty(t)
                            ? i.globals.events[t].push(e)
                            : (i.globals.events[t] = [e]);
                    },
                },
                {
                    key: "removeEventListener",
                    value: function (t, e) {
                        var i = this.w;
                        i.globals.events.hasOwnProperty(t) &&
                            -1 !== (e = i.globals.events[t].indexOf(e)) &&
                            i.globals.events[t].splice(e, 1);
                    },
                },
                {
                    key: "fireEvent",
                    value: function (t, e) {
                        var i = this.w;
                        if (i.globals.events.hasOwnProperty(t)) {
                            (e && e.length) || (e = []);
                            for (
                                var a = i.globals.events[t],
                                    s = a.length,
                                    o = 0;
                                o < s;
                                o++
                            )
                                a[o].apply(null, e);
                        }
                    },
                },
                {
                    key: "setupEventHandlers",
                    value: function () {
                        var e = this,
                            i = this.w,
                            a = this.ctx,
                            s = i.globals.dom.baseEl.querySelector(
                                i.globals.chartClass
                            );
                        this.ctx.eventList.forEach(function (t) {
                            s.addEventListener(
                                t,
                                function (t) {
                                    var e = Object.assign({}, i, {
                                        seriesIndex: i.globals.axisCharts
                                            ? i.globals.capturedSeriesIndex
                                            : 0,
                                        dataPointIndex:
                                            i.globals.capturedDataPointIndex,
                                    });
                                    "mousemove" === t.type ||
                                    "touchmove" === t.type
                                        ? "function" ==
                                              typeof i.config.chart.events
                                                  .mouseMove &&
                                          i.config.chart.events.mouseMove(
                                              t,
                                              a,
                                              e
                                          )
                                        : "mouseleave" === t.type ||
                                          "touchleave" === t.type
                                        ? "function" ==
                                              typeof i.config.chart.events
                                                  .mouseLeave &&
                                          i.config.chart.events.mouseLeave(
                                              t,
                                              a,
                                              e
                                          )
                                        : (("mouseup" === t.type &&
                                              1 === t.which) ||
                                              "touchend" === t.type) &&
                                          ("function" ==
                                              typeof i.config.chart.events
                                                  .click &&
                                              i.config.chart.events.click(
                                                  t,
                                                  a,
                                                  e
                                              ),
                                          a.ctx.events.fireEvent("click", [
                                              t,
                                              a,
                                              e,
                                          ]));
                                },
                                { capture: !1, passive: !0 }
                            );
                        }),
                            this.ctx.eventList.forEach(function (t) {
                                i.globals.dom.baseEl.addEventListener(
                                    t,
                                    e.documentEvent,
                                    { passive: !0 }
                                );
                            }),
                            this.ctx.core.setupBrushHandler();
                    },
                },
                {
                    key: "documentEvent",
                    value: function (t) {
                        var e,
                            i = this.w,
                            a = t.target.className;
                        "click" === t.type &&
                            (e =
                                i.globals.dom.baseEl.querySelector(
                                    ".apexcharts-menu"
                                )) &&
                            e.classList.contains("apexcharts-menu-open") &&
                            "apexcharts-menu-icon" !== a &&
                            e.classList.remove("apexcharts-menu-open"),
                            (i.globals.clientX = (
                                "touchmove" === t.type ? t.touches[0] : t
                            ).clientX),
                            (i.globals.clientY = (
                                "touchmove" === t.type ? t.touches[0] : t
                            ).clientY);
                    },
                },
            ]),
            Ye),
        St =
            (t(Ee, [
                {
                    key: "setCurrentLocaleValues",
                    value: function (e) {
                        var t = this.w.config.chart.locales,
                            t = (t =
                                window.Apex.chart &&
                                window.Apex.chart.locales &&
                                0 < window.Apex.chart.locales.length
                                    ? this.w.config.chart.locales.concat(
                                          window.Apex.chart.locales
                                      )
                                    : t).filter(function (t) {
                                return t.name === e;
                            })[0];
                        if (!t)
                            throw new Error(
                                "Wrong locale name provided. Please make sure you set the correct locale name in options"
                            );
                        t = N.extend(gt, t);
                        this.w.globals.locale = t.options;
                    },
                },
            ]),
            Ee),
        Ct =
            (t(Xe, [
                {
                    key: "drawAxis",
                    value: function (t, e) {
                        var i,
                            a,
                            s = this,
                            o = this.w.globals,
                            r = this.w.config,
                            n = new u(this.ctx, e),
                            l = new kt(this.ctx, e);
                        o.axisCharts &&
                            "radar" !== t &&
                            (o.isBarHorizontal
                                ? ((a = l.drawYaxisInversed(0)),
                                  (i = n.drawXaxisInversed(0)),
                                  o.dom.elGraphical.add(i),
                                  o.dom.elGraphical.add(a))
                                : ((i = n.drawXaxis()),
                                  o.dom.elGraphical.add(i),
                                  r.yaxis.map(function (t, e) {
                                      -1 === o.ignoreYAxisIndexes.indexOf(e) &&
                                          ((a = l.drawYaxis(e)),
                                          o.dom.Paper.add(a),
                                          "back" ===
                                              s.w.config.grid.position) &&
                                          ((e =
                                              o.dom.Paper.children()[1]).remove(),
                                          o.dom.Paper.add(e));
                                  })));
                    },
                },
            ]),
            Xe),
        Lt =
            (t(ze, [
                {
                    key: "drawXCrosshairs",
                    value: function () {
                        var t = this.w,
                            e = new W(this.ctx),
                            i = new I(this.ctx),
                            a = t.config.xaxis.crosshairs.fill.gradient,
                            s = t.config.xaxis.crosshairs.dropShadow,
                            o = t.config.xaxis.crosshairs.fill.type,
                            r = a.colorFrom,
                            n = a.colorTo,
                            l = a.opacityFrom,
                            h = a.opacityTo,
                            a = a.stops,
                            c = s.enabled,
                            d = s.left,
                            g = s.top,
                            u = s.blur,
                            p = s.color,
                            s = s.opacity,
                            f = t.config.xaxis.crosshairs.fill.color;
                        t.config.xaxis.crosshairs.show &&
                            ("gradient" === o &&
                                (f = e.drawGradient(
                                    "vertical",
                                    r,
                                    n,
                                    l,
                                    h,
                                    null,
                                    a,
                                    null
                                )),
                            (o = e.drawRect()),
                            1 === t.config.xaxis.crosshairs.width &&
                                (o = e.drawLine()),
                            (r = t.globals.gridHeight),
                            (!N.isNumber(r) || r < 0) && (r = 0),
                            (n = t.config.xaxis.crosshairs.width),
                            (!N.isNumber(n) || n < 0) && (n = 0),
                            o.attr({
                                class: "apexcharts-xcrosshairs",
                                x: 0,
                                y: 0,
                                y2: r,
                                width: n,
                                height: r,
                                fill: f,
                                filter: "none",
                                "fill-opacity":
                                    t.config.xaxis.crosshairs.opacity,
                                stroke: t.config.xaxis.crosshairs.stroke.color,
                                "stroke-width":
                                    t.config.xaxis.crosshairs.stroke.width,
                                "stroke-dasharray":
                                    t.config.xaxis.crosshairs.stroke.dashArray,
                            }),
                            c &&
                                (o = i.dropShadow(o, {
                                    left: d,
                                    top: g,
                                    blur: u,
                                    color: p,
                                    opacity: s,
                                })),
                            t.globals.dom.elGraphical.add(o));
                    },
                },
                {
                    key: "drawYCrosshairs",
                    value: function () {
                        var t = this.w,
                            e = new W(this.ctx),
                            i = t.config.yaxis[0].crosshairs,
                            a = t.globals.barPadForNumericAxis,
                            s =
                                (t.config.yaxis[0].crosshairs.show &&
                                    ((s = e.drawLine(
                                        -a,
                                        0,
                                        t.globals.gridWidth + a,
                                        0,
                                        i.stroke.color,
                                        i.stroke.dashArray,
                                        i.stroke.width
                                    )).attr({
                                        class: "apexcharts-ycrosshairs",
                                    }),
                                    t.globals.dom.elGraphical.add(s)),
                                e.drawLine(
                                    -a,
                                    0,
                                    t.globals.gridWidth + a,
                                    0,
                                    i.stroke.color,
                                    0,
                                    0
                                ));
                        s.attr({ class: "apexcharts-ycrosshairs-hidden" }),
                            t.globals.dom.elGraphical.add(s);
                    },
),
                                            (t = N.extend(n.config, t)),
                                            r.overrideResponsiveOptions(t));
                            }),
                            t
                                ? ((e = X.extendArrayProps(o, t, n)),
                                  (e = N.extend(n.config, e)),
                                  i((e = N.extend(e, t))))
                                : i({}));
                    },
                },
                {
                    key: "overrideResponsiveOptions",
                    value: function (t) {
                        t = new p(t).init({ responsiveOverride: !0 });
                        this.w.config = t;
                    },
                },
            ]),
            Te),
        Mt =
            (t(Ie, [
                {
                    key: "init",
                    value: function () {
                        this.setDefaultColors();
                    },
                },
                {
                    key: "setDefaultColors",
                    value: function () {
                        var t,
                            a = this,
                            s = this.w,
                            e = new N();
                        if (
                            (s.globals.dom.elWrap.classList.add(
                                "apexcharts-theme-".concat(s.config.theme.mode)
                            ),
                            void 0 === s.config.colors ||
                            0 ===
                                (null == (t = s.config.colors)
                                    ? void 0
                                    : t.length)
                                ? (s.globals.colors = this.predefined())
                                : ((s.globals.colors = s.config.colors),
                                  Array.isArray(s.config.colors) &&
                                      0 < s.config.colors.length &&
                                      "function" == typeof s.config.colors[0] &&
                                      (s.globals.colors = s.config.series.map(
                                          function (t, e) {
                                              var i = s.config.colors[e];
                                              return "function" ==
                                                  typeof (i =
                                                      i || s.config.colors[0])
                                                  ? ((a.isColorFn = !0),
                                                    i({
                                                        value: s.globals
                                                            .axisCharts
                                                            ? s.globals.series[
                                                                  e
                                                              ][0] || 0
                                                            : s.globals.series[
                                                                  e
                                                              ],
                                                        seriesIndex: e,
                                                        dataPointIndex: e,
                                                        w: s,
                                                    }))
                                                  : i;
                                          }
                                      ))),
                            s.globals.seriesColors.map(function (t, e) {
                                t && (s.globals.colors[e] = t);
                            }),
                            s.config.theme.monochrome.enabled)
                        ) {
                            var i = [],
                                o = s.globals.series.length;
                            (this.isBarDistributed ||
                                this.isHeatmapDistributed) &&
                                (o =
                                    s.globals.series[0].length *
                                    s.globals.series.length);
                            for (
                                var r = s.config.theme.monochrome.color,
                                    n =
                                        1 /
                                        (o /
                                            s.config.theme.monochrome
                                                .shadeIntensity),
                                    l = s.config.theme.monochrome.shadeTo,
                                    h = 0,
                                    c = 0;
                                c < o;
                                c++
                            ) {
                                var d = void 0,
                                    d =
                                        "dark" === l
                                            ? e.shadeColor(-1 * h, r)
                                            : e.shadeColor(h, r);
                                (h += n), i.push(d);
                            }
                            s.globals.colors = i.slice();
                        }
                        var g = s.globals.colors.slice();
                        this.pushExtraColors(s.globals.colors),
                            ["fill", "stroke"].forEach(function (t) {
                                void 0 === s.config[t].colors
                                    ? (s.globals[t].colors = a.isColorFn
                                          ? s.config.colors
                                          : g)
                                    : (s.globals[t].colors =
                                          s.config[t].colors.slice()),
                                    a.pushExtraColors(s.globals[t].colors);
                            }),
                            void 0 === s.config.dataLabels.style.colors
                                ? (s.globals.dataLabels.style.colors = g)
                                : (s.globals.dataLabels.style.colors =
                                      s.config.dataLabels.style.colors.slice()),
                            this.pushExtraColors(
                                s.globals.dataLabels.style.colors,
                                50
                            ),
                            void 0 ===
                            s.config.plotOptions.radar.polygons.fill.colors
                                ? (s.globals.radarPolygons.fill.colors = [
                                      "dark" === s.config.theme.mode
                                          ? "#424242"
                                          : "none",
                                  ])
                                : (s.globals.radarPolygons.fill.colors =
                                      s.config.plotOptions.radar.polygons.fill.colors.slice()),
                            this.pushExtraColors(
                                s.globals.radarPolygons.fill.colors,
                                20
                            ),
                            void 0 === s.config.markers.colors
                                ? (s.globals.markers.colors = g)
                                : (s.globals.markers.colors =
                                      s.config.markers.colors.slice()),
                            this.pushExtraColors(s.globals.markers.colors);
                    },
                },
                {
                    key: "pushExtraColors",
                    value: function (t, e) {
                        var i =
                                2 < arguments.length && void 0 !== arguments[2]
                                    ? arguments[2]
                                    : null,
                            a = this.w,
                            e = e || a.globals.series.length;
                        if (
                            ((i =
                                null === i
                                    ? this.isBarDistributed ||
                                      this.isHeatmapDistributed ||
                                      ("heatmap" === a.config.chart.type &&
                                          a.config.plotOptions.heatmap
                                              .colorScale.inverse)
                                    : i) &&
                                a.globals.series.length &&
                                (e =
                                    a.globals.series[
                                        a.globals.maxValsInArrayIndex
                                    ].length * a.globals.series.length),
                            t.length < e)
                        )
                            for (var s = e - t.length, o = 0; o < s; o++)
                                t.push(t[o]);
                    },
                },
                {
                    key: "updateThemeOptions",
                    value: function (t) {
                        (t.chart = t.chart || {}),
                            (t.tooltip = t.tooltip || {});
                        var e = t.theme.mode,
                            i =
                                "dark" === e
                                    ? "palette4"
                                    : ("light" !== e && t.theme.palette) ||
                                      "palette1",
                            a =
                                "dark" === e
                                    ? "#f6f7f8"
                                    : ("light" !== e && t.chart.foreColor) ||
                                      "#373d3f";
                        return (
                            (t.tooltip.theme = e || "light"),
                            (t.chart.foreColor = a),
                            (t.theme.palette = i),
                            t
                        );
                    },
                },
                {
                    key: "predefined",
                    value: function () {
                        switch (this.w.config.theme.palette) {
                            case "palette1":
                            default:
                                this.colors = [
                                    "#008FFB",
                                    "#00E396",
                                    "#FEB019",
                                    "#FF4560",
                                    "#775DD0",
                                ];
                                break;
                            case "palette2":
                                this.colors = [
                                    "#3f51b5",
                                    "#03a9f4",
                                    "#4caf50",
                                    "#f9ce1d",
                                    "#FF9800",
                                ];
                                break;
                            case "palette3":
                                this.colors = [
                                    "#33b2df",
                                    "#546E7A",
                                    "#d4526e",
                                    "#13d8aa",
                                    "#A5978B",
                                ];
                                break;
                            case "palette4":
                                this.colors = [
                                    "#4ecdc4",
                                    "#c7f464",
                                    "#81D4FA",
                                    "#fd6a6a",
                                    "#546E7A",
                                ];
                                break;
                            case "palette5":
                                this.colors = [
                                    "#2b908f",
                                    "#f9a3a4",
                                    "#90ee7e",
                                    "#fa4443",
                                    "#69d2e7",
                                ];
                                break;
                            case "palette6":
                                this.colors = [
                                    "#449DD1",
                                    "#F86624",
                                    "#EA3546",
                                    "#662E9B",
                                    "#C5D86D",
                                ];
                                break;
                            case "palette7":
                                this.colors = [
                                    "#D7263D",
                                    "#1B998B",
                                    "#2E294E",
                                    "#F46036",
                                    "#E2C044",
                                ];
                                break;
                            case "palette8":
                                this.colors = [
                                    "#662E9B",
                                    "#F86624",
                                    "#F9C80E",
                                    "#EA3546",
                                    "#43BCCD",
                                ];
                                break;
                            case "palette9":
                                this.colors = [
                                    "#5C4742",
                                    "#A5978B",
                                    "#8D5B4C",
                                    "#5A2A27",
                                    "#C4BBAF",
                                ];
                                break;
                            case "palette10":
                                this.colors = [
                                    "#A300D6",
                                    "#7D02EB",
                                    "#5653FE",
                                    "#2983FF",
                                    "#00B1F2",
                                ];
                        }
                        return this.colors;
                    },
                },
            ]),
            Ie),
        It =
            (t(Me, [
                {
                    key: "draw",
                    value: function () {
                        this.drawTitleSubtitle("title"),
                            this.drawTitleSubtitle("subtitle");
                    },
                },
                {
                    key: "drawTitleSubtitle",
                    value: function (t) {
                        var e = this.w,
                            i =
                                "title" === t
                                    ? e.config.title
                                    : e.config.subtitle,
                            a = e.globals.svgWidth / 2,
                            s = i.offsetY,
                            o = "middle";
                        "left" === i.align
                            ? ((a = 10), (o = "start"))
                            : "right" === i.align &&
                              ((a = e.globals.svgWidth - 10), (o = "end")),
                            (a += i.offsetX),
                            (s =
                                s +
                                parseInt(i.style.fontSize, 10) +
                                i.margin / 2),
                            void 0 !== i.text &&
                                ((a = new W(this.ctx).drawText({
                                    x: a,
                                    y: s,
                                    text: i.text,
                                    textAnchor: o,
                                    fontSize: i.style.fontSize,
                                    fontFamily: i.style.fontFamily,
                                    fontWeight: i.style.fontWeight,
                                    foreColor: i.style.color,
                                    opacity: 1,
                                })).node.setAttribute(
                                    "class",
                                    "apexcharts-".concat(t, "-text")
                                ),
                                e.globals.dom.Paper.add(a));
                    },
                },
            ]),
            Me),
        Tt =
            (t(Pe, [
                {
                    key: "getTitleSubtitleCoords",
                    value: function (t) {
                        var e = this.w,
                            i = 0,
                            a = 0,
                            s = (
                                "title" === t
                                    ? e.config.title
                                    : e.config.subtitle
                            ).floating,
                            t = e.globals.dom.baseEl.querySelector(
                                ".apexcharts-".concat(t, "-text")
                            );
                        return (
                            null === t ||
                                s ||
                                ((i = (s = t.getBoundingClientRect()).width),
                                (a = e.globals.axisCharts
                                    ? s.height + 5
                                    : s.height)),
                            { width: i, height: a }
                        );
                    },
                },
                {
                    key: "getLegendsRect",
                    value: function () {
                        var t = this.w,
                            e = t.globals.dom.elLegendWrap,
                            i =
                                (t.config.legend.height ||
                                    ("top" !== t.config.legend.position &&
                                        "bottom" !==
                                            t.config.legend.position) ||
                                    (e.style.maxHeight =
                                        t.globals.svgHeight / 2 + "px"),
                                Object.assign({}, N.getBoundingClientRect(e)));
                        return (
                            null !== e &&
                            !t.config.legend.floating &&
                            t.config.legend.show
                                ? (this.dCtx.lgRect = {
                                      x: i.x,
                                      y: i.y,
                                      height: i.height,
                                      width: 0 === i.height ? 0 : i.width,
                                  })
                                : (this.dCtx.lgRect = {
                                      x: 0,
                                      y: 0,
                                      height: 0,
                                      width: 0,
                                  }),
                            ("left" !== t.config.legend.position &&
                                "right" !== t.config.legend.position) ||
                                (1.5 * this.dCtx.lgRect.width >
                                    t.globals.svgWidth &&
                                    (this.dCtx.lgRect.width =
                                        t.globals.svgWidth / 1.5)),
                            this.dCtx.lgRect
                        );
                    },
                },
                {
                    key: "getDatalabelsRect",
                    value: function () {
                        var s = this,
                            o = this.w,
                            r = [],
                            n =
                                (o.config.series.forEach(function (t, a) {
                                    t.data.forEach(function (t, e) {
                                        var i = o.globals.series[a][e];
                                        (n = o.config.dataLabels.formatter(i, {
                                            ctx: s.dCtx.ctx,
                                            seriesIndex: a,
                                            dataPointIndex: e,
                                            w: o,
                                        })),
                                            r.push(n);
                                    });
                                }),
                                N.getLargestStringFromArr(r)),
                            t = new W(this.dCtx.ctx),
                            e = o.config.dataLabels.style,
                            t = t.getTextRects(
                                n,
                                parseInt(e.fontSize),
                                e.fontFamily
                            );
                        return { width: 1.05 * t.width, height: t.height };
                    },
                },
                {
                    key: "getLargestStringFromMultiArr",
                    value: function (t, e) {
                        var i, a;
                        return (
                            this.w.globals.isMultiLineX &&
                                ((i = e.map(function (t, e) {
                                    return Array.isArray(t) ? t.length : 1;
                                })),
                                (a = Math.max.apply(Math, S(i))),
                                (t = e[i.indexOf(a)])),
                            t
                        );
                    },
                },
            ]),
            Pe),
        zt =
            (t(Le, [
                {
                    key: "getxAxisLabelsCoords",
                    value: function () {
                        var t,
                            e,
                            i,
                            a,
                            s,
                            o,
                            r,
                            n = this.w,
                            l = n.globals.labels.slice();
                        return (
                            n.config.xaxis.convertedCatToNumeric &&
                                0 === l.length &&
                                (l = n.globals.categoryLabels),
                            0 < n.globals.timescaleLabels.length
                                ? ((t = {
                                      width: (t =
                                          this.getxAxisTimeScaleLabelsCoords())
                                          .width,
                                      height: t.height,
                                  }),
                                  (n.globals.rotateXLabels = !1))
                                : ((this.dCtx.lgWidthForSideLegends =
                                      ("left" !== n.config.legend.position &&
                                          "right" !==
                                              n.config.legend.position) ||
                                      n.config.legend.floating
                                          ? 0
                                          : this.dCtx.lgRect.width),
                                  (s = n.globals.xLabelFormatter),
                                  (e = N.getLargestStringFromArr(l)),
                                  (i =
                                      this.dCtx.dimHelpers.getLargestStringFromMultiArr(
                                          e,
                                          l
                                      )),
                                  n.globals.isBarHorizontal &&
                                      (i = e =
                                          n.globals.yAxisScale[0].result.reduce(
                                              function (t, e) {
                                                  return t.length > e.length
                                                      ? t
                                                      : e;
                                              },
                                              0
                                          )),
                                  (o = e),
                                  (e = (r = new f(this.dCtx.ctx)).xLabelFormat(
                                      s,
                                      e,
                                      o,
                                      {
                                          i: void 0,
                                          dateFormatter: new y(this.dCtx.ctx)
                                              .formatDate,
                                          w: n,
                                      }
                                  )),
                                  (i = r.xLabelFormat(s, i, o, {
                                      i: void 0,
                                      dateFormatter: new y(this.dCtx.ctx)
                                          .formatDate,
                                      w: n,
                                  })),
                                  ((n.config.xaxis.convertedCatToNumeric &&
                                      void 0 === e) ||
                                      "" === String(e).trim()) &&
                                      (i = e = "1"),
                                  (s = r =
                                      (a = new W(this.dCtx.ctx)).getTextRects(
                                          e,
                                          n.config.xaxis.labels.style.fontSize
                                      )),
                                  e !== i &&
                                      (s = a.getTextRects(
                                          i,
                                          n.config.xaxis.labels.style.fontSize
                                      )),
                                  ((t = {
                                      width: (r.width >= s.width ? r : s).width,
                                      height: (r.height >= s.height ? r : s)
                                          .height,
                                  }).width *
                                      l.length >
                                      n.globals.svgWidth -
                                          this.dCtx.lgWidthForSideLegends -
                                          this.dCtx.yAxisWidth -
                                          this.dCtx.gridPad.left -
                                          this.dCtx.gridPad.right &&
                                      0 !== n.config.xaxis.labels.rotate) ||
                                  n.config.xaxis.labels.rotateAlways
                                      ? n.globals.isBarHorizontal ||
                                        ((n.globals.rotateXLabels = !0),
                                        (r = (o = function (t) {
                                            return a.getTextRects(
                                                t,
                                                n.config.xaxis.labels.style
                                                    .fontSize,
                                                n.config.xaxis.labels.style
                                                    .fontFamily,
                                                "rotate(".concat(
                                                    n.config.xaxis.labels
                                                        .rotate,
                                                    " 0 0)"
                                                ),
                                                !1
                                            );
                                        })(e)),
                                        e !== i && (s = o(i)),
                                        (t.height =
                                            (r.height > s.height ? r : s)
                                                .height / 1.5),
                                        (t.width = (
                                            r.width > s.width ? r : s
                                        ).width))
                                      : (n.globals.rotateXLabels = !1)),
                            {
                                width: (t = n.config.xaxis.labels.show
                                    ? t
                                    : { width: 0, height: 0 }).width,
                                height: t.height,
                            }
                        );
                    },
                },
                {
                    key: "getxAxisGroupLabelsCoords",
                    value: function () {
                        var t,
                            e,
                            i,
                            a,
                            s,
                            o,
                            r = this.w;
                        return r.globals.hasXaxisGroups
                            ? ((t =
                                  (null == (t = r.config.xaxis.group.style)
                                      ? void 0
                                      : t.fontSize) ||
                                  r.config.xaxis.labels.style.fontSize),
                              (i = r.globals.groups.map(function (t) {
                                  return t.title;
                              })),
                              (e = N.getLargestStringFromArr(i)),
                              (i =
                                  this.dCtx.dimHelpers.getLargestStringFromMultiArr(
                                      e,
                                      i
                                  )),
                              (o = s =
                                  (a = new W(this.dCtx.ctx)).getTextRects(
                                      e,
                                      t
                                  )),
                              e !== i && (o = a.getTextRects(i, t)),
                              (e = {
                                  width: (s.width >= o.width ? s : o).width,
                                  height: (s.height >= o.height ? s : o).height,
                              }),
                              {
                                  width: (e = r.config.xaxis.labels.show
                                      ? e
                                      : { width: 0, height: 0 }).width,
                                  height: e.height,
                              })
                            : { width: 0, height: 0 };
                    },
                },
                {
                    key: "getxAxisTitleCoords",
                    value: function () {
                        var t = this.w,
                            e = 0,
                            i = 0;
                        return (
                            void 0 !== t.config.xaxis.title.text &&
                                ((e = (t = new W(this.dCtx.ctx).getTextRects(
                                    t.config.xaxis.title.text,
                                    t.config.xaxis.title.style.fontSize
                                )).width),
                                (i = t.height)),
                            { width: e, height: i }
                        );
                    },
                },
                {
                    key: "getxAxisTimeScaleLabelsCoords",
                    value: function () {
                        var t = this.w,
                            e =
                                ((this.dCtx.timescaleLabels =
                                    t.globals.timescaleLabels.slice()),
                                this.dCtx.timescaleLabels.map(function (t) {
                                    return t.value;
                                })),
                            i = e.reduce(function (t, e) {
                                return void 0 === t
                                    ? (console.error(
                                          "You have possibly supplied invalid Date format. Please supply a valid JavaScript Date"
                                      ),
                                      0)
                                    : t.length > e.length
                                    ? t
                                    : e;
                            }, 0);
                        return (
                            1.05 *
                                (i = new W(this.dCtx.ctx).getTextRects(
                                    i,
                                    t.config.xaxis.labels.style.fontSize
                                )).width *
                                e.length >
                                t.globals.gridWidth &&
                                0 !== t.config.xaxis.labels.rotate &&
                                (t.globals.overlappingXLabels = !0),
                            i
                        );
                    },
                },
                {
                    key: "additionalPaddingXLabels",
                    value: function (t) {
                        var s = this,
                            o = this.w,
                            r = o.globals,
                            n = o.config,
                            l = n.xaxis.type,
                            h = t.width,
                            c =
                                ((r.skipLastTimelinelabel = !1),
                                (r.skipFirstTimelinelabel = !1),
                                o.config.yaxis[0].opposite &&
                                    o.globals.isBarHorizontal);
                        n.yaxis.forEach(function (t, e) {
                            var i, a;
                            c
                                ? (s.dCtx.gridPad.left < h &&
                                      (s.dCtx.xPadLeft = h / 2 + 1),
                                  (s.dCtx.xPadRight = h / 2 + 1))
                                : ((t = t),
                                  (e = e),
                                  (1 < n.yaxis.length &&
                                      -1 !==
                                          r.collapsedSeriesIndices.indexOf(
                                              e
                                          )) ||
                                      ((e = t),
                                      s.dCtx.timescaleLabels &&
                                      s.dCtx.timescaleLabels.length
                                          ? ((t = s.dCtx.timescaleLabels[0]),
                                            (i =
                                                s.dCtx.timescaleLabels[
                                                    s.dCtx.timescaleLabels
                                                        .length - 1
                                                ].position +
                                                h / 1.75 -
                                                s.dCtx.yAxisWidthRight),
                                            (t =
                                                t.position -
                                                h / 1.75 +
                                                s.dCtx.yAxisWidthLeft),
                                            (a =
                                                "right" ===
                                                    o.config.legend.position &&
                                                0 < s.dCtx.lgRect.width
                                                    ? s.dCtx.lgRect.width
                                                    : 0),
                                            i > r.svgWidth - r.translateX - a &&
                                                (r.skipLastTimelinelabel = !0),
                                            t <
                                                -((e.show && !e.floating) ||
                                                ("bar" !== n.chart.type &&
                                                    "candlestick" !==
                                                        n.chart.type &&
                                                    "rangeBar" !==
                                                        n.chart.type &&
                                                    "boxPlot" !== n.chart.type)
                                                    ? 10
                                                    : h / 1.75) &&
                                                (r.skipFirstTimelinelabel = !0))
                                          : "datetime" === l
                                          ? s.dCtx.gridPad.right < h &&
                                            !r.rotateXLabels &&
                                            (r.skipLastTimelinelabel = !0)
                                          : "datetime" !== l &&
                                            s.dCtx.gridPad.right <
                                                h / 2 -
                                                    s.dCtx.yAxisWidthRight &&
                                            !r.rotateXLabels &&
                                            !o.config.xaxis.labels.trim &&
                                            ("between" !==
                                                o.config.xaxis.tickPlacement ||
                                                o.globals.isBarHorizontal) &&
                                            (s.dCtx.xPadRight = h / 2 + 1)));
                        });
                    },
                },
            ]),
            Le),
        Xt =
            (t(Ce, [
                {
                    key: "getyAxisLabelsCoords",
                    value: function () {
                        var c = this,
                            d = this.w,
                            g = [],
                            u = 10,
                            p = new w(this.dCtx.ctx);
                        return (
                            d.config.yaxis.map(function (t, e) {
                                var a,
                                    i,
                                    s,
                                    o,
                                    r,
                                    n = {
                                        seriesIndex: e,
                                        dataPointIndex: -1,
                                        w: d,
                                    },
                                    l = d.globals.yAxisScale[e],
                                    h = 0;
                                !p.isYAxisHidden(e) &&
                                    t.labels.show &&
                                    void 0 !== t.labels.minWidth &&
                                    (h = t.labels.minWidth),
                                    !p.isYAxisHidden(e) &&
                                    t.labels.show &&
                                    l.result.length
                                        ? ((a = d.globals.yLabelFormatters[e]),
                                          (s =
                                              l.niceMin === Number.MIN_VALUE
                                                  ? 0
                                                  : l.niceMin),
                                          (s = l.result.reduce(function (t, e) {
                                              var i;
                                              return (null ==
                                              (i = String(a(t, n)))
                                                  ? void 0
                                                  : i.length) >
                                                  (null == (i = String(a(e, n)))
                                                      ? void 0
                                                      : i.length)
                                                  ? t
                                                  : e;
                                          }, s)),
                                          (i = s = a(s, n)),
                                          (void 0 !== s && 0 !== s.length) ||
                                              (s = l.niceMax),
                                          d.globals.isBarHorizontal &&
                                              ((u = 0),
                                              (l = d.globals.labels.slice()),
                                              (s =
                                                  N.getLargestStringFromArr(l)),
                                              (s = a(s, {
                                                  seriesIndex: e,
                                                  dataPointIndex: -1,
                                                  w: d,
                                              })),
                                              (i =
                                                  c.dCtx.dimHelpers.getLargestStringFromMultiArr(
                                                      s,
                                                      l
                                                  ))),
                                          (e = new W(c.dCtx.ctx)),
                                          (l = "rotate(".concat(
                                              t.labels.rotate,
                                              " 0 0)"
                                          )),
                                          (r = o =
                                              e.getTextRects(
                                                  s,
                                                  t.labels.style.fontSize,
                                                  t.labels.style.fontFamily,
                                                  l,
                                                  !1
                                              )),
                                          s !== i &&
                                              (r = e.getTextRects(
                                                  i,
                                                  t.labels.style.fontSize,
                                                  t.labels.style.fontFamily,
                                                  l,
                                                  !1
                                              )),
                                          g.push({
                                              width:
                                                  (h > r.width || h > o.width
                                                      ? h
                                                      : (r.width > o.width
                                                            ? r
                                                            : o
                                                        ).width) + u,
                                              height: (r.height > o.height
                                                  ? r
                                                  : o
                                              ).height,
                                          }))
                                        : g.push({ width: 0, height: 0 });
                            }),
                            g
                        );
                    },
                },
                {
                    key: "getyAxisTitleCoords",
                    value: function () {
                        var s = this,
                            t = this.w,
                            o = [];
                        return (
                            t.config.yaxis.map(function (t, e) {
                                var i, a;
                                t.show && void 0 !== t.title.text
                                    ? ((a = new W(s.dCtx.ctx)),
                                      (i = "rotate(".concat(
                                          t.title.rotate,
                                          " 0 0)"
                                      )),
                                      (a = a.getTextRects(
                                          t.title.text,
                                          t.title.style.fontSize,
                                          t.title.style.fontFamily,
                                          i,
                                          !1
                                      )),
                                      o.push({
                                          width: a.width,
                                          height: a.height,
                                      }))
                                    : o.push({ width: 0, height: 0 });
                            }),
                            o
                        );
                    },
                },
                {
                    key: "getTotalYAxisWidth",
                    value: function () {
                        function i(t, e) {
                            var i = s.config.yaxis[e].floating,
                                a = 0;
                            0 < t.width && !i
                                ? ((a = t.width + l),
                                  -1 <
                                      s.globals.ignoreYAxisIndexes.indexOf(e) &&
                                      (a = a - t.width - l))
                                : (a = i || h.isYAxisHidden(e) ? 0 : 5),
                                s.config.yaxis[e].opposite
                                    ? (n += a)
                                    : (r += a),
                                (o += a);
                        }
                        var s = this.w,
                            o = 0,
                            r = 0,
                            n = 0,
                            l = 1 < s.globals.yAxisScale.length ? 10 : 0,
                            h = new w(this.dCtx.ctx);
                        return (
                            s.globals.yLabelsCoords.map(function (t, e) {
                                i(t, e);
                            }),
                            s.globals.yTitleCoords.map(function (t, e) {
                                i(t, e);
                            }),
                            s.globals.isBarHorizontal &&
                                !s.config.yaxis[0].floating &&
                                (o =
                                    s.globals.yLabelsCoords[0].width +
                                    s.globals.yTitleCoords[0].width +
                                    15),
                            (this.dCtx.yAxisWidthLeft = r),
                            (this.dCtx.yAxisWidthRight = n),
                            o
                        );
                    },
                },
            ]),
            Ce),
        Et =
            (t(Se, [
                {
                    key: "gridPadForColumnsInNumericAxis",
                    value: function (t) {
                        var e,
                            i,
                            a,
                            s,
                            o,
                            r,
                            n = this.w,
                            l = n.config,
                            n = n.globals;
                        return n.noData ||
                            n.collapsedSeries.length +
                                n.ancillaryCollapsedSeries.length ===
                                l.series.length
                            ? 0
                            : ((r = l.chart.type),
                              (a = (e = function (t) {
                                  return (
                                      "bar" === t ||
                                      "rangeBar" === t ||
                                      "candlestick" === t ||
                                      "boxPlot" === t
                                  );
                              })(r)
                                  ? l.series.length
                                  : 1),
                              (i = 0) < n.comboBarCount &&
                                  (a = n.comboBarCount),
                              n.collapsedSeries.forEach(function (t) {
                                  e(t.type) && --a;
                              }),
                              l.chart.stacked && (a = 1),
                              (r = e(r) || 0 < n.comboBarCount),
                              (s = Math.abs(n.initialMaxX - n.initialMinX)),
                              r &&
                                  n.isXNumeric &&
                                  !n.isBarHorizontal &&
                                  0 < a &&
                                  0 !== s &&
                                  ((r = (s = s <= 3 ? n.dataPoints : s) / t),
                                  t / 2 <
                                      (o =
                                          n.minXDiff && 0 < n.minXDiff / r
                                              ? n.minXDiff / r
                                              : o) && (o /= 2),
                                  (i =
                                      (o *
                                          parseInt(
                                              l.plotOptions.bar.columnWidth,
                                              10
                                          )) /
                                      100) < 1 && (i = 1),
                                  (n.barPadForNumericAxis = i)),
                              i);
                    },
                },
                {
                    key: "gridPadFortitleSubtitle",
                    value: function () {
                        var e = this,
                            i = this.w,
                            t = i.globals,
                            a =
                                this.dCtx.isSparkline || !i.globals.axisCharts
                                    ? 0
                                    : 10,
                            s =
                                (["title", "subtitle"].forEach(function (t) {
                                    void 0 !== i.config[t].text
                                        ? (a += i.config[t].margin)
                                        : (a +=
                                              e.dCtx.isSparkline ||
                                              !i.globals.axisCharts
                                                  ? 0
                                                  : 5);
                                }),
                                !i.config.legend.show ||
                                    "bottom" !== i.config.legend.position ||
                                    i.config.legend.floating ||
                                    i.globals.axisCharts ||
                                    (a += 10),
                                this.dCtx.dimHelpers.getTitleSubtitleCoords(
                                    "title"
                                )),
                            o =
                                this.dCtx.dimHelpers.getTitleSubtitleCoords(
                                    "subtitle"
                                );
                        (t.gridHeight = t.gridHeight - s.height - o.height - a),
                            (t.translateY =
                                t.translateY + s.height + o.height + a);
                    },
                },
                {
                    key: "setGridXPosForDualYAxis",
                    value: function (i, a) {
                        var s = this.w,
                            o = new w(this.dCtx.ctx);
                        s.config.yaxis.map(function (t, e) {
                            -1 !== s.globals.ignoreYAxisIndexes.indexOf(e) ||
                                t.floating ||
                                o.isYAxisHidden(e) ||
                                (t.opposite &&
                                    (s.globals.translateX =
                                        s.globals.translateX -
                                        (a[e].width + i[e].width) -
                                        parseInt(
                                            s.config.yaxis[e].labels.style
                                                .fontSize,
                                            10
                                        ) /
                                            1.2 -
                                        12),
                                s.globals.translateX < 2 &&
                                    (s.globals.translateX = 2));
                        });
                    },
                },
            ]),
            Se),
        Yt =
            (t(Ae, [
                {
                    key: "plotCoords",
                    value: function () {
                        var i = this,
                            t = this.w,
                            e = t.globals,
                            a =
                                ((this.lgRect =
                                    this.dimHelpers.getLegendsRect()),
                                (this.datalabelsCoords = {
                                    width: 0,
                                    height: 0,
                                }),
                                Array.isArray(t.config.stroke.width)
                                    ? Math.max.apply(
                                          Math,
                                          S(t.config.stroke.width)
                                      )
                                    : t.config.stroke.width),
                            t =
                                (this.isSparkline &&
                                    ((0 < t.config.markers.discrete.length ||
                                        0 < t.config.markers.size) &&
                                        Object.entries(this.gridPad).forEach(
                                            function (t) {
                                                var t = O(t, 2),
                                                    e = t[0],
                                                    t = t[1];
                                                i.gridPad[e] = Math.max(
                                                    t,
                                                    i.w.globals.markers
                                                        .largestSize / 1.5
                                                );
                                            }
                                        ),
                                    (this.gridPad.top = Math.max(
                                        a / 2,
                                        this.gridPad.top
                                    )),
                                    (this.gridPad.bottom = Math.max(
                                        a / 2,
                                        this.gridPad.bottom
                                    ))),
                                e.axisCharts
                                    ? this.setDimensionsForAxisCharts()
                                    : this.setDimensionsForNonAxisCharts(),
                                this.dimGrid.gridPadFortitleSubtitle(),
                                (e.gridHeight =
                                    e.gridHeight -
                                    this.gridPad.top -
                                    this.gridPad.bottom),
                                (e.gridWidth =
                                    e.gridWidth -
                                    this.gridPad.left -
                                    this.gridPad.right -
                                    this.xPadRight -
                                    this.xPadLeft),
                                this.dimGrid.gridPadForColumnsInNumericAxis(
                                    e.gridWidth
                                ));
                        (e.gridWidth = e.gridWidth - 2 * t),
                            (e.translateX =
                                e.translateX +
                                this.gridPad.left +
                                this.xPadLeft +
                                (0 < t ? t : 0)),
                            (e.translateY = e.translateY + this.gridPad.top);
                    },
                },
                {
                    key: "setDimensionsForAxisCharts",
                    value: function () {
                        function t() {
                            (a.translateX = h + e.datalabelsCoords.width),
                                (a.gridHeight =
                                    a.svgHeight -
                                    e.lgRect.height -
                                    c -
                                    (e.isSparkline ||
                                    "treemap" === i.config.chart.type
                                        ? 0
                                        : i.globals.rotateXLabels
                                        ? 10
                                        : 15)),
                                (a.gridWidth =
                                    a.svgWidth -
                                    h -
                                    2 * e.datalabelsCoords.width);
                        }
                        var e = this,
                            i = this.w,
                            a = i.globals,
                            s = this.dimYAxis.getyAxisLabelsCoords(),
                            o = this.dimYAxis.getyAxisTitleCoords(),
                            r =
                                (a.isSlopeChart &&
                                    (this.datalabelsCoords =
                                        this.dimHelpers.getDatalabelsRect()),
                                (i.globals.yLabelsCoords = []),
                                (i.globals.yTitleCoords = []),
                                i.config.yaxis.map(function (t, e) {
                                    i.globals.yLabelsCoords.push({
                                        width: s[e].width,
                                        index: e,
                                    }),
                                        i.globals.yTitleCoords.push({
                                            width: o[e].width,
                                            index: e,
                                        });
                                }),
                                (this.yAxisWidth =
                                    this.dimYAxis.getTotalYAxisWidth()),
                                this.dimXAxis.getxAxisLabelsCoords()),
                            n = this.dimXAxis.getxAxisGroupLabelsCoords(),
                            l = this.dimXAxis.getxAxisTitleCoords(),
                            h =
                                (this.conditionalChecksForAxisCoords(r, l, n),
                                (a.translateXAxisY = i.globals.rotateXLabels
                                    ? this.xAxisHeight / 8
                                    : -4),
                                (a.translateXAxisX =
                                    i.globals.rotateXLabels &&
                                    i.globals.isXNumeric &&
                                    i.config.xaxis.labels.rotate <= -45
                                        ? -this.xAxisWidth / 4
                                        : 0),
                                i.globals.isBarHorizontal &&
                                    ((a.rotateXLabels = !1),
   : this.elPan;
                        e && e.classList.add(this.selectedClass),
                            t && t.classList.remove(this.selectedClass);
                    },
                },
                {
                    key: "togglePanning",
                    value: function () {
                        this.ctx.getSyncedCharts().forEach(function (t) {
                            t.ctx.toolbar.toggleOtherControls(),
                                (t.w.globals.panEnabled =
                                    !t.w.globals.panEnabled),
                                t.ctx.toolbar.elPan.classList.contains(
                                    t.ctx.toolbar.selectedClass
                                )
                                    ? t.ctx.toolbar.elPan.classList.remove(
                                          t.ctx.toolbar.selectedClass
                                      )
                                    : t.ctx.toolbar.elPan.classList.add(
                                          t.ctx.toolbar.selectedClass
                                      );
                        });
                    },
                },
                {
                    key: "toggleOtherControls",
                    value: function () {
                        var e = this,
                            t = this.w;
                        (t.globals.panEnabled = !1),
                            (t.globals.zoomEnabled = !1),
                            (t.globals.selectionEnabled = !1),
                            this.getToolbarIconsReference(),
                            [this.elPan, this.elSelection, this.elZoom].forEach(
                                function (t) {
                                    t && t.classList.remove(e.selectedClass);
                                }
                            );
                    },
                },
                {
                    key: "handleZoomIn",
                    value: function () {
                        var t = this.w,
                            e =
                                (t.globals.isRangeBar &&
                                    ((this.minX = t.globals.minY),
                                    (this.maxX = t.globals.maxY)),
                                (this.minX + this.maxX) / 2),
                            i = (this.minX + e) / 2,
                            e = (this.maxX + e) / 2,
                            i = this._getNewMinXMaxX(i, e);
                        t.globals.disableZoomIn ||
                            this.zoomUpdateOptions(i.minX, i.maxX);
                    },
                },
                {
                    key: "handleZoomOut",
                    value: function () {
                        var t,
                            e,
                            i = this.w;
                        i.globals.isRangeBar &&
                            ((this.minX = i.globals.minY),
                            (this.maxX = i.globals.maxY)),
                            ("datetime" === i.config.xaxis.type &&
                                new Date(this.minX).getUTCFullYear() < 1e3) ||
                                ((t = (this.minX + this.maxX) / 2),
                                (e = this.minX - (t - this.minX)),
                                (t = this.maxX - (t - this.maxX)),
                                (e = this._getNewMinXMaxX(e, t)),
                                i.globals.disableZoomOut) ||
                                this.zoomUpdateOptions(e.minX, e.maxX);
                    },
                },
                {
                    key: "_getNewMinXMaxX",
                    value: function (t, e) {
                        var i = this.w.config.xaxis.convertedCatToNumeric;
                        return {
                            minX: i ? Math.floor(t) : t,
                            maxX: i ? Math.floor(e) : e,
                        };
                    },
                },
                {
                    key: "zoomUpdateOptions",
                    value: function (t, e) {
                        var i,
                            a = this.w;
                        void 0 !== t || void 0 !== e
                            ? (a.config.xaxis.convertedCatToNumeric &&
                                  (t < 1 &&
                                      ((t = 1), (e = a.globals.dataPoints)),
                                  e - t < 2)) ||
                              ((e = {
                                  xaxis: (t = (e = this.getBeforeZoomRange(
                                      (t = { min: t, max: e })
                                  ))
                                      ? e.xaxis
                                      : t),
                              }),
                              (i = N.clone(a.globals.initialConfig.yaxis)),
                              a.config.chart.group || (e.yaxis = i),
                              (this.w.globals.zoomed = !0),
                              this.ctx.updateHelpers._updateOptions(
                                  e,
                                  !1,
                                  this.w.config.chart.animations
                                      .dynamicAnimation.enabled
                              ),
                              this.zoomCallback(t, i))
                            : this.handleZoomReset();
                    },
                },
                {
                    key: "zoomCallback",
                    value: function (t, e) {
                        "function" == typeof this.ev.zoomed &&
                            this.ev.zoomed(this.ctx, { xaxis: t, yaxis: e });
                    },
                },
                {
                    key: "getBeforeZoomRange",
                    value: function (t, e) {
                        var i = null;
                        return (i =
                            "function" == typeof this.ev.beforeZoom
                                ? this.ev.beforeZoom(this, {
                                      xaxis: t,
                                      yaxis: e,
                                  })
                                : i);
                    },
                },
                {
                    key: "toggleMenu",
                    value: function () {
                        var t = this;
                        window.setTimeout(function () {
                            t.elMenu.classList.contains("apexcharts-menu-open")
                                ? t.elMenu.classList.remove(
                                      "apexcharts-menu-open"
                                  )
                                : t.elMenu.classList.add(
                                      "apexcharts-menu-open"
                                  );
                        }, 0);
                    },
                },
                {
                    key: "handleDownload",
                    value: function (t) {
                        var e = this.w,
                            i = new mt(this.ctx);
                        switch (t) {
                            case "svg":
                                i.exportToSVG(this.ctx);
                                break;
                            case "png":
                                i.exportToPng(this.ctx);
                                break;
                            case "csv":
                                i.exportToCSV({
                                    series: e.config.series,
                                    columnDelimiter:
                                        e.config.chart.toolbar.export.csv
                                            .columnDelimiter,
                                });
                        }
                    },
                },
                {
                    key: "handleZoomReset",
                    value: function (t) {
                        this.ctx.getSyncedCharts().forEach(function (t) {
                            var e = t.w,
                                i =
                                    ((e.globals.lastXAxis.min =
                                        e.globals.initialConfig.xaxis.min),
                                    (e.globals.lastXAxis.max =
                                        e.globals.initialConfig.xaxis.max),
                                    t.updateHelpers.revertDefaultAxisMinMax(),
                                    "function" ==
                                        typeof e.config.chart.events
                                            .beforeResetZoom &&
                                        (i =
                                            e.config.chart.events.beforeResetZoom(
                                                t,
                                                e
                                            )) &&
                                        t.updateHelpers.revertDefaultAxisMinMax(
                                            i
                                        ),
                                    "function" ==
                                        typeof e.config.chart.events.zoomed &&
                                        t.ctx.toolbar.zoomCallback({
                                            min: e.config.xaxis.min,
                                            max: e.config.xaxis.max,
                                        }),
                                    (e.globals.zoomed = !1),
                                    t.ctx.series.emptyCollapsedSeries(
                                        N.clone(e.globals.initialSeries)
                                    ));
                            t.updateHelpers._updateSeries(
                                i,
                                e.config.chart.animations.dynamicAnimation
                                    .enabled
                            );
                        });
                    },
                },
                {
                    key: "destroy",
                    value: function () {
                        (this.elZoom = null),
                            (this.elZoomIn = null),
                            (this.elZoomOut = null),
                            (this.elPan = null),
                            (this.elSelection = null),
                            (this.elZoomReset = null),
                            (this.elMenuIcon = null);
                    },
                },
            ]),
            ye),
        Dt =
            (e(x, Ht),
            (dt = i(x)),
            t(x, [
                {
                    key: "init",
                    value: function (t) {
                        var e = this,
                            i = t.xyRatios,
                            t = this.w,
                            a = this;
                        (this.xyRatios = i),
                            (this.zoomRect = this.graphics.drawRect(
                                0,
                                0,
                                0,
                                0
                            )),
                            (this.selectionRect = this.graphics.drawRect(
                                0,
                                0,
                                0,
                                0
                            )),
                            (this.gridRect =
                                t.globals.dom.baseEl.querySelector(
                                    ".apexcharts-grid"
                                )),
                            this.zoomRect.node.classList.add(
                                "apexcharts-zoom-rect"
                            ),
                            this.selectionRect.node.classList.add(
                                "apexcharts-selection-rect"
                            ),
                            t.globals.dom.elGraphical.add(this.zoomRect),
                            t.globals.dom.elGraphical.add(this.selectionRect),
                            "x" === t.config.chart.selection.type
                                ? (this.slDraggableRect = this.selectionRect
                                      .draggable({
                                          minX: 0,
                                          minY: 0,
                                          maxX: t.globals.gridWidth,
                                          maxY: t.globals.gridHeight,
                                      })
                                      .on(
                                          "dragmove",
                                          this.selectionDragging.bind(
                                              this,
                                              "dragging"
                                          )
                                      ))
                                : "y" === t.config.chart.selection.type
                                ? (this.slDraggableRect = this.selectionRect
                                      .draggable({
                                          minX: 0,
                                          maxX: t.globals.gridWidth,
                                      })
                                      .on(
                                          "dragmove",
                                          this.selectionDragging.bind(
                                              this,
                                              "dragging"
                                          )
                                      ))
                                : (this.slDraggableRect = this.selectionRect
                                      .draggable()
                                      .on(
                                          "dragmove",
                                          this.selectionDragging.bind(
                                              this,
                                              "dragging"
                                          )
                                      )),
                            this.preselectedSelection(),
                            (this.hoverArea =
                                t.globals.dom.baseEl.querySelector(
                                    "".concat(
                                        t.globals.chartClass,
                                        " .apexcharts-svg"
                                    )
                                )),
                            this.hoverArea.classList.add("apexcharts-zoomable"),
                            this.eventList.forEach(function (t) {
                                e.hoverArea.addEventListener(
                                    t,
                                    a.svgMouseEvents.bind(a, i),
                                    { capture: !1, passive: !0 }
                                );
                            });
                    },
                },
                {
                    key: "destroy",
                    value: function () {
                        this.slDraggableRect &&
                            (this.slDraggableRect.draggable(!1),
                            this.slDraggableRect.off(),
                            this.selectionRect.off()),
                            (this.selectionRect = null),
                            (this.zoomRect = null),
                            (this.gridRect = null);
                    },
                },
                {
                    key: "svgMouseEvents",
                    value: function (t, e) {
                        var i,
                            a = this.w,
                            s = this,
                            o = this.ctx.toolbar,
                            r = (
                                a.globals.zoomEnabled
                                    ? a.config.chart.zoom
                                    : a.config.chart.selection
                            ).type,
                            n = a.config.chart.toolbar.autoSelected;
                        e.shiftKey
                            ? ((this.shiftWasPressed = !0),
                              o.enableZoomPanFromToolbar(
                                  "pan" === n ? "zoom" : "pan"
                              ))
                            : this.shiftWasPressed &&
                              (o.enableZoomPanFromToolbar(n),
                              (this.shiftWasPressed = !1)),
                            e.target &&
                                ((o = e.target.classList),
                                e.target.parentNode &&
                                    null !== e.target.parentNode &&
                                    (i = e.target.parentNode.classList),
                                o.contains("apexcharts-selection-rect") ||
                                    o.contains("apexcharts-legend-marker") ||
                                    o.contains("apexcharts-legend-text") ||
                                    (i && i.contains("apexcharts-toolbar")) ||
                                    ((s.clientX = (
                                        "touchmove" === e.type ||
                                        "touchstart" === e.type
                                            ? e.touches[0]
                                            : "touchend" === e.type
                                            ? e.changedTouches[0]
                                            : e
                                    ).clientX),
                                    (s.clientY = (
                                        "touchmove" === e.type ||
                                        "touchstart" === e.type
                                            ? e.touches[0]
                                            : "touchend" === e.type
                                            ? e.changedTouches[0]
                                            : e
                                    ).clientY),
                                    "mousedown" === e.type &&
                                        1 === e.which &&
                                        ((n =
                                            s.gridRect.getBoundingClientRect()),
                                        (s.startX = s.clientX - n.left),
                                        (s.startY = s.clientY - n.top),
                                        (s.dragged = !1),
                                        (s.w.globals.mousedown = !0)),
                                    (("mousemove" === e.type &&
                                        1 === e.which) ||
                                        "touchmove" === e.type) &&
                                        ((s.dragged = !0),
                                        a.globals.panEnabled
                                            ? ((a.globals.selection = null),
                                              s.w.globals.mousedown &&
                                                  s.panDragging({
                                                      context: s,
                                                      zoomtype: r,
                                                      xyRatios: t,
                                                  }))
                                            : ((s.w.globals.mousedown &&
                                                  a.globals.zoomEnabled) ||
                                                  (s.w.globals.mousedown &&
                                                      a.globals
                                                          .selectionEnabled)) &&
                                              (s.selection = s.selectionDrawing(
                                                  { context: s, zoomtype: r }
                                              ))),
                                    ("mouseup" !== e.type &&
                                        "touchend" !== e.type &&
                                        "mouseleave" !== e.type) ||
                                        ((o =
                                            s.gridRect.getBoundingClientRect()),
                                        s.w.globals.mousedown &&
                                            ((s.endX = s.clientX - o.left),
                                            (s.endY = s.clientY - o.top),
                                            (s.dragX = Math.abs(
                                                s.endX - s.startX
                                            )),
                                            (s.dragY = Math.abs(
                                                s.endY - s.startY
                                            )),
                                            (a.globals.zoomEnabled ||
                                                a.globals.selectionEnabled) &&
                                                s.selectionDrawn({
                                                    context: s,
                                                    zoomtype: r,
                                                }),
                                            a.globals.panEnabled) &&
                                            a.config.xaxis
                                                .convertedCatToNumeric &&
                                            s.delayedPanScrolled(),
                                        a.globals.zoomEnabled &&
                                            s.hideSelectionRect(
                                                this.selectionRect
                                            ),
                                        (s.dragged = !1),
                                        (s.w.globals.mousedown = !1)),
                                    this.makeSelectionRectDraggable()));
                    },
                },
                {
                    key: "makeSelectionRectDraggable",
                    value: function () {
                        var t,
                            e = this.w;
                        this.selectionRect &&
                            0 <
                                (t =
                                    this.selectionRect.node.getBoundingClientRect())
                                    .width &&
                            0 < t.height &&
                            this.slDraggableRect
                                .selectize({
                                    points: "l, r",
                                    pointSize: 8,
                                    pointType: "rect",
                                })
                                .resize({
                                    constraint: {
                                        minX: 0,
                                        minY: 0,
                                        maxX: e.globals.gridWidth,
                                        maxY: e.globals.gridHeight,
                                    },
                                })
                                .on(
                                    "resizing",
                                    this.selectionDragging.bind(
                                        this,
                                        "resizing"
                                    )
                                );
                    },
                },
                {
                    key: "preselectedSelection",
                    value: function () {
                        var t,
                            e,
                            i = this.w,
                            a = this.xyRatios;
                        i.globals.zoomEnabled ||
                            (void 0 !== i.globals.selection &&
                            null !== i.globals.selection
                                ? this.drawSelectionRect(i.globals.selection)
                                : void 0 !==
                                      i.config.chart.selection.xaxis.min &&
                                  void 0 !==
                                      i.config.chart.selection.xaxis.max &&
                                  ((t =
                                      (i.config.chart.selection.xaxis.min -
                                          i.globals.minX) /
                                      a.xRatio),
                                  (e =
                                      i.globals.gridWidth -
                                      (i.globals.maxX -
                                          i.config.chart.selection.xaxis.max) /
                                          a.xRatio -
                                      t),
                                  i.globals.isRangeBar &&
                                      ((t =
                                          (i.config.chart.selection.xaxis.min -
                                              i.globals.yAxisScale[0].niceMin) /
                                          a.invertedYRatio),
                                      (e =
                                          (i.config.chart.selection.xaxis.max -
                                              i.config.chart.selection.xaxis
                                                  .min) /
                                          a.invertedYRatio)),
                                  (a = {
                                      x: t,
                                      y: 0,
                                      width: e,
                                      height: i.globals.gridHeight,
                                      translateX: 0,
                                      translateY: 0,
                                      selectionEnabled: !0,
                                  }),
                                  this.drawSelectionRect(a),
                                  this.makeSelectionRectDraggable(),
                                  "function" ==
                                      typeof i.config.chart.events.selection) &&
                                  i.config.chart.events.selection(this.ctx, {
                                      xaxis: {
                                          min: i.config.chart.selection.xaxis
                                              .min,
                                          max: i.config.chart.selection.xaxis
                                              .max,
                                      },
                                      yaxis: {},
                                  }));
                    },
                },
                {
                    key: "drawSelectionRect",
                    value: function (t) {
                        var e = t.x,
                            i = t.y,
                            a = t.width,
                            s = t.height,
                            o = t.translateX,
                            t = t.translateY,
                            r = this.w,
                            n = this.zoomRect,
                            l = this.selectionRect;
                        (this.dragged || null !== r.globals.selection) &&
                            ((o = {
                                transform:
                                    "translate(" +
                                    (void 0 === o ? 0 : o) +
                                    ", " +
                                    (void 0 === t ? 0 : t) +
                                    ")",
                            }),
                            r.globals.zoomEnabled &&
                                this.dragged &&
                                (n.attr({
                                    x: e,
                                    y: i,
                                    width: (a = a < 0 ? 1 : a),
                                    height: s,
                                    fill: r.config.chart.zoom.zoomedArea.fill
                                        .color,
                                    "fill-opacity":
                                        r.config.chart.zoom.zoomedArea.fill
                                            .opacity,
                                    stroke: r.config.chart.zoom.zoomedArea
                                        .stroke.color,
                                    "stroke-width":
                                        r.config.chart.zoom.zoomedArea.stroke
                                            .width,
                                    "stroke-opacity":
                                        r.config.chart.zoom.zoomedArea.stroke
                                            .opacity,
                                }),
                                W.setAttrs(n.node, o)),
                            r.globals.selectionEnabled) &&
                            (l.attr({
                                x: e,
                                y: i,
                                width: 0 < a ? a : 0,
                                height: 0 < s ? s : 0,
                                fill: r.config.chart.selection.fill.color,
                                "fill-opacity":
                                    r.config.chart.selection.fill.opacity,
                                stroke: r.config.chart.selection.stroke.color,
                                "stroke-width":
                                    r.config.chart.selection.stroke.width,
                                "stroke-dasharray":
                                    r.config.chart.selection.stroke.dashArray,
                                "stroke-opacity":
                                    r.config.chart.selection.stroke.opacity,
                            }),
                            W.setAttrs(l.node, o));
                    },
                },
                {
                    key: "hideSelectionRect",
                    value: function (t) {
                        t && t.attr({ x: 0, y: 0, width: 0, height: 0 });
                    },
                },
                {
                    key: "selectionDrawing",
                    value: function (t) {
                        var e = t.context,
                            t = t.zoomtype,
                            i = this.w,
                            a = this.gridRect.getBoundingClientRect(),
                            s = e.startX - 1,
                            o = e.startY,
                            r = !1,
                            n = !1,
                            l = e.clientX - a.left - s,
                            h = e.clientY - a.top - o;
                        return (
                            Math.abs(l + s) > i.globals.gridWidth
                                ? (l = i.globals.gridWidth - s)
                                : e.clientX - a.left < 0 && (l = s),
                            s > e.clientX - a.left &&
                                ((r = !0), (l = Math.abs(l))),
                            o > e.clientY - a.top &&
                                ((n = !0), (h = Math.abs(h))),
                            (a =
                                "x" === t
                                    ? {
                                          x: r ? s - l : s,
                                          y: 0,
                                          width: l,
                                          height: i.globals.gridHeight,
                                      }
                                    : "y" === t
                                    ? {
                                          x: 0,
                                          y: n ? o - h : o,
                                          width: i.globals.gridWidth,
                                          height: h,
                                      }
                                    : {
                                          x: r ? s - l : s,
                                          y: n ? o - h : o,
                                          width: l,
                                          height: h,
                                      }),
                            e.drawSelectionRect(a),
                            e.selectionDragging("resizing"),
                            a
                        );
                    },
                },
                {
                    key: "selectionDragging",
                    value: function (t, e) {
                        function i(t) {
                            return parseFloat(l.node.getAttribute(t));
                        }
                        var o = this,
                            r = this.w,
                            n = this.xyRatios,
                            l = this.selectionRect,
                            a = 0,
                            t =
                                ("resizing" === t && (a = 30),
                                {
                                    x: i("x"),
                                    y: i("y"),
                                    width: i("width"),
                                    height: i("height"),
                                });
                        (r.globals.selection = t),
                            "function" ==
                                typeof r.config.chart.events.selection &&
                                r.globals.selectionEnabled &&
                                (clearTimeout(
                                    this.w.globals.selectionResizeTimer
                                ),
                                (this.w.globals.selectionResizeTimer =
                                    window.setTimeout(function () {
                                        var t,
                                            e,
                                            i,
                                            a =
                                                o.gridRect.getBoundingClientRect(),
                                            s = l.node.getBoundingClientRect(),
                                            s = r.globals.isRangeBar
                                                ? ((t =
                                                      r.globals.yAxisScale[0]
                                                          .niceMin +
                                                      (s.left - a.left) *
                                                          n.invertedYRatio),
                                                  (e =
                                                      r.globals.yAxisScale[0]
                                                          .niceMin +
                                                      (s.right - a.left) *
                                                          n.invertedYRatio),
                                                  (i = 0),
                                                  1)
                                                : ((t =
                                                      r.globals.xAxisScale
                                                          .niceMin +
                                                      (s.left - a.left) *
                                                          n.xRatio),
                                                  (e =
                                                      r.globals.xAxisScale
                                                          .niceMin +
                                                      (s.right - a.left) *
                                                          n.xRatio),
                                                  (i =
                                                      r.globals.yAxisScale[0]
                                                          .niceMin +
                                                      (a.bottom - s.bottom) *
                                                          n.yRatio[0]),
                                                  r.globals.yAxisScale[0]
                                                      .niceMax -
                                                      (s.top - a.top) *
                                                          n.yRatio[0]),
                                            a = {
                                                xaxis: { min: t, max: e },
                                                yaxis: { min: i, max: s },
                                            };
                                        r.config.chart.events.selection(
                                            o.ctx,
                                            a
                                        ),
                                            r.config.chart.brush.enabled &&
                                                void 0 !==
                                                    r.config.chart.events
                                                        .brushScrolled &&
                                                r.config.chart.events.brushScrolled(
                                                    o.ctx,
                                                    a
                                                );
                                    }, a)));
                    },
                },
                {
                    key: "selectionDrawn",
                    value: function (t) {
                        var i,
                            e,
                            a,
                            s,
                            o = t.context,
                            t = t.zoomtype,
                            r = this.w,
                            n = o,
                            l = this.xyRatios,
                            o = this.ctx.toolbar,
                            h =
                                (n.startX > n.endX &&
                                    ((h = n.startX),
                                    (n.startX = n.endX),
                                    (n.endX = h)),
                                n.startY > n.endY &&
                                    ((h = n.startY),
                                    (n.startY = n.endY),
                                    (n.endY = h)),
                                void 0),
                            c = void 0,
                            c = r.globals.isRangeBar
                                ? ((h =
                                      r.globals.yAxisScale[0].niceMin +
                                      n.startX * l.invertedYRatio),
                                  r.globals.yAxisScale[0].niceMin +
                                      n.endX * l.invertedYRatio)
                                : ((h =
                                      r.globals.xAxisScale.niceMin +
                                      n.startX * l.xRatio),
                                  r.globals.xAxisScale.niceMin +
                                      n.endX * l.xRatio),
                            d = [],
                            g = [];
                        r.config.yaxis.forEach(function (t, e) {
                            var i;
                            0 < r.globals.seriesYAxisMap[e].length &&
                                ((i = r.globals.seriesYAxisMap[e][0]),
                                d.push(
                                    r.globals.yAxisScale[e].niceMax -
                                        l.yRatio[i] * n.startY
                                ),
                                g.push(
                                    r.globals.yAxisScale[e].niceMax -
                                        l.yRatio[i] * n.endY
                                ));
                        }),
                            n.dragged &&
                                (10 < n.dragX || 10 < n.dragY) &&
                                h !== c &&
                                (r.globals.zoomEnabled
                                    ? ((i = N.clone(
                                          r.globals.initialConfig.yaxis
                                      )),
                                      (e = N.clone(
                                          r.globals.initialConfig.xaxis
                                      )),
                                      (r.globals.zoomed = !0),
                                      r.config.xaxis.convertedCatToNumeric &&
                                          ((h = Math.floor(h)),
                                          (c = Math.floor(c)),
                                          h < 1 &&
                                              ((h = 1),
                                              (c = r.globals.dataPoints)),
                                          c - h < 2) &&
                                          (c = h + 1),
                                      ("xy" !== t && "x" !== t) ||
                                          (e = { min: h, max: c }),
                                      ("xy" !== t && "y" !== t) ||
                                          i.forEach(function (t, e) {
                                              (i[e].min = g[e]),
                                                  (i[e].max = d[e]);
                                          }),
                                      o &&
                                          (s = o.getBeforeZoomRange(e, i)) &&
                                          ((e = s.xaxis || e),
                                          (i = s.yaxis || i)),
                                      (s = { xaxis: e }),
                                      r.config.chart.group || (s.yaxis = i),
                                      n.ctx.updateHelpers._updateOptions(
                                          s,
                                          !1,
                                          n.w.config.chart.animations
                                              .dynamicAnimation.enabled
                                      ),
                                      "function" ==
                                          typeof r.config.chart.events.zoomed &&
                                          o.zoomCallback(e, i))
                                    : r.globals.selectionEnabled &&
                                      ((a = null),
                                      (s = { min: h, max: c }),
                                      ("xy" !== t && "y" !== t) ||
                                          (a = N.clone(r.config.yaxis)).forEach(
                                              function (t, e) {
                                                  (a[e].min = g[e]),
                                                      (a[e].max = d[e]);
                                              }
                                          ),
                                      (r.globals.selection = n.selection),
                                      "function" ==
                                          typeof r.config.chart.events
                                              .selection) &&
                                      r.config.chart.events.selection(n.ctx, {
                                          xaxis: s,
                                          yaxis: a,
                                      }));
                    },
                },
                {
                    key: "panDragging",
                    value: function (t) {
                        var t = t.context,
                            e = this.w,
                            i =
                                (void 0 !== e.globals.lastClientPosition.x &&
                                    ((i =
                                        e.globals.lastClientPosition.x -
                                        t.clientX),
                                    (a =
                                        e.globals.lastClientPosition.y -
                                        t.clientY),
                                    Math.abs(i) > Math.abs(a) && 0 < i
                                        ? (this.moveDirection = "left")
                                        : Math.abs(i) > Math.abs(a) && i < 0
                                        ? (this.moveDirection = "right")
                                        : Math.abs(a) > Math.abs(i) && 0 < a
                                        ? (this.moveDirection = "up")
                                        : Math.abs(a) > Math.abs(i) &&
                                          a < 0 &&
                                          (this.moveDirection = "down")),
                                (e.globals.lastClientPosition = {
                                    x: t.clientX,
                                    y: t.clientY,
                                }),
                                e.globals.isRangeBar
                                    ? e.globals.minY
                                    : e.globals.minX),
                            a = e.globals.isRangeBar
                                ? e.globals.maxY
                                : e.globals.maxX;
                        e.config.xaxis.convertedCatToNumeric ||
                            t.panScrolled(i, a);
                    },
                },
                {
                    key: "delayedPanScrolled",
                    value: function () {
                        var t = this.w,
                            e = t.globals.minX,
                            i = t.globals.maxX,
                            a = (t.globals.maxX - t.globals.minX) / 2;
                        "left" === this.moveDirection
                            ? ((e = t.globals.minX + a),
                              (i = t.globals.maxX + a))
                            : "right" === this.moveDirection &&
                              ((e = t.globals.minX - a),
                              (i = t.globals.maxX - a)),
                            (e = Math.floor(e)),
                            (i = Math.floor(i)),
                            this.updateScrolledChart(
                                { xaxis: { min: e, max: i } },
                                e,
                                i
                            );
                    },
                },
                {
                    key: "panScrolled",
                    value: function (t, e) {
                        var i = this.w,
                            a = this.xyRatios,
                            s = N.clone(i.globals.initialConfig.yaxis),
                            o = a.xRatio,
                            r = i.globals.minX,
                            n = i.globals.maxX,
                            a =
                                (i.globals.isRangeBar &&
                                    ((o = a.invertedYRatio),
                                    (r = i.globals.minY),
                                    (n = i.globals.maxY)),
                                "left" === this.moveDirection
                                    ? ((t = r + (i.globals.gridWidth / 15) * o),
                                      (e = n + (i.globals.gridWidth / 15) * o))
                                    : "right" === this.moveDirection &&
                                      ((t = r - (i.globals.gridWidth / 15) * o),
                                      (e = n - (i.globals.gridWidth / 15) * o)),
                                i.globals.isRangeBar ||
                                    ((t < i.globals.initialMinX ||
                                        e > i.globals.initialMaxX) &&
                                        ((t = r), (e = n))),
                                { xaxis: { min: t, max: e } });
                        i.config.chart.group || (a.yaxis = s),
                            this.updateScrolledChart(a, t, e);
                    },
                },
                {
                    key: "updateScrolledChart",
                    value: function (t, e, i) {
                        var a = this.w;
                        this.ctx.updateHelpers._updateOptions(t, !1, !1),
                            "function" ==
                                typeof a.config.chart.events.scrolled &&
                                a.config.chart.events.scrolled(this.ctx, {
                                    xaxis: { min: e, max: i },
                                });
                    },
                },
            ]),
            x),
        Ot =
            (t(ve, [
                {
                    key: "getNearestValues",
                    value: function (t) {
                        var e,
                            i = t.hoverArea,
                            a = t.elGrid,
                            s = t.clientX,
                            t = t.clientY,
                            o = this.w,
                            a = a.getBoundingClientRect(),
                            r = a.width,
                            n = a.height,
                            l = r / (o.globals.dataPoints - 1),
                            h = n / o.globals.dataPoints,
                            c = this.hasBars(),
                            s =
                                ((!o.globals.comboCharts && !c) ||
                                    o.config.xaxis.convertedCatToNumeric ||
                                    (l = r / o.globals.dataPoints),
                                s - a.left - o.globals.barPadForNumericAxis),
                            t = t - a.top,
                            a =
                                (s < 0 || t < 0 || r < s || n < t
                                    ? (i.classList.remove("hovering-zoom"),
                                      i.classList.remove("hovering-pan"))
                                    : o.globals.zoomEnabled
                                    ? (i.classList.remove("hovering-pan"),
                                      i.classList.add("hovering-zoom"))
                                    : o.globals.panEnabled &&
                                      (i.classList.remove("hovering-zoom"),
                                      i.classList.add("hovering-pan")),
                                Math.round(s / l)),
                            i = Math.floor(t / h),
                            h =
                                (c &&
                                    !o.config.xaxis.convertedCatToNumeric &&
                                    ((a = Math.ceil(s / l)), --a),
                                null),
                            c = o.globals.seriesXvalues.map(function (t) {
                                return t.filter(function (t) {
                                    return N.isNumber(t);
                                });
                            }),
                            l = o.globals.seriesYvalues.map(function (t) {
                                return t.filter(function (t) {
                                    return N.isNumber(t);
                                });
                            });
                        return (
                            o.globals.isXNumeric &&
                                ((r =
                                    s *
                                    ((e = this.ttCtx
                                        .getElGrid()
                                        .getBoundingClientRect()).width /
                                        r)),
                                (e = t * (e.height / n)),
                                (h = (n = this.closestInMultiArray(r, e, c, l))
                                    .index),
                                (a = n.j),
                                null !== h) &&
                                ((c = o.globals.seriesXvalues[h]),
                                (a = this.closestInArray(r, c).index)),
                            (o.globals.capturedSeriesIndex =
                                null === h ? -1 : h),
                            (!a || a < 1) && (a = 0),
                            o.globals.isBarHorizontal
                                ? (o.globals.capturedDataPointIndex = i)
                                : (o.globals.capturedDataPointIndex = a),
                            {
                                capturedSeries: h,
                                j: o.globals.isBarHorizontal ? i : a,
                                hoverX: s,
                                hoverY: t,
                            }
                        );
                    },
                },
                {
                    key: "closestInMultiArray",
                    value: function (i, a, t, e) {
                        var s,
                            o = this.w,
                            r = 0,
                            n = null,
                            l = -1,
                            o =
                                (1 < o.globals.series.length
                                    ? (r = this.getFirstActiveXArray(t))
                                    : (n = 0),
                                t[r][0]),
                            h = Math.abs(i - o);
                        return (
                            t.forEach(function (t) {
                                t.forEach(function (t, e) {
                                    t = Math.abs(i - t);
                                    t <= h && ((h = t), (l = e));
                                });
                            }),
                            -1 !== l &&
                                ((o = e[r][l]),
                                (s = Math.abs(a - o)),
                                (n = r),
                                e.forEach(function (t, e) {
                                    t = Math.abs(a - t[l]);
                                    t <= s && ((s = t), (n = e));
                                })),
                            { index: n, j: l }
                        );
                    },
                },
                {
                    key: "getFirstActiveXArray",
                    value: function (t) {
                        for (
                            var e = this.w,
                                i = 0,
                                a = t.map(function (t, e) {
                                    return 0 < t.length ? e : -1;
                                }),
                                s = 0;
                            s < a.length;
                            s++
                        )
                            if (
                                -1 !== a[s] &&
                                -1 ===
                                    e.globals.collapsedSeriesIndices.indexOf(
                                        s
                                    ) &&
                                -1 ===
                                    e.globals.ancillaryCollapsedSeriesIndices.indexOf(
                                        s
                                    )
                            ) {
                                i = a[s];
                                break;
                            }
                        return i;
                    },
                },
                {
                    key: "closestInArray",
                    value: function (t, e) {
                        for (
                            var i = e[0], a = null, s = Math.abs(t - i), o = 0;
                            o < e.length;
                            o++
                        ) {
                            var r = Math.abs(t - e[o]);
                            r < s && ((s = r), (a = o));
                        }
                        return { index: a };
                    },
                },
                {
                    key: "isXoverlap",
                    value: function (t) {
                        var e = [],
                            i = this.w.globals.seriesX.filter(function (t) {
                                return void 0 !== t[0];
                            });
                        if (0 < i.length)
                            for (var a = 0; a < i.length - 1; a++)
                                void 0 !== i[a][t] &&
                                    void 0 !== i[a + 1][t] &&
                                    i[a][t] !== i[a + 1][t] &&
                                    e.push("unEqual");
                        return 0 === e.length;
                    },
                },
                {
                    key: "isInitialSeriesSameLen",
                    value: function () {
                        for (
                            var t = !0, e = this.w.globals.initialSeries, i = 0;
                            i < e.length - 1;
                            i++
                        )
                            if (e[i].data.length !== e[i + 1].data.length) {
                                t = !1;
                                break;
                            }
                        return t;
                    },
                },
                {
                    key: "getBarsHeight",
                    value: function (t) {
                        return S(t).reduce(function (t, e) {
                            return t + e.getBBox().height;
                        }, 0);
                    },
                },
                {
                    key: "getElMarkers",
                    value: function (t) {
                        return "number" == typeof t
                            ? this.w.globals.dom.baseEl.querySelectorAll(
                                  ".apexcharts-series[data\\:realIndex='".concat(
                                      t,
                                      "'] .apexcharts-series-markers-wrap > *"
                                  )
                              )
                            : this.w.globals.dom.baseEl.querySelectorAll(
                                  ".apexcharts-series-markers-wrap > *"
                              );
                    },
                },
                {
                    key: "getAllMarkers",
                    value: function () {
                        var t = this.w.globals.dom.baseEl.querySelectorAll(
                                ".apexcharts-series-markers-wrap"
                            ),
                            e =
                                ((t = S(t)).sort(function (t, e) {
                                    (t = Number(
                                        t.getAttribute("data:realIndex")
                                    )),
                                        (e = Number(
                                            e.getAttribute("data:realIndex")
                                        ));
                                    return e < t ? 1 : t < e ? -1 : 0;
                                }),
                                []);
                        return (
                            t.forEach(function (t) {
                                e.push(t.querySelector(".apexcharts-marker"));
                            }),
                            e
                        );
                    },
                },
                {
                    key: "hasMarkers",
                    value: function (t) {
                        return 0 < this.getElMarkers(t).length;
                    },
                },
                {
                    key: "getElBars",
                    value: function () {
                        return this.w.globals.dom.baseEl.querySelectorAll(
                            ".apexcharts-bar-series,  .apexcharts-candlestick-series, .apexcharts-boxPlot-series, .apexcharts-rangebar-series"
                        );
                    },
                },
                {
                    key: "hasBars",
                    value: function () {
                        return 0 < this.getElBars().length;
                    },
                },
                {
                    key: "getHoverMarkerSize",
                    value: function (t) {
                        var e = this.w,
                            i = e.config.markers.hover.size;
                        return (i =
                            void 0 === i
                                ? e.globals.markers.size[t] +
                                  e.config.markers.hover.sizeOffset
                                : i);
                    },
                },
                {
                    key: "toggleAllTooltipSeriesGroups",
                    value: function (t) {
                        var e = this.w,
                            i = this.ttCtx;
                        0 === i.allTooltipSeriesGroups.length &&
                            (i.allTooltipSeriesGroups =
                                e.globals.dom.baseEl.querySelectorAll(
                                    ".apexcharts-tooltip-series-group"
                                ));
                        for (
                            var a = i.allTooltipSeriesGroups, s = 0;
                            s < a.length;
                            s++
                        )
                            "enable" === t
                                ? (a[s].classList.add("apexcharts-active"),
                                  (a[s].style.display =
                                      e.config.tooltip.items.display))
                                : (a[s].classList.remove("apexcharts-active"),
                                  (a[s].style.display = "none"));
                    },
                },
            ]),
            ve),
        Nt =
            (t(me, [
                {
                    key: "drawSeriesTexts",
                    value: function (t) {
                        var e = t.shared,
                            e = void 0 === e || e,
                            i = t.ttItems,
                            a = t.i,
                            a = void 0 === a ? 0 : a,
                            s = t.j,
                            s = void 0 === s ? null : s,
                            o = t.y1,
                            r = t.y2,
                            t = t.e,
                            n = this.w,
                            o =
                                (void 0 !== n.config.tooltip.custom
                                    ? this.handleCustomTooltip({
                                          i: a,
                                          j: s,
                                          y1: o,
                                          y2: r,
                                          w: n,
                                      })
                                    : this.toggleActiveInactiveSeries(e),
                                this.getValuesToPrint({ i: a, j: s })),
                            r =
                                (this.printLabels({
                                    i: a,
                                    j: s,
                                    values: o,
                                    ttItems: i,
                                    shared: e,
       als[t] &&
                                g.globals.seriesGoals[t][l] &&
                                Array.isArray(g.globals.seriesGoals[t][l])
                            );
                        }
                        var o,
                            r = this,
                            n = t.i,
                            l = t.j,
                            e = t.values,
                            h = t.ttItems,
                            c = t.shared,
                            d = t.e,
                            g = this.w,
                            u = [],
                            p = e.xVal,
                            f = e.zVal,
                            x = e.xAxisTTVal,
                            b = "",
                            m = g.globals.colors[n];
                        null !== l &&
                            g.config.plotOptions.bar.distributed &&
                            (m = g.globals.colors[l]);
                        for (
                            var i = 0, a = g.globals.series.length - 1;
                            i < g.globals.series.length;
                            i++, a--
                        )
                            !(function (t, e) {
                                var i = r.getFormatters(n),
                                    a =
                                        ((b = r.getSeriesName({
                                            fn: i.yLbTitleFormatter,
                                            index: n,
                                            seriesIndex: n,
                                            j: l,
                                        })),
                                        "treemap" === g.config.chart.type &&
                                            (b = i.yLbTitleFormatter(
                                                String(
                                                    g.config.series[n].data[l].x
                                                ),
                                                {
                                                    series: g.globals.series,
                                                    seriesIndex: n,
                                                    dataPointIndex: l,
                                                    w: g,
                                                }
                                            )),
                                        g.config.tooltip.inverseOrder ? e : t);
                                g.globals.axisCharts &&
                                    ((e = function (t) {
                                        var e;
                                        return g.globals.isRangeData
                                            ? i.yLbFormatter(
                                                  null ==
                                                      (e =
                                                          g.globals
                                                              .seriesRangeStart) ||
                                                      null == (e = e[t])
                                                      ? void 0
                                                      : e[l],
                                                  {
                                                      series: g.globals
                                                          .seriesRangeStart,
                                                      seriesIndex: t,
                                                      dataPointIndex: l,
                                                      w: g,
                                                  }
                                              ) +
                                                  " - " +
                                                  i.yLbFormatter(
                                                      null ==
                                                          (e =
                                                              g.globals
                                                                  .seriesRangeEnd) ||
                                                          null == (e = e[t])
                                                          ? void 0
                                                          : e[l],
                                                      {
                                                          series: g.globals
                                                              .seriesRangeEnd,
                                                          seriesIndex: t,
                                                          dataPointIndex: l,
                                                          w: g,
                                                      }
                                                  )
                                            : i.yLbFormatter(
                                                  g.globals.series[t][l],
                                                  {
                                                      series: g.globals.series,
                                                      seriesIndex: t,
                                                      dataPointIndex: l,
                                                      w: g,
                                                  }
                                              );
                                    }),
                                    c
                                        ? ((i = r.getFormatters(a)),
                                          (b = r.getSeriesName({
                                              fn: i.yLbTitleFormatter,
                                              index: a,
                                              seriesIndex: n,
                                              j: l,
                                          })),
                                          (m = g.globals.colors[a]),
                                          (o = e(a)),
                                          s(a) &&
                                              (u = g.globals.seriesGoals[a][
                                                  l
                                              ].map(function (t) {
                                                  return {
                                                      attrs: t,
                                                      val: i.yLbFormatter(
                                                          t.value,
                                                          {
                                                              seriesIndex: a,
                                                              dataPointIndex: l,
                                                              w: g,
                                                          }
                                                      ),
                                                  };
                                              })))
                                        : ((t =
                                              null == d ||
                                              null == (t = d.target)
                                                  ? void 0
                                                  : t.getAttribute("fill")) &&
                                              (m =
                                                  -1 !== t.indexOf("url")
                                                      ? document
                                                            .querySelector(
                                                                t
                                                                    .substr(4)
                                                                    .slice(
                                                                        0,
                                                                        -1
                                                                    )
                                                            )
                                                            .childNodes[0].getAttribute(
                                                                "stroke"
                                                            )
                                                      : t),
                                          (o = e(n)),
                                          s(n) &&
                                              Array.isArray(
                                                  g.globals.seriesGoals[n][l]
                                              ) &&
                                              (u = g.globals.seriesGoals[n][
                                                  l
                                              ].map(function (t) {
                                                  return {
                                                      attrs: t,
                                                      val: i.yLbFormatter(
                                                          t.value,
                                                          {
                                                              seriesIndex: n,
                                                              dataPointIndex: l,
                                                              w: g,
                                                          }
                                                      ),
                                                  };
                                              })))),
                                    null === l &&
                                        (o = i.yLbFormatter(
                                            g.globals.series[n],
                                            z(
                                                z({}, g),
                                                {},
                                                {
                                                    seriesIndex: n,
                                                    dataPointIndex: n,
                                                }
                                            )
                                        )),
                                    r.DOMHandling({
                                        i: n,
                                        t: a,
                                        j: l,
                                        ttItems: h,
                                        values: {
                                            val: o,
                                            goalVals: u,
                                            xVal: p,
                                            xAxisTTVal: x,
                                            zVal: f,
                                        },
                                        seriesName: b,
                                        shared: c,
                                        pColor: m,
                                    });
                            })(i, a);
                    },
                },
                {
                    key: "getFormatters",
                    value: function (t) {
                        var e,
                            i = this.w,
                            a = i.globals.yLabelFormatters[t];
                        return (
                            void 0 !== i.globals.ttVal
                                ? Array.isArray(i.globals.ttVal)
                                    ? ((a =
                                          i.globals.ttVal[t] &&
                                          i.globals.ttVal[t].formatter),
                                      (e =
                                          i.globals.ttVal[t] &&
                                          i.globals.ttVal[t].title &&
                                          i.globals.ttVal[t].title.formatter))
                                    : ((a = i.globals.ttVal.formatter),
                                      "function" ==
                                          typeof i.globals.ttVal.title
                                              .formatter &&
                                          (e = i.globals.ttVal.title.formatter))
                                : (e = i.config.tooltip.y.title.formatter),
                            {
                                yLbFormatter: (a =
                                    "function" != typeof a
                                        ? i.globals.yLabelFormatters[0] ||
                                          function (t) {
                                              return t;
                                          }
                                        : a),
                                yLbTitleFormatter: (e =
                                    "function" != typeof e
                                        ? function (t) {
                                              return t;
                                          }
                                        : e),
                            }
                        );
                    },
                },
                {
                    key: "getSeriesName",
                    value: function (t) {
                        var e = t.fn,
                            i = t.index,
                            a = t.seriesIndex,
                            t = t.j,
                            s = this.w;
                        return e(String(s.globals.seriesNames[i]), {
                            series: s.globals.series,
                            seriesIndex: a,
                            dataPointIndex: t,
                            w: s,
                        });
                    },
                },
                {
                    key: "DOMHandling",
                    value: function (t) {
                        t.i;
                        var e = t.t,
                            i = t.j,
                            a = t.ttItems,
                            s = t.values,
                            o = t.seriesName,
                            r = t.shared,
                            t = t.pColor,
                            n = this.w,
                            l = this.ttCtx,
                            h = s.val,
                            c = s.goalVals,
                            d = s.xVal,
                            g = s.xAxisTTVal,
                            s = s.zVal,
                            u = null,
                            u = a[e].children,
                            l =
                                (n.config.tooltip.fillSeriesColor &&
                                    ((a[e].style.backgroundColor = t),
                                    (u[0].style.display = "none")),
                                l.showTooltipTitle &&
                                    (null === l.tooltipTitle &&
                                        (l.tooltipTitle =
                                            n.globals.dom.baseEl.querySelector(
                                                ".apexcharts-tooltip-title"
                                            )),
                                    (l.tooltipTitle.innerHTML = d)),
                                l.isXAxisTooltipEnabled &&
                                    (l.xaxisTooltipText.innerHTML =
                                        "" !== g ? g : d),
                                a[e].querySelector(
                                    ".apexcharts-tooltip-text-y-label"
                                )),
                            g =
                                (l && (l.innerHTML = o || ""),
                                a[e].querySelector(
                                    ".apexcharts-tooltip-text-y-value"
                                )),
                            p =
                                (g && (g.innerHTML = void 0 !== h ? h : ""),
                                u[0] &&
                                    u[0].classList.contains(
                                        "apexcharts-tooltip-marker"
                                    ) &&
                                    (n.config.tooltip.marker.fillColors &&
                                        Array.isArray(
                                            n.config.tooltip.marker.fillColors
                                        ) &&
                                        (t =
                                            n.config.tooltip.marker.fillColors[
                                                e
                                            ]),
                                    (u[0].style.backgroundColor = t)),
                                n.config.tooltip.marker.show ||
                                    (u[0].style.display = "none"),
                                a[e].querySelector(
                                    ".apexcharts-tooltip-text-goals-label"
                                )),
                            f = a[e].querySelector(
                                ".apexcharts-tooltip-text-goals-value"
                            );
                        c.length &&
                        n.globals.seriesGoals[e] &&
                        ((d = function () {
                            var i = "<div >",
                                a = "<div>";
                            c.forEach(function (t, e) {
                                (i +=
                                    ' <div style="display: flex"><span class="apexcharts-tooltip-marker" style="background-color: '
                                        .concat(
                                            t.attrs.strokeColor,
                                            '; height: 3px; border-radius: 0; top: 5px;"></span> '
                                        )
                                        .concat(t.attrs.name, "</div>")),
                                    (a += "<div>".concat(t.val, "</div>"));
                            }),
                                (p.innerHTML = i + "</div>"),
                                (f.innerHTML = a + "</div>");
                        }),
                        !r ||
                            (n.globals.seriesGoals[e][i] &&
                                Array.isArray(n.globals.seriesGoals[e][i])))
                            ? d()
                            : ((p.innerHTML = ""), (f.innerHTML = "")),
                            null !== s &&
                                ((a[e].querySelector(
                                    ".apexcharts-tooltip-text-z-label"
                                ).innerHTML = n.config.tooltip.z.title),
                                (a[e].querySelector(
                                    ".apexcharts-tooltip-text-z-value"
                                ).innerHTML = void 0 !== s ? s : "")),
                            r &&
                                u[0] &&
                                (n.config.tooltip.hideEmptySeries &&
                                    ((l = a[e].querySelector(
                                        ".apexcharts-tooltip-marker"
                                    )),
                                    (o = a[e].querySelector(
                                        ".apexcharts-tooltip-text"
                                    )),
                                    0 == parseFloat(h)
                                        ? ((l.style.display = "none"),
                                          (o.style.display = "none"))
                                        : ((l.style.display = "block"),
                                          (o.style.display = "block"))),
                                null == h ||
                                -1 <
                                    n.globals.ancillaryCollapsedSeriesIndices.indexOf(
                                        e
                                    ) ||
                                -1 < n.globals.collapsedSeriesIndices.indexOf(e)
                                    ? (u[0].parentNode.style.display = "none")
                                    : (u[0].parentNode.style.display =
                                          n.config.tooltip.items.display));
                    },
                },
                {
                    key: "toggleActiveInactiveSeries",
                    value: function (t) {
                        var e = this.w;
                        t
                            ? this.tooltipUtil.toggleAllTooltipSeriesGroups(
                                  "enable"
                              )
                            : (this.tooltipUtil.toggleAllTooltipSeriesGroups(
                                  "disable"
                              ),
                              (t = e.globals.dom.baseEl.querySelector(
                                  ".apexcharts-tooltip-series-group"
                              )) &&
                                  (t.classList.add("apexcharts-active"),
                                  (t.style.display =
                                      e.config.tooltip.items.display)));
                    },
                },
                {
                    key: "getValuesToPrint",
                    value: function (t) {
                        var e = t.i,
                            t = t.j,
                            i = this.w,
                            a = this.ctx.series.filteredSeriesX(),
                            s = "",
                            o = "",
                            r = null,
                            n = null,
                            l = {
                                series: i.globals.series,
                                seriesIndex: e,
                                dataPointIndex: t,
                                w: i,
                            },
                            h = i.globals.ttZFormatter,
                            a =
                                (null === t
                                    ? (n = i.globals.series[e])
                                    : i.globals.isXNumeric &&
                                      "treemap" !== i.config.chart.type
                                    ? ((s = a[e][t]),
                                      0 === a[e].length &&
                                          (s =
                                              a[
                                                  this.tooltipUtil.getFirstActiveXArray(
                                                      a
                                                  )
                                              ][t]))
                                    : (s =
                                          void 0 !== i.globals.labels[t]
                                              ? i.globals.labels[t]
                                              : ""),
                                s),
                            s =
                                i.globals.isXNumeric &&
                                "datetime" === i.config.xaxis.type
                                    ? new f(this.ctx).xLabelFormat(
                                          i.globals.ttKeyFormatter,
                                          a,
                                          a,
                                          {
                                              i: void 0,
                                              dateFormatter: new y(this.ctx)
                                                  .formatDate,
                                              w: this.w,
                                          }
                                      )
                                    : i.globals.isBarHorizontal
                                    ? i.globals.yLabelFormatters[0](a, l)
                                    : i.globals.xLabelFormatter(a, l);
                        return (
                            void 0 !== i.config.tooltip.x.formatter &&
                                (s = i.globals.ttKeyFormatter(a, l)),
                            0 < i.globals.seriesZ.length &&
                                0 < i.globals.seriesZ[e].length &&
                                (r = h(i.globals.seriesZ[e][t], i)),
                            (o =
                                "function" ==
                                typeof i.config.xaxis.tooltip.formatter
                                    ? i.globals.xaxisTooltipFormatter(a, l)
                                    : s),
                            {
                                val: Array.isArray(n) ? n.join(" ") : n,
                                xVal: Array.isArray(s) ? s.join(" ") : s,
                                xAxisTTVal: Array.isArray(o) ? o.join(" ") : o,
                                zVal: r,
                            }
                        );
                    },
                },
                {
                    key: "handleCustomTooltip",
                    value: function (t) {
                        var e = t.i,
                            i = t.j,
                            a = t.y1,
                            s = t.y2,
                            t = t.w,
                            o = this.ttCtx.getElTooltip(),
                            r = t.config.tooltip.custom;
                        Array.isArray(r) && r[e] && (r = r[e]),
                            (o.innerHTML = r({
                                ctx: this.ctx,
                                series: t.globals.series,
                                seriesIndex: e,
                                dataPointIndex: i,
                                y1: a,
                                y2: s,
                                w: t,
                            }));
                    },
                },
            ]),
            me),
        Wt =
            (t(be, [
                {
                    key: "moveXCrosshairs",
                    value: function (t) {
                        var e =
                                1 < arguments.length && void 0 !== arguments[1]
                                    ? arguments[1]
                                    : null,
                            i = this.ttCtx,
                            a = this.w,
                            s = i.getElXCrosshairs(),
                            t = t - i.xcrosshairsWidth / 2,
                            o = a.globals.labels.slice().length;
                        null !== e && (t = (a.globals.gridWidth / o) * e),
                            null === s ||
                                a.globals.isBarHorizontal ||
                                (s.setAttribute("x", t),
                                s.setAttribute("x1", t),
                                s.setAttribute("x2", t),
                                s.setAttribute("y2", a.globals.gridHeight),
                                s.classList.add("apexcharts-active")),
                            (t = t < 0 ? 0 : t) > a.globals.gridWidth &&
                                (t = a.globals.gridWidth),
                            i.isXAxisTooltipEnabled &&
                                ((o = t),
                                ("tickWidth" !==
                                    a.config.xaxis.crosshairs.width &&
                                    "barWidth" !==
                                        a.config.xaxis.crosshairs.width) ||
                                    (o = t + i.xcrosshairsWidth / 2),
                                this.moveXAxisTooltip(o));
                    },
                },
                {
                    key: "moveYCrosshairs",
                    value: function (t) {
                        var e = this.ttCtx;
                        null !== e.ycrosshairs &&
                            W.setAttrs(e.ycrosshairs, { y1: t, y2: t }),
                            null !== e.ycrosshairsHidden &&
                                W.setAttrs(e.ycrosshairsHidden, {
                                    y1: t,
                                    y2: t,
                                });
                    },
                },
                {
                    key: "moveXAxisTooltip",
                    value: function (t) {
                        var e,
                            i = this.w,
                            a = this.ttCtx;
                        null !== a.xaxisTooltip &&
                            0 !== a.xcrosshairsWidth &&
                            (a.xaxisTooltip.classList.add("apexcharts-active"),
                            (e =
                                a.xaxisOffY +
                                i.config.xaxis.tooltip.offsetY +
                                i.globals.translateY +
                                1 +
                                i.config.xaxis.offsetY),
                            (t -=
                                a.xaxisTooltip.getBoundingClientRect().width /
                                2),
                            isNaN(t) ||
                                ((t += i.globals.translateX),
                                (i = new W(this.ctx).getTextRects(
                                    a.xaxisTooltipText.innerHTML
                                )),
                                (a.xaxisTooltipText.style.minWidth =
                                    i.width + "px"),
                                (a.xaxisTooltip.style.left = t + "px"),
                                (a.xaxisTooltip.style.top = e + "px")));
                    },
                },
                {
                    key: "moveYAxisTooltip",
                    value: function (t) {
                        var e = this.w,
                            i = this.ttCtx,
                            a =
                                (null === i.yaxisTTEls &&
                                    (i.yaxisTTEls =
                                        e.globals.dom.baseEl.querySelectorAll(
                                            ".apexcharts-yaxistooltip"
                                        )),
                                parseInt(
                                    i.ycrosshairsHidden.getAttribute("y1"),
                                    10
                                )),
                            a = e.globals.translateY + a,
                            s = i.yaxisTTEls[t].getBoundingClientRect().height,
                            o = e.globals.translateYAxisX[t] - 2;
                        e.config.yaxis[t].opposite && (o -= 26),
                            (a -= s / 2),
                            -1 === e.globals.ignoreYAxisIndexes.indexOf(t)
                                ? (i.yaxisTTEls[t].classList.add(
                                      "apexcharts-active"
                                  ),
                                  (i.yaxisTTEls[t].style.top = a + "px"),
                                  (i.yaxisTTEls[t].style.left =
                                      o +
                                      e.config.yaxis[t].tooltip.offsetX +
                                      "px"))
                                : i.yaxisTTEls[t].classList.remove(
                                      "apexcharts-active"
                                  );
                    },
                },
                {
                    key: "moveTooltip",
                    value: function (t, e) {
                        var i =
                                2 < arguments.length && void 0 !== arguments[2]
                                    ? arguments[2]
                                    : null,
                            a = this.w,
                            s = this.ttCtx,
                            o = s.getElTooltip(),
                            r = s.tooltipRect,
                            i = null !== i ? parseFloat(i) : 1,
                            t = parseFloat(t) + i + 5,
                            e = parseFloat(e) + i / 2;
                        (t =
                            (t =
                                t > a.globals.gridWidth / 2
                                    ? t - r.ttWidth - i - 10
                                    : t) >
                            a.globals.gridWidth - r.ttWidth - 10
                                ? a.globals.gridWidth - r.ttWidth
                                : t) < -20 && (t = -20),
                            a.config.tooltip.followCursor
                                ? ((i = s.getElGrid().getBoundingClientRect()),
                                  (t = s.e.clientX - i.left) >
                                      a.globals.gridWidth / 2 &&
                                      (t -= s.tooltipRect.ttWidth),
                                  (e =
                                      s.e.clientY +
                                      a.globals.translateY -
                                      i.top) >
                                      a.globals.gridHeight / 2 &&
                                      (e -= s.tooltipRect.ttHeight))
                                : a.globals.isBarHorizontal ||
                                  (r.ttHeight / 2 + e > a.globals.gridHeight &&
                                      (e =
                                          a.globals.gridHeight -
                                          r.ttHeight +
                                          a.globals.translateY)),
                            isNaN(t) ||
                                ((t += a.globals.translateX),
                                (o.style.left = t + "px"),
                                (o.style.top = e + "px"));
                    },
                },
                {
                    key: "moveMarkers",
                    value: function (t, e) {
                        var i = this.w,
                            a = this.ttCtx;
                        if (0 < i.globals.markers.size[t])
                            for (
                                var s = i.globals.dom.baseEl.querySelectorAll(
                                        " .apexcharts-series[data\\:realIndex='".concat(
                                            t,
                                            "'] .apexcharts-marker"
                                        )
                                    ),
                                    o = 0;
                                o < s.length;
                                o++
                            )
                                parseInt(s[o].getAttribute("rel"), 10) === e &&
                                    (a.marker.resetPointsSize(),
                                    a.marker.enlargeCurrentPoint(e, s[o]));
                        else
                            a.marker.resetPointsSize(),
                                this.moveDynamicPointOnHover(e, t);
                    },
                },
                {
                    key: "moveDynamicPointOnHover",
                    value: function (t, e) {
                        var i = this.w,
                            a = this.ttCtx,
                            s = i.globals.pointsArray,
                            o = a.tooltipUtil.getHoverMarkerSize(e),
                            r = i.config.series[e].type;
                        (r &&
                            ("column" === r ||
                                "candlestick" === r ||
                                "boxPlot" === r)) ||
                            ((r = null == (r = s[e][t]) ? void 0 : r[0]),
                            (t = (null == (s = s[e][t]) ? void 0 : s[1]) || 0),
                            (s = i.globals.dom.baseEl.querySelector(
                                ".apexcharts-series[data\\:realIndex='".concat(
                                    e,
                                    "'] .apexcharts-series-markers circle"
                                )
                            )) &&
                                t < i.globals.gridHeight &&
                                0 < t &&
                                (s.setAttribute("r", o),
                                s.setAttribute("cx", r),
                                s.setAttribute("cy", t)),
                            this.moveXCrosshairs(r),
                            a.fixedTooltip) ||
                            this.moveTooltip(r, t, o);
                    },
                },
                {
                    key: "moveDynamicPointsOnHover",
                    value: function (t) {
                        var e = this.ttCtx,
                            i = e.w,
                            a = 0,
                            s = 0,
                            o = i.globals.pointsArray,
                            r = new P(this.ctx).getActiveConfigSeriesIndex(
                                "asc",
                                ["line", "area", "scatter", "bubble"]
                            ),
                            n = e.tooltipUtil.getHoverMarkerSize(r),
                            l =
                                (o[r] && ((a = o[r][t][0]), (s = o[r][t][1])),
                                e.tooltipUtil.getAllMarkers());
                        if (null !== l)
                            for (var h = 0; h < i.globals.series.length; h++) {
                                var c,
                                    d,
                                    g = o[h];
                                i.globals.comboCharts &&
                                    void 0 === g &&
                                    l.splice(h, 0, null),
                                    g &&
                                        g.length &&
                                        ((g = o[h][t][1]),
                                        (d = void 0),
                                        l[h].setAttribute("cx", a),
                                        "rangeArea" !== i.config.chart.type ||
                                            i.globals.comboCharts ||
                                            ((c =
                                                t + i.globals.series[h].length),
                                            (d = o[h][c][1]),
                                            (g -= Math.abs(g - d) / 2)),
                                        null !== g &&
                                        !isNaN(g) &&
                                        g < i.globals.gridHeight + n &&
                                        0 < g + n
                                            ? (l[h] &&
                                                  l[h].setAttribute("r", n),
                                              l[h] &&
                                                  l[h].setAttribute("cy", g))
                                            : l[h] &&
                                              l[h].setAttribute("r", 0));
                            }
                        this.moveXCrosshairs(a),
                            e.fixedTooltip ||
                                this.moveTooltip(
                                    a,
                                    s || i.globals.gridHeight,
                                    n
                                );
                    },
                },
                {
                    key: "moveStickyTooltipOverBars",
                    value: function (t, e) {
                        var i = this.w,
                            a = this.ttCtx,
                            s = (i.globals.columnSeries || i.globals.series)
                                .length,
                            o =
                                2 <= s && s % 2 == 0
                                    ? Math.floor(s / 2)
                                    : Math.floor(s / 2) + 1,
                            o =
                                (i.globals.isBarHorizontal &&
                                    (o =
                                        new P(
                                            this.ctx
                                        ).getActiveConfigSeriesIndex("desc") +
                                        1),
                                i.globals.dom.baseEl.querySelector(
                                    ".apexcharts-bar-series .apexcharts-series[rel='"
                                        .concat(o, "'] path[j='")
                                        .concat(
                                            t,
                                            "'], .apexcharts-candlestick-series .apexcharts-series[rel='"
                                        )
                                        .concat(o, "'] path[j='")
                                        .concat(
                                            t,
                                            "'], .apexcharts-boxPlot-series .apexcharts-series[rel='"
                                        )
                                        .concat(o, "'] path[j='")
                                        .concat(
                                            t,
                                            "'], .apexcharts-rangebar-series .apexcharts-series[rel='"
                                        )
                                        .concat(o, "'] path[j='")
                                        .concat(t, "']")
                                )),
                            e = (o =
                                o || "number" != typeof e
                                    ? o
                                    : i.globals.dom.baseEl.querySelector(
                                          ".apexcharts-bar-series .apexcharts-series[data\\:realIndex='"
                                              .concat(e, "'] path[j='")
                                              .concat(
                                                  t,
                                                  "'],\n        .apexcharts-candlestick-series .apexcharts-series[data\\:realIndex='"
                                              )
                                              .concat(e, "'] path[j='")
                                              .concat(
                                                  t,
                                                  "'],\n        .apexcharts-boxPlot-series .apexcharts-series[data\\:realIndex='"
                                              )
                                              .concat(e, "'] path[j='")
                                              .concat(
                                                  t,
                                                  "'],\n        .apexcharts-rangebar-series .apexcharts-series[data\\:realIndex='"
                                              )
                                              .concat(e, "'] path[j='")
                                              .concat(t, "']")
                                      ))
                                ? parseFloat(o.getAttribute("cx"))
                                : 0,
                            r = o ? parseFloat(o.getAttribute("cy")) : 0,
                            n = o ? parseFloat(o.getAttribute("barWidth")) : 0,
                            l = a.getElGrid().getBoundingClientRect(),
                            h =
                                o &&
                                (o.classList.contains(
                                    "apexcharts-candlestick-area"
                                ) ||
                                    o.classList.contains(
                                        "apexcharts-boxPlot-area"
                                    ));
                        i.globals.isXNumeric
                            ? (o && !h && (e -= s % 2 != 0 ? n / 2 : 0),
                              o && h && i.globals.comboCharts && (e -= n / 2))
                            : i.globals.isBarHorizontal ||
                              ((e =
                                  a.xAxisTicksPositions[t - 1] +
                                  a.dataPointsDividedWidth / 2),
                              isNaN(e) &&
                                  (e =
                                      a.xAxisTicksPositions[t] -
                                      a.dataPointsDividedWidth / 2)),
                            i.globals.isBarHorizontal
                                ? (r -= a.tooltipRect.ttHeight)
                                : i.config.tooltip.followCursor
                                ? (r =
                                      a.e.clientY -
                                      l.top -
                                      a.tooltipRect.ttHeight / 2)
                                : r + a.tooltipRect.ttHeight + 15 >
                                      i.globals.gridHeight &&
                                  (r = i.globals.gridHeight),
                            i.globals.isBarHorizontal ||
                                this.moveXCrosshairs(e),
                            a.fixedTooltip ||
                                this.moveTooltip(e, r || i.globals.gridHeight);
                    },
                },
            ]),
            be),
        Bt =
            (t(xe, [
                {
                    key: "drawDynamicPoints",
                    value: function () {
                        var t = this.w,
                            e = new W(this.ctx),
                            i = new k(this.ctx),
                            a = S(
                                (a =
                                    t.globals.dom.baseEl.querySelectorAll(
                                        ".apexcharts-series"
                                    ))
                            );
                        t.config.chart.stacked &&
                            a.sort(function (t, e) {
                                return (
                                    parseFloat(
                                        t.getAttribute("data:realIndex")
                                    ) -
                                    parseFloat(e.getAttribute("data:realIndex"))
                                );
                            });
                        for (var s = 0; s < a.length; s++) {
                            var o,
                                r,
                                n = a[s].querySelector(
                                    ".apexcharts-series-markers-wrap"
                                );
                            null !== n &&
                                ((o = void 0),
                                (r = "apexcharts-marker w".concat(
                                    (Math.random() + 1)
                                        .toString(36)
                                        .substring(4)
                                )),
                                ("line" !== t.config.chart.type &&
                                    "area" !== t.config.chart.type) ||
                                    t.globals.comboCharts ||
                                    t.config.tooltip.intersect ||
                                    (r += " no-pointer-events"),
                                (r = i.getMarkerConfig({
                                    cssClass: r,
                                    seriesIndex: Number(
                                        n.getAttribute("data:realIndex")
                                    ),
                                })),
                                (o = e.drawMarker(0, 0, r)).node.setAttribute(
                                    "default-marker-size",
                                    0
                                ),
                                (r = document.createElementNS(
                                    t.globals.SVGNS,
                                    "g"
                                )).classList.add("apexcharts-series-markers"),
                                r.appendChild(o.node),
                                n.appendChild(r));
                        }
                    },
                },
                {
                    key: "enlargeCurrentPoint",
                    value: function (t, e) {
                        var i =
                                2 < arguments.length && void 0 !== arguments[2]
                                    ? arguments[2]
                                    : null,
                            a =
                                3 < arguments.length && void 0 !== arguments[3]
                                    ? arguments[3]
                                    : null,
                            s = this.w,
                            t =
                                ("bubble" !== s.config.chart.type &&
                                    this.newPointSize(t, e),
                                e.getAttribute("cx")),
                            e = e.getAttribute("cy");
                        null !== i && null !== a && ((t = i), (e = a)),
                            this.tooltipPosition.moveXCrosshairs(t),
                            this.fixedTooltip ||
                                ("radar" === s.config.chart.type &&
                                    ((i = this.ttCtx
                                        .getElGrid()
                                        .getBoundingClientRect()),
                                    (t = this.ttCtx.e.clientX - i.left)),
                                this.tooltipPosition.moveTooltip(
                                    t,
                                    e,
                                    s.config.markers.hover.size
                                ));
                    },
                },
                {
                    key: "enlargePoints",
                    value: function (t) {
                        for (
                            var e = this.w,
                                i = this.ttCtx,
                                a = t,
                                s = e.globals.dom.baseEl.querySelectorAll(
                                    ".apexcharts-series:not(.apexcharts-series-collapsed) .apexcharts-marker"
                                ),
                                o = e.config.markers.hover.size,
                                r = 0;
                            r < s.length;
                            r++
                        ) {
                            var n = s[r].getAttribute("rel"),
                                l = s[r].getAttribute("index");
                            void 0 === o &&
                                (o =
                                    e.globals.markers.size[l] +
                                    e.config.markers.hover.sizeOffset),
                                a === parseInt(n, 10)
                                    ? (this.newPointSize(a, s[r]),
                                      (l = s[r].getAttribute("cx")),
                                      (n = s[r].getAttribute("cy")),
                                      this.tooltipPosition.moveXCrosshairs(l),
                                      i.fixedTooltip ||
                                          this.tooltipPosition.moveTooltip(
                                              l,
                                              n,
                                              o
                                          ))
                                    : this.oldPointSize(s[r]);
                        }
                    },
                },
                {
                    key: "newPointSize",
                    value: function (t, e) {
                        var i = this.w,
                            a = i.config.markers.hover.size,
                            t =
                                0 === t
                                    ? e.parentNode.firstChild
                                    : e.parentNode.lastChild;
                        "0" !== t.getAttribute("default-marker-size") &&
                            ((e = parseInt(t.getAttribute("index"), 10)),
                            void 0 === a &&
                                (a =
                                    i.globals.markers.size[e] +
                                    i.config.markers.hover.sizeOffset),
                            t.setAttribute("r", (a = a < 0 ? 0 : a)));
                    },
                },
                {
                    key: "oldPointSize",
                    value: function (t) {
                        var e = parseFloat(
                            t.getAttribute("default-marker-size")
                        );
                        t.setAttribute("r", e);
                    },
                },
                {
                    key: "resetPointsSize",
                    value: function () {
                        for (
                            var t = this.w.globals.dom.baseEl.querySelectorAll(
                                    ".apexcharts-series:not(.apexcharts-series-collapsed) .apexcharts-marker"
                                ),
                                e = 0;
                            e < t.length;
                            e++
                        ) {
                            var i = parseFloat(
                                t[e].getAttribute("default-marker-size")
                            );
                            N.isNumber(i) && 0 <= i
                                ? t[e].setAttribute("r", i)
                                : t[e].setAttribute("r", 0);
                        }
                    },
                },
            ]),
            xe),
        Gt =
            (t(fe, [
                {
                    key: "getAttr",
                    value: function (t, e) {
                        return parseFloat(t.target.getAttribute(e));
                    },
                },
                {
                    key: "handleHeatTreeTooltip",
                    value: function (t) {
                        var e,
                            i,
                            a,
                            s,
                            o,
                            r = t.e,
                            n = t.opt,
                            l = t.x,
                            h = t.y,
                            t = t.type,
                            c = this.ttCtx,
                            d = this.w;
                        return (
                            r.target.classList.contains(
                                "apexcharts-".concat(t, "-rect")
                            ) &&
                                ((t = this.getAttr(r, "i")),
                                (e = this.getAttr(r, "j")),
                                (i = this.getAttr(r, "cx")),
                                (a = this.getAttr(r, "cy")),
                                (s = this.getAttr(r, "width")),
                                (o = this.getAttr(r, "height")),
                                c.tooltipLabels.drawSeriesTexts({
                                    ttItems: n.ttItems,
                                    i: t,
                                    j: e,
                                    shared: !1,
                                    e: r,
                                }),
                                (d.globals.capturedSeriesIndex = t),
                                (d.globals.capturedDataPointIndex = e),
                                (l = i + c.tooltipRect.ttWidth / 2 + s),
                                (h = a + c.tooltipRect.ttHeight / 2 - o / 2),
                                c.tooltipPosition.moveXCrosshairs(i + s / 2),
                                l > d.globals.gridWidth / 2 &&
                                    (l = i - c.tooltipRect.ttWidth / 2 + s),
                                c.w.config.tooltip.followCursor) &&
                                ((n =
                                    d.globals.dom.elWrap.getBoundingClientRect()),
                                (l =
                                    d.globals.clientX -
                                    n.left -
                                    (l > d.globals.gridWidth / 2
                                        ? c.tooltipRect.ttWidth
                                        : 0)),
                                (h =
                                    d.globals.clientY -
                                    n.top -
                                    (h > d.globals.gridHeight / 2
                                        ? c.tooltipRect.ttHeight
                                        : 0))),
                            { x: l, y: h }
                        );
                    },
                },
                {
                    key: "handleMarkerTooltip",
                    value: function (t) {
                        var e,
                            i,
                            a,
                            s,
                            o,
                            r,
                            n = t.e,
                            l = t.opt,
                            h = t.x,
                            t = t.y,
                            c = this.w,
                            d = this.ttCtx;
                        return (
                            n.target.classList.contains("apexcharts-marker") &&
                                ((e = parseInt(l.paths.getAttribute("cx"), 10)),
                                (i = parseInt(l.paths.getAttribute("cy"), 10)),
                                (a = parseFloat(l.paths.getAttribute("val"))),
                                (s = parseInt(l.paths.getAttribute("rel"), 10)),
                                (o =
                                    parseInt(
                                        l.paths.parentNode.parentNode.parentNode.getAttribute(
                                            "rel"
                                        ),
                                        10
                                    ) - 1),
                                d.intersect &&
                                    (r = N.findAncestor(
                                        l.paths,
                                        "apexcharts-series"
                                    )) &&
                                    (o = parseInt(
                                        r.getAttribute("data:realIndex"),
                                        10
                                    )),
                                d.tooltipLabels.drawSeriesTexts({
                                    ttItems: l.ttItems,
                                    i: o,
                                    j: s,
                                    shared:
                                        !d.showOnIntersect &&
                                        c.config.tooltip.shared,
                                    e: n,
                                }),
                                "mouseup" === n.type && d.markerClick(n, o, s),
                                (c.globals.capturedSeriesIndex = o),
                                (c.globals.capturedDataPointIndex = s),
                                (h = e),
                                (t =
                                    i +
                                    c.globals.translateY -
                                    1.4 * d.tooltipRect.ttHeight),
                                d.w.config.tooltip.followCursor &&
                                    ((r = d
                                        .getElGrid()
                                        .getBoundingClientRect()),
                                    (t =
                                        d.e.clientY +
                                        c.globals.translateY -
                                        r.top)),
                                d.marker.enlargeCurrentPoint(
                                    s,
                                    l.paths,
                                  x: i,
                                    y: a,
                                    i: r,
                                    j: n,
                                    realIndex: l,
                                    columnGroupIndex: h,
                                    renderedPath: t,
                                    bcx: e,
                                    bcy: f,
                                    barHeight: d,
                                    barWidth: g,
                                    textRects: C,
                                    strokeWidth: m,
                                    dataLabelsX: y,
                                    dataLabelsY: w,
                                    dataLabelsConfig: k,
                                    barDataLabelsConfig: A,
                                    barTotalDataLabelsConfig: S,
                                    offX: p,
                                    offY: u,
                                }),
                            L = this.barCtx.isHorizontal
                                ? this.calculateBarsDataLabelsPosition(b)
                                : this.calculateColumnsDataLabelsPosition(b);
                        return (
                            t.attr({
                                cy: L.bcy,
                                cx: L.bcx,
                                j: n,
                                val: c[r][n],
                                barHeight: d,
                                barWidth: g,
                            }),
                            {
                                dataLabels: this.drawCalculatedDataLabels({
                                    x: L.dataLabelsX,
                                    y: L.dataLabelsY,
                                    val: this.barCtx.isRangeBar
                                        ? [s, o]
                                        : c[r][n],
                                    i: l,
                                    j: n,
                                    barWidth: g,
                                    barHeight: d,
                                    textRects: C,
                                    dataLabelsConfig: k,
                                }),
                                totalDataLabels: (v =
                                    x.config.chart.stacked && S.enabled
                                        ? this.drawTotalDataLabels({
                                              x: L.totalDataLabelsX,
                                              y: L.totalDataLabelsY,
                                              barWidth: g,
                                              barHeight: d,
                                              realIndex: l,
                                              textAnchor:
                                                  L.totalDataLabelsAnchor,
                                              val: this.getStackedTotalDataLabel(
                                                  { realIndex: l, j: n }
                                              ),
                                              dataLabelsConfig: k,
                                              barTotalDataLabelsConfig: S,
                                          })
                                        : v),
                            }
                        );
                    },
                },
                {
                    key: "getStackedTotalDataLabel",
                    value: function (t) {
                        var e = t.realIndex,
                            t = t.j,
                            i = this.w,
                            a = this.barCtx.stackedSeriesTotals[t];
                        return (a = this.totalFormatter
                            ? this.totalFormatter(
                                  a,
                                  z(
                                      z({}, i),
                                      {},
                                      {
                                          seriesIndex: e,
                                          dataPointIndex: t,
                                          w: i,
                                      }
                                  )
                              )
                            : a);
                    },
                },
                {
                    key: "calculateColumnsDataLabelsPosition",
                    value: function (t) {
                        var e,
                            i,
                            a = this.w,
                            s = t.i,
                            o = t.j,
                            r = t.realIndex,
                            n = t.columnGroupIndex,
                            l = t.y,
                            h = t.bcx,
                            c = t.barWidth,
                            d = t.barHeight,
                            g = t.textRects,
                            u = t.dataLabelsX,
                            p = t.dataLabelsY,
                            f = t.dataLabelsConfig,
                            x = t.barDataLabelsConfig,
                            b = t.barTotalDataLabelsConfig,
                            m = t.strokeWidth,
                            v = t.offX,
                            y = t.offY,
                            t = h,
                            d = Math.abs(d),
                            w =
                                "vertical" ===
                                a.config.plotOptions.bar.dataLabels.orientation,
                            k = this.barCtx.barHelpers.getZeroValueEncounters({
                                i: s,
                                j: o,
                            }).zeroEncounters,
                            h = h - m / 2 + n * c,
                            n = a.globals.gridWidth / a.globals.dataPoints,
                            A =
                                (this.barCtx.isVerticalGroupedRangeBar
                                    ? (u += c / 2)
                                    : ((u = a.globals.isXNumeric
                                          ? h - c / 2 + v
                                          : h - n + c / 2 + v),
                                      0 < k &&
                                          a.config.plotOptions.bar
                                              .hideZeroBarsWhenGrouped &&
                                          (u -= c * k)),
                                w && (u = u + g.height / 2 - m / 2 - 2),
                                this.barCtx.series[s][o] < 0),
                            S = l;
                        switch (
                            (this.barCtx.isReversed &&
                                ((S = l + (A ? d : -d)), (l -= d)),
                            x.position)
                        ) {
                            case "center":
                                p = w
                                    ? A
                                        ? S - d / 2 + y
                                        : S + d / 2 - y
                                    : A
                                    ? S - d / 2 + g.height / 2 + y
                                    : S + d / 2 + g.height / 2 - y;
                                break;
                            case "bottom":
                                p = w
                                    ? A
                                        ? S - d + y
                                        : S + d - y
                                    : A
                                    ? S - d + g.height + m + y
                                    : S + d - g.height / 2 + m - y;
                                break;
                            case "top":
                                p = w
                                    ? A
                                        ? S + y
                                        : S - y
                                    : A
                                    ? S - g.height / 2 - y
                                    : S + g.height + y;
                        }
                        return (
                            this.barCtx.lastActiveBarSerieIndex === r &&
                                b.enabled &&
                                ((n = new W(this.barCtx.ctx).getTextRects(
                                    this.getStackedTotalDataLabel({
                                        realIndex: r,
                                        j: o,
                                    }),
                                    f.fontSize
                                )),
                                (e = A
                                    ? S - n.height / 2 - y - b.offsetY + 18
                                    : S + n.height + y + b.offsetY - 18),
                                (v =
                                    a.globals.gridWidth / a.globals.dataPoints),
                                (i =
                                    t +
                                    c * (a.globals.barGroups.length - 0.5) -
                                    (a.globals.isXNumeric ? c : v) +
                                    b.offsetX)),
                            a.config.chart.stacked ||
                                (p < 0
                                    ? (p = 0 + m)
                                    : p + g.height / 3 > a.globals.gridHeight &&
                                      (p = a.globals.gridHeight - m)),
                            {
                                bcx: h,
                                bcy: l,
                                dataLabelsX: u,
                                dataLabelsY: p,
                                totalDataLabelsX: i,
                                totalDataLabelsY: e,
                                totalDataLabelsAnchor: "middle",
                            }
                        );
                    },
                },
                {
                    key: "calculateBarsDataLabelsPosition",
                    value: function (t) {
                        var e,
                            i,
                            a = this.w,
                            s = t.x,
                            o = t.i,
                            r = t.j,
                            n = t.realIndex,
                            l = t.columnGroupIndex,
                            h = t.bcy,
                            c = t.barHeight,
                            d = t.barWidth,
                            g = t.textRects,
                            u = t.dataLabelsX,
                            p = t.strokeWidth,
                            f = t.dataLabelsConfig,
                            x = t.barDataLabelsConfig,
                            b = t.barTotalDataLabelsConfig,
                            m = t.offX,
                            t = t.offY,
                            v = a.globals.gridHeight / a.globals.dataPoints,
                            d = Math.abs(d),
                            l =
                                (h += l * c) -
                                (this.barCtx.isRangeBar ? 0 : v) +
                                c / 2 +
                                g.height / 2 +
                                t -
                                3,
                            v = "start",
                            y = this.barCtx.series[o][r] < 0,
                            w = s;
                        switch (
                            (this.barCtx.isReversed &&
                                ((w = s + (y ? -d : d)),
                                (s = a.globals.gridWidth - d),
                                (v = y ? "start" : "end")),
                            x.position)
                        ) {
                            case "center":
                                u = y
                                    ? w + d / 2 - m
                                    : Math.max(g.width / 2, w - d / 2) + m;
                                break;
                            case "bottom":
                                u = y
                                    ? w + d - p - Math.round(g.width / 2) - m
                                    : w - d + p + Math.round(g.width / 2) + m;
                                break;
                            case "top":
                                u = y
                                    ? w - p + Math.round(g.width / 2) - m
                                    : w - p - Math.round(g.width / 2) + m;
                        }
                        return (
                            this.barCtx.lastActiveBarSerieIndex === n &&
                                b.enabled &&
                                ((c = new W(this.barCtx.ctx).getTextRects(
                                    this.getStackedTotalDataLabel({
                                        realIndex: n,
                                        j: r,
                                    }),
                                    f.fontSize
                                )),
                                y
                                    ? ((e = w - p - m - b.offsetX), (v = "end"))
                                    : (e =
                                          w +
                                          m +
                                          b.offsetX +
                                          (this.barCtx.isReversed
                                              ? -(d + p)
                                              : p)),
                                (i =
                                    l -
                                    g.height / 2 +
                                    c.height / 2 +
                                    b.offsetY +
                                    p)),
                            a.config.chart.stacked ||
                                (u < 0
                                    ? (u = u + g.width + p)
                                    : u + g.width / 2 > a.globals.gridWidth &&
                                      (u = a.globals.gridWidth - g.width - p)),
                            {
                                bcx: s,
                                bcy: h,
                                dataLabelsX: u,
                                dataLabelsY: l,
                                totalDataLabelsX: e,
                                totalDataLabelsY: i,
                                totalDataLabelsAnchor: v,
                            }
                        );
                    },
                },
                {
                    key: "drawCalculatedDataLabels",
                    value: function (t) {
                        var e = t.x,
                            i = t.y,
                            a = t.val,
                            s = t.i,
                            o = t.j,
                            r = t.textRects,
                            n = t.barHeight,
                            l = t.barWidth,
                            t = t.dataLabelsConfig,
                            h = this.w,
                            c = "rotate(0)",
                            d =
                                ("vertical" ===
                                    h.config.plotOptions.bar.dataLabels
                                        .orientation &&
                                    (c = "rotate(-90, "
                                        .concat(e, ", ")
                                        .concat(i, ")")),
                                new L(this.barCtx.ctx)),
                            g = new W(this.barCtx.ctx),
                            u = t.formatter,
                            p = null,
                            f =
                                -1 <
                                h.globals.collapsedSeriesIndices.indexOf(s);
                        return (
                            t.enabled &&
                                !f &&
                                ((p = g.group({
                                    class: "apexcharts-data-labels",
                                    transform: c,
                                })),
                                (f = ""),
                                void 0 !== a &&
                                    (f = u(
                                        a,
                                        z(
                                            z({}, h),
                                            {},
                                            {
                                                seriesIndex: s,
                                                dataPointIndex: o,
                                                w: h,
                                            }
                                        )
                                    )),
                                !a &&
                                    h.config.plotOptions.bar
                                        .hideZeroBarsWhenGrouped &&
                                    (f = ""),
                                (c = h.globals.series[s][o] < 0),
                                (u =
                                    h.config.plotOptions.bar.dataLabels
                                        .position),
                                "vertical" ===
                                    h.config.plotOptions.bar.dataLabels
                                        .orientation &&
                                    ("top" === u &&
                                        (t.textAnchor = c ? "end" : "start"),
                                    "center" === u && (t.textAnchor = "middle"),
                                    "bottom" === u) &&
                                    (t.textAnchor = c ? "end" : "start"),
                                this.barCtx.isRangeBar &&
                                    this.barCtx.barOptions.dataLabels
                                        .hideOverflowingLabels &&
                                    l <
                                        g.getTextRects(
                                            f,
                                            parseFloat(t.style.fontSize)
                                        ).width &&
                                    (f = ""),
                                h.config.chart.stacked &&
                                    this.barCtx.barOptions.dataLabels
                                        .hideOverflowingLabels &&
                                    (this.barCtx.isHorizontal
                                        ? r.width / 1.6 > Math.abs(l) &&
                                          (f = "")
                                        : r.height / 1.6 > Math.abs(n) &&
                                          (f = "")),
                                (u = z({}, t)),
                                this.barCtx.isHorizontal &&
                                    a < 0 &&
                                    ("start" === t.textAnchor
                                        ? (u.textAnchor = "end")
                                        : "end" === t.textAnchor &&
                                          (u.textAnchor = "start")),
                                d.plotDataLabelsText({
                                    x: e,
                                    y: i,
                                    text: f,
                                    i: s,
                                    j: o,
                                    parent: p,
                                    dataLabelsConfig: u,
                                    alwaysDrawDataLabel: !0,
                                    offsetCorrection: !0,
                                })),
                            p
                        );
                    },
                },
                {
                    key: "drawTotalDataLabels",
                    value: function (t) {
                        var e,
                            i = t.x,
                            a = t.y,
                            s = t.val,
                            o = t.barWidth,
                            r = t.barHeight,
                            n = t.realIndex,
                            l = t.textAnchor,
                            t = t.barTotalDataLabelsConfig,
                            h = this.w,
                            c = new W(this.barCtx.ctx);
                        return (e =
                            t.enabled &&
                            void 0 !== i &&
                            void 0 !== a &&
                            this.barCtx.lastActiveBarSerieIndex === n
                                ? c.drawText({
                                      x:
                                          i -
                                          (!h.globals.isBarHorizontal &&
                                          h.globals.barGroups.length
                                              ? (o *
                                                    (h.globals.barGroups
                                                        .length -
                                                        1)) /
                                                2
                                              : 0),
                                      y:
                                          a -
                                          (h.globals.isBarHorizontal &&
                                          h.globals.barGroups.length
                                              ? (r *
                                                    (h.globals.barGroups
                                                        .length -
                                                        1)) /
                                                2
                                              : 0),
                                      foreColor: t.style.color,
                                      text: s,
                                      textAnchor: l,
                                      fontFamily: t.style.fontFamily,
                                      fontSize: t.style.fontSize,
                                      fontWeight: t.style.fontWeight,
                                  })
                                : e);
                    },
                },
            ]),
            ge),
        Ut =
            (t(de, [
                {
                    key: "initVariables",
                    value: function (t) {
                        var e = this.w;
                        (this.barCtx.series = t),
                            (this.barCtx.totalItems = 0),
                            (this.barCtx.seriesLen = 0),
                            (this.barCtx.visibleI = -1),
                            (this.barCtx.visibleItems = 1);
                        for (var i = 0; i < t.length; i++)
                            if (
                                (0 < t[i].length &&
                                    ((this.barCtx.seriesLen =
                                        this.barCtx.seriesLen + 1),
                                    (this.barCtx.totalItems += t[i].length)),
                                e.globals.isXNumeric)
                            )
                                for (var a = 0; a < t[i].length; a++)
                                    e.globals.seriesX[i][a] > e.globals.minX &&
                                        e.globals.seriesX[i][a] <
                                            e.globals.maxX &&
                                        this.barCtx.visibleItems++;
                            else
                                this.barCtx.visibleItems = e.globals.dataPoints;
                        0 === this.barCtx.seriesLen &&
                            (this.barCtx.seriesLen = 1),
                            (this.barCtx.zeroSerieses = []),
                            e.globals.comboCharts ||
                                this.checkZeroSeries({ series: t });
                    },
                },
                {
                    key: "initialPositions",
                    value: function () {
                        var t,
                            e,
                            i,
                            a,
                            s,
                            o,
                            r,
                            n,
                            l = this.w,
                            h = l.globals.dataPoints,
                            c =
                                (this.barCtx.isRangeBar &&
                                    (h = l.globals.labels.length),
                                this.barCtx.seriesLen);
                        return (
                            l.config.plotOptions.bar.rangeBarGroupRows &&
                                (c = 1),
                            this.barCtx.isHorizontal
                                ? ((a = (i = l.globals.gridHeight / h) / c),
                                  (a =
                                      ((a = l.globals.isXNumeric
                                          ? (i =
                                                l.globals.gridHeight /
                                                this.barCtx.totalItems) /
                                            this.barCtx.seriesLen
                                          : a) *
                                          parseInt(
                                              this.barCtx.barOptions.barHeight,
                                              10
                                          )) /
                                      100),
                                  -1 ===
                                      String(
                                          this.barCtx.barOptions.barHeight
                                      ).indexOf("%") &&
                                      (a = parseInt(
                                          this.barCtx.barOptions.barHeight,
                                          10
                                      )),
                                  (o =
                                      this.barCtx.baseLineInvertedY +
                                      l.globals.padHorizontal +
                                      (this.barCtx.isReversed
                                          ? l.globals.gridWidth
                                          : 0) -
                                      (this.barCtx.isReversed
                                          ? 2 * this.barCtx.baseLineInvertedY
                                          : 0)),
                                  this.barCtx.isFunnel &&
                                      (o = l.globals.gridWidth / 2),
                                  (e = (i - a * this.barCtx.seriesLen) / 2))
                                : ((r =
                                      l.globals.gridWidth /
                                      this.barCtx.visibleItems),
                                  (n =
                                      (((r = l.config.xaxis
                                          .convertedCatToNumeric
                                          ? l.globals.gridWidth /
                                            l.globals.dataPoints
                                          : r) /
                                          c) *
                                          parseInt(
                                              this.barCtx.barOptions
                                                  .columnWidth,
                                              10
                                          )) /
                                      100),
                                  l.globals.isXNumeric &&
                                      ((h = this.barCtx.xRatio),
                                      (n =
                                          (((r =
                                              l.globals.minXDiff &&
                                              0.5 !== l.globals.minXDiff &&
                                              0 < l.globals.minXDiff / h
                                                  ? l.globals.minXDiff / h
                                                  : r) /
                                              c) *
                                              parseInt(
                                                  this.barCtx.barOptions
                                                      .columnWidth,
                                                  10
                                              )) /
                                          100) < 1) &&
                                      (n = 1),
                                  -1 ===
                                      String(
                                          this.barCtx.barOptions.columnWidth
                                      ).indexOf("%") &&
                                      (n = parseInt(
                                          this.barCtx.barOptions.columnWidth,
                                          10
                                      )),
                                  (s =
                                      l.globals.gridHeight -
                                      this.barCtx.baseLineY[
                                          this.barCtx.translationsIndex
                                      ] -
                                      (this.barCtx.isReversed
                                          ? l.globals.gridHeight
                                          : 0) +
                                      (this.barCtx.isReversed
                                          ? 2 *
                                            this.barCtx.baseLineY[
                                                this.barCtx.translationsIndex
                                            ]
                                          : 0)),
                                  (t =
                                      l.globals.padHorizontal +
                                      (r - n * this.barCtx.seriesLen) / 2)),
                            {
                                x: t,
                                y: e,
                                yDivision: i,
                                xDivision: r,
                                barHeight: (l.globals.barHeight = a),
                                barWidth: (l.globals.barWidth = n),
                                zeroH: s,
                                zeroW: o,
                            }
                        );
                    },
                },
                {
                    key: "initializeStackedPrevVars",
                    value: function (e) {
                        e.w.globals.seriesGroups.forEach(function (t) {
                            e[t] || (e[t] = {}),
                                (e[t].prevY = []),
                                (e[t].prevX = []),
                                (e[t].prevYF = []),
                                (e[t].prevXF = []),
                                (e[t].prevYVal = []),
                                (e[t].prevXVal = []);
                        });
                    },
                },
                {
                    key: "initializeStackedXYVars",
                    value: function (e) {
                        e.w.globals.seriesGroups.forEach(function (t) {
                            e[t] || (e[t] = {}),
                                (e[t].xArrj = []),
                                (e[t].xArrjF = []),
                                (e[t].xArrjVal = []),
                                (e[t].yArrj = []),
                                (e[t].yArrjF = []),
                                (e[t].yArrjVal = []);
                        });
                    },
                },
                {
                    key: "getPathFillColor",
                    value: function (e, i, a, t) {
                        var s = this.w,
                            o = new C(this.barCtx.ctx),
                            r = null,
                            n = this.barCtx.barOptions.distributed ? a : i;
                        return (
                            0 < this.barCtx.barOptions.colors.ranges.length &&
                                this.barCtx.barOptions.colors.ranges.map(
                                    function (t) {
                                        e[i][a] >= t.from &&
                                            e[i][a] <= t.to &&
                                            (r = t.color);
                                    }
                                ),
                            s.config.series[i].data[a] &&
                                s.config.series[i].data[a].fillColor &&
                                (r = s.config.series[i].data[a].fillColor),
                            o.fillPath({
                                seriesNumber: this.barCtx.barOptions.distributed
                                    ? n
                                    : t,
                                dataPointIndex: a,
                                color: r,
                                value: e[i][a],
                                fillConfig:
                                    null == (o = s.config.series[i].data[a])
                                        ? void 0
                                        : o.fill,
                                fillType:
                                    null != (n = s.config.series[i].data[a]) &&
                                    null != (t = n.fill) &&
                                    t.type
                                        ? null ==
                                          (o = s.config.series[i].data[a])
                                            ? void 0
                                            : o.fill.type
                                        : Array.isArray(s.config.fill.type)
                                        ? s.config.fill.type[i]
                                        : s.config.fill.type,
                            })
                        );
                    },
                },
                {
                    key: "getStrokeWidth",
                    value: function (t, e, i) {
                        var a = 0,
                            s = this.w;
                        return (
                            void 0 === this.barCtx.series[t][e] ||
                            null === this.barCtx.series[t][e]
                                ? (this.barCtx.isNullValue = !0)
                                : (this.barCtx.isNullValue = !1),
                            (a =
                                !s.config.stroke.show || this.barCtx.isNullValue
                                    ? a
                                    : Array.isArray(this.barCtx.strokeWidth)
                                    ? this.barCtx.strokeWidth[i]
                                    : this.barCtx.strokeWidth)
                        );
                    },
                },
                {
                    key: "shouldApplyRadius",
                    value: function (t) {
                        var e = this.w,
                            i = !1;
                        return (i =
                            0 < e.config.plotOptions.bar.borderRadius &&
                            (!e.config.chart.stacked ||
                                "last" !==
                                    e.config.plotOptions.bar
                                        .borderRadiusWhenStacked ||
                                this.barCtx.lastActiveBarSerieIndex === t)
                                ? !0
                                : i);
                    },
                },
                {
                    key: "barBackground",
                    value: function (t) {
                        var e = t.j,
                            i = t.i,
                            a = t.x1,
                            s = t.x2,
                            o = t.y1,
                            r = t.y2,
                            t = t.elSeries,
                            n = this.w,
                            l = new W(this.barCtx.ctx),
                            h = new P(
                                this.barCtx.ctx
                            ).getActiveConfigSeriesIndex();
                        0 <
                            this.barCtx.barOptions.colors.backgroundBarColors
                                .length &&
                            h === i &&
                            (e >=
                                this.barCtx.barOptions.colors
                                    .backgroundBarColors.length &&
                                (e %=
                                    this.barCtx.barOptions.colors
                                        .backgroundBarColors.length),
                            (h =
                                this.barCtx.barOptions.colors
                                    .backgroundBarColors[e]),
                            (i = l.drawRect(
                                void 0 !== a ? a : 0,
                                void 0 !== o ? o : 0,
                                void 0 !== s ? s : n.globals.gridWidth,
                                void 0 !== r ? r : n.globals.gridHeight,
                                this.barCtx.barOptions.colors
                                    .backgroundBarRadius,
                                h,
                                this.barCtx.barOptions.colors
                                    .backgroundBarOpacity
                            )),
                            t.add(i),
                            i.node.classList.add("apexcharts-backgroundBar"));
                    },
                },
                {
                    key: "getColumnPaths",
                    value: function (t) {
                        var e = t.barWidth,
                            i = t.barXPosition,
                            a = t.y1,
                            s = t.y2,
                            o = t.strokeWidth,
                            r = t.seriesGroup,
                            n = t.realIndex,
                            l = t.i,
                            h = t.j,
                            t = t.w,
                            c = new W(this.barCtx.ctx),
                            o = (o = Array.isArray(o) ? o[n] : o) || 0,
                            d = e,
                            g = i,
                            u =
                                (null != (u = t.config.series[n].data[h]) &&
                                    u.columnWidthOffset &&
                                    ((g =
                                        i -
                                        t.config.series[n].data[h]
                                            .columnWidthOffset /
                                            2),
                                    (d =
                                        e +
                                        t.config.series[n].data[h]
                                            .columnWidthOffset)),
                                o / 2),
                            i = g + u,
                            e = g + d - u,
                            g = ((s += 0.001 + u), c.move(i, (a += 0.001 - u))),
                            d = c.move(i, a),
                            p = c.line(e, a);
                        return (
                            0 < t.globals.previousPaths.length &&
                                (d = this.barCtx.getPreviousPath(n, h, !1)),
                            (g =
                                g +
                                c.line(i, s) +
                                c.line(e, s) +
                                c.line(e, a) +
                                ("around" ===
                                t.config.plotOptions.bar.borderRadiusApplication
                                    ? " Z"
                                    : " z")),
                            (d =
                                d +
                                c.line(i, a) +
                                p +
                                p +
                                p +
                                p +
                                p +
                                c.line(i, a) +
                                ("around" ===
                                t.config.plotOptions.bar.borderRadiusApplication
                                    ? " Z"
                                    : " z")),
                            this.shouldApplyRadius(n) &&
                                (g = c.roundPathCorners(
                                    g,
                                    t.config.plotOptions.bar.borderRadius
                                )),
                            t.config.chart.stacked &&
                                ((e = this.barCtx),
                                (e = this.barCtx[r]).yArrj.push(s - u),
                                e.yArrjF.push(Math.abs(a - s + o)),
                                e.yArrjVal.push(this.barCtx.series[l][h])),
                            { pathTo: g, pathFrom: d }
                        );
                    },
                },
                {
                    key: "getBarpaths",
                    value: function (t) {
                        var e = t.barYPosition,
                            i = t.barHeight,
                            a = t.x1,
                            s = t.x2,
                            o = t.strokeWidth,
                            r = t.seriesGroup,
                            n = t.realIndex,
                            l = t.i,
                            h = t.j,
                            t = t.w,
                            c = new W(this.barCtx.ctx),
                            o = (o = Array.isArray(o) ? o[n] : o) || 0,
                            d = e,
                            g = i,
                            u =
                                (null != (u = t.config.series[n].data[h]) &&
                                    u.barHeightOffset &&
                                    ((d =
                                        e -
                                        t.config.series[n].data[h]
                                            .barHeightOffset /
                                            2),
                                    (g =
                                        i +
                                        t.config.series[n].data[h]
                                            .barHeightOffset)),
                                o / 2),
                            e = d + u,
                            i = d + g - u,
                            o = ((s += 0.001 + u), c.move((a += 0.001 - u), e)),
                            d = c.move(a, e),
                            g =
                                (0 < t.globals.previousPaths.length &&
                                    (d = this.barCtx.getPreviousPath(n, h, !1)),
                                c.line(a, i)),
                            o =
                                o +
                                c.line(s, e) +
                                c.line(s, i) +
                                g +
                                ("around" ===
                                t.config.plotOptions.bar.borderRadiusApplication
                                    ? " Z"
                                    : " z"),
                            d =
                                d +
                                c.line(a, e) +
                                g +
                                g +
                                g +
                                g +
                                g +
                                c.line(a, e) +
                                ("around" ===
                                t.config.plotOptions.bar.borderRadiusApplication
                                    ? " Z"
                                    : " z");
                        return (
                            this.shouldApplyRadius(n) &&
                                (o = c.roundPathCorners(
                                    o,
                                    t.config.plotOptions.bar.borderRadius
                                )),
                            t.config.chart.stacked &&
                                ((i = this.barCtx),
                                (i = this.barCtx[r]).xArrj.push(s + u),
                                i.xArrjF.push(Math.abs(a - s)),
                                i.xArrjVal.push(this.barCtx.series[l][h])),
                            { pathTo: o, pathFrom: d }
                        );
                    },
                },
                {
                    key: "checkZeroSeries",
                    value: function (t) {
                        for (
                            var e = t.series, i = this.w, a = 0;
                            a < e.length;
                            a++
                        ) {
                            for (
                                var s = 0, o = 0;
                                o < e[i.globals.maxValsInArrayIndex].length;
                                o++
                            )
                                s += e[a][o];
                            0 === s && this.barCtx.zeroSerieses.push(a);
                        }
                    },
                },
                {
                    key: "getXForValue",
                    value: function (t, e) {
                        var i =
                            2 < arguments.length &&
                            void 0 !== arguments[2] &&
                            !arguments[2]
                                ? null
                                : e;
                        return (i =
                            null != t
                                ? e +
                                  t / this.barCtx.invertedYRatio -
                                  2 *
                                      (this.barCtx.isReversed
                                          ? t / this.barCtx.invertedYRatio
                                          : 0)
                                : i);
                    },
                },
                {
                    key: "getYForValue",
                    value: function (t, e, i) {
                        var a =
                            3 < arguments.length &&
                            void 0 !== arguments[3] &&
                            !arguments[3]
                                ? null
                                : e;
                        return (a =
                            null != t
                                ? e -
                                  t / this.barCtx.yRatio[i] +
                                  2 *
                                      (this.barCtx.isReversed
                                          ? t / this.barCtx.yRatio[i]
                                          : 0)
                                : a);
                    },
                },
                {
                    key: "getGoalValues",
                    value: function (a, s, o, t, e, r) {
                        function i(t, e) {
                            var i;
                            d.push(
                                (g(
                                    (i = {}),
                                    a,
                                    "x" === a
                                        ? h.getXForValue(t, s, !1)
                                        : h.getYForValue(t, o, r, !1)
                                ),
                                g(i, "attrs", e),
                                i)
                            );
                        }
                        var n,
                            l,
                            h = this,
                            c = this.w,
                            d = [];
                        return (
                            c.globals.seriesGoals[t] &&
                                c.globals.seriesGoals[t][e] &&
                                Array.isArray(c.globals.seriesGoals[t][e]) &&
                                c.globals.seriesGoals[t][e].forEach(function (
                                    t
                                ) {
                                    i(t.value, t);
                                }),
                            this.barCtx.barOptions.isDumbbell &&
                                c.globals.seriesRange.length &&
                                ((n =
                                    this.barCtx.barOptions.dumbbellColors ||
                                    c.globals.colors),
                                (l = {
                                    strokeHeight:
                                        "x" === a
                                            ? 0
                                            : c.globals.markers.size[t],
                                    strokeWidth:
                                        "x" === a
                                            ? c.globals.markers.size[t]
                                            : 0,
                                    strokeDashArray: 0,
                                    strokeLineCap: "round",
                                    strokeColor: Array.isArray(n[t])
                                        ? n[t][0]
                                        : n[t],
                                }),
                                i(c.globals.seriesRangeStart[t][e], l),
                                i(
                                    c.globals.seriesRangeEnd[t][e],
                                    z(
                                        z({}, l),
                                        {},
                                        {
                                            strokeColor: Array.isArray(n[t])
                                                ? n[t][1]
                                                : n[t],
                                        }
                                    )
                                )),
                            d
                        );
                    },
                },
                {
                    key: "drawGoalLine",
                    value: function (t) {
                        var a = t.barXPosition,
                            s = t.barYPosition,
                            e = t.goalX,
                            i = t.goalY,
                            o = t.barWidth,
                            r = t.barHeight,
                            n = new W(this.barCtx.ctx),
                            l = n.group({
                                className: "apexcharts-bar-goals-groups",
                            }),
                            h =
                                (l.node.classList.add(
                                    "apexcharts-element-hidden"
                                ),
                                this.barCtx.w.globals.delayedElements.push({
                                    el: l.node,
                                }),
                                l.attr(
                                    "clip-path",
                                    "url(#gridRectMarkerMask".concat(
                                        this.barCtx.w.globals.cuid,
                                        ")"
                                    )
                                ),
                                null);
                        return (
                            this.barCtx.isHorizontal
                                ? Array.isArray(e) &&
                                  e.forEach(function (t) {
                                      var e, i;
                                      -1 <= t.x &&
                                          t.x <= n.w.globals.gridWidth + 1 &&
                                          ((e =
                                              void 0 !== t.attrs.strokeHeight
                                                  ? t.attrs.strokeHeight
                                                  : r / 2),
                                          (h = n.drawLine(
                                              t.x,
                                              (i = s + e + r / 2) - 2 * e,
                                              t.x,
                                              i,
                                              t.attrs.strokeColor || void 0,
                                              t.attrs.strokeDashArray,
                                              t.attrs.strokeWidth || 2,
                                              t.attrs.strokeLineCap
                                          )),
                                          l.add(h));
                                  })
                                : Array.isArray(i) &&
                                  i.forEach(function (t) {
                                      var e, i;
                                      -1 <= t.y &&
                                          t.y <= n.w.globals.gridHeight + 1 &&
                                          ((e =
                                              void 0 !== t.attrs.strokeWidth
                                                  ? t.attrs.strokeWidth
                                                  : o / 2),
                                          (h = n.drawLine(
                                              (i = a + e + o / 2) - 2 * e,
                                              t.y,
                                              i,
                                              t.y,
                                              t.attrs.strokeColor || void 0,
                                              t.attrs.strokeDashArray,
                                              t.attrs.strokeHeight || 2,
                                              t.attrs.strokeLineCap
                                          )),
                                          l.add(h));
                                  }),
                            l
                        );
                    },
                },
                {
                    key: "drawBarShadow",
                    value: function (t) {
                        var e = t.prevPaths,
                            i = t.currPaths,
                            t = t.color,
                            a = this.w,
                            s = e.x,
                            o = e.x1,
                            e = e.barYPosition,
                            r = i.x,
                            n = i.x1,
                            l = i.barYPosition,
                            e = e + i.barHeight,
                            i = new W(this.barCtx.ctx),
                            h = new N(),
                            s =
                                i.move(o, e) +
                                i.line(s, e) +
                                i.line(r, l) +
                                i.line(n, l) +
                                i.line(o, e) +
                                ("around" ===
                                a.config.plotOptions.bar.borderRadiusApplication
                                    ? " Z"
                                    : " z");
                        return i.drawPath({
                            d: s,
                            fill: h.shadeColor(0.5, N.rgb2hex(t)),
                            stroke: "none",
                            strokeWidth: 0,
                            fillOpacity: 1,
                            classes: "apexcharts-bar-shadows",
                        });
                    },
                },
                {
                    key: "getZeroValueEncounters",
                    value: function (t) {
                        var i = t.i,
                            a = t.j,
                            s = this.w,
                            o = 0,
                            r = 0;
                        return (
                            (s.config.plotOptions.bar.horizontal
                                ? s.globals.series.map(function (t, e) {
                                      return e;
                                  })
                                : (null == (t = s.globals.columnSeries)
                                      ? void 0
                                      : t.i.map(function (t) {
                                            return t;
                                        })) || []
                            ).forEach(function (t) {
                                var e = s.globals.seriesPercent[t][a];
                                e && o++, t < i && 0 === e && r++;
                            }),
                            { nonZeroColumns: o, zeroEncounters: r }
                        );
                    },
                },
                {
                    key: "getGroupIndex",
                    value: function (e) {
                        var i = this.w,
                            t = i.globals.seriesGroups.findIndex(function (t) {
                                return -1 < t.indexOf(i.globals.seriesNames[e]);
                            }),
                            a = this.barCtx.columnGroupIndices,
                            s = a.indexOf(t);
                        return (
                            s < 0 && (a.push(t), (s = a.length - 1)),
                            { groupIndex: t, columnGroupIndex: s }
                        );
                    },
                },
            ]),
            de),
        T =
            (t(ce, [
                {
                    key: "draw",
                    value: function (t, e) {
                        var i = this.w,
                            a = new W(this.ctx),
                            s = new X(this.ctx, i),
                            o =
                                ((t = s.getLogSeries(t)),
                                (this.series = t),
                                (this.yRatio = s.getLogYRatios(this.yRatio)),
                                this.barHelpers.initVariables(t),
                                a.group({
                                    class: "apexcharts-bar-series apexcharts-plot-series",
                                }));
                        i.config.dataLabels.enabled &&
                            this.totalItems >
                                this.barOptions.dataLabels.maxItems &&
                            console.warn(
                                "WARNING: DataLabels are enabled but there are too many to display. This may cause performance issue when rendering - ApexCharts"
                            );
                        for (var r = 0, n = 0; r < t.length; r++, n++) {
                            var l = void 0,
                                h = void 0,
                                c = [],
                                d = [],
                                g = i.globals.comboCharts ? e[r] : r,
                                u =
                                    this.barHelpers.getGroupIndex(
                                        g
                                    ).columnGroupIndex,
                                p = a.group({
                                    class: "apexcharts-series",
                                                       ? ((M = this.drawBarPaths(
                                                  z(
                                                      z({}, I),
                                                      {},
                                                      {
                                                          barHeight: f,
                                                          zeroW: y,
                                                          yDivision: v,
                                                      }
                                                  )
                                              )),
                                              (x =
                                                  this.series[r][L] /
                                                  this.invertedYRatio))
                                            : ((M = this.drawColumnPaths(
                                                  z(
                                                      z({}, I),
                                                      {},
                                                      {
                                                          xDivision: w,
                                                          barWidth: x,
                                                          zeroH: k,
                                                      }
                                                  )
                                              )),
                                              (f =
                                                  this.series[r][L] /
                                                  this.yRatio[b])),
                                        this.barHelpers.getPathFillColor(
                                            t,
                                            r,
                                            L,
                                            g
                                        )),
                                    T =
                                        (this.isFunnel &&
                                            this.barOptions.isFunnel3d &&
                                            this.pathArr.length &&
                                            0 < L &&
                                            (T = this.barHelpers.drawBarShadow({
                                                color:
                                                    "string" == typeof I &&
                                                    -1 ===
                                                        (null == I
                                                            ? void 0
                                                            : I.indexOf("url"))
                                                        ? I
                                                        : N.hexToRgba(
                                                              i.globals.colors[
                                                                  r
                                                              ]
                                                          ),
                                                prevPaths:
                                                    this.pathArr[
                                                        this.pathArr.length - 1
                                                    ],
                                                currPaths: M,
                                            })) &&
                                            C.add(T),
                                        this.pathArr.push(M),
                                        this.barHelpers.drawGoalLine({
                                            barXPosition: M.barXPosition,
                                            barYPosition: M.barYPosition,
                                            goalX: M.goalX,
                                            goalY: M.goalY,
                                            barHeight: f,
                                            barWidth: x,
                                        }));
                                T && S.add(T),
                                    (h = M.y),
                                    (l = M.x),
                                    0 < L && d.push(l + x / 2),
                                    c.push(h),
                                    this.renderSeries({
                                        realIndex: g,
                                        pathFill: I,
                                        j: L,
                                        i: r,
                                        columnGroupIndex: u,
                                        pathFrom: M.pathFrom,
                                        pathTo: M.pathTo,
                                        strokeWidth: P,
                                        elSeries: p,
                                        x: l,
                                        y: h,
                                        series: t,
                                        barHeight: M.barHeight || f,
                                        barWidth: M.barWidth || x,
                                        elDataLabelsWrap: A,
                                        elGoalsMarkers: S,
                                        elBarShadows: C,
                                        visibleSeries: this.visibleI,
                                        type: "bar",
                                    });
                            }
                            (i.globals.seriesXvalues[g] = d),
                                (i.globals.seriesYvalues[g] = c),
                                o.add(p);
                        }
                        return o;
                    },
                },
                {
                    key: "renderSeries",
                    value: function (t) {
                        var e,
                            i = t.realIndex,
                            a = t.pathFill,
                            s = t.lineFill,
                            o = t.j,
                            r = t.i,
                            n = t.columnGroupIndex,
                            l = t.pathFrom,
                            h = t.pathTo,
                            c = t.strokeWidth,
                            d = t.elSeries,
                            g = t.x,
                            u = t.y,
                            p = t.y1,
                            f = t.y2,
                            x = t.series,
                            b = t.barHeight,
                            m = t.barWidth,
                            v = t.barXPosition,
                            y = t.barYPosition,
                            w = t.elDataLabelsWrap,
                            k = t.elGoalsMarkers,
                            A = t.elBarShadows,
                            S = t.visibleSeries,
                            t = t.type,
                            C = this.w,
                            L = new W(this.ctx),
                            P =
                                (s ||
                                    ((e =
                                        "function" ==
                                        typeof C.globals.stroke.colors[i]
                                            ? ((P = i),
                                              (e = C.config.stroke.colors),
                                              Array.isArray(e) &&
                                              0 < e.length &&
                                              "function" ==
                                                  typeof (M = (M = e[P]) || "")
                                                  ? M({
                                                        value: C.globals.series[
                                                            P
                                                        ][o],
                                                        dataPointIndex: o,
                                                        w: C,
                                                    })
                                                  : M)
                                            : C.globals.stroke.colors[i]),
                                    (s = this.barOptions.distributed
                                        ? C.globals.stroke.colors[o]
                                        : e)),
                                C.config.series[r].data[o] &&
                                    C.config.series[r].data[o].strokeColor &&
                                    (s =
                                        C.config.series[r].data[o].strokeColor),
                                this.isNullValue && (a = "none"),
                                ((o /
                                    C.config.chart.animations.animateGradually
                                        .delay) *
                                    (C.config.chart.animations.speed /
                                        C.globals.dataPoints)) /
                                    2.4),
                            M = L.renderPaths({
                                i: r,
                                j: o,
                                realIndex: i,
                                pathFrom: l,
                                pathTo: h,
                                stroke: s,
                                strokeWidth: c,
                                strokeLineCap: C.config.stroke.lineCap,
                                fill: a,
                                animationDelay: P,
                                initialSpeed: C.config.chart.animations.speed,
                                dataChangeSpeed:
                                    C.config.chart.animations.dynamicAnimation
                                        .speed,
                                className: "apexcharts-".concat(t, "-area"),
                            }),
                            L =
                                (M.attr(
                                    "clip-path",
                                    "url(#gridRectMask".concat(
                                        C.globals.cuid,
                                        ")"
                                    )
                                ),
                                C.config.forecastDataPoints),
                            l =
                                (0 < L.count &&
                                    o >= C.globals.dataPoints - L.count &&
                                    (M.node.setAttribute(
                                        "stroke-dasharray",
                                        L.dashArray
                                    ),
                                    M.node.setAttribute(
                                        "stroke-width",
                                        L.strokeWidth
                                    ),
                                    M.node.setAttribute(
                                        "fill-opacity",
                                        L.fillOpacity
                                    )),
                                void 0 !== p &&
                                    void 0 !== f &&
                                    (M.attr("data-range-y1", p),
                                    M.attr("data-range-y2", f)),
                                new I(this.ctx).setSelectionFilter(M, i, o),
                                d.add(M),
                                new _t(this).handleBarDataLabels({
                                    x: g,
                                    y: u,
                                    y1: p,
                                    y2: f,
                                    i: r,
                                    j: o,
                                    series: x,
                                    realIndex: i,
                                    columnGroupIndex: n,
                                    barHeight: b,
                                    barWidth: m,
                                    barXPosition: v,
                                    barYPosition: y,
                                    renderedPath: M,
                                    visibleSeries: S,
                                }));
                        return (
                            null !== l.dataLabels && w.add(l.dataLabels),
                            l.totalDataLabels && w.add(l.totalDataLabels),
                            d.add(w),
                            k && d.add(k),
                            A && d.add(A),
                            d
                        );
                    },
                },
                {
                    key: "drawBarPaths",
                    value: function (t) {
                        var e,
                            i,
                            a,
                            s,
                            o = t.indexes,
                            r = t.barHeight,
                            n = t.strokeWidth,
                            l = t.zeroW,
                            h = (t.x, t.y),
                            c = t.yDivision,
                            t = t.elSeries,
                            d = this.w,
                            g = o.i,
                            u = o.j,
                            n =
                                (d.globals.isXNumeric
                                    ? (e =
                                          (h =
                                              (d.globals.seriesX[g][u] -
                                                  d.globals.minX) /
                                                  this.invertedXRatio -
                                              r) +
                                          r * this.visibleI)
                                    : d.config.plotOptions.bar
                                          .hideZeroBarsWhenGrouped
                                    ? ((s = a = 0),
                                      d.globals.seriesPercent.forEach(function (
                                          t,
                                          e
                                      ) {
                                          t[u] && a++,
                                              e < g && 0 === t[u] && s++;
                                      }),
                                      (e =
                                          h +
                                          (r =
                                              0 < a
                                                  ? (this.seriesLen * r) / a
                                                  : r) *
                                              this.visibleI),
                                      (e -= r * s))
                                    : (e = h + r * this.visibleI),
                                this.isFunnel &&
                                    (l -=
                                        (this.barHelpers.getXForValue(
                                            this.series[g][u],
                                            l
                                        ) -
                                            l) /
                                        2),
                                (i = this.barHelpers.getXForValue(
                                    this.series[g][u],
                                    l
                                )),
                                this.barHelpers.getBarpaths({
                                    barYPosition: e,
                                    barHeight: r,
                                    x1: l,
                                    x2: i,
                                    strokeWidth: n,
                                    series: this.series,
                                    realIndex: o.realIndex,
                                    i: g,
                                    j: u,
                                    w: d,
                                }));
                        return (
                            d.globals.isXNumeric || (h += c),
                            this.barHelpers.barBackground({
                                j: u,
                                i: g,
                                y1: e - r * this.visibleI,
                                y2: r * this.seriesLen,
                                elSeries: t,
                            }),
                            {
                                pathTo: n.pathTo,
                                pathFrom: n.pathFrom,
                                x1: l,
                                x: i,
                                y: h,
                                goalX: this.barHelpers.getGoalValues(
                                    "x",
                                    l,
                                    null,
                                    g,
                                    u
                                ),
                                barYPosition: e,
                                barHeight: r,
                            }
                        );
                    },
                },
                {
                    key: "drawColumnPaths",
                    value: function (t) {
                        var e,
                            i,
                            a = t.indexes,
                            s = t.x,
                            o = (t.y, t.xDivision),
                            r = t.barWidth,
                            n = t.zeroH,
                            l = t.strokeWidth,
                            t = t.elSeries,
                            h = this.w,
                            c = a.realIndex,
                            d = a.translationsIndex,
                            g = a.i,
                            u = a.j,
                            a = a.bc,
                            p =
                                (h.globals.isXNumeric
                                    ? ((s = (e = this.getBarXForNumericXAxis({
                                          x: s,
                                          j: u,
                                          realIndex: c,
                                          barWidth: r,
                                      })).x),
                                      (e = e.barXPosition))
                                    : h.config.plotOptions.bar
                                          .hideZeroBarsWhenGrouped
                                    ? ((i = (p =
                                          this.barHelpers.getZeroValueEncounters(
                                              { i: g, j: u }
                                          )).nonZeroColumns),
                                      (p = p.zeroEncounters),
                                      (e =
                                          s +
                                          (r =
                                              0 < i
                                                  ? (this.seriesLen * r) / i
                                                  : r) *
                                              this.visibleI),
                                      (e -= r * p))
                                    : (e = s + r * this.visibleI),
                                (i = this.barHelpers.getYForValue(
                                    this.series[g][u],
                                    n,
                                    d
                                )),
                                this.barHelpers.getColumnPaths({
                                    barXPosition: e,
                                    barWidth: r,
                                    y1: n,
                                    y2: i,
                                    strokeWidth: l,
                                    series: this.series,
                                    realIndex: c,
                                    i: g,
                                    j: u,
                                    w: h,
                                }));
                        return (
                            h.globals.isXNumeric || (s += o),
                            this.barHelpers.barBackground({
                                bc: a,
                                j: u,
                                i: g,
                                x1: e - l / 2 - r * this.visibleI,
                                x2: r * this.seriesLen + l / 2,
                                elSeries: t,
                            }),
                            {
                                pathTo: p.pathTo,
                                pathFrom: p.pathFrom,
                                x: s,
                                y: i,
                                goalY: this.barHelpers.getGoalValues(
                                    "y",
                                    null,
                                    n,
                                    g,
                                    u,
                                    d
                                ),
                                barXPosition: e,
                                barWidth: r,
                            }
                        );
                    },
                },
                {
                    key: "getBarXForNumericXAxis",
                    value: function (t) {
                        var e = t.x,
                            i = t.barWidth,
                            a = t.realIndex,
                            t = t.j,
                            s = this.w,
                            o = a;
                        return (
                            s.globals.seriesX[a].length ||
                                (o = s.globals.maxValsInArrayIndex),
                            {
                                barXPosition:
                                    (e = s.globals.seriesX[o][t]
                                        ? (s.globals.seriesX[o][t] -
                                              s.globals.minX) /
                                              this.xRatio -
                                          (i * this.seriesLen) / 2
                                        : e) +
                                    i * this.visibleI,
                                x: e,
                            }
                        );
                    },
                },
                {
                    key: "getPreviousPath",
                    value: function (t, e) {
                        for (
                            var i, a = this.w, s = 0;
                            s < a.globals.previousPaths.length;
                            s++
                        ) {
                            var o = a.globals.previousPaths[s];
                            o.paths &&
                                0 < o.paths.length &&
                                parseInt(o.realIndex, 10) === parseInt(t, 10) &&
                                void 0 !==
                                    a.globals.previousPaths[s].paths[e] &&
                                (i = a.globals.previousPaths[s].paths[e].d);
                        }
                        return i;
                    },
                },
            ]),
            ce),
        qt =
            (e(c, T),
            (ct = i(c)),
            t(c, [
                {
                    key: "draw",
                    value: function (k, A) {
                        var S = this,
                            C = this.w,
                            t =
                                ((this.graphics = new W(this.ctx)),
                                (this.bar = new T(this.ctx, this.xyRatios)),
                                new X(this.ctx, C));
                        (k = t.getLogSeries(k)),
                            (this.yRatio = t.getLogYRatios(this.yRatio)),
                            this.barHelpers.initVariables(k),
                            "100%" === C.config.chart.stackType &&
                                (k = C.globals.comboCharts
                                    ? A.map(function (t) {
                                          return C.globals.seriesPercent[t];
                                      })
                                    : C.globals.seriesPercent.slice()),
                            (this.series = k),
                            this.barHelpers.initializeStackedPrevVars(this);
                        for (
                            var L = this.graphics.group({
                                    class: "apexcharts-bar-series apexcharts-plot-series",
                                }),
                                P = 0,
                                M = 0,
                                e = 0,
                                i = 0;
                            e < k.length;
                            e++, i++
                        )
                            !(function (t, e) {
                                var i,
                                    a,
                                    s,
                                    o,
                                    r = C.globals.comboCharts ? A[t] : t,
                                    n = S.barHelpers.getGroupIndex(r),
                                    l = n.groupIndex,
                                    h = n.columnGroupIndex,
                                    c =
                                        ((S.groupCtx =
                                            S[C.globals.seriesGroups[l]]),
                                        []),
                                    d = [],
                                    g = 0,
                                    u =
                                        (1 < S.yRatio.length &&
                                            ((S.yaxisIndex =
                                                C.globals.seriesYAxisReverseMap[
                                                    r
                                                ][0]),
                                            (g = r)),
                                        (S.isReversed =
                                            C.config.yaxis[S.yaxisIndex] &&
                                            C.config.yaxis[S.yaxisIndex]
                                                .reversed),
                                        S.graphics.group({
                                            class: "apexcharts-series",
                                            seriesName: N.escapeString(
                                                C.globals.seriesNames[r]
                                            ),
                                            rel: t + 1,
                                            "data:realIndex": r,
                                        })),
                                    p =
                                        (S.ctx.series.addCollapsedClassToSeries(
                                            u,
                                            r
                                        ),
                                        S.graphics.group({
                                            class: "apexcharts-datalabels",
                                            "data:realIndex": r,
                                        })),
                                    f = S.graphics.group({
                                        class: "apexcharts-bar-goals-markers",
                                    }),
                                    x = 0,
                                    b = 0,
                                    n = S.initialPositions(
                                        P,
                                        M,
                                        void 0,
                                        void 0,
                                        void 0,
                                        void 0,
                                        g
                                    );
                                (M = n.y),
                                    (x = n.barHeight),
                                    (a = n.yDivision),
                                    (o = n.zeroW),
                                    (P = n.x),
                                    (b = n.barWidth),
                                    (i = n.xDivision),
                                    (s = n.zeroH),
                                    (C.globals.barHeight = x),
                                    (C.globals.barWidth = b),
                                    S.barHelpers.initializeStackedXYVars(S),
                                    1 === S.groupCtx.prevY.length &&
                                        S.groupCtx.prevY[0].every(function (t) {
                                            return isNaN(t);
                                        }) &&
                                        ((S.groupCtx.prevY[0] =
                                            S.groupCtx.prevY[0].map(
                                                function () {
                                                    return s;
                                                }
                                            )),
                                        (S.groupCtx.prevYF[0] =
                                            S.groupCtx.prevYF[0].map(
                                                function () {
                                                    return 0;
                                                }
                                            )));
                                for (var m = 0; m < C.globals.dataPoints; m++)
                                    var v = S.barHelpers.getStrokeWidth(
                                            t,
                                            m,
                                            r
                                        ),
                                        y = {
                                            indexes: {
                                                i: t,
                                                j: m,
                                                realIndex: r,
                                                translationsIndex: g,
                                                bc: e,
                                            },
                                            strokeWidth: v,
                                            x: P,
                                            y: M,
                                            elSeries: u,
                                            columnGroupIndex: h,
                                            seriesGroup:
                                                C.globals.seriesGroups[l],
                                        },
                                        w = null,
                                        y =
                                            (S.isHorizontal
                                                ? ((w = S.drawStackedBarPaths(
                                                      z(
                                                          z({}, y),
                                                          {},
                                                          {
                                                              zeroW: o,
                                                              barHeight: x,
                                                              yDivision: a,
                                                          }
                                                      )
                                                  )),
                                                  (b =
                                                      S.series[t][m] /
                                                      S.invertedYRatio))
                                                : ((w =
                                                      S.drawStackedColumnPaths(
                                                          z(
                                                              z({}, y),
                                                              {},
                                                              {
                                                                  xDivision: i,
                                                                  barWidth: b,
                                                                  zeroH: s,
                                                              }
                                                          )
                                                      )),
                                                  (x =
                                                      S.series[t][m] /
                                                      S.yRatio[g])),
                                            S.barHelpers.drawGoalLine({
                                                barXPosition: w.barXPosition,
                                                barYPosition: w.barYPosition,
                                                goalX: w.goalX,
                                                goalY: w.goalY,
                                                barHeight: x,
                                                barWidth: b,
                                            })),
                                        y =
                                            (y && f.add(y),
                                            (M = w.y),
                                            (P = w.x),
                                            c.push(P),
                                            d.push(M),
                                            S.barHelpers.getPathFillColor(
                                                k,
                                                t,
                                                m,
                                                r
                                            )),
                                        u = S.renderSeries({
                                            realIndex: r,
                                            pathFill: y,
                                            j: m,
                                            i: t,
                                            columnGroupIndex: h,
                                            pathFrom: w.pathFrom,
                                            pathTo: w.pathTo,
                                            strokeWidth: v,
                                            elSeries: u,
                                            x: P,
                                            y: M,
                                            series: k,
                                            barHeight: x,
                                            barWidth: b,
                                            elDataLabelsWrap: p,
                                            elGoalsMarkers: f,
                                            type: "bar",
                                            visibleSeries: 0,
                                        });
                                (C.globals.seriesXvalues[r] = c),
                                    (C.globals.seriesYvalues[r] = d),
                                    S.groupCtx.prevY.push(S.groupCtx.yArrj),
                                    S.groupCtx.prevYF.push(S.groupCtx.yArrjF),
                                    S.groupCtx.prevYVal.push(
                                        S.groupCtx.yArrjVal
                                    ),
                                    S.groupCtx.prevX.push(S.groupCtx.xArrj),
                                    S.groupCtx.prevXF.push(S.groupCtx.xArrjF),
                                    S.groupCtx.prevXVal.push(
                                        S.groupCtx.xArrjVal
                                    ),
                                    L.add(u);
                            })(e, i);
                        return L;
                    },
                },
                {
                    key: "initialPositions",
                    value: function (t, e, i, a, s, o, r) {
                        var n,
                            l,
                            h = this.w,
                            c =
                                (this.isHorizontal
                                    ? ((a =
                                          h.globals.gridHeight /
                                          h.globals.dataPoints),
                                      (n = h.config.plotOptions.bar.barHeight),
                                      (n =
                                          -1 === String(n).indexOf("%")
                                              ? parseInt(n, 10)
                                              : (a * parseInt(n, 10)) / 100),
                                      (o =
                                          h.globals.padHorizontal +
                                          (this.isReversed
                                              ? h.globals.gridWidth -
                                                this.baseLineInvertedY
                                              : this.baseLineInvertedY)),
                                      (e = (a - n) / 2))
                                    : ((l = i =
                                          h.globals.gridWidth /
                                          h.globals.dataPoints),
                                      (c =
                                          h.config.plotOptions.bar.columnWidth),
                                      h.globals.isXNumeric &&
                                      1 < h.globals.dataPoints
                                          ? (l =
                                                ((i =
                                                    h.globals.minXDiff /
                                                    this.xRatio) *
                                                    parseInt(
                                                        this.barOptions
                                                            .columnWidth,
                                                        10
                                                    )) /
                                                100)
                                          : -1 === String(c).indexOf("%")
                                          ? (l = parseInt(c, 10))
                                          : (l *= parseInt(c, 10) / 100),
                                      (s =
                                          h.globals.gridHeight -
                                          this.baseLineY[r] -
                                          (this.isReversed
                                              ? h.globals.gridHeight
                                              : 0)),
                                      (t =
                                          h.globals.padHorizontal +
                                          (i - l) / 2)),
                                h.globals.barGroups.length || 1);
                        return {
                            x: t,
                            y: e,
                            yDivision: a,
                            xDivision: i,
                            barHeight: n / c,
                            barWidth: l / c,
                            zeroH: s,
                            zeroW: o,
                        };
                    },
                },
                {
                    key: "drawStackedBarPaths",
                    value: function (t) {
                        for (
                            var e = t.indexes,
                                i = t.barHeight,
                                a = t.strokeWidth,
                                s = t.zeroW,
                                o = (t.x, t.y),
                                r = t.columnGroupIndex,
                                n = t.seriesGroup,
                                l = t.yDivision,
                                t = t.elSeries,
                                h = this.w,
                                r = o + r * i,
                                c = e.i,
                                d = e.j,
                                g = e.realIndex,
                                u = e.translationsIndex,
                                p = 0,
                                f = 0;
                            f < this.groupCtx.prevXF.length;
                            f++
                        )
                            p += this.groupCtx.prevXF[f][d];
                        var g =
                                0 < (g = n.indexOf(h.config.series[g].name))
                                    ? ((x = s),
                                      this.groupCtx.prevXVal[g - 1][d] < 0
                                          ? (x =
                                                0 <= this.series[c][d]
                                                    ? this.groupCtx.prevX[
                                                          g - 1
                                                      ][d] +
                                                      p -
                                                      2 *
                                                          (this.isReversed
                                                              ? p
                                                              : 0)
                                                    : this.groupCtx.prevX[
                                                          g - 1
                                                      ][d])
                                          : 0 <=
                                                this.groupCtx.prevXVal[g - 1][
                                                    d
                                                ] &&
                                            (x =
                                                0 <= this.series[c][d]
                                                    ? this.groupCtx.prevX[
                                                          g - 1
                                                      ][d]
                                                    : this.groupCtx.prevX[
                                                          g - 1
                                                      ][d] -
                                                      p +
                                                      2 *
                                                          (this.isReversed
                                                              ? p
                                                              : 0)),
                                      x)
                                    : s,
                            x =
                                null === this.series[c][d]
                                    ? g
                                    : g +
                                      this.series[c][d] / this.invertedYRatio -
                                      2 *
                                          (this.isReversed
                                              ? this.series[c][d] /
                                                this.invertedYRatio
                                              : 0),
                            a = this.barHelpers.getBarpaths({
                                barYPosition: r,
                                barHeight: i,
                                x1: g,
                                x2: x,
                                strokeWidth: a,
                                series: this.series,
                                realIndex: e.realIndex,
                                seriesGroup: n,
                                i: c,
                                j: d,
                                w: h,
                            });
                        return (
                            this.barHelpers.barBackground({
                                j: d,
                                i: c,
                                y1: r,
                                y2: i,
                                elSeries: t,
                            }),
                            (o += l),
                            {
                                pathTo: a.pathTo,
                                pathFrom: a.pathFrom,
                                goalX: this.barHelpers.getGoalValues(
                                    "x",
                                    s,
                                    null,
                                    c,
                                    d,
                                    u
                                ),
                                barXPosition: g,
                                barYPosition: r,
                                x: x,
                                y: o,
                            }
                        );
                    },
                },
                {
                    key: "drawStackedColumnPaths",
                    value: function (t) {
                        for (
                            var e = t.indexes,
                                i = t.x,
                                a = (t.y, t.xDivision),
                                s = t.barWidth,
                                o = t.zeroH,
                                r = t.columnGroupIndex,
                                n = t.seriesGroup,
                                t = t.elSeries,
                                l = this.w,
                                h = e.i,
                                c = e.j,
                                d = e.bc,
                                g = e.realIndex,
                                u = e.translationsIndex,
                                r =
                                    (i = l.globals.isXNumeric
                                        ? ((l.globals.seriesX[g][c] || 0) -
                                              l.globals.minX) /
                                              this.xRatio -
                                          (s / 2) * l.globals.barGroups.length
                                        : i) +
                                    r * s,
                                p = 0,
                                f = 0;
                            f < this.groupCtx.prevYF.length;
                            f++
                        )
                            p += isNaN(this.groupCtx.prevYF[f][c])
                                ? 0
                                : this.groupCtx.prevYF[f][c];
                        var x = h;
                        if (
                            (0 <
                                (x = n
                                    ? n.indexOf(l.globals.seriesNames[g])
                                    : x) &&
                                !l.globals.isXNumeric) ||
                            (0 < x &&
                                l.globals.isXNumeric &&
                                l.globals.seriesX[g - 1][c] ===
                                    l.globals.seriesX[g][c])
                        ) {
                            var b,
                                m,
                                v,
                                y = Math.min(this.yRatio.length + 1, g + 1);
                            if (
                                void 0 !== this.groupCtx.prevY[x - 1] &&
                                this.groupCtx.prevY[x - 1].length
                            )
                                for (var w = 1; w < y; w++)
                                    if (
                                        !isNaN(
                                            null ==
                                                (v = this.groupCtx.prevY[x - w])
                                                ? void 0
                                                : v[c]
                                        )
                                    ) {
                                        m = this.groupCtx.prevY[x - w][c];
                                        break;
                                    }
                            for (var k, A = 1; A < y; A++) {
                                if (
                                    (null == (k = this.groupCtx.prevYVal[x - A])
                                        ? void 0
                                        : k[c]) < 0
                                ) {
                                    b =
                                        0 <= this.series[h][c]
                                            ? m -
                                              p +
                                              2 * (this.isReversed ? p : 0)
                                            : m;
                                    break;
                                }
                                if (
                                    0 <=
                                    (null == (k = this.groupCtx.prevYVal[x - A])
                                        ? void 0
                                        : k[c])
                                ) {
                                    b =
                                        0 <= this.series[h][c]
                                            ? m
                                            : m +
                                              p -
                                              2 * (this.isReversed ? p : 0);
                                    break;
                                }
                            }
                            void 0 === b && (b = l.globals.gridHeight),
                                (S =
                                    null != (g = this.groupCtx.prevYF[0]) &&
                                    g.every(function (t) {
                                        return 0 === t;
                                    }) &&
                                    this.groupCtx.prevYF
                                        .slice(1, x)
                                        .every(function (t) {
                                            return t.every(function (t) {
                                                return isNaN(t);
                                            });
                                        })
                                        ? o
                                        : b);
                        } else S = o;
                        var g = this.series[h][c]
                                ? S -
                                  this.series[h][c] / this.yRatio[u] +
                                  2 *
                                      (this.isReversed
                                          ? this.series[h][c] / this.yRatio[u]
                                          : 0)
                                : S,
                            S = this.barHelpers.getColumnPaths({
                                barXPosition: r,
                                barWidth: s,
                                y1: S,
                                y2: g,
                                yRatio: this.yRatio[u],
                                strokeWidth: this.strokeWidth,
                                series: this.series,
                                seriesGroup: n,
                                realIndex: e.realIndex,
                                i: h,
                                j: c,
                                w: l,
                            });
                        return (
                            this.barHelpers.barBackground({
                                bc: d,
                                j: c,
                                i: h,
                                x1: r,
                                x2: s,
                                elSeries: t,
                            }),
                            {
                                pathTo: S.pathTo,
                                pathFrom: S.pathFrom,
                                goalY: this.barHelpers.getGoalValues(
                                    "y",
                                    null,
                                    o,
                                    h,
                                    c
                                ),
                                barXPosition: r,
                                x: l.globals.isXNumeric ? i : i + a,
                                y: g,
                            }
                        );
                    },
                },
            ]),
            c),
        Zt =
            (e(h, T),
            (ht = i(h)),
            t(h, [
                {
                    key: "draw",
                    value: function (y, t, s) {
                        var w = this,
                            k = this.w,
                            o = new W(this.ctx),
                            t = k.globals.comboCharts ? t : k.config.chart.type,
                            A = new C(this.ctx),
                            e =
                                ((this.candlestickOptions =
                                    this.w.config.plotOptions.candlestick),
                                (this.boxOptions =
                                    this.w.config.plotOptions.boxPlot),
                                (this.isHorizontal =
                                    k.config.plotOptions.bar.horizontal),
                                new X(this.ctx, k));
                        (y = e.getLogSeries(y)),
                            (this.series = y),
                            (this.yRatio = e.getLogYRatios(this.yRatio)),
                            this.barHelpers.initVariables(y);
                        for (
                            var S = o.group({
                                    class: "apexcharts-".concat(
                                        t,
                                        "-series apexcharts-plot-series"
                                    ),
                                }),
                                i = 0;
                            i < y.length;
                            i++
                        )
                            !(function (r) {
                                w.isBoxPlot =
                                    "boxPlot" === k.config.chart.type ||
                                    "boxPlot" === k.config.series[r].type;
                                var n = void 0,
                                    l = void 0,
                                    e = [],
                                    i = [],
                                    h = k.globals.comboCharts ? s[r] : r,
                                    c =
                                        w.barHelpers.getGroupIndex(
                                            h
                                        ).columnGroupIndex,
                                    d = o.group({
                                        class: "apexcharts-series",
                                        seriesName: N.escapeString(
                                            k.globals.seriesNames[h]
                                        ),
                                        rel: r + 1,
                                        "data:realIndex": h,
                                    });
                                w.ctx.series.addCollapsedClassToSeries(d, h),
                                    0 < y[r].length &&
                                        (w.visibleI = w.visibleI + 1);
                                var g = 0,
                                    t =
                                        (1 < w.yRatio.length &&
                                            ((w.yaxisIndex =
                                                k.globals.seriesYAxisReverseMap[
                                                    h
                                                ][0]),
                                            (g = h)),
                                        w.barHelpers.initialPositions()),
                                    l = t.y,
                                    u = t.barHeight,
                                    p = t.yDivision,
                                    f = t.zeroW,
                                    n = t.x,
                                    x = t.barWidth,
                                    b = t.xDivision,
                                    m = t.zeroH;
                                i.push(n + x / 2);
                                for (
                                    var v = o.group({
                                            class: "apexcharts-datalabels",
                                            "data:realIndex": h,
                                        }),
                                        a = 0;
                                    a < k.globals.dataPoints;
                                    a++
                                )
                                    !(function (a) {
                                        var s = w.barHelpers.getStrokeWidth(
                                                r,
                                                a,
                                                h
                                            ),
                                            o = null,
                                            t = {
                                                indexes: {
                                                    i: r,
                                                    j: a,
                                                    realIndex: h,
                                                    translationsIndex: g,
                                                },
                                                x: n,
                                                y: l,
                                                strokeWidth: s,
                                                elSeries: d,
                                            },
                                            o = w.isHorizontal
                                                ? w.drawHorizontalBoxPaths(
                                                      z(
                                                          z({}, t),
                                                          {},
                                                          {
                                                              yDivision: p,
                                                              barHeight: u,
                                                              zeroW: f,
                                                          }
                                                      )
                                                  )
                                                : w.drawVerticalBoxPaths(
                                                      z(
                                                          z({}, t),
                                                          {},
                                                          {
                                                              xDivision: b,
                                                              barWidth: x,
                                                              zeroH: m,
                                                          }
                                                      )
                                                  );
                                        (l = o.y),
                                            (n = o.x),
                                            0 < a && i.push(n + x / 2),
                                            e.push(l),
                                            o.pathTo.forEach(function (t, e) {
                                                var i =
                                                        !w.isBoxPlot &&
                                                        w.candlestickOptions
                                                            .wick.useFillColor
                                                            ? o.color[e]
                                                            : k.globals.stroke
                                                                  .colors[r],
                                                    e = A.fillPath({
                                                        seriesNumber: h,
                                                        dataPointIndex: a,
                                                        color: o.color[e],
                                                        value: y[r][a],
                                                    });
                                                w.renderSeries({
                                                    realIndex: h,
                                                    pathFill: e,
                                                    lineFill: i,
                                                    j: a,
                                                    i: r,
                                                    pathFrom: o.pathFrom,
                                                    pathTo: t,
                                                    strokeWidth: s,
                                                    elSeries: d,
                                                    x: n,
                                                    y: l,
                                                    series: y,
                                                    columnGroupIndex: c,
                                                    barHeight: u,
                                                    barWidth: x,
                                                    elDataLabelsWrap: v,
                                                    visibleSeries: w.visibleI,
                                                    type: k.config.chart.type,
                                                });
                                            });
                                    })(a);
                                (k.globals.seriesXvalues[h] = i),
                                    (k.globals.seriesYvalues[h] = e),
                                    S.add(d);
                            })(i);
                        return S;
                    },
                },
                {
                    key: "drawVerticalBoxPaths",
                    value: function (t) {
                        var e = t.indexes,
                            i = t.x,
                            a = (t.y, t.xDivision),
                            s = t.barWidth,
                            o = t.zeroH,
                            t = t.strokeWidth,
                            r = this.w,
                            n = new W(this.ctx),
                            l = e.i,
                            h = e.j,
                            c = !0,
                            d = r.config.plotOptions.candlestick.colors.upward,
                            g =
                                r.config.plotOptions.candlestick.colors
                                    .downward,
                            u = "",
                            p =
                                                             y2: C,
                                              },
                                              I
                                          )
                                      )).barWidth))
                                    : ((P =
                                          (r = i.globals.isXNumeric
                                              ? (i.globals.seriesX[o][w] -
                                                    i.globals.minX) /
                                                    this.xRatio -
                                                g / 2
                                              : r) +
                                          g * this.visibleI),
                                      i.config.series[o].data[w].x &&
                                          ((g = (k = this.detectOverlappingBars(
                                              {
                                                  i: o,
                                                  j: w,
                                                  barXPosition: P,
                                                  srtx: (x - g * T) / 2,
                                                  barWidth: g,
                                                  xDivision: x,
                                                  initPositions: p,
                                              }
                                          )).barWidth),
                                          (P = k.barXPosition)),
                                      (d = (L = this.drawRangeColumnPaths(
                                          z(
                                              {
                                                  indexes: {
                                                      i: o,
                                                      j: w,
                                                      realIndex: l,
                                                      translationsIndex: u,
                                                  },
                                                  barWidth: g,
                                                  barXPosition: P,
                                                  zeroH: m,
                                                  xDivision: x,
                                              },
                                              I
                                          )
                                      )).barHeight));
                                (T = this.barHelpers.drawGoalLine({
                                    barXPosition: L.barXPosition,
                                    barYPosition: M,
                                    goalX: L.goalX,
                                    goalY: L.goalY,
                                    barHeight: d,
                                    barWidth: g,
                                })),
                                    (I =
                                        (T && y.add(T),
                                        (n = L.y),
                                        (r = L.x),
                                        this.barHelpers.getPathFillColor(
                                            t,
                                            o,
                                            w,
                                            l
                                        ))),
                                    (T = i.globals.stroke.colors[l]);
                                this.renderSeries({
                                    realIndex: l,
                                    pathFill: I,
                                    lineFill: T,
                                    j: w,
                                    i: o,
                                    x: r,
                                    y: n,
                                    y1: S,
                                    y2: C,
                                    pathFrom: L.pathFrom,
                                    pathTo: L.pathTo,
                                    strokeWidth: A,
                                    elSeries: c,
                                    series: t,
                                    barHeight: d,
                                    barWidth: g,
                                    barXPosition: P,
                                    barYPosition: M,
                                    columnGroupIndex: h,
                                    elDataLabelsWrap: v,
                                    elGoalsMarkers: y,
                                    visibleSeries: this.visibleI,
                                    type: "rangebar",
                                });
                            }
                            s.add(c);
                        }
                        return s;
                    },
                },
                {
                    key: "detectOverlappingBars",
                    value: function (t) {
                        var e = t.i,
                            i = t.j,
                            a = t.barYPosition,
                            s = t.barXPosition,
                            o = t.srty,
                            r = t.srtx,
                            n = t.barHeight,
                            l = t.barWidth,
                            h = t.yDivision,
                            c = t.xDivision,
                            t = t.initPositions,
                            d = this.w,
                            g = [],
                            u = d.config.series[e].data[i].rangeName,
                            i = d.config.series[e].data[i].x,
                            p = Array.isArray(i) ? i.join(" ") : i,
                            i = d.globals.labels
                                .map(function (t) {
                                    return Array.isArray(t) ? t.join(" ") : t;
                                })
                                .indexOf(p),
                            f = d.globals.seriesRange[e].findIndex(function (
                                t
                            ) {
                                return t.x === p && 0 < t.overlaps.length;
                            });
                        return (
                            this.isHorizontal
                                ? ((a = d.config.plotOptions.bar
                                      .rangeBarGroupRows
                                      ? o + h * i
                                      : o + n * this.visibleI + h * i),
                                  -1 < f &&
                                      !d.config.plotOptions.bar
                                          .rangeBarOverlap &&
                                      -1 <
                                          (g =
                                              d.globals.seriesRange[e][f]
                                                  .overlaps).indexOf(u) &&
                                      (a =
                                          (n = t.barHeight / g.length) *
                                              this.visibleI +
                                          (h *
                                              (100 -
                                                  parseInt(
                                                      this.barOptions.barHeight,
                                                      10
                                                  ))) /
                                              100 /
                                              2 +
                                          n * (this.visibleI + g.indexOf(u)) +
                                          h * i))
                                : (-1 < i &&
                                      !d.globals.timescaleLabels.length &&
                                      (s = d.config.plotOptions.bar
                                          .rangeBarGroupRows
                                          ? r + c * i
                                          : r + l * this.visibleI + c * i),
                                  -1 < f &&
                                      !d.config.plotOptions.bar
                                          .rangeBarOverlap &&
                                      -1 <
                                          (g =
                                              d.globals.seriesRange[e][f]
                                                  .overlaps).indexOf(u) &&
                                      (s =
                                          (l = t.barWidth / g.length) *
                                              this.visibleI +
                                          (c *
                                              (100 -
                                                  parseInt(
                                                      this.barOptions.barWidth,
                                                      10
                                                  ))) /
                                              100 /
                                              2 +
                                          l * (this.visibleI + g.indexOf(u)) +
                                          c * i)),
                            {
                                barYPosition: a,
                                barXPosition: s,
                                barHeight: n,
                                barWidth: l,
                            }
                        );
                    },
                },
                {
                    key: "drawRangeColumnPaths",
                    value: function (t) {
                        var e = t.indexes,
                            i = t.x,
                            a = t.xDivision,
                            s = t.barWidth,
                            o = t.barXPosition,
                            t = t.zeroH,
                            r = this.w,
                            n = e.i,
                            l = e.j,
                            h = e.realIndex,
                            e = e.translationsIndex,
                            c = this.yRatio[e],
                            d = this.getRangeValue(h, l),
                            g = Math.min(d.start, d.end),
                            u = Math.max(d.start, d.end),
                            c =
                                (void 0 === this.series[n][l] ||
                                null === this.series[n][l]
                                    ? (g = t)
                                    : ((g = t - g / c), (u = t - u / c)),
                                Math.abs(u - g)),
                            p = this.barHelpers.getColumnPaths({
                                barXPosition: o,
                                barWidth: s,
                                y1: g,
                                y2: u,
                                strokeWidth: this.strokeWidth,
                                series: this.seriesRangeEnd,
                                realIndex: h,
                                i: h,
                                j: l,
                                w: r,
                            });
                        return (
                            r.globals.isXNumeric
                                ? ((i = (r = this.getBarXForNumericXAxis({
                                      x: i,
                                      j: l,
                                      realIndex: h,
                                      barWidth: s,
                                  })).x),
                                  (o = r.barXPosition))
                                : (i += a),
                            {
                                pathTo: p.pathTo,
                                pathFrom: p.pathFrom,
                                barHeight: c,
                                x: i,
                                y: d.start < 0 && d.end < 0 ? g : u,
                                goalY: this.barHelpers.getGoalValues(
                                    "y",
                                    null,
                                    t,
                                    n,
                                    l,
                                    e
                                ),
                                barXPosition: o,
                            }
                        );
                    },
                },
                {
                    key: "preventBarOverflow",
                    value: function (t) {
                        var e = this.w;
                        return (t =
                            (t = t < 0 ? 0 : t) > e.globals.gridWidth
                                ? e.globals.gridWidth
                                : t);
                    },
                },
                {
                    key: "drawRangeBarPaths",
                    value: function (t) {
                        var e = t.indexes,
                            i = t.y,
                            a = t.y1,
                            s = t.y2,
                            o = t.yDivision,
                            r = t.barHeight,
                            n = t.barYPosition,
                            t = t.zeroW,
                            l = this.w,
                            h = e.realIndex,
                            e = e.j,
                            a = this.preventBarOverflow(
                                t + a / this.invertedYRatio
                            ),
                            s = this.preventBarOverflow(
                                t + s / this.invertedYRatio
                            ),
                            c = this.getRangeValue(h, e),
                            d = Math.abs(s - a),
                            n = this.barHelpers.getBarpaths({
                                barYPosition: n,
                                barHeight: r,
                                x1: a,
                                x2: s,
                                strokeWidth: this.strokeWidth,
                                series: this.seriesRangeEnd,
                                i: h,
                                realIndex: h,
                                j: e,
                                w: l,
                            });
                        return (
                            l.globals.isXNumeric || (i += o),
                            {
                                pathTo: n.pathTo,
                                pathFrom: n.pathFrom,
                                barWidth: d,
                                x: c.start < 0 && c.end < 0 ? a : s,
                                goalX: this.barHelpers.getGoalValues(
                                    "x",
                                    t,
                                    null,
                                    h,
                                    e
                                ),
                                y: i,
                            }
                        );
                    },
                },
                {
                    key: "getRangeValue",
                    value: function (t, e) {
                        var i = this.w;
                        return {
                            start: i.globals.seriesRangeStart[t][e],
                            end: i.globals.seriesRangeEnd[t][e],
                        };
                    },
                },
            ]),
            r),
        ae =
            (t(se, [
                {
                    key: "sameValueSeriesFix",
                    value: function (t, e) {
                        var i = this.w;
                        return (
                            ("gradient" !== i.config.fill.type &&
                                "gradient" !== i.config.fill.type[t]) ||
                                !new X(
                                    this.lineCtx.ctx,
                                    i
                                ).seriesHaveSameValues(t) ||
                                (((i = e[t].slice())[i.length - 1] =
                                    i[i.length - 1] + 1e-6),
                                (e[t] = i)),
                            e
                        );
                    },
                },
                {
                    key: "calculatePoints",
                    value: function (t) {
                        var e,
                            i = t.series,
                            a = t.realIndex,
                            s = t.x,
                            o = t.y,
                            r = t.i,
                            n = t.j,
                            t = t.prevY,
                            l = this.w,
                            h = [],
                            c = [];
                        return (
                            0 === n &&
                                ((e =
                                    this.lineCtx.categoryAxisCorrection +
                                    l.config.markers.offsetX),
                                l.globals.isXNumeric &&
                                    (e =
                                        (l.globals.seriesX[a][0] -
                                            l.globals.minX) /
                                            this.lineCtx.xRatio +
                                        l.config.markers.offsetX),
                                h.push(e),
                                c.push(
                                    N.isNumber(i[r][0])
                                        ? t + l.config.markers.offsetY
                                        : null
                                )),
                            h.push(s + l.config.markers.offsetX),
                            c.push(
                                N.isNumber(i[r][n + 1])
                                    ? o + l.config.markers.offsetY
                                    : null
                            ),
                            { x: h, y: c }
                        );
                    },
                },
                {
                    key: "checkPreviousPaths",
                    value: function (t) {
                        for (
                            var e = t.pathFromLine,
                                i = t.pathFromArea,
                                a = t.realIndex,
                                s = this.w,
                                o = 0;
                            o < s.globals.previousPaths.length;
                            o++
                        ) {
                            var r = s.globals.previousPaths[o];
                            ("line" === r.type || "area" === r.type) &&
                                0 < r.paths.length &&
                                parseInt(r.realIndex, 10) === parseInt(a, 10) &&
                                ("line" === r.type
                                    ? ((this.lineCtx.appendPathFrom = !1),
                                      (e =
                                          s.globals.previousPaths[o].paths[0]
                                              .d))
                                    : "area" === r.type &&
                                      ((this.lineCtx.appendPathFrom = !1),
                                      (i =
                                          s.globals.previousPaths[o].paths[0]
                                              .d),
                                      s.config.stroke.show) &&
                                      s.globals.previousPaths[o].paths[1] &&
                                      (e =
                                          s.globals.previousPaths[o].paths[1]
                                              .d));
                        }
                        return { pathFromLine: e, pathFromArea: i };
                    },
                },
                {
                    key: "determineFirstPrevY",
                    value: function (t) {
                        var e = t.i,
                            i = t.realIndex,
                            a = t.series,
                            s = t.prevY,
                            o = t.lineYPosition,
                            t = t.translationsIndex,
                            r = this.w,
                            i =
                                (r.config.chart.stacked &&
                                    !r.globals.comboCharts) ||
                                (r.config.chart.stacked &&
                                    r.globals.comboCharts &&
                                    (!this.w.config.chart.stackOnlyBar ||
                                        "bar" ===
                                            (null ==
                                            (r = this.w.config.series[i])
                                                ? void 0
                                                : r.type) ||
                                        "column" ===
                                            (null ==
                                            (r = this.w.config.series[i])
                                                ? void 0
                                                : r.type)));
                        if (void 0 !== (null == (r = a[e]) ? void 0 : r[0]))
                            s =
                                (o =
                                    i && 0 < e
                                        ? this.lineCtx.prevSeriesY[e - 1][0]
                                        : this.lineCtx.zeroY) -
                                a[e][0] / this.lineCtx.yRatio[t] +
                                2 *
                                    (this.lineCtx.isReversed
                                        ? a[e][0] / this.lineCtx.yRatio[t]
                                        : 0);
                        else if (i && 0 < e && void 0 === a[e][0])
                            for (var n = e - 1; 0 <= n; n--)
                                if (null !== a[n][0] && void 0 !== a[n][0]) {
                                    s = o = this.lineCtx.prevSeriesY[n][0];
                                    break;
                                }
                        return { prevY: s, lineYPosition: o };
                    },
                },
            ]),
            se);
    function se(t) {
        a(this, se), (this.w = t.w), (this.lineCtx = t);
    }
    function r() {
        return a(this, r), nt.apply(this, arguments);
    }
    function l(t) {
        a(this, l),
            ((e = lt.call(this, t)).ctx = t),
            (e.w = t.w),
            (e.animBeginArr = [0]),
            (e.animDur = 0);
        var e,
            t = e.w;
        return (
            (e.startAngle = t.config.plotOptions.radialBar.startAngle),
            (e.endAngle = t.config.plotOptions.radialBar.endAngle),
            (e.totalAngle = Math.abs(
                t.config.plotOptions.radialBar.endAngle -
                    t.config.plotOptions.radialBar.startAngle
            )),
            (e.trackStartAngle =
                t.config.plotOptions.radialBar.track.startAngle),
            (e.trackEndAngle = t.config.plotOptions.radialBar.track.endAngle),
            (e.barLabels = e.w.config.plotOptions.radialBar.barLabels),
            (e.donutDataLabels = e.w.config.plotOptions.radialBar.dataLabels),
            (e.radialDataLabels = e.donutDataLabels),
            e.trackStartAngle || (e.trackStartAngle = e.startAngle),
            e.trackEndAngle || (e.trackEndAngle = e.endAngle),
            360 === e.endAngle && (e.endAngle = 359.99),
            (e.margin = parseInt(
                t.config.plotOptions.radialBar.track.margin,
                10
            )),
            (e.onBarLabelClick = e.onBarLabelClick.bind(D(e))),
            e
        );
    }
    function oe(t) {
        a(this, oe),
            (this.ctx = t),
            (this.w = t.w),
            (this.chartType = this.w.config.chart.type),
            (this.initialAnim = this.w.config.chart.animations.enabled),
            (this.dynamicAnim =
                this.initialAnim &&
                this.w.config.chart.animations.dynamicAnimation.enabled),
            (this.animDur = 0);
        t = this.w;
        (this.graphics = new W(this.ctx)),
            (this.lineColorArr = (
                void 0 !== t.globals.stroke.colors
                    ? t.globals.stroke
                    : t.globals
            ).colors),
            (this.defaultSize =
                t.globals.svgHeight < t.globals.svgWidth
                    ? t.globals.gridHeight + 1.5 * t.globals.goldenPadding
                    : t.globals.gridWidth),
            (this.isLog = t.config.yaxis[0].logarithmic),
            (this.logBase = t.config.yaxis[0].logBase),
            (this.coreUtils = new X(this.ctx)),
            (this.maxValue = this.isLog
                ? this.coreUtils.getLogVal(this.logBase, t.globals.maxY, 0)
                : t.globals.maxY),
            (this.minValue = this.isLog
                ? this.coreUtils.getLogVal(this.logBase, this.w.globals.minY, 0)
                : t.globals.minY),
            (this.polygons = t.config.plotOptions.radar.polygons),
            (this.strokeWidth = t.config.stroke.show
                ? t.config.stroke.width
                : 0),
            (this.size =
                this.defaultSize / 2.1 -
                this.strokeWidth -
                t.config.chart.dropShadow.blur),
            t.config.xaxis.labels.show &&
                (this.size = this.size - t.globals.xAxisLabelsWidth / 1.75),
            void 0 !== t.config.plotOptions.radar.size &&
                (this.size = t.config.plotOptions.radar.size),
            (this.dataRadiusOfPercent = []),
            (this.dataRadius = []),
            (this.angleArr = []),
            (this.yaxisLabelsTextsPos = []);
    }
    function re(t) {
        a(this, re), (this.ctx = t), (this.w = t.w);
        var t = this.w,
            e =
                ((this.chartType = this.w.config.chart.type),
                (this.initialAnim = this.w.config.chart.animations.enabled),
                (this.dynamicAnim =
                    this.initialAnim &&
                    this.w.config.chart.animations.dynamicAnimation.enabled),
                (this.animBeginArr = [0]),
                (this.animDur = 0),
                (this.donutDataLabels =
                    this.w.config.plotOptions.pie.donut.labels),
                (this.lineColorArr = (
                    void 0 !== t.globals.stroke.colors
                        ? t.globals.stroke
                        : t.globals
                ).colors),
                (this.defaultSize = Math.min(
                    t.globals.gridWidth,
                    t.globals.gridHeight
                )),
                (this.centerY = this.defaultSize / 2),
                (this.centerX = t.globals.gridWidth / 2),
                "radialBar" === t.config.chart.type
                    ? (this.fullAngle = 360)
                    : (this.fullAngle = Math.abs(
                          t.config.plotOptions.pie.endAngle -
                              t.config.plotOptions.pie.startAngle
                      )),
                (this.initialAngle =
                    t.config.plotOptions.pie.startAngle % this.fullAngle),
                (t.globals.radialSize =
                    this.defaultSize / 2.05 -
                    t.config.stroke.width -
                    (t.config.chart.sparkline.enabled
                        ? 0
                        : t.config.chart.dropShadow.blur)),
                (this.donutSize =
                    (t.globals.radialSize *
                        parseInt(t.config.plotOptions.pie.donut.size, 10)) /
                    100),
                t.config.plotOptions.pie.customScale),
            i = t.globals.gridWidth / 2,
            t = t.globals.gridHeight / 2;
        (this.translateX = i - i * e),
            (this.translateY = t - t * e),
            (this.dataLabelsGroup = new W(this.ctx).group({
                class: "apexcharts-datalabels-group",
                transform: "translate("
                    .concat(this.translateX, ", ")
                    .concat(this.translateY, ") scale(")
                    .concat(e, ")"),
            })),
            (this.maxY = 0),
            (this.sliceLabels = []),
            (this.sliceSizes = []),
            (this.prevSectorAngleArr = []);
    }
    function ne(t) {
        a(this, ne), (this.ctx = t), (this.w = t.w);
    }
    function le(t, e) {
        a(this, le),
            (this.ctx = t),
            (this.w = t.w),
            (this.xRatio = e.xRatio),
            (this.yRatio = e.yRatio),
            (this.dynamicAnim =
                this.w.config.chart.animations.dynamicAnimation),
            (this.helpers = new $t(t)),
            (this.rectRadius = this.w.config.plotOptions.heatmap.radius),
            (this.strokeWidth = this.w.config.stroke.show
                ? this.w.config.stroke.width
                : 0);
    }
    function he(t) {
        a(this, he), (this.ctx = t), (this.w = t.w);
    }
    function h() {
        return a(this, h), ht.apply(this, arguments);
    }
    function c() {
        return a(this, c), ct.apply(this, arguments);
    }
    function ce(t, e) {
        a(this, ce), (this.ctx = t), (this.w = t.w);
        var t = this.w,
            t =
                ((this.barOptions = t.config.plotOptions.bar),
                (this.isHorizontal = this.barOptions.horizontal),
                (this.strokeWidth = t.config.stroke.width),
                (this.isNullValue = !1),
                (this.isRangeBar =
                    t.globals.seriesRange.length && this.isHorizontal),
                (this.isVerticalGroupedRangeBar =
                    !t.globals.isBarHorizontal &&
                    t.globals.seriesRange.length &&
                    t.config.plotOptions.bar.rangeBarGroupRows),
                (this.isFunnel = this.barOptions.isFunnel),
                (this.xyRatios = e),
                null !== this.xyRatios &&
                    ((this.xRatio = e.xRatio),
                    (this.yRatio = e.yRatio),
                    (this.invertedXRatio = e.invertedXRatio),
                    (this.invertedYRatio = e.invertedYRatio),
                    (this.baseLineY = e.baseLineY),
                    (this.baseLineInvertedY = e.baseLineInvertedY)),
                (this.yaxisIndex = 0),
                (this.translationsIndex = 0),
                (this.seriesLen = 0),
                (this.pathArr = []),
                new P(this.ctx)),
            i =
                ((this.lastActiveBarSerieIndex = t.getActiveConfigSeriesIndex(
                    "desc",
                    ["bar", "column"]
                )),
                (this.columnGroupIndices = []),
                t.getBarSeriesIndices()),
            e = new X(this.ctx);
        (this.stackedSeriesTotals = e.getStackedSeriesTotals(
            this.w.config.series
                .map(function (t, e) {
                    return -1 === i.indexOf(e) ? e : -1;
                })
                .filter(function (t) {
                    return -1 !== t;
                })
        )),
            (this.barHelpers = new Ut(this));
    }
    function de(t) {
        a(this, de), (this.w = t.w), (this.barCtx = t);
    }
    function ge(t) {
        a(this, ge),
            (this.w = t.w),
            (this.barCtx = t),
            (this.totalFormatter =
                this.w.config.plotOptions.bar.dataLabels.total.formatter),
            this.totalFormatter ||
                (this.totalFormatter = this.w.config.dataLabels.formatter);
    }
    function ue(t) {
        a(this, ue), (this.ctx = t), (this.w = t.w);
        t = this.w;
        (this.tConfig = t.config.tooltip),
            (this.tooltipUtil = new Ot(this)),
            (this.tooltipLabels = new Nt(this)),
            (this.tooltipPosition = new Wt(this)),
            (this.marker = new Bt(this)),
            (this.intersect = new Gt(this)),
            (this.axesTooltip = new Vt(this)),
            (this.showOnIntersect = this.tConfig.intersect),
            (this.showTooltipTitle = this.tConfig.x.show),
            (this.fixedTooltip = this.tConfig.fixed.enabled),
            (this.xaxisTooltip = null),
            (this.yaxisTTEls = null),
            (this.isBarShared =
                !t.globals.isBarHorizontal && this.tConfig.shared),
            (this.lastHoverTime = Date.now());
    }
    function pe(t) {
        a(this, pe), (this.w = t.w), (this.ttCtx = t);
    }
    function fe(t) {
        a(this, fe), (this.w = t.w);
        var e = this.w;
        (this.ttCtx = t),
            (this.isVerticalGroupedRangeBar =
                !e.globals.isBarHorizontal &&
                "rangeBar" === e.config.chart.type &&
                e.config.plotOptions.bar.rangeBarGroupRows);
    }
    function xe(t) {
        a(this, xe),
            (this.w = t.w),
            (this.ttCtx = t),
            (this.ctx = t.ctx),
            (this.tooltipPosition = new Wt(t));
    }
    function be(t) {
        a(this, be), (this.ttCtx = t), (this.ctx = t.ctx), (this.w = t.w);
    }
    function me(t) {
        a(this, me),
            (this.w = t.w),
            (this.ctx = t.ctx),
            (this.ttCtx = t),
            (this.tooltipUtil = new Ot(t));
    }
    function ve(t) {
        a(this, ve), (this.w = t.w), (this.ttCtx = t), (this.ctx = t.ctx);
    }
    function x(t) {
        var e;
        return (
            a(this, x),
            ((e = dt.call(this, t)).ctx = t),
            (e.w = t.w),
            (e.dragged = !1),
            (e.graphics = new W(e.ctx)),
            (e.eventList = [
                "mousedown",
                "mouseleave",
                "mousemove",
                "touchstart",
                "touchmove",
                "mouseup",
                "touchend",
            ]),
            (e.clientX = 0),
            (e.clientY = 0),
            (e.startX = 0),
            (e.endX = 0),
            (e.dragX = 0),
            (e.startY = 0),
            (e.endY = 0),
            (e.dragY = 0),
            (e.moveDirection = "none"),
            e
        );
    }
    function ye(t) {
        a(this, ye), (this.ctx = t), (this.w = t.w);
        t = this.w;
        (this.ev = this.w.config.chart.events),
            (this.selectedClass = "apexcharts-selected"),
            (this.localeValues = this.w.globals.locale.toolbar),
            (this.minX = t.globals.minX),
            (this.maxX = t.globals.maxX);
    }
    function we(t) {
        a(this, we),
            (this.ctx = t),
            (this.w = t.w),
            (this.onLegendClick = this.onLegendClick.bind(this)),
            (this.onLegendHovered = this.onLegendHovered.bind(this)),
            (this.isBarsDistributed =
                "bar" === this.w.config.chart.type &&
                this.w.config.plotOptions.bar.distributed &&
                1 === this.w.config.series.length),
            (this.legendHelpers = new Ft(this));
    }
    function ke(t) {
        a(this, ke), (this.w = t.w), (this.lgCtx = t);
    }
    function Ae(t) {
        a(this, Ae),
            (this.ctx = t),
            (this.w = t.w),
            (this.lgRect = {}),
            (this.yAxisWidth = 0),
            (this.yAxisWidthLeft = 0),
            (this.yAxisWidthRight = 0),
            (this.xAxisHeight = 0),
            (this.isSparkline = this.w.config.chart.sparkline.enabled),
            (this.dimHelpers = new Tt(this)),
            (this.dimYAxis = new Xt(this)),
            (this.dimXAxis = new zt(this)),
            (this.dimGrid = new Et(this)),
            (this.lgWidthForSideLegends = 0),
            (this.gridPad = this.w.config.grid.padding),
            (this.xPadRight = 0),
            (this.xPadLeft = 0);
    }
    function Se(t) {
        a(this, Se), (this.w = t.w), (this.dCtx = t);
    }
    function Ce(t) {
        a(this, Ce), (this.w = t.w), (this.dCtx = t);
    }
    function Le(t) {
        a(this, Le), (this.w = t.w), (this.dCtx = t);
    }
    function Pe(t) {
        a(this, Pe), (this.w = t.w), (this.dCtx = t);
    }
    function Me(t) {
        a(this, Me), (this.ctx = t), (this.w = t.w);
    }
    function Ie(t) {
        a(this, Ie), (this.ctx = t), (this.colors = []), (this.w = t.w);
        t = this.w;
        (this.isColorFn = !1),
            (this.isHeatmapDistributed =
                ("treemap" === t.config.chart.type &&
                    t.config.plotOptions.treemap.distributed) ||
                ("heatmap" === t.config.chart.type &&
                    t.config.plotOptions.heatmap.distributed)),
            (this.isBarDistributed =
                t.config.plotOptions.bar.distributed &&
                ("bar" === t.config.chart.type ||
                    "rangeBar" === t.config.chart.type));
    }
    function Te(t) {
        a(this, Te), (this.ctx = t), (this.w = t.w);
    }
    function ze(t) {
        a(this, ze), (this.ctx = t), (this.w = t.w);
    }
    function Xe(t) {
        a(this, Xe), (this.ctx = t), (this.w = t.w);
    }
    function Ee(t) {
        a(this, Ee), (this.ctx = t), (this.w = t.w);
    }
    function Ye(t) {
        a(this, Ye),
            (this.ctx = t),
            (this.w = t.w),
            (this.documentEvent = N.bind(this.documentEvent, this));
    }
    function Fe(t, e) {
        a(this, Fe), (this.ctx = t), (this.elgrid = e), (this.w = t.w);
        e = this.w;
        (this.xaxisFontSize = e.config.xaxis.labels.style.fontSize),
            (this.axisFontFamily = e.config.xaxis.labels.style.fontFamily),
            (this.xaxisForeColors = e.config.xaxis.labels.style.colors),
            (this.isCategoryBarHorizontal =
                "bar" === e.config.chart.type &&
                e.config.plotOptions.bar.horizontal),
            (this.xAxisoffX = 0),
            "bottom" === e.config.xaxis.position &&
                (this.xAxisoffX = e.globals.gridHeight),
            (this.drawnLabels = []),
            (this.axesUtils = new w(t));
    }
    function Re(t) {
        a(this, Re), (this.ctx = t), (this.w = t.w), (this.scales = new yt(t));
    }
    function He(t) {
        a(this, He), (this.ctx = t), (this.w = t.w);
    }
    function De(t) {
        a(this, De), (this.ctx = t), (this.w = t.w);
        var e = this.w;
        (this.xaxisLabels = e.globals.labels.slice()),
            (this.axesUtils = new w(t)),
            (this.isRangeBar =
                e.globals.seriesRange.length && e.globals.isBarHorizontal),
            0 < e.globals.timescaleLabels.length &&
                (this.xaxisLabels = e.globals.timescaleLabels.slice());
    }
    function Oe(t, e) {
        a(this, Oe), (this.ctx = t), (this.elgrid = e), (this.w = t.w);
        e = this.w;
        (this.axesUtils = new w(t)),
            (this.xaxisLabels = e.globals.labels.slice()),
            0 < e.globals.timescaleLabels.length &&
                !e.globals.isBarHorizontal &&
                (this.xaxisLabels = e.globals.timescaleLabels.slice()),
            e.config.xaxis.overwriteCategories &&
                (this.xaxisLabels = e.config.xaxis.overwriteCategories),
            (this.drawnLabels = []),
            (this.drawnLabelsRects = []),
            "top" === e.config.xaxis.position
                ? (this.offY = 0)
                : (this.offY = e.globals.gridHeight),
            (this.offY = this.offY + e.config.xaxis.axisBorder.offsetY),
            (this.isCategoryBarHorizontal =
                "bar" === e.config.chart.type &&
                e.config.plotOptions.bar.horizontal),
            (this.xaxisFontSize = e.config.xaxis.labels.style.fontSize),
            (this.xaxisFontFamily = e.config.xaxis.labels.style.fontFamily),
            (this.xaxisForeColors = e.config.xaxis.labels.style.colors),
            (this.xaxisBorderWidth = e.config.xaxis.axisBorder.width),
            this.isCategoryBarHorizontal &&
                (this.xaxisBorderWidth =
                    e.config.yaxis[0].axisBorder.width.toString()),
            -1 < this.xaxisBorderWidth.indexOf("%")
                ? (this.xaxisBorderWidth =
                      (e.globals.gridWidth *
                          parseInt(this.xaxisBorderWidth, 10)) /
                      100)
                : (this.xaxisBorderWidth = parseInt(this.xaxisBorderWidth, 10)),
            (this.xaxisBorderHeight = e.config.xaxis.axisBorder.height),
            (this.yaxis = e.config.yaxis[0]);
    }
    function Ne(t) {
        a(this, Ne), (this.ctx = t), (this.w = t.w);
    }
    function We(t) {
        a(this, We),
            (this.ctx = t),
            (this.w = t.w),
            (this.twoDSeries = []),
            (this.threeDSeries = []),
            (this.twoDSeriesX = []),
            (this.seriesGoals = []),
            (this.coreUtils = new X(this.ctx));
    }
    function Be(t) {
        a(this, Be),
            (this.ctx = t),
            (this.w = t.w),
            (this.legendInactiveClass = "legend-mouseover-inactive");
    }
    function Ge(t) {
        a(this, Ge), (this.ctx = t), (this.w = t.w);
    }
    function Ve(t) {
        a(this, Ve),
            (this.ctx = t),
            (this.w = t.w),
            (this.initialAnim = this.w.config.chart.animations.enabled);
    }
    function je(t, e) {
        a(this, je), (this.ctx = t), (this.w = t.w);
    }
    function _e(t) {
        a(this, _e),
            (this.ctx = t),
            (this.w = t.w),
            (this.opts = null),
            (this.seriesIndex = 0);
    }
    function Ue(t) {
        a(this, Ue), (this.opts = t);
    }
    function qe() {
        a(this, qe);
    }
    function Ze(t) {
        a(this, Ze), (this.opts = t);
    }
    function $e(t) {
        a(this, $e), (this.opts = t);
    }
    function Je(t) {
        a(this, Je),
            (this.ctx = t),
            (this.w = t.w),
            (this.graphics = new W(this.ctx)),
            this.w.globals.isBarHorizontal && (this.invertAxis = !0),
            (this.helpers = new s(this)),
            (this.xAxisAnnotations = new V(this)),
            (this.yAxisAnnotations = new j(this)),
            (this.pointsAnnotations = new _(this)),
            this.w.globals.isBarHorizontal &&
                this.w.config.yaxis[0].reversed &&
                (this.inversedReversedAxis = !0),
            (this.xDivision =
                this.w.globals.gridWidth / this.w.globals.dataPoints);
    }
    function Qe() {
        a(this, Qe),
            (this.yAxis = {
                show: !0,
                showAlways: !1,
                showForNullSeries: !0,
                seriesName: void 0,
                opposite: !1,
                reversed: !1,
                logarithmic: !1,
                logBase: 10,
                tickAmount: void 0,
                stepSize: void 0,
                forceNiceScale: !1,
                max: void 0,
                min: void 0,
                floating: !1,
                decimalsInFloat: void 0,
                labels: {
                    show: !0,
                    minWidth: 0,
                    maxWidth: 160,
                    offsetX: 0,
                    offsetY: 0,
                    align: void 0,
                    rotate: 0,
                    padding: 20,
                    style: {
                        colors: [],
                        fontSize: "11px",
                        fontWeight: 400,
                        fontFamily: void 0,
                        cssClass: "",
                    },
                    formatter: void 0,
                },
                axisBorder: {
                    show: !1,
                    color: "#e0e0e0",
                    width: 1,
                    offsetX: 0,
                    offsetY: 0,
                },
                axisTicks: {
                    show: !1,
                    color: "#e0e0e0",
                    width: 6,
                    offsetX: 0,
                    offsetY: 0,
                },
                title: {
                    text: void 0,
                    rotate: -90,
                    offsetY: 0,
                    offsetX: 0,
                    style: {
                        color: void 0,
                        fontSize: "11px",
                        fontWeight: 900,
                        fontFamily: void 0,
                        cssClass: "",
                    },
                },
                tooltip: { enabled: !1, offsetX: 0 },
                crosshairs: {
                    show: !0,
                    position: "front",
                    stroke: { color: "#b6b6b6", width: 1, dashArray: 0 },
                },
            }),
            (this.pointAnnotation = {
                id: void 0,
                x: 0,
                y: null,
                yAxisIndex: 0,
                seriesIndex: void 0,
                mouseEnter: void 0,
                mouseLeave: void 0,
                click: void 0,
                marker: {
                    size: 4,
                    fillColor: "#fff",
                    strokeWidth: 2,
                    strokeColor: "#333",
                    shape: "circle",
                    offsetX: 0,
                    offsetY: 0,
                    radius: 2,
                    cssClass: "",
                },
                label: {
                    borderColor: "#c2c2c2",
                    borderWidth: 1,
                    borderRadius: 2,
                    text: void 0,
                    textAnchor: "middle",
                    offsetX: 0,
                    offsetY: 0,
                    mouseEnter: void 0,
                    mouseLeave: void 0,
                    click: void 0,
                    style: {
                        background: "#fff",
                        color: void 0,
                        fontSize: "11px",
                        fontFamily: void 0,
                        fontWeight: 400,
                        cssClass: "",
                        padding: { left: 5, right: 5, top: 2, bottom: 2 },
                    },
                },
                customSVG: {
                    SVG: void 0,
                    cssClass: void 0,
                    offsetX: 0,
                    offsetY: 0,
                },
                image: {
                    path: void 0,
                    width: 20,
                    height: 20,
                    offsetX: 0,
                    offsetY: 0,
                },
            }),
            (this.yAxisAnnotation = {
                id: void 0,
                y: 0,
                y2: null,
                strokeDashArray: 1,
                fillColor: "#c2c2c2",
                borderColor: "#c2c2c2",
                borderWidth: 1,
                opacity: 0.3,
                offsetX: 0,
                offsetY: 0,
                width: "100%",
                yAxisIndex: 0,
                label: {
                    borderColor: "#c2c2c2",
                    borderWidth: 1,
                    borderRadius: 2,
                    text: void 0,
                    textAnchor: "end",
                    position: "right",
                    offsetX: 0,
                    offsetY: -3,
                    mouseEnter: void 0,
                    mouseLeave: void 0,
                    click: void 0,
                    style: {
                        background: "#fff",
                        color: void 0,
                        fontSize: "11px",
                        fontFamily: void 0,
                        fontWeight: 400,
                        cssClass: "",
                        padding: { left: 5, right: 5, top: 2, bottom: 2 },
                    },
                },
            }),
            (this.xAxisAnnotation = {
                id: void 0,
                x: 0,
                x2: null,
                strokeDashArray: 1,
                fillColor: "#c2c2c2",
                borderColor: "#c2c2c2",
                borderWidth: 1,
                opacity: 0.3,
                offsetX: 0,
                offsetY: 0,
                label: {
                    borderColor: "#c2c2c2",
                    borderWidth: 1,
                    borderRadius: 2,
                    text: void 0,
                    textAnchor: "middle",
                    orientation: "vertical",
                    position: "top",
                    offsetX: 0,
                    offsetY: 0,
                    mouseEnter: void 0,
                    mouseLeave: void 0,
                    click: void 0,
                    style: {
                        background: "#fff",
                        color: void 0,
                        fontSize: "11px",
                        fontFamily: void 0,
                        fontWeight: 400,
                        cssClass: "",
                        padding: { left: 5, right: 5, top: 2, bottom: 2 },
                    },
                },
            }),
            (this.text = {
                x: 0,
                y: 0,
                text: "",
                textAnchor: "start",
                foreColor: void 0,
                fontSize: "13px",
                fontFamily: void 0,
                fontWeight: 400,
                appendTo: ".apexcharts-annotations",
                backgroundColor: "transparent",
                borderColor: "#c2c2c2",
                borderRadius: 0,
                borderWidth: 0,
                paddingLeft: 4,
                paddingRight: 4,
                paddingTop: 2,
                paddingBottom: 2,
            });
    }
    function Ke(t, e) {
        return (e[1] - t[1]) / (e[0] - t[0]);
    }
    t(ei, [
        {
            key: "draw",
            value: function (t, e, i, a) {
                var s = this.w,
                    o = new W(this.ctx),
                    r = s.globals.comboCharts ? e : s.config.chart.type,
                    n = o.group({
                        class: "apexcharts-".concat(
                            r,
                            "-series apexcharts-plot-series"
                        ),
                    }),
                    e = new X(this.ctx, s);
                (this.yRatio = this.xyRatios.yRatio),
                    (this.zRatio = this.xyRatios.zRatio),
                    (this.xRatio = this.xyRatios.xRatio),
                    (this.baseLineY = this.xyRatios.baseLineY),
                    (t = e.getLogSeries(t)),
                    (this.yRatio = e.getLogYRatios(this.yRatio)),
                    (this.prevSeriesY = []);
                for (var l = [], h = 0; h < t.length; h++) {
                    t = this.lineHelpers.sameValueSeriesFix(h, t);
                    var c = s.globals.comboCharts ? i[h] : h,
                        d = 1 < this.yRatio.length ? c : 0,
                        g = (this._initSerieVariables(t, h, c), []),
                        u = [],
                        p = [],
                        f =
                            s.globals.padHorizontal +
                            this.categoryAxisCorrection;
                    this.ctx.series.addCollapsedClassToSeries(this.elSeries, c),
  s[a][
                                    r.globals.seriesXvalues[a].length -
                                        h.count -
                                        1
                                ]),
                            (e = n.drawRect(
                                t,
                                0,
                                r.globals.gridWidth,
                                r.globals.gridHeight,
                                0
                            )),
                            r.globals.dom.elForecastMask.appendChild(e.node),
                            (e = n.drawRect(0, 0, t, r.globals.gridHeight, 0)),
                            r.globals.dom.elNonForecastMask.appendChild(
                                e.node
                            )),
                        this.pointsChart ||
                            r.globals.delayedElements.push({
                                el: this.elPointsMain.node,
                                index: a,
                            }),
                        {
                            i: s,
                            realIndex: a,
                            animationDelay: s,
                            initialSpeed: r.config.chart.animations.speed,
                            dataChangeSpeed:
                                r.config.chart.animations.dynamicAnimation
                                    .speed,
                            className: "apexcharts-".concat(i),
                        });
                if ("area" === i)
                    for (
                        var d = l.fillPath({ seriesNumber: a }), g = 0;
                        g < o.areaPaths.length;
                        g++
                    ) {
                        var u = n.renderPaths(
                            z(
                                z({}, c),
                                {},
                                {
                                    pathFrom: o.pathFromArea,
                                    pathTo: o.areaPaths[g],
                                    stroke: "none",
                                    strokeWidth: 0,
                                    strokeLineCap: null,
                                    fill: d,
                                }
                            )
                        );
                        this.elSeries.add(u);
                    }
                if (r.config.stroke.show && !this.pointsChart) {
                    var p = null;
                    "line" === i
                        ? (p = l.fillPath({ seriesNumber: a, i: s }))
                        : "solid" === r.config.stroke.fill.type
                        ? (p = r.globals.stroke.colors[a])
                        : ((t = r.config.fill),
                          (r.config.fill = r.config.stroke.fill),
                          (p = l.fillPath({ seriesNumber: a, i: s })),
                          (r.config.fill = t));
                    for (var f = 0; f < o.linePaths.length; f++) {
                        var x = p,
                            x =
                                ("rangeArea" === i &&
                                    (x = l.fillPath({ seriesNumber: a })),
                                z(
                                    z({}, c),
                                    {},
                                    {
                                        pathFrom: o.pathFromLine,
                                        pathTo: o.linePaths[f],
                                        stroke: p,
                                        strokeWidth: this.strokeWidth,
                                        strokeLineCap: r.config.stroke.lineCap,
                                        fill: "rangeArea" === i ? x : "none",
                                    }
                                )),
                            b = n.renderPaths(x);
                        this.elSeries.add(b),
                            b.attr("fill-rule", "evenodd"),
                            0 < h.count &&
                                "rangeArea" !== i &&
                                ((x = n.renderPaths(x)).node.setAttribute(
                                    "stroke-dasharray",
                                    h.dashArray
                                ),
                                h.strokeWidth &&
                                    x.node.setAttribute(
                                        "stroke-width",
                                        h.strokeWidth
                                    ),
                                this.elSeries.add(x),
                                x.attr(
                                    "clip-path",
                                    "url(#forecastMask".concat(
                                        r.globals.cuid,
                                        ")"
                                    )
                                ),
                                b.attr(
                                    "clip-path",
                                    "url(#nonForecastMask".concat(
                                        r.globals.cuid,
                                        ")"
                                    )
                                ));
                    }
                }
            },
        },
        {
            key: "_iterateOverDataPoints",
            value: function (t) {
                function e(t, e) {
                    return e - t / C[n] + 2 * (i.isReversed ? t / C[n] : 0);
                }
                var i = this,
                    a = t.type,
                    s = t.series,
                    o = t.iterations,
                    r = t.realIndex,
                    n = t.translationsIndex,
                    l = t.i,
                    h = t.x,
                    c = t.y,
                    d = t.pX,
                    g = t.pY,
                    u = t.pathsFrom,
                    p = t.linePaths,
                    f = t.areaPaths,
                    x = t.seriesIndex,
                    b = t.lineYPosition,
                    m = t.xArrj,
                    v = t.yArrj,
                    y = t.y2Arrj,
                    w = t.isRangeStart,
                    k = t.seriesRangeEnd,
                    A = this.w,
                    S = new W(this.ctx),
                    C = this.yRatio,
                    L = u.prevY,
                    P = u.linePath,
                    M = u.areaPath,
                    I = u.pathFromLine,
                    T = u.pathFromArea,
                    R = N.isNumber(A.globals.minYArr[r])
                        ? A.globals.minYArr[r]
                        : A.globals.minY,
                    o =
                        o ||
                        (1 < A.globals.dataPoints
                            ? A.globals.dataPoints - 1
                            : A.globals.dataPoints),
                    z = c,
                    H =
                        (A.config.chart.stacked && !A.globals.comboCharts) ||
                        (A.config.chart.stacked &&
                            A.globals.comboCharts &&
                            (!this.w.config.chart.stackOnlyBar ||
                                "bar" ===
                                    (null == (t = this.w.config.series[r])
                                        ? void 0
                                        : t.type) ||
                                "column" ===
                                    (null == (u = this.w.config.series[r])
                                        ? void 0
                                        : u.type))),
                    X = A.config.stroke.curve;
                Array.isArray(X) && (X = Array.isArray(x) ? X[x[l]] : X[l]);
                for (var D = 0, E = 0; E < o; E++) {
                    var Y = void 0 === s[l][E + 1] || null === s[l][E + 1],
                        F =
                            (A.globals.isXNumeric
                                ? ((F = A.globals.seriesX[r][E + 1]),
                                  (h =
                                      ((F =
                                          void 0 === A.globals.seriesX[r][E + 1]
                                              ? A.globals.seriesX[r][o - 1]
                                              : F) -
                                          A.globals.minX) /
                                      this.xRatio))
                                : (h += this.xDivision),
                            (b =
                                H &&
                                0 < l &&
                                A.globals.collapsedSeries.length <
                                    A.config.series.length - 1
                                    ? this.prevSeriesY[
                                          (function () {
                                              for (var t = l - 1; 0 < t; t--) {
                                                  if (
                                                      !(
                                                          -1 <
                                                          A.globals.collapsedSeriesIndices.indexOf(
                                                              (null == x
                                                                  ? void 0
                                                                  : x[t]) || t
                                                          )
                                                      )
                                                  )
                                                      return t;
                                                  t--;
                                              }
                                              return 0;
                                          })()
                                      ][E + 1]
                                    : this.zeroY),
                            Y
                                ? (c = e(R, b))
                                : ((c = e(s[l][E + 1], b)),
                                  "rangeArea" === a && (z = e(k[l][E + 1], b))),
                            m.push(h),
                            !Y ||
                            ("smooth" !== A.config.stroke.curve &&
                                "monotoneCubic" !== A.config.stroke.curve)
                                ? (v.push(c), y.push(z))
                                : (v.push(null), y.push(null)),
                            this.lineHelpers.calculatePoints({
                                series: s,
                                x: h,
                                y: c,
                                realIndex: r,
                                i: l,
                                j: E,
                                prevY: L,
                            })),
                        Y = this._createPaths({
                            type: a,
                            series: s,
                            i: l,
                            realIndex: r,
                            j: E,
                            x: h,
                            y: c,
                            y2: z,
                            xArrj: m,
                            yArrj: v,
                            y2Arrj: y,
                            pX: d,
                            pY: g,
                            pathState: D,
                            segmentStartX: O,
                            linePath: P,
                            areaPath: M,
                            linePaths: p,
                            areaPaths: f,
                            curve: X,
                            isRangeStart: w,
                        }),
                        f = Y.areaPaths,
                        p = Y.linePaths,
                        d = Y.pX,
                        g = Y.pY,
                        D = Y.pathState,
                        O = Y.segmentStartX,
                        M = Y.areaPath,
                        P = Y.linePath;
                    !this.appendPathFrom ||
                        ("monotoneCubic" === X && "rangeArea" === a) ||
                        ((I += S.line(h, this.zeroY)),
                        (T += S.line(h, this.zeroY))),
                        this.handleNullDataPoints(s, F, l, E, r),
                        this._handleMarkersAndLabels({
                            type: a,
                            pointsPos: F,
                            i: l,
                            j: E,
                            realIndex: r,
                            isRangeStart: w,
                        });
                }
                return {
                    yArrj: v,
                    xArrj: m,
                    pathFromArea: T,
                    areaPaths: f,
                    pathFromLine: I,
                    linePaths: p,
                    linePath: P,
                    areaPath: M,
                };
            },
        },
        {
            key: "_handleMarkersAndLabels",
            value: function (t) {
                var e = t.type,
                    i = t.pointsPos,
                    a = t.isRangeStart,
                    s = t.i,
                    o = t.j,
                    t = t.realIndex,
                    r = this.w,
                    n = new L(this.ctx),
                    s =
                        (this.pointsChart
                            ? this.scatter.draw(this.elSeries, o, {
                                  realIndex: t,
                                  pointsPos: i,
                                  zRatio: this.zRatio,
                                  elParent: this.elPointsMain,
                              })
                            : (1 < r.globals.series[s].length &&
                                  this.elPointsMain.node.classList.add(
                                      "apexcharts-element-hidden"
                                  ),
                              null !==
                                  (r = this.markers.plotChartMarkers(
                                      i,
                                      t,
                                      o + 1
                                  )) && this.elPointsMain.add(r)),
                        n.drawDataLabel({
                            type: e,
                            isRangeStart: a,
                            pos: i,
                            i: t,
                            j: o + 1,
                        }));
                null !== s && this.elDataLabelsWrap.add(s);
            },
        },
        {
            key: "_createPaths",
            value: function (t) {
                var e = t.type,
                    i = t.series,
                    a = t.i,
                    s = (t.realIndex, t.j),
                    o = t.x,
                    r = t.y,
                    n = t.xArrj,
                    R = t.yArrj,
                    l = t.y2,
                    h = t.y2Arrj,
                    c = t.pX,
                    d = t.pY,
                    g = t.pathState,
                    u = t.segmentStartX,
                    p = t.linePath,
                    f = t.areaPath,
                    x = t.linePaths,
                    b = t.areaPaths,
                    m = t.curve,
                    v = t.isRangeStart;
                this.w;
                var y,
                    w = new W(this.ctx),
                    k = this.areaBottomY,
                    A = "rangeArea" === e,
                    S = "rangeArea" === e && v;
                switch (m) {
                    case "monotoneCubic":
                        var C = v ? R : h;
                        switch (g) {
                            case 0:
                                if (null === C[s + 1]) break;
                                g = 1;
                            case 1:
                                if (
                                    !(A
                                        ? n.length === i[a].length
                                        : s === i[a].length - 2)
                                )
                                    break;
                            case 2:
                                var L = v ? n : n.slice().reverse(),
                                    P = v ? C : C.slice().reverse(),
                                    M =
                                        ((y = P),
                                        L.map(function (t, e) {
                                            return [t, y[e]];
                                        }).filter(function (t) {
                                            return null !== t[1];
                                        })),
                                    L = 1 < M.length ? rt(M) : M,
                                    I = [],
                                    T =
                                        (A && (S ? (b = M) : (I = b.reverse())),
                                        0),
                                    z = 0;
                                (function (t, e) {
                                    (i = []),
                                        (a = 0),
                                        t.forEach(function (t) {
                                            null !== t
                                                ? a++
                                                : 0 < a && (i.push(a), (a = 0));
                                        }),
                                        0 < a && i.push(a);
                                    for (
                                        var i, a, s = i, o = [], r = 0, n = 0;
                                        r < s.length;
                                        n += s[r++]
                                    )
                                        o[r] = (function (t, e, i) {
                                            t = t.slice(e, i);
                                            return (
                                                e &&
                                                    (1 < i - e &&
                                                        t[1].length < 6 &&
                                                        ((i = t[0].length),
                                                        (t[1] = [
                                                            2 * t[0][i - 2] -
                                                                t[0][i - 4],
                                                            2 * t[0][i - 1] -
                                                                t[0][i - 3],
                                                        ].concat(t[1]))),
                                                    (t[0] = t[0].slice(-2))),
                                                t
                                            );
                                        })(e, n, n + s[r]);
                                    return o;
                                })(P, L).forEach(function (t) {
                                    T++;
                                    var e = (function (t) {
                                            for (
                                                var e = "", i = 0;
                                                i < t.length;
                                                i++
                                            ) {
                                                var a = t[i],
                                                    s = a.length;
                                                4 < s
                                                    ? (e =
                                                          (e =
                                                              (e += "C"
                                                                  .concat(
                                                                      a[0],
                                                                      ", "
                                                                  )
                                                                  .concat(
                                                                      a[1]
                                                                  )) +
                                                              ", "
                                                                  .concat(
                                                                      a[2],
                                                                      ", "
                                                                  )
                                                                  .concat(
                                                                      a[3]
                                                                  )) +
                                                          ", "
                                                              .concat(
                                                                  a[4],
                                                                  ", "
                                                              )
                                                              .concat(a[5]))
                                                    : 2 < s &&
                                                      (e =
                                                          (e += "S"
                                                              .concat(
                                                                  a[0],
                                                                  ", "
                                                              )
                                                              .concat(a[1])) +
                                                          ", "
                                                              .concat(
                                                                  a[2],
                                                                  ", "
                                                              )
                                                              .concat(a[3]));
                                            }
                                            return e;
                                        })(t),
                                        i = z,
                                        t = (z += t.length) - 1;
                                    S
                                        ? (p = w.move(M[i][0], M[i][1]) + e)
                                        : A
                                        ? (p =
                                              w.move(I[i][0], I[i][1]) +
                                              w.line(M[i][0], M[i][1]) +
                                              e +
                                              w.line(I[t][0], I[t][1]))
                                        : ((p = w.move(M[i][0], M[i][1]) + e),
                                          (f =
                                              p +
                                              w.line(M[t][0], k) +
                                              w.line(M[i][0], k) +
                                              "z"),
                                          b.push(f)),
                                        x.push(p);
                                }),
                                    A &&
                                        1 < T &&
                                        !S &&
                                        ((P = x.slice(T).reverse()),
                                        x.splice(T),
                                        P.forEach(function (t) {
                                            return x.push(t);
                                        })),
                                    (g = 0);
                        }
                        break;
                    case "smooth":
                        var X = 0.35 * (o - c);
                        if (null === i[a][s]) g = 0;
                        else
                            switch (g) {
                                case 0:
                                    if (
                                        ((u = c),
                                        (p = S
                                            ? w.move(c, h[s]) + w.line(c, d)
                                            : w.move(c, d)),
                                        (f = w.move(c, d)),
                                        (g = 1),
                                        s < i[a].length - 2)
                                    ) {
                                        var E = w.curve(
                                            c + X,
                                            d,
                                            o - X,
                                            r,
                                            o,
                                            r
                                        );
                                        (p += E), (f += E);
                                        break;
                                    }
                                case 1:
                                    null === i[a][s + 1]
                                        ? ((p += S
                                              ? w.line(c, l)
                                              : w.move(c, d)),
                                          (f +=
                                              w.line(c, k) +
                                              w.line(u, k) +
                                              "z"),
                                          x.push(p),
                                          b.push(f),
                                          (g = -1))
                                        : ((E = w.curve(
                                              c + X,
                                              d,
                                              o - X,
                                              r,
                                              o,
                                              r
                                          )),
                                          (p += E),
                                          (f += E),
                                          s >= i[a].length - 2 &&
                                              (S &&
                                                  (p +=
                                                      w.curve(
                                                          o,
                                                          r,
                                                          o,
                                                          r,
                                                          o,
                                                          l
                                                      ) + w.move(o, l)),
                                              (f +=
                                                  w.curve(o, r, o, r, o, k) +
                                                  w.line(u, k) +
                                                  "z"),
                                              x.push(p),
                                              b.push(f),
                                              (g = -1)));
                            }
                        (c = o), (d = r);
                        break;
                    default:
                        var Y = function (t, e, i) {
                            var a = [];
                            switch (t) {
                                case "stepline":
                                    a =
                                        w.line(e, null, "H") +
                                        w.line(null, i, "V");
                                    break;
                                case "linestep":
                                    a =
                                        w.line(null, i, "V") +
                                        w.line(e, null, "H");
                                    break;
                                case "straight":
                                    a = w.line(e, i);
                            }
                            return a;
                        };
                        if (null === i[a][s]) g = 0;
                        else
                            switch (g) {
                                case 0:
                                    if (
                                        ((u = c),
                                        (p = S
                                            ? w.move(c, h[s]) + w.line(c, d)
                                            : w.move(c, d)),
                                        (f = w.move(c, d)),
                                        (g = 1),
                                        s < i[a].length - 2)
                                    ) {
                                        var F = Y(m, o, r);
                                        (p += F), (f += F);
                                        break;
                                    }
                                case 1:
                                    null === i[a][s + 1]
                                        ? ((p += S
                                              ? w.line(c, l)
                                              : w.move(c, d)),
                                          (f +=
                                              w.line(c, k) +
                                              w.line(u, k) +
                                              "z"),
                                          x.push(p),
                                          b.push(f),
                                          (g = -1))
                                        : ((F = Y(m, o, r)),
                                          (p += F),
                                          (f += F),
                                          s >= i[a].length - 2 &&
                                              (S && (p += w.line(o, l)),
                                              (f +=
                                                  w.line(o, k) +
                                                  w.line(u, k) +
                                                  "z"),
                                              x.push(p),
                                              b.push(f),
                                              (g = -1)));
                            }
                        (c = o), (d = r);
                }
                return {
                    linePaths: x,
                    areaPaths: b,
                    pX: c,
                    pY: d,
                    pathState: g,
                    segmentStartX: u,
                    linePath: p,
                    areaPath: f,
                };
            },
        },
        {
            key: "handleNullDataPoints",
            value: function (t, e, i, a, s) {
                var o = this.w;
                ((null === t[i][a] && o.config.markers.showNullDataPoints) ||
                    1 === t[i].length) &&
                    ((t = this.strokeWidth - o.config.markers.strokeWidth / 2),
                    null !==
                        (i = this.markers.plotChartMarkers(
                            e,
                            s,
                            a + 1,
                            (t = 0 < t ? t : 0),
                            !0
                        ))) &&
                    this.elPointsMain.add(i);
            },
        },
    ]);
    var ti = ei;
    function ei(t, e, i) {
        a(this, ei),
            (this.ctx = t),
            (this.w = t.w),
            (this.xyRatios = e),
            (this.pointsChart =
                !(
                    "bubble" !== this.w.config.chart.type &&
                    "scatter" !== this.w.config.chart.type
                ) || i),
            (this.scatter = new xt(this.ctx)),
            (this.noNegatives = this.w.globals.minX === Number.MAX_VALUE),
            (this.lineHelpers = new ae(this)),
            (this.markers = new k(this.ctx)),
            (this.prevSeriesY = []),
            (this.categoryAxisCorrection = 0),
            (this.yaxisIndex = 0);
    }
    function ii(t, e, i, a) {
        (this.xoffset = t),
            (this.yoffset = e),
            (this.height = a),
            (this.width = i),
            (this.shortestEdge = function () {
                return Math.min(this.height, this.width);
            }),
            (this.getCoordinates = function (t) {
                var e,
                    i = [],
                    a = this.xoffset,
                    s = this.yoffset,
                    o = b(t) / this.height,
                    r = b(t) / this.width;
                if (this.width >= this.height)
                    for (e = 0; e < t.length; e++)
                        i.push([a, s, a + o, s + t[e] / o]), (s += t[e] / o);
                else
                    for (e = 0; e < t.length; e++)
                        i.push([a, s, a + t[e] / r, s + r]), (a += t[e] / r);
                return i;
            }),
            (this.cutArea = function (t) {
                var e, i;
                return this.width >= this.height
                    ? ((e = t / this.height),
                      (i = this.width - e),
                      new ii(this.xoffset + e, this.yoffset, i, this.height))
                    : ((e = t / this.width),
                      (i = this.height - e),
                      new ii(this.xoffset, this.yoffset + e, this.width, i));
            });
    }
    function ai(t, s, o, e, i) {
        (e = void 0 === e ? 0 : e), (i = void 0 === i ? 0 : i);
        for (
            var a,
                r = (function t(e, i, a, s) {
                    var o, r;
                    if (0 !== e.length)
                        return (
                            (r = a.shortestEdge()),
                            (function (t, e, i) {
                                var a;
                                if (0 === t.length) return 1;
                                (a = t.slice()).push(e);
                                (e = si(t, i)), (t = si(a, i));
                                return t <= e;
                            })(i, (o = e[0]), r)
                                ? (i.push(o), t(e.slice(1), i, a, s))
                                : ((r = a.cutArea(b(i), s)),
                                  s.push(a.getCoordinates(i)),
                                  t(e, [], r, s)),
                            s
                        );
                    s.push(a.getCoordinates(i));
                })(
                    (function (t) {
                        for (
                            var e = [], i = (s * o) / b(t), a = 0;
                            a < t.length;
                            a++
                        )
                            e[a] = t[a] * i;
                        return e;
                    })(t),
                    [],
                    new ii(e, i, s, o),
                    []
                ),
                n = [],
                l = 0;
            l < r.length;
            l++
        )
            for (a = 0; a < r[l].length; a++) n.push(r[l][a]);
        return n;
    }
    function si(t, e) {
        var i = Math.min.apply(Math, t),
            a = Math.max.apply(Math, t),
            t = b(t);
        return Math.max(
            (Math.pow(e, 2) * a) / Math.pow(t, 2),
            Math.pow(t, 2) / (Math.pow(e, 2) * i)
        );
    }
    function oi(t) {
        return t && t.constructor === Array;
    }
    function b(t) {
        for (var e = 0, i = 0; i < t.length; i++) e += t[i];
        return e;
    }
    (window.TreemapSquared = {}),
        (window.TreemapSquared.generate = function t(e, i, a, s, o) {
            (s = void 0 === s ? 0 : s), (o = void 0 === o ? 0 : o);
            var r,
                n,
                l = [],
                h = [];
            if (oi(e[0])) {
                for (n = 0; n < e.length; n++)
                    l[n] = (function t(e) {
                        var i,
                            a = 0;
                        if (oi(e[0]))
                            for (i = 0; i < e.length; i++) a += t(e[i]);
                        else a = b(e);
                        return a;
                    })(e[n]);
                for (r = ai(l, i, a, s, o), n = 0; n < e.length; n++)
                    h.push(
                        t(
                            e[n],
                            r[n][2] - r[n][0],
                            r[n][3] - r[n][1],
                            r[n][0],
                            r[n][1]
                        )
                    );
            } else h = ai(e, i, a, s, o);
            return h;
        });
    t(ui, [
        {
            key: "draw",
            value: function (u) {
                var e,
                    p = this,
                    f = this.w,
                    x = new W(this.ctx),
                    b = new C(this.ctx),
                    i = x.group({ class: "apexcharts-treemap" });
                return (
                    f.globals.noData ||
                        ((e = []),
                        u.forEach(function (t) {
                            t = t.map(function (t) {
                                return Math.abs(t);
                            });
                            e.push(t);
                        }),
                        (this.negRange = this.helpers.checkColorRange()),
                        f.config.series.forEach(function (t, e) {
                            t.data.forEach(function (t) {
                                Array.isArray(p.labels[e]) ||
                                    (p.labels[e] = []),
                                    p.labels[e].push(t.x);
                            });
                        }),
                        window.TreemapSquared.generate(
                            e,
                            f.globals.gridWidth,
                            f.globals.gridHeight
                        ).forEach(function (t, d) {
                            var g = x.group({
                                    class: "apexcharts-series apexcharts-treemap-series",
                                    seriesName: N.escapeString(
                                        f.globals.seriesNames[d]
                                    ),
                                    rel: d + 1,
                                    "data:realIndex": d,
                                }),
                                e =
                                    (f.config.chart.dropShadow.enabled &&
                                        ((e = f.config.chart.dropShadow),
                                        new I(p.ctx).dropShadow(i, e, d)),
                                    x.group({
                                        class: "apexcharts-data-labels",
                                    }));
                            t.forEach(function (t, e) {
                                var i = t[0],
                                    a = t[1],
                                    s = t[2],
                                    o = t[3],
                                    r = x.drawRect(
                                        i,
                                        a,
                                        s - i,
                                        o - a,
                                        f.config.plotOptions.treemap
                                            .borderRadius,
                                        "#fff",
                                        1,
                                        p.strokeWidth,
                                        f.config.plotOptions.treemap
                                            .useFillColorAsStroke
                                            ? l
                                            : f.globals.stroke.colors[d]
                                    ),
                                    n =
                                        (r.attr({
                                            cx: i,
                                            cy: a,
                                            index: d,
                                            i: d,
                                            j: e,
                                            width: s - i,
                                            height: o - a,
                                        }),
                                        p.helpers.getShadeColor(
                                            f.config.chart.type,
                                            d,
                                            e,
                                            p.negRange
                                        )),
                                    l = n.color,
                                    l =
                                        (void 0 !==
                                            f.config.series[d].data[e] &&
                                            f.config.series[d].data[e]
                                                .fillColor &&
                                            (l =
                                                f.config.series[d].data[e]
                                                    .fillColor),
                                        b.fillPath({
                                            color: l,
                                            seriesNumber: d,
                                            dataPointIndex: e,
                                        })),
                                    l =
                                        (r.node.classList.add(
                                            "apexcharts-treemap-rect"
                                        ),
                                        r.attr({ fill: l }),
                                        p.helpers.addListeners(r),
                                        {
                                            x: i + (s - i) / 2,
                                            y: a + (o - a) / 2,
                                            width: 0,
                                            height: 0,
                                        }),
                                    h = {
                                        x: i,
                                        y: a,
                                        width: s - i,
                                        height: o - a,
                                    },
                                    l =
                                        (f.config.chart.animations.enabled &&
                                            !f.globals.dataChanged &&
                                            ((c = 1),
                                            f.globals.resized ||
                                                (c =
                                                    f.config.chart.animations
                                                        .speed),
                                            p.animateTreemap(r, l, h, c)),
                                        f.globals.dataChanged &&
                                            ((c = 1), p.dynamicAnim.enabled) &&
                                            f.globals.shouldAnimate &&
                                            ((c = p.dynamicAnim.speed),
                                            f.globals.previousPaths[d] &&
                                                f.globals.previousPaths[d][e] &&
                                                f.globals.previousPaths[d][e]
                                                    .rect &&
                                                (l =
                                                    f.globals.previousPaths[d][
                                                        e
                                                    ].rect),
                                            p.animateTreemap(r, l, h, c)),
                                        p.getFontSize(t)),
                                    h = f.config.dataLabels.formatter(
                                        p.labels[d][e],
                                        {
                                            value: f.globals.series[d][e],
                                            seriesIndex: d,
                                            dataPointIndex: e,
                                            w: f,
                                        }
                                    ),
                                    c =
                                        ("truncate" ===
                                            f.config.plotOptions.treemap
                                                .dataLabels.format &&
                                            ((l = parseInt(
                                                f.config.dataLabels.style
                                                    .fontSize,
                                                10
                                            )),
                                            (h = p.truncateLabels(
                                                h,
                                                l,
                                                i,
                                                a,
                                                s,
                                                o
                                            ))),
                                        p.helpers.calculateDataLabels({
                                            text: h,
                                            x: (i + s) / 2,
                                            y:
                                                (a + o) / 2 +
                                                p.strokeWidth / 2 +
                                                l / 3,
                                            i: d,
                                            j: e,
                                            colorProps: n,
                                            fontSize: l,
                                            series: u,
                                        }));
                                f.config.dataLabels.enabled &&
                                    c &&
                                    p.rotateToFitLabel(c, l, h, i, a, s, o),
                                    g.add(r),
                                    null !== c && g.add(c);
                            }),
                                g.add(e),
                                i.add(g);
                        })),
                    i
                );
            },
        },
        {
            key: "getFontSize",
            value: function (t) {
                var e = this.w,
                    i =
                        (function t(e) {
                            var i,
                                a = 0;
                            if (Array.isArray(e[0]))
                                for (i = 0; i < e.length; i++) a += t(e[i]);
                            else
                                for (i = 0; i < e.length; i++) a += e[i].length;
                            return a;
                        })(this.labels) /
                        (function t(e) {
                            var i,
                                a = 0;
                            if (Array.isArray(e[0]))
                                for (i = 0; i < e.length; i++) a += t(e[i]);
                            else for (i = 0; i < e.length; i++) a += 1;
                            return a;
                        })(this.labels),
                    a = t[2] - t[0],
                    t = t[3] - t[1],
                    a = Math.pow(a * t, 0.5);
                return Math.min(
                    a / i,
                    parseInt(e.config.dataLabels.style.fontSize, 10)
                );
            },
        },
        {
            key: "rotateToFitLabel",
            value: function (t, e, i, a, s, o, r) {
                var n = new W(this.ctx),
                    i = n.getTextRects(i, e);
                i.width + this.w.config.stroke.width + 5 > o - a &&
                    i.width <= r - s &&
                    ((e = n.rotateAroundCenter(t.node)),
                    t.node.setAttribute(
                        "transform",
                        "rotate(-90 "
                            .concat(e.x, " ")
                            .concat(e.y, ") translate(")
                            .concat(i.height / 3, ")")
                    ));
            },
        },
        {
            key: "truncateLabels",
            value: function (t, e, i, a, s, o) {
                var r = new W(this.ctx),
                    o =
                        r.getTextRects(t, e).width +
                            this.w.config.stroke.width +
                            5 >
                            s - i && s - i < o - a
                            ? o - a
                            : s - i,
                    a = r.getTextBasedOnMaxWidth({
                        text: t,
                        maxWidth: o,
                        fontSize: e,
                    });
                return t.length !== a.length && o / e < 5 ? "" : a;
            },
        },
        {
            key: "animateTreemap",
            value: function (t, e, i, a) {
                var s = new A(this.ctx);
                s.animateRect(
                    t,
                    { x: e.x, y: e.y, width: e.width, height: e.height },
                    { x: i.x, y: i.y, width: i.width, height: i.height },
                    a,
                    function () {
                        s.animationCompleted(t);
                    }
                );
            },
        },
    ]);
    var m,
        M,
        ri = ui,
        ni =
            (t(gi, [
                {
                    key: "calculateTimeScaleTicks",
                    value: function (t, e) {
                        var r = this,
                            n = this.w;
                        if (n.globals.allSeriesCollapsed)
                            return (
                                (n.globals.labels = []),
                                (n.globals.timescaleLabels = []),
                                []
                            );
                        var i = new y(this.ctx),
                            a = (e - t) / 864e5,
                            i =
                                (this.determineInterval(a),
                                (n.globals.disableZoomIn = !1),
                                (n.globals.disableZoomOut = !1),
                                a < 10 / 86400
                                    ? (n.globals.disableZoomIn = !0)
                                    : 5e4 < a &&
                                      (n.globals.disableZoomOut = !0),
                                i.getTimeUnitsfromTimestamp(t, e, this.utc)),
                            t = n.globals.gridWidth / a,
                            e = t / 24,
                            s = e / 60,
                            o = s / 60,
                            l = Math.floor(24 * a),
                            h = Math.floor(1440 * a),
                            c = Math.floor(86400 * a),
                            d = Math.floor(a),
                            g = Math.floor(a / 30),
                            a = Math.floor(a / 365),
                            i = {
                                minMillisecond: i.minMillisecond,
                                minSecond: i.minSecond,
                                minMinute: i.minMinute,
                                minHour: i.minHour,
                                minDate: i.minDate,
                                minMonth: i.minMonth,
                                minYear: i.minYear,
                            },
                            u = {
                                firstVal: i,
                                currentMillisecond: i.minMillisecond,
                                currentSecond: i.minSecond,
                                currentMinute: i.minMinute,
                                currentHour: i.minHour,
                                currentMonthDate: i.minDate,
                                currentDate: i.minDate,
                                currentMonth: i.minMonth,
                                currentYear: i.minYear,
                                daysWidthOnXAxis: t,
                                hoursWidthOnXAxis: e,
                                minutesWidthOnXAxis: s,
                                secondsWidthOnXAxis: o,
                                numberOfSeconds: c,
                                numberOfMinutes: h,
                                numberOfHours: l,
                                numberOfDays: d,
                                numberOfMonths: g,
                                numberOfYears: a,
                            };
                        switch (this.tickInterval) {
                            case "years":
                                this.generateYearScale(u);
                                break;
                            case "months":
                            case "half_year":
                                this.generateMonthScale(u);
                                break;
                            case "months_days":
                            case "months_fortnight":
                            case "days":
                            case "week_days":
                                this.generateDayScale(u);
                                break;
                            case "hours":
                                this.generateHourScale(u);
                                break;
                            case "minutes_fives":
                            case "minutes":
                                this.generateMinuteScale(u);
                                break;
                            case "seconds_tens":
                            case "seconds_fives":
                            case "seconds":
                                this.generateSecondScale(u);
                        }
                        var p = this.timeScaleArray.map(function (t) {
                            var e = {
                                position: t.position,
                                unit: t.unit,
                                year: t.year,
                                day: t.day || 1,
                                hour: t.hour || 0,
                                month: t.month + 1,
                            };
                            return "month" === t.unit
                                ? z(
                                      z({}, e),
                                      {},
                                      { day: 1, value: t.value + 1 }
                                  )
                                : "day" === t.unit || "hour" === t.unit
                                ? z(z({}, e), {}, { value: t.value })
                                : "minute" === t.unit
                                ? z(
                                      z({}, e),
                                      {},
                                      { value: t.value, minute: t.value }
                                  )
                                : "second" === t.unit
                                ? z(
                                      z({}, e),
                                      {},
                                      {
                                          value: t.value,
                                          minute: t.minute,
                                          second: t.second,
                                      }
                                  )
                                : t;
                        });
                        return p.filter(function (t) {
                            var e = 1,
                                i = Math.ceil(n.globals.gridWidth / 120),
                                a = t.value,
                                s =
                                    (void 0 !== n.config.xaxis.tickAmount &&
                                        (i = n.config.xaxis.tickAmount),
                                    p.length > i &&
                                        (e = Math.floor(p.length / i)),
                                    !1),
                                o = !1;
                            switch (r.tickInterval) {
                                case "years":
                                    "year" === t.unit && (s = !0);
                                    break;
                                case "half_year":
                                    (e = 7), "year" === t.unit && (s = !0);
                                    break;
                                case "months":
                                    (e = 1), "year" === t.unit && (s = !0);
                                    break;
                                case "months_fortnight":
                                    (e = 15),
                                        ("year" !== t.unit &&
                                            "month" !== t.unit) ||
                                            (s = !0),
                                        30 === a && (o = !0);
                                    break;
                                case "months_days":
    art.animations.dynamicAnimation),
            (this.labels = []);
    }
    function E(t) {
        (this.el = t).remember("_selectHandler", this),
            (this.pointSelection = { isSelected: !1 }),
            (this.rectSelection = { isSelected: !1 }),
            (this.pointsList = {
                lt: [0, 0],
                rt: ["width", 0],
                rb: ["width", "height"],
                lb: [0, "height"],
                t: ["width", 0],
                r: ["width", "height"],
                b: ["width", "height"],
                l: [0, "height"],
            }),
            (this.pointCoord = function (t, e, i) {
                e = "string" != typeof t ? t : e[t];
                return i ? e / 2 : e;
            }),
            (this.pointCoords = function (t, e) {
                var i = this.pointsList[t];
                return {
                    x: this.pointCoord(i[0], e, "t" === t || "b" === t),
                    y: this.pointCoord(i[1], e, "r" === t || "l" === t),
                };
            });
    }
    function pi(t) {
        switch (t[0]) {
            case "z":
            case "Z":
                (t[0] = "L"), (t[1] = this.start[0]), (t[2] = this.start[1]);
                break;
            case "H":
                (t[0] = "L"), (t[2] = this.pos[1]);
                break;
            case "V":
                (t[0] = "L"), (t[2] = t[1]), (t[1] = this.pos[0]);
                break;
            case "T":
                (t[0] = "Q"),
                    (t[3] = t[1]),
                    (t[4] = t[2]),
                    (t[1] = this.reflection[1]),
                    (t[2] = this.reflection[0]);
                break;
            case "S":
                (t[0] = "C"),
                    (t[6] = t[4]),
                    (t[5] = t[3]),
                    (t[4] = t[2]),
                    (t[3] = t[1]),
                    (t[2] = this.reflection[1]),
                    (t[1] = this.reflection[0]);
        }
        return t;
    }
    function fi(t) {
        var e = t.length;
        return (
            (this.pos = [t[e - 2], t[e - 1]]),
            -1 != "SCQT".indexOf(t[0]) &&
                (this.reflection = [
                    2 * this.pos[0] - t[e - 4],
                    2 * this.pos[1] - t[e - 3],
                ]),
            t
        );
    }
    function xi(t) {
        var e = [t];
        switch (t[0]) {
            case "M":
                return (this.pos = this.start = [t[1], t[2]]), e;
            case "L":
                (t[5] = t[3] = t[1]),
                    (t[6] = t[4] = t[2]),
                    (t[1] = this.pos[0]),
                    (t[2] = this.pos[1]);
                break;
            case "Q":
                (t[6] = t[4]),
                    (t[5] = t[3]),
                    (t[4] = +t[4] / 3 + (2 * t[2]) / 3),
                    (t[3] = +t[3] / 3 + (2 * t[1]) / 3),
                    (t[2] = +this.pos[1] / 3 + (2 * t[2]) / 3),
                    (t[1] = +this.pos[0] / 3 + (2 * t[1]) / 3);
                break;
            case "A":
                t = (e = (function (t, e) {
                    var i,
                        a,
                        s,
                        o,
                        r,
                        n,
                        l,
                        h,
                        c,
                        d,
                        g,
                        u,
                        p,
                        f,
                        x,
                        b,
                        m,
                        v,
                        y,
                        w = Math.abs(e[1]),
                        k = Math.abs(e[2]),
                        A = e[3] % 360,
                        S = e[4],
                        C = e[5],
                        L = e[6],
                        P = e[7],
                        e = new SVG.Point(t),
                        t = new SVG.Point(L, P),
                        M = [];
                    if (0 === w || 0 === k || (e.x === t.x && e.y === t.y))
                        return [["C", e.x, e.y, t.x, t.y, t.x, t.y]];
                    for (
                        1 <
                            (r =
                                ((r = new SVG.Point(
                                    (e.x - t.x) / 2,
                                    (e.y - t.y) / 2
                                ).transform(new SVG.Matrix().rotate(A))).x *
                                    r.x) /
                                    (w * w) +
                                (r.y * r.y) / (k * k)) &&
                            ((w *= r = Math.sqrt(r)), (k *= r)),
                            i = new SVG.Matrix()
                                .rotate(A)
                                .scale(1 / w, 1 / k)
                                .rotate(-A),
                            e = e.transform(i),
                            s =
                                (r = [
                                    (t = t.transform(i)).x - e.x,
                                    t.y - e.y,
                                ])[0] *
                                    r[0] +
                                r[1] * r[1],
                            o = Math.sqrt(s),
                            r[0] /= o,
                            r[1] /= o,
                            o = s < 4 ? Math.sqrt(1 - s / 4) : 0,
                            S === C && (o *= -1),
                            a = new SVG.Point(
                                (t.x + e.x) / 2 + o * -r[1],
                                (t.y + e.y) / 2 + o * r[0]
                            ),
                            s = new SVG.Point(e.x - a.x, e.y - a.y),
                            S = new SVG.Point(t.x - a.x, t.y - a.y),
                            o = Math.acos(
                                s.x / Math.sqrt(s.x * s.x + s.y * s.y)
                            ),
                            s.y < 0 && (o *= -1),
                            r = Math.acos(
                                S.x / Math.sqrt(S.x * S.x + S.y * S.y)
                            ),
                            S.y < 0 && (r *= -1),
                            C && r < o && (r += 2 * Math.PI),
                            !C && o < r && (r -= 2 * Math.PI),
                            c = [],
                            n =
                                (r - (d = o)) /
                                (l = Math.ceil(
                                    (2 * Math.abs(o - r)) / Math.PI
                                )),
                            h = (4 * Math.tan(n / 4)) / 3,
                            f = 0;
                        f <= l;
                        f++
                    )
                        (u = Math.cos(d)),
                            (g = Math.sin(d)),
                            (p = new SVG.Point(a.x + u, a.y + g)),
                            (c[f] = [
                                new SVG.Point(p.x + h * g, p.y - h * u),
                                p,
                                new SVG.Point(p.x - h * g, p.y + h * u),
                            ]),
                            (d += n);
                    for (
                        c[0][0] = c[0][1].clone(),
                            c[c.length - 1][2] = c[c.length - 1][1].clone(),
                            i = new SVG.Matrix()
                                .rotate(A)
                                .scale(w, k)
                                .rotate(-A),
                            f = 0,
                            x = c.length;
                        f < x;
                        f++
                    )
                        (c[f][0] = c[f][0].transform(i)),
                            (c[f][1] = c[f][1].transform(i)),
                            (c[f][2] = c[f][2].transform(i));
                    for (f = 1, x = c.length; f < x; f++)
                        (b = (p = c[f - 1][2]).x),
                            (m = p.y),
                            (v = (p = c[f][0]).x),
                            (y = p.y),
                            (L = (p = c[f][1]).x),
                            (P = p.y),
                            M.push(["C", b, m, v, y, L, P]);
                    return M;
                })(this.pos, t))[0];
        }
        return (
            (t[0] = "C"),
            (this.pos = [t[5], t[6]]),
            (this.reflection = [2 * t[5] - t[3], 2 * t[6] - t[4]]),
            e
        );
    }
    function bi(t, e) {
        if (!1 !== e)
            for (var i = e, a = t.length; i < a; ++i)
                if ("M" == t[i][0]) return i;
        return !1;
    }
    (m = "undefined" != typeof window ? window : void 0),
        (M = function (s, o) {
            var h = ((void 0 !== this ? this : s).SVG = function (t) {
                if (h.supported)
                    return (t = new h.Doc(t)), h.parser.draw || h.prepare(), t;
            });
            if (
                ((h.ns = "http://www.w3.org/2000/svg"),
                (h.xmlns = "http://www.w3.org/2000/xmlns/"),
                (h.xlink = "http://www.w3.org/1999/xlink"),
                (h.svgjs = "http://svgjs.dev"),
                (h.supported = !0),
                !h.supported)
            )
                return !1;
            (h.did = 1e3),
                (h.eid = function (t) {
                    return "Svgjs" + n(t) + h.did++;
                }),
                (h.create = function (t) {
                    var e = o.createElementNS(this.ns, t);
                    return e.setAttribute("id", this.eid(t)), e;
                }),
                (h.extend = function () {
                    for (
                        var t,
                            e = (t = [].slice.call(arguments)).pop(),
                            i = t.length - 1;
                        0 <= i;
                        i--
                    )
                        if (t[i]) for (var a in e) t[i].prototype[a] = e[a];
                    h.Set && h.Set.inherit && h.Set.inherit();
                }),
                (h.invent = function (t) {
                    var e =
                        "function" == typeof t.create
                            ? t.create
                            : function () {
                                  this.constructor.call(
                                      this,
                                      h.create(t.create)
                                  );
                              };
                    return (
                        t.inherit && (e.prototype = new t.inherit()),
                        t.extend && h.extend(e, t.extend),
                        t.construct &&
                            h.extend(t.parent || h.Container, t.construct),
                        e
                    );
                }),
                (h.adopt = function (t) {
                    return t
                        ? t.instance ||
                              (((e =
                                  "svg" == t.nodeName
                                      ? new (t.parentNode instanceof
                                        s.SVGElement
                                            ? h.Nested
                                            : h.Doc)()
                                      : "linearGradient" == t.nodeName
                                      ? new h.Gradient("linear")
                                      : "radialGradient" == t.nodeName
                                      ? new h.Gradient("radial")
                                      : h[n(t.nodeName)]
                                      ? new h[n(t.nodeName)]()
                                      : new h.Element(t)).type = t.nodeName),
                              ((e.node = t).instance = e) instanceof h.Doc &&
                                  e.namespace().defs(),
                              e.setData(
                                  JSON.parse(t.getAttribute("svgjs:data")) || {}
                              ),
                              e)
                        : null;
                    var e;
                }),
                (h.prepare = function () {
                    var t = o.getElementsByTagName("body")[0],
                        e = (
                            t
                                ? new h.Doc(t)
                                : h.adopt(o.documentElement).nested()
                        ).size(2, 0);
                    h.parser = {
                        body: t || o.documentElement,
                        draw: e.style(
                            "opacity:0;position:absolute;left:-100%;top:-100%;overflow:hidden"
                        ).node,
                        poly: e.polyline().node,
                        path: e.path().node,
                        native: h.create("svg"),
                    };
                }),
                (h.parser = { native: h.create("svg") }),
                o.addEventListener(
                    "DOMContentLoaded",
                    function () {
                        h.parser.draw || h.prepare();
                    },
                    !1
                ),
                (h.regex = {
                    numberAndUnit:
                        /^([+-]?(\d+(\.\d*)?|\.\d+)(e[+-]?\d+)?)([a-z%]*)$/i,
                    hex: /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,
                    rgb: /rgb\((\d+),(\d+),(\d+)\)/,
                    reference: /#([a-z0-9\-_]+)/i,
                    transforms: /\)\s*,?\s*/,
                    whitespace: /\s/g,
                    isHex: /^#[a-f0-9]{3,6}$/i,
                    isRgb: /^rgb\(/,
                    isCss: /[^:]+:[^;]+;?/,
                    isBlank: /^(\s+)?$/,
                    isNumber: /^[+-]?(\d+(\.\d*)?|\.\d+)(e[+-]?\d+)?$/i,
                    isPercent: /^-?[\d\.]+%$/,
                    isImage: /\.(jpg|jpeg|png|gif|svg)(\?[^=]+.*)?/i,
                    delimiter: /[\s,]+/,
                    hyphen: /([^e])\-/gi,
                    pathLetters: /[MLHVCSQTAZ]/gi,
                    isPathLetter: /[MLHVCSQTAZ]/i,
                    numbersWithDots:
                        /((\d?\.\d+(?:e[+-]?\d+)?)((?:\.\d+(?:e[+-]?\d+)?)+))+/gi,
                    dots: /\./g,
                }),
                (h.utils = {
                    map: function (t, e) {
                        for (var i = t.length, a = [], s = 0; s < i; s++)
                            a.push(e(t[s]));
                        return a;
                    },
                    filter: function (t, e) {
                        for (var i = t.length, a = [], s = 0; s < i; s++)
                            e(t[s]) && a.push(t[s]);
                        return a;
                    },
                    filterSVGElements: function (t) {
                        return this.filter(t, function (t) {
                            return t instanceof s.SVGElement;
                        });
                    },
                }),
                (h.defaults = {
                    attrs: {
                        "fill-opacity": 1,
                        "stroke-opacity": 1,
                        "stroke-width": 0,
                        "stroke-linejoin": "miter",
                        "stroke-linecap": "butt",
                        fill: "#000000",
                        stroke: "#000000",
                        opacity: 1,
                        x: 0,
                        y: 0,
                        cx: 0,
                        cy: 0,
                        width: 0,
                        height: 0,
                        r: 0,
                        rx: 0,
                        ry: 0,
                        offset: 0,
                        "stop-opacity": 1,
                        "stop-color": "#000000",
                        "font-size": 16,
                        "font-family": "Helvetica, Arial, sans-serif",
                        "text-anchor": "start",
                    },
                }),
                (h.Color = function (t) {
                    var e, i;
                    (this.r = 0),
                        (this.g = 0),
                        (this.b = 0),
                        t &&
                            ("string" == typeof t
                                ? h.regex.isRgb.test(t)
                                    ? ((e = h.regex.rgb.exec(
                                          t.replace(h.regex.whitespace, "")
                                      )),
                                      (this.r = parseInt(e[1])),
                                      (this.g = parseInt(e[2])),
                                      (this.b = parseInt(e[3])))
                                    : h.regex.isHex.test(t) &&
                                      ((e = h.regex.hex.exec(
                                          4 == (i = t).length
                                              ? [
                                                    "#",
                                                    i.substring(1, 2),
                                                    i.substring(1, 2),
                                                    i.substring(2, 3),
                                                    i.substring(2, 3),
                                                    i.substring(3, 4),
                                                    i.substring(3, 4),
                                                ].join("")
                                              : i
                                      )),
                                      (this.r = parseInt(e[1], 16)),
                                      (this.g = parseInt(e[2], 16)),
                                      (this.b = parseInt(e[3], 16)))
                                : "object" === v(t) &&
                                  ((this.r = t.r),
                                  (this.g = t.g),
                                  (this.b = t.b)));
                }),
                h.extend(h.Color, {
                    toString: function () {
                        return this.toHex();
                    },
                    toHex: function () {
                        return "#" + d(this.r) + d(this.g) + d(this.b);
                    },
                    toRgb: function () {
                        return "rgb(" + [this.r, this.g, this.b].join() + ")";
                    },
                    brightness: function () {
                        return (
                            (this.r / 255) * 0.3 +
                            (this.g / 255) * 0.59 +
                            (this.b / 255) * 0.11
                        );
                    },
                    morph: function (t) {
                        return (this.destination = new h.Color(t)), this;
                    },
                    at: function (t) {
                        return this.destination
                            ? new h.Color({
                                  r: ~~(
                                      this.r +
                                      (this.destination.r - this.r) *
                                          (t = t < 0 ? 0 : 1 < t ? 1 : t)
                                  ),
                                  g: ~~(
                                      this.g +
                                      (this.destination.g - this.g) * t
                                  ),
                                  b: ~~(
                                      this.b +
                                      (this.destination.b - this.b) * t
                                  ),
                              })
                            : this;
                    },
                }),
                (h.Color.test = function (t) {
                    return (
                        h.regex.isHex.test((t += "")) || h.regex.isRgb.test(t)
                    );
                }),
                (h.Color.isRgb = function (t) {
                    return (
                        t &&
                        "number" == typeof t.r &&
                        "number" == typeof t.g &&
                        "number" == typeof t.b
                    );
                }),
                (h.Color.isColor = function (t) {
                    return h.Color.isRgb(t) || h.Color.test(t);
                }),
                (h.Array = function (t, e) {
                    0 == (t = (t || []).valueOf()).length &&
                        e &&
                        (t = e.valueOf()),
                        (this.value = this.parse(t));
                }),
                h.extend(h.Array, {
                    toString: function () {
                        return this.value.join(" ");
                    },
                    valueOf: function () {
                        return this.value;
                    },
                    parse: function (t) {
                        return (
                            (t = t.valueOf()),
                            Array.isArray(t) ? t : this.split(t)
                        );
                    },
                }),
                (h.PointArray = function (t, e) {
                    h.Array.call(this, t, e || [[0, 0]]);
                }),
                (h.PointArray.prototype = new h.Array()),
                (h.PointArray.prototype.constructor = h.PointArray);
            for (
                var l = {
                        M: function (t, e, i) {
                            return (
                                (e.x = i.x = t[0]),
                                (e.y = i.y = t[1]),
                                ["M", e.x, e.y]
                            );
                        },
                        L: function (t, e) {
                            return (
                                (e.x = t[0]), (e.y = t[1]), ["L", t[0], t[1]]
                            );
                        },
                        H: function (t, e) {
                            return (e.x = t[0]), ["H", t[0]];
                        },
                        V: function (t, e) {
                            return (e.y = t[0]), ["V", t[0]];
                        },
                        C: function (t, e) {
                            return (
                                (e.x = t[4]),
                                (e.y = t[5]),
                                ["C", t[0], t[1], t[2], t[3], t[4], t[5]]
                            );
                        },
                        Q: function (t, e) {
                            return (
                                (e.x = t[2]),
                                (e.y = t[3]),
                                ["Q", t[0], t[1], t[2], t[3]]
                            );
                        },
                        S: function (t, e) {
                            return (
                                (e.x = t[2]),
                                (e.y = t[3]),
                                ["S", t[0], t[1], t[2], t[3]]
                            );
                        },
                        Z: function (t, e, i) {
                            return (e.x = i.x), (e.y = i.y), ["Z"];
                        },
                    },
                    t = "mlhvqtcsaz".split(""),
                    e = 0,
                    i = t.length;
                e < i;
                ++e
            )
                l[t[e]] = (function (o) {
                    return function (t, e, i) {
                        if ("H" == o) t[0] = t[0] + e.x;
                        else if ("V" == o) t[0] = t[0] + e.y;
                        else if ("A" == o)
                            (t[5] = t[5] + e.x), (t[6] = t[6] + e.y);
                        else
                            for (var a = 0, s = t.length; a < s; ++a)
                                t[a] = t[a] + (a % 2 ? e.y : e.x);
                        if (l && "function" == typeof l[o])
                            return l[o](t, e, i);
                    };
                })(t[e].toUpperCase());
            (h.PathArray = function (t, e) {
                h.Array.call(this, t, e || [["M", 0, 0]]);
            }),
                (h.PathArray.prototype = new h.Array()),
                (h.PathArray.prototype.constructor = h.PathArray),
                h.extend(h.PathArray, {
                    toString: function () {
                        for (
                            var t = this.value, e = 0, i = t.length, a = "";
                            e < i;
                            e++
                        )
                            (a += t[e][0]),
                                null != t[e][1] &&
                                    ((a += t[e][1]), null != t[e][2]) &&
                                    ((a = a + " " + t[e][2]),
                                    null != t[e][3]) &&
                                    ((a =
                                        (a = a + " " + t[e][3]) +
                                        " " +
                                        t[e][4]),
                                    null != t[e][5]) &&
                                    ((a =
                                        (a = a + " " + t[e][5]) +
                                        " " +
                                        t[e][6]),
                                    null != t[e][7]) &&
                                    (a = a + " " + t[e][7]);
                        return a + " ";
                    },
                    move: function (t, e) {
                        var i = this.bbox();
                        return i.x, i.y, this;
                    },
                    at: function (t) {
                        if (!this.destination) return this;
                        for (
                            var e = this.value,
                                i = this.destination.value,
                                a = [],
                                s = new h.PathArray(),
                                o = 0,
                                r = e.length;
                            o < r;
                            o++
                        ) {
                            a[o] = [e[o][0]];
                            for (var n = 1, l = e[o].length; n < l; n++)
                                a[o][n] = e[o][n] + (i[o][n] - e[o][n]) * t;
                            "A" === a[o][0] &&
                                ((a[o][4] = +(0 != a[o][4])),
                                (a[o][5] = +(0 != a[o][5])));
                        }
                        return (s.value = a), s;
                    },
                    parse: function (t) {
                        if (t instanceof h.PathArray) return t.valueOf();
                        for (
                            var e,
                                i = {
                                    M: 2,
                                    L: 2,
                                    H: 1,
                                    V: 1,
                                    C: 6,
                                    S: 4,
                                    Q: 4,
                                    T: 2,
                                    A: 7,
                                    Z: 0,
                                },
                                a =
                                    ((t =
                                        "string" == typeof t
                                            ? t
                                                  .replace(
                                                      h.regex.numbersWithDots,
                                                      c
                                                  )
                                                  .replace(
                                                      h.regex.pathLetters,
                                                      " $& "
                                                  )
                                                  .replace(
                                                      h.regex.hyphen,
                                                      "$1 -"
                                                  )
                                                  .trim()
                                                  .split(h.regex.delimiter)
                                            : t.reduce(function (t, e) {
                                                  return [].concat.call(t, e);
                                              }, [])),
                                    []),
                                s = new h.Point(),
                                o = new h.Point(),
                                r = 0,
                                n = t.length;
                            h.regex.isPathLetter.test(t[r])
                                ? ((e = t[r]), ++r)
                                : "M" == e
                                ? (e = "L")
                                : "m" == e && (e = "l"),
                                a.push(
                                    l[e].call(
                                        null,
                                        t
                                            .slice(r, (r += i[e.toUpperCase()]))
                                            .map(parseFloat),
                                        s,
                                        o
                                    )
                                ),
                                r < n;

                        );
                        return a;
                    },
                    bbox: function () {
                        return (
                            h.parser.draw || h.prepare(),
                            h.parser.path.setAttribute("d", this.toString()),
                            h.parser.path.getBBox()
                        );
                    },
                }),
                (h.Number = h.invent({
                    create: function (t, e) {
                        (this.value = 0),
                            (this.unit = e || ""),
                            "number" == typeof t
                                ? (this.value = isNaN(t)
                                      ? 0
                                      : isFinite(t)
                                      ? t
                                      : t < 0
                                      ? -34e37
                                      : 34e37)
                                : "string" == typeof t
                                ? (e = t.match(h.regex.numberAndUnit)) &&
                                  ((this.value = parseFloat(e[1])),
                                  "%" == e[5]
                                      ? (this.value /= 100)
                                      : "s" == e[5] && (this.value *= 1e3),
                                  (this.unit = e[5]))
                                : t instanceof h.Number &&
                                  ((this.value = t.valueOf()),
                                  (this.unit = t.unit));
                    },
                    extend: {
                        toString: function () {
                            return (
                                ("%" == this.unit
                                    ? ~~(1e8 * this.value) / 1e6
                                    : "s" == this.unit
                                    ? this.value / 1e3
                                    : this.value) + this.unit
                            );
                        },
                        toJSON: function () {
                            return this.toString();
                        },
                        valueOf: function () {
                            return this.value;
                        },
                        plus: function (t) {
                            return (
                                (t = new h.Number(t)),
                                new h.Number(this + t, this.unit || t.unit)
                            );
                        },
                        minus: function (t) {
                            return (
                                (t = new h.Number(t)),
                                new h.Number(this - t, this.unit || t.unit)
                            );
                        },
                        times: function (t) {
                            return (
                                (t = new h.Number(t)),
                                new h.Number(this * t, this.unit || t.unit)
                            );
                        },
                        divide: function (t) {
                            return (
                                (t = new h.Number(t)),
                                new h.Number(this / t, this.unit || t.unit)
                            );
                        },
                        to: function (t) {
                            var e = new h.Number(this);
                            return "string" == typeof t && (e.unit = t), e;
                        },
                        morph: function (t) {
                            return (
                                (this.destination = new h.Number(t)),
                                t.relative &&
                                    (this.destination.value += this.value),
                                this
                            );
                        },
                        at: function (t) {
                            return this.destination
                                ? new h.Number(this.destination)
                                      .minus(this)
                                      .times(t)
                                      .plus(this)
                                : this;
                        },
                    },
                })),
                (h.Element = h.invent({
                    create: function (t) {
                        (this._stroke = h.defaults.attrs.stroke),
                            (this._event = null),
                            (this.dom = {}),
                            (this.node = t) &&
                                ((this.type = t.nodeName),
                                ((this.node.instance = this)._stroke =
                                    t.getAttribute("stroke") || this._stroke));
                    },
                    extend: {
                        x: function (t) {
                            return this.attr("x", t);
                        },
                        y: function (t) {
                            return this.attr("y", t);
                        },
                        cx: function (t) {
                            return null == t
                                ? this.x() + this.width() / 2
                                : this.x(t - this.width() / 2);
                        },
                        cy: function (t) {
                            return null == t
                                ? this.y() + this.height() / 2
                                : this.y(t - this.height() / 2);
                        },
                        move: function (t, e) {
                            return this.x(t).y(e);
                        },
                        center: function (t, e) {
                            return this.cx(t).cy(e);
                        },
                        width: function (t) {
                            return this.attr("width", t);
                        },
                        height: function (t) {
                            return this.attr("height", t);
                        },
                        size: function (t, e) {
                            t = g(this, t, e);
                            return this.width(new h.Number(t.width)).height(
                                new h.Number(t.height)
                            );
                        },
                        clone: function (t) {
                            this.writeDataToDom();
                            var e = f(this.node.cloneNode(!0));
                            return t ? t.add(e) : this.after(e), e;
                        },
                        remove: function () {
                            return (
                                this.parent() &&
                                    this.parent().removeElement(this),
                                this
                            );
                        },
                        replace: function (t) {
                            return this.after(t).remove(), t;
                        },
                        addTo: function (t) {
                            return t.put(this);
                        },
                        putIn: function (t) {
                            return t.add(this);
                        },
                        id: function (t) {
                            return this.attr("id", t);
                        },
                        show: function () {
                            return this.style("display", "");
                        },
                        hide: function () {
                            return this.style("display", "none");
                        },
                        visible: function () {
                            return "none" != this.style("display");
                        },
                        toString: function () {
                            return this.attr("id");
                        },
                        classes: function () {
                            var t = this.attr("class");
                            return null == t
                                ? []
                                : t.trim().split(h.regex.delimiter);
                        },
                        hasClass: function (t) {
                            return -1 != this.classes().indexOf(t);
                        },
                        addClass: function (t) {
                            var e;
                            return (
                                this.hasClass(t) ||
                                    ((e = this.classes()).push(t),
                                    this.attr("class", e.join(" "))),
                                this
                            );
                        },
                        removeClass: function (e) {
                            return (
                                this.hasClass(e) &&
                                    this.attr(
                                        "class",
                                        this.classes()
                                            .filter(function (t) {
                                                return t != e;
                                            })
                                            .join(" ")
                                    ),
                                this
                            );
                        },
                        toggleClass: function (t) {
                            return this.hasClass(t)
                                ? this.removeClass(t)
                                : this.addClass(t);
                        },
                        reference: function (t) {
                            return h.get(this.attr(t));
                        },
                        parent: function (t) {
                            var e = this;
                            if (!e.node.parentNode) return null;
                            if (((e = h.adopt(e.node.parentNode)), !t))
                                return e;
                            for (; e && e.node instanceof s.SVGElement; ) {
                                if (
                                    "string" == typeof t
                                        ? e.matches(t)
                                        : e instanceof t
                                )
                                    return e;
                                if (
                                    !e.node.parentNode ||
                                    "#document" == e.node.parentNode.nodeName
                                )
                                    return null;
                                e = h.adopt(e.node.parentNode);
                            }
                        },
                        doc: function () {
                            return this instanceof h.Doc
                                ? this
                                : this.parent(h.Doc);
                        },
                        parents: function (t) {
                            for (
                                var e = [], i = this;
                                (i = i.parent(t)) &&
                                i.node &&
                                (e.push(i), i.parent);

                            );
                            return e;
                        },
                        matches: function (t) {
                            return (
                                (e = this.node).matches ||
                                e.matchesSelector ||
                                e.msMatchesSelector ||
                                e.mozMatchesSelector ||
                                e.webkitMatchesSelector ||
                                e.oMatchesSelector
                            ).call(e, t);
                            var e;
                        },
                        native: function () {
                            return this.node;
                        },
                        svg: function (t) {
                            var e = o.createElementNS(
                                "http://www.w3.org/2000/svg",
                                "svg"
                            );
                            if (!(t && this instanceof h.Parent))
                                return (
                                    e.appendChild(
                                        (t = o.createElementNS(
                                            "http://www.w3.org/2000/svg",
                                            "svg"
                                        ))
                                    ),
                                    this.writeDataToDom(),
                                    t.appendChild(this.node.cloneNode(!0)),
                                    e.innerHTML
                                        .replace(/^<svg>/, "")
                                        .replace(/<\/svg>$/, "")
                                );
                            e.innerHTML =
                                "<svg>" +
                                t
                                    .replace(/\n/, "")
                                    .replace(
                                        /<([\w:-]+)([^<]+?)\/>/g,
                                        "<$1$2></$1>"
                                    ) +
                                "</svg>";
                            for (
                                var i = 0, a = e.firstChild.childNodes.length;
                                i < a;
                                i++
                            )
                                this.node.appendChild(e.firstChild.firstChild);
                            return this;
                        },
                        writeDataToDom: function () {
                            return (
                                (this.each || this.lines) &&
                                    (this.each ? this : this.lines()).each(
                                        function () {
                                            this.writeDataToDom();
                                        }
                                    ),
                                this.node.removeAttribute("svgjs:data"),
                                Object.keys(this.dom).length &&
                                    this.node.setAttribute(
                                        "svgjs:data",
                                        JSON.stringify(this.dom)
                                    ),
                                this
                            );
                        },
                        setData: function (t) {
                            return (this.dom = t), this;
                        },
                        is: function (t) {
                            return this instanceof t;
                        },
                    },
                })),
                (h.easing = {
                    "-": function (t) {
                        return t;
                    },
                    "<>": function (t) {
                        return -Math.cos(t * Math.PI) / 2 + 0.5;
                    },
                    ">": function (t) {
                        return Math.sin((t * Math.PI) / 2);
                    },
                    "<": function (t) {
                        return 1 - Math.cos((t * Math.PI) / 2);
                    },
                }),
                (h.morph = function (i) {
                    return function (t, e) {
                        return new h.MorphObj(t, e).at(i);
                    };
                }),
                (h.Situation = h.invent({
                    create: function (t) {
                        (this.init = !1),
                            (this.reversed = !1),
                            (this.reversing = !1),
                            (this.duration = new h.Number(
                                t.duration
                            ).valueOf()),
                            (this.delay = new h.Number(t.delay).valueOf()),
                            (this.start = +new Date() + this.delay),
                            (this.finish = this.start + this.duration),
                            (this.ease = t.ease),
                            (this.loop = 0),
                            (this.loops = !1),
                            (this.animations = {}),
                            (this.attrs = {}),
                            (this.styles = {}),
                            (this.transforms = []),
                            (this.once = {});
                    },
                })),
                (h.FX = h.invent({
                    create: function (t) {
                        (this._target = t),
                            (this.situations = []),
                            (this.active = !1),
                            (this.situation = null),
                            (this.paused = !1),
                            (this.lastPos = 0),
                            (this.pos = 0),
                            (this.absPos = 0),
                            (this._speed = 1);
                    },
                    extend: {
                        animate: function (t, e, i) {
                            "object" === v(t) &&
                                ((e = t.ease), (i = t.delay), (t = t.duration));
                            t = new h.Situation({
                                duration: t || 1e3,
                                delay: i || 0,
                                ease: h.easing[e || "-"] || e,
                            });
                            return this.queue(t), this;
                        },
                        target: function (t) {
                            return t && t instanceof h.Element
                                ? ((this._target = t), this)
                                : this._target;
                        },
                        timeToAbsPos: function (t) {
                            return (
                                (t - this.situation.start) /
                                (this.situation.duration / this._speed)
                            );
                        },
                        absPosToTime: function (t) {
                            return (
                                (this.situation.duration / this._speed) * t +
                                this.situation.start
                            );
                        },
                        startAnimFrame: function () {
                            this.stopAnimFrame(),
                                (this.animationFrame = s.requestAnimationFrame(
                                    function () {
                                        this.step();
                                    }.bind(this)
                                ));
                        },
                        stopAnimFrame: function () {
                            s.cancelAnimationFrame(this.animationFrame);
                        },
                        start: function () {
                            return (
                                !this.active &&
                                    this.situation &&
                                    ((this.active = !0), this.startCurrent()),
                                this
                            );
                        },
                        startCurrent: function () {
                            return (
                                (this.situation.start =
                                    +new Date() +
                                    this.situation.delay / this._speed),
                                (this.situation.finish =
                                    this.situation.start +
                                    this.situation.duration / this._speed),
                                this.initAnimations().step()
                            );
                        },
                        queue: function (t) {
                            return (
                                ("function" == typeof t ||
                                    t instanceof h.Situation) &&
                                    this.situations.push(t),
                                this.situation ||
                                    (this.situation = this.situations.shift()),
                                this
                            );
                        },
                        dequeue: function () {
                            return (
                                this.stop(),
                                (this.situation = this.situations.shift()),
                                this.situation &&
                                    (this.situation instanceof h.Situation
                                        ? this.start()
                                        : this.situation.call(this)),
                                this
                            );
                        },
                        initAnimations: function () {
                            var t,
                                e = this.situation;
                            if (!e.init) {
                                for (var i in e.animations) {
                                    (t = this.target()[i]()),
                                        Array.isArray(t) || (t = [t]),
                                        Array.isArray(e.animations[i]) ||
                                            (e.animations[i] = [
                                                e.animations[i],
                                            ]);
                                    for (var a = t.length; a--; )
                                        e.animations[i][a] instanceof
                                            h.Number &&
                                            (t[a] = new h.Number(t[a])),
                                            (e.animations[i][a] = t[a].morph(
                                                e.animations[i][a]
                                            ));
                                }
                                for (var i in e.attrs)
                                    e.attrs[i] = new h.MorphObj(
                                        this.target().attr(i),
                                        e.attrs[i]
                                    );
                                for (var i in e.styles)
                                    e.styles[i] = new h.MorphObj(
                                        this.target().style(i),
                                        e.styles[i]
                                    );
                                (e.initialTransformation =
                                    this.target().matrixify()),
                                    (e.init = !0);
                            }
                            return this;
                        },
                        clearQueue: function () {
                            return (this.situations = []), this;
                        },
                        clearCurrent: function () {
                            return (this.situation = null), this;
                        },
                        stop: function (t, e) {
                            var i = this.active;
                            return (
                                (this.active = !1),
                                e && this.clearQueue(),
                                t &&
                                    this.situation &&
                                    (i || this.startCurrent(), this.atEnd()),
                                this.stopAnimFrame(),
                                this.clearCurrent()
                            );
                        },
                        after: function (i) {
                            var a = this.last();
                            return (
                                this.target().on("finished.fx", function t(e) {
                                    e.detail.situation == a &&
                                        (i.call(this, a),
                                        this.off("finished.fx", t));
                                }),
                                this._callStart()
                            );
                        },
                        during: function (e) {
                            function t(t) {
                                t.detail.situation == i &&
                                    e.call(
                                        this,
                                        t.detail.pos,
                                        h.morph(t.detail.pos),
                                        t.detail.eased,
                                        i
                                    );
                            }
                            var i = this.last();
                            return (
                                this.target()
                                    .off("during.fx", t)
                                    .on("during.fx", t),
                                this.after(function () {
                                    this.off("during.fx", t);
                                }),
                                this._callStart()
                            );
                        },
                        afterAll: function (e) {
                            function i(t) {
                                e.call(this), this.off("allfinished.fx", i);
                            }
                            return (
                                this.target()
                                    .off("allfinished.fx", i)
                                    .on("allfinished.fx", i),
                                this._callStart()
                            );
                        },
                        last: function () {
                            return this.situations.length
                                ? this.situations[this.situations.length - 1]
                                : this.situation;
                        },
                        add: function (t, e, i) {
                            return (
                                (this.last()[i || "animations"][t] = e),
                                this._callStart()
                            );
                        },
                        step: function (t) {
                            t || (this.absPos = this.timeToAbsPos(+new Date())),
                                !1 !== this.situation.loops
                                    ? ((t = Math.max(this.absPos, 0)),
                                      (e = Math.floor(t)),
                                      !0 === this.situation.loops ||
                                      e < this.situation.loops
                                          ? ((this.pos = t - e),
                                            (i = this.situation.loop),
                                            (this.situation.loop = e))
                                          : ((this.absPos =
                                                this.situation.loops),
                                            (this.pos = 1),
                                            (i = this.situation.loop - 1),
                                            (this.situation.loop =
                                                this.situation.loops)),
                                      this.situation.reversing &&
                                          (this.situation.reversed =
                                              this.situation.reversed !=
                                              Boolean(
                                                  (this.situation.loop - i) % 2
                                              )))
                                    : ((this.absPos = Math.min(this.absPos, 1)),
                                      (this.pos = this.absPos)),
                                this.pos < 0 && (this.pos = 0),
                                this.situation.reversed &&
                                    (this.pos = 1 - this.pos);
                            var e,
                                i,
                                a,
                                s = this.situation.ease(this.pos);
                            for (a in this.situation.once)
                                a > this.lastPos &&
                                    a <= s &&
                                    (this.situation.once[a].call(
                                        this.target(),
                                        this.pos,
                                        s
                                    ),
                                    delete this.situation.once[a]);
                            return (
                                this.active &&
                                    this.target().fire("during", {
                                        pos: this.pos,
                                        eased: s,
                                        fx: this,
                                        situation: this.situation,
                                    }),
                                this.situation &&
                                    (this.eachAt(),
                                    (1 == this.pos &&
                                        !this.situation.reversed) ||
                                    (this.situation.reversed && 0 == this.pos)
                                        ? (this.stopAnimFrame(),
                                          this.target().fire("finished", {
                                              fx: this,
                                              situation: this.situation,
                                          }),
                                          this.situations.length ||
                                              (this.target().fire(
                                                  "allfinished"
                                              ),
                                              this.situations.length) ||
                                              (this.target().off(".fx"),
                                              (this.active = !1)),
                                          this.active
                                              ? this.dequeue()
                                              : this.clearCurrent())
                                        : !this.paused &&
                                          this.active &&
                                          this.startAnimFrame(),
                                    (this.lastPos = s)),
                                this
                            );
                        },
                        eachAt: function () {
                            var t,
                                e = this,
                                i = this.target(),
                                a = this.situation;
                            for (t in a.animations)
                                (r = []
                                    .concat(a.animations[t])
                                    .map(function (t) {
                                        return "string" != typeof t && t.at
                                            ? t.at(a.ease(e.pos), e.pos)
                                            : t;
                                    })),
                                    i[t].apply(i, r);
                            for (t in a.attrs)
                                (r = [t].concat(a.attrs[t]).map(function (t) {
                                    return "string" != typeof t && t.at
                                        ? t.at(a.ease(e.pos), e.pos)
                                        : t;
                                })),
                                    i.attr.apply(i, r);
                            for (t in a.styles)
                                (r = [t].concat(a.styles[t]).map(function (t) {
                                    return "string" != typeof t && t.at
                                        ? t.at(a.ease(e.pos), e.pos)
                                        : t;
                                  i.matrix(r);
                            }
                            return this;
                        },
                        once: function (t, e, i) {
                            var a = this.last();
                            return i || (t = a.ease(t)), (a.once[t] = e), this;
                        },
                        _callStart: function () {
                            return (
                                setTimeout(
                                    function () {
                                        this.start();
                                    }.bind(this),
                                    0
                                ),
                                this
                            );
                        },
                    },
                    parent: h.Element,
                    construct: {
                        animate: function (t, e, i) {
                            return (
                                this.fx || (this.fx = new h.FX(this))
                            ).animate(t, e, i);
                        },
                        delay: function (t) {
                            return (
                                this.fx || (this.fx = new h.FX(this))
                            ).delay(t);
                        },
                        stop: function (t, e) {
                            return this.fx && this.fx.stop(t, e), this;
                        },
                        finish: function () {
                            return this.fx && this.fx.finish(), this;
                        },
                    },
                })),
                (h.MorphObj = h.invent({
                    create: function (t, e) {
                        return h.Color.isColor(e)
                            ? new h.Color(t).morph(e)
                            : h.regex.delimiter.test(t)
                            ? new (h.regex.pathLetters.test(t)
                                  ? h.PathArray
                                  : h.Array)(t).morph(e)
                            : h.regex.numberAndUnit.test(e)
                            ? new h.Number(t).morph(e)
                            : ((this.value = t), void (this.destination = e));
                    },
                    extend: {
                        at: function (t, e) {
                            return e < 1 ? this.value : this.destination;
                        },
                        valueOf: function () {
                            return this.value;
                        },
                    },
                })),
                h.extend(h.FX, {
                    attr: function (t, e, i) {
                        if ("object" === v(t))
                            for (var a in t) this.attr(a, t[a]);
                        else this.add(t, e, "attrs");
                        return this;
                    },
                    plot: function (t, e, i, a) {
                        return 4 == arguments.length
                            ? this.plot([t, e, i, a])
                            : this.add(
                                  "plot",
                                  new (this.target().morphArray)(t)
                              );
                    },
                }),
                (h.Box = h.invent({
                    create: function (t, e, i, a) {
                        if (!("object" !== v(t) || t instanceof h.Element))
                            return h.Box.call(
                                this,
                                null != t.left ? t.left : t.x,
                                null != t.top ? t.top : t.y,
                                t.width,
                                t.height
                            );
                        4 == arguments.length &&
                            ((this.x = t),
                            (this.y = e),
                            (this.width = i),
                            (this.height = a)),
                            null == (t = this).x &&
                                ((t.x = 0),
                                (t.y = 0),
                                (t.width = 0),
                                (t.height = 0)),
                            (t.w = t.width),
                            (t.h = t.height),
                            (t.x2 = t.x + t.width),
                            (t.y2 = t.y + t.height),
                            (t.cx = t.x + t.width / 2),
                            (t.cy = t.y + t.height / 2);
                    },
                })),
                (h.BBox = h.invent({
                    create: function (e) {
                        if (
                            (h.Box.apply(this, [].slice.call(arguments)),
                            e instanceof h.Element)
                        ) {
                            var i, a;
                            try {
                                if (!o.documentElement.contains) {
                                    for (var t = e.node; t.parentNode; )
                                        t = t.parentNode;
                                    if (t != o)
                                        throw new Error(
                                            "Element not in the dom"
                                        );
                                }
                                i = e.node.getBBox();
                            } catch (t) {
                                e instanceof h.Shape
                                    ? (h.parser.draw || h.prepare(),
                                      (a = e
                                          .clone(h.parser.draw.instance)
                                          .show()) &&
                                          a.node &&
                                          "function" == typeof a.node.getBBox &&
                                          (i = a.node.getBBox()),
                                      a &&
                                          "function" == typeof a.remove &&
                                          a.remove())
                                    : (i = {
                                          x: e.node.clientLeft,
                                          y: e.node.clientTop,
                                          width: e.node.clientWidth,
                                          height: e.node.clientHeight,
                                      });
                            }
                            h.Box.call(this, i);
                        }
                    },
                    inherit: h.Box,
                    parent: h.Element,
                    construct: {
                        bbox: function () {
                            return new h.BBox(this);
                        },
                    },
                })),
                (h.BBox.prototype.constructor = h.BBox),
                (h.Matrix = h.invent({
                    create: function (t) {
                        var e = p([1, 0, 0, 1, 0, 0]);
                        t =
                            null === t
                                ? e
                                : t instanceof h.Element
                                ? t.matrixify()
                                : "string" == typeof t
                                ? p(t.split(h.regex.delimiter).map(parseFloat))
                                : 6 == arguments.length
                                ? p([].slice.call(arguments))
                                : Array.isArray(t)
                                ? p(t)
                                : t && "object" === v(t)
                                ? t
                                : e;
                        for (var i = m.length - 1; 0 <= i; --i)
                            this[m[i]] = (null != t[m[i]] ? t : e)[m[i]];
                    },
                    extend: {
                        extract: function () {
                            var t = u(this, 0, 1),
                                t =
                                    (u(this, 1, 0),
                                    (180 / Math.PI) * Math.atan2(t.y, t.x) -
                                        90);
                            return {
                                x: this.e,
                                y: this.f,
                                transformedX:
                                    (this.e * Math.cos((t * Math.PI) / 180) +
                                        this.f *
                                            Math.sin((t * Math.PI) / 180)) /
                                    Math.sqrt(
                                        this.a * this.a + this.b * this.b
                                    ),
                                transformedY:
                                    (this.f * Math.cos((t * Math.PI) / 180) +
                                        this.e *
                                            Math.sin((-t * Math.PI) / 180)) /
                                    Math.sqrt(
                                        this.c * this.c + this.d * this.d
                                    ),
                                rotation: t,
                                a: this.a,
                                b: this.b,
                                c: this.c,
                                d: this.d,
                                e: this.e,
                                f: this.f,
                                matrix: new h.Matrix(this),
                            };
                        },
                        clone: function () {
                            return new h.Matrix(this);
                        },
                        morph: function (t) {
                            return (this.destination = new h.Matrix(t)), this;
                        },
                        multiply: function (t) {
                            return new h.Matrix(
                                this.native().multiply(
                                    (t =
                                        (t = t) instanceof h.Matrix
                                            ? t
                                            : new h.Matrix(t)).native()
                                )
                            );
                        },
                        inverse: function () {
                            return new h.Matrix(this.native().inverse());
                        },
                        translate: function (t, e) {
                            return new h.Matrix(
                                this.native().translate(t || 0, e || 0)
                            );
                        },
                        native: function () {
                            for (
                                var t = h.parser.native.createSVGMatrix(),
                                    e = m.length - 1;
                                0 <= e;
                                e--
                            )
                                t[m[e]] = this[m[e]];
                            return t;
                        },
                        toString: function () {
                            return (
                                "matrix(" +
                                x(this.a) +
                                "," +
                                x(this.b) +
                                "," +
                                x(this.c) +
                                "," +
                                x(this.d) +
                                "," +
                                x(this.e) +
                                "," +
                                x(this.f) +
                                ")"
                            );
                        },
                    },
                    parent: h.Element,
                    construct: {
                        ctm: function () {
                            return new h.Matrix(this.node.getCTM());
                        },
                        screenCTM: function () {
                            var t, e;
                            return this instanceof h.Nested
                                ? ((e = (t = this.rect(
                                      1,
                                      1
                                  )).node.getScreenCTM()),
                                  t.remove(),
                                  new h.Matrix(e))
                                : new h.Matrix(this.node.getScreenCTM());
                        },
                    },
                })),
                (h.Point = h.invent({
                    create: function (t, e) {
                        e = Array.isArray(t)
                            ? { x: t[0], y: t[1] }
                            : "object" === v(t)
                            ? { x: t.x, y: t.y }
                            : null != t
                            ? { x: t, y: null != e ? e : t }
                            : { x: 0, y: 0 };
                        (this.x = e.x), (this.y = e.y);
                    },
                    extend: {
                        clone: function () {
                            return new h.Point(this);
                        },
                        morph: function (t, e) {
                            return (this.destination = new h.Point(t, e)), this;
                        },
                    },
                })),
                h.extend(h.Element, {
                    point: function (t, e) {
                        return new h.Point(t, e).transform(
                            this.screenCTM().inverse()
                        );
                    },
                }),
                h.extend(h.Element, {
                    attr: function (t, e, i) {
                        if (null == t) {
                            for (
                                t = {},
                                    i = (e = this.node.attributes).length - 1;
                                0 <= i;
                                i--
                            )
                                t[e[i].nodeName] = h.regex.isNumber.test(
                                    e[i].nodeValue
                                )
                                    ? parseFloat(e[i].nodeValue)
                                    : e[i].nodeValue;
                            return t;
                        }
                        if ("object" === v(t))
                            for (var a in t) this.attr(a, t[a]);
                        else if (null === e) this.node.removeAttribute(t);
                        else {
                            if (null == e)
                                return null == (e = this.node.getAttribute(t))
                                    ? h.defaults.attrs[t]
                                    : h.regex.isNumber.test(e)
                                    ? parseFloat(e)
                                    : e;
                            "stroke-width" == t
                                ? this.attr(
                                      "stroke",
                                      0 < parseFloat(e) ? this._stroke : null
                                  )
                                : "stroke" == t && (this._stroke = e),
                                ("fill" != t && "stroke" != t) ||
                                    ((e = h.regex.isImage.test(e)
                                        ? this.doc().defs().image(e, 0, 0)
                                        : e) instanceof h.Image &&
                                        (e = this.doc()
                                            .defs()
                                            .pattern(0, 0, function () {
                                                this.add(e);
                                            }))),
                                "number" == typeof e
                                    ? (e = new h.Number(e))
                                    : h.Color.isColor(e)
                                    ? (e = new h.Color(e))
                                    : Array.isArray(e) && (e = new h.Array(e)),
                                "leading" == t
                                    ? this.leading && this.leading(e)
                                    : "string" == typeof i
                                    ? this.node.setAttributeNS(
                                          i,
                                          t,
                                          e.toString()
                                      )
                                    : this.node.setAttribute(t, e.toString()),
                                !this.rebuild ||
                                    ("font-size" != t && "x" != t) ||
                                    this.rebuild(t, e);
                        }
                        return this;
                    },
                }),
                h.extend(h.Element, {
                    transform: function (t, e) {
                        var i;
                        return "object" !== v(t)
                            ? ((i = new h.Matrix(this).extract()),
                              "string" == typeof t ? i[t] : i)
                            : ((i = new h.Matrix(this)),
                              (e = !!e || !!t.relative),
                              null != t.a &&
                                  (i = e
                                      ? i.multiply(new h.Matrix(t))
                                      : new h.Matrix(t)),
                              this.attr("transform", i));
                    },
                }),
                h.extend(h.Element, {
                    untransform: function () {
                        return this.attr("transform", null);
                    },
                    matrixify: function () {
                        return (this.attr("transform") || "")
                            .split(h.regex.transforms)
                            .slice(0, -1)
                            .map(function (t) {
                                t = t.trim().split("(");
                                return [
                                    t[0],
                                    t[1]
                                        .split(h.regex.delimiter)
                                        .map(function (t) {
                                            return parseFloat(t);
                                        }),
                                ];
                            })
                            .reduce(function (t, e) {
                                return "matrix" == e[0]
                                    ? t.multiply(p(e[1]))
                                    : t[e[0]].apply(t, e[1]);
                            }, new h.Matrix());
                    },
                    toParent: function (t) {
                        var e, i;
                        return (
                            this != t &&
                                ((e = this.screenCTM()),
                                (i = t.screenCTM().inverse()),
                                this.addTo(t)
                                    .untransform()
                                    .transform(i.multiply(e))),
                            this
                        );
                    },
                    toDoc: function () {
                        return this.toParent(this.doc());
                    },
                }),
                (h.Transformation = h.invent({
                    create: function (t, e) {
                        if (1 < arguments.length && "boolean" != typeof e)
                            return this.constructor.call(
                                this,
                                [].slice.call(arguments)
                            );
                        if (Array.isArray(t))
                            for (
                                var i = 0, a = this.arguments.length;
                                i < a;
                                ++i
                            )
                                this[this.arguments[i]] = t[i];
                        else if (t && "object" === v(t))
                            for (i = 0, a = this.arguments.length; i < a; ++i)
                                this[this.arguments[i]] = t[this.arguments[i]];
                        !(this.inversed = !1) === e && (this.inversed = !0);
                    },
                })),
                (h.Translate = h.invent({
                    parent: h.Matrix,
                    inherit: h.Transformation,
                    create: function (t, e) {
                        this.constructor.apply(this, [].slice.call(arguments));
                    },
                    extend: {
                        arguments: ["transformedX", "transformedY"],
                        method: "translate",
                    },
                })),
                h.extend(h.Element, {
                    style: function (t, e) {
                        if (0 == arguments.length)
                            return this.node.style.cssText || "";
                        if (arguments.length < 2)
                            if ("object" === v(t))
                                for (var i in t) this.style(i, t[i]);
                            else {
                                if (!h.regex.isCss.test(t))
                                    return this.node.style[r(t)];
                                for (
                                    t = t
                                        .split(/\s*;\s*/)
                                        .filter(function (t) {
                                            return !!t;
                                        })
                                        .map(function (t) {
                                            return t.split(/\s*:\s*/);
                                        });
                                    (e = t.pop());

                                )
                                    this.style(e[0], e[1]);
                            }
                        else
                            this.node.style[r(t)] =
                                null === e || h.regex.isBlank.test(e) ? "" : e;
                        return this;
                    },
                }),
                (h.Parent = h.invent({
                    create: function (t) {
                        this.constructor.call(this, t);
                    },
                    inherit: h.Element,
                    extend: {
                        children: function () {
                            return h.utils.map(
                                h.utils.filterSVGElements(this.node.childNodes),
                                function (t) {
                                    return h.adopt(t);
                                }
                            );
                        },
                        add: function (t, e) {
                            return (
                                null == e
                                    ? this.node.appendChild(t.node)
                                    : t.node != this.node.childNodes[e] &&
                                      this.node.insertBefore(
                                          t.node,
                                          this.node.childNodes[e]
                                      ),
                                this
                            );
                        },
                        put: function (t, e) {
                            return this.add(t, e), t;
                        },
                        has: function (t) {
                            return 0 <= this.index(t);
                        },
                        index: function (t) {
                            return [].slice
                                .call(this.node.childNodes)
                                .indexOf(t.node);
                        },
                        get: function (t) {
                            return h.adopt(this.node.childNodes[t]);
                        },
                        first: function () {
                            return this.get(0);
                        },
                        last: function () {
                            return this.get(this.node.childNodes.length - 1);
                        },
                        each: function (t, e) {
                            for (
                                var i = this.children(), a = 0, s = i.length;
                                a < s;
                                a++
                            )
                                i[a] instanceof h.Element &&
                                    t.apply(i[a], [a, i]),
                                    e &&
                                        i[a] instanceof h.Container &&
                                        i[a].each(t, e);
                            return this;
                        },
                        removeElement: function (t) {
                            return this.node.removeChild(t.node), this;
                        },
                        clear: function () {
                            for (; this.node.hasChildNodes(); )
                                this.node.removeChild(this.node.lastChild);
                            return delete this._defs, this;
                        },
                        defs: function () {
                            return this.doc().defs();
                        },
                    },
                })),
                h.extend(h.Parent, {
                    ungroup: function (t, e) {
                        return (
                            0 === e ||
                                this instanceof h.Defs ||
                                this.node == h.parser.draw ||
                                ((t =
                                    t ||
                                    (this instanceof h.Doc
                                        ? this
                                        : this.parent(h.Parent))),
                                (e = e || 1 / 0),
                                this.each(function () {
                                    return this instanceof h.Defs
                                        ? this
                                        : this instanceof h.Parent
                                        ? this.ungroup(t, e - 1)
                                        : this.toParent(t);
                                }),
                                this.node.firstChild) ||
                                this.remove(),
                            this
                        );
                    },
                    flatten: function (t, e) {
                        return this.ungroup(t, e);
                    },
                }),
                (h.Container = h.invent({
                    create: function (t) {
                        this.constructor.call(this, t);
                    },
                    inherit: h.Parent,
                })),
                (h.ViewBox = h.invent({ parent: h.Container, construct: {} })),
                [
                    "click",
                    "dblclick",
                    "mousedown",
                    "mouseup",
                    "mouseover",
                    "mouseout",
                    "mousemove",
                    "touchstart",
                    "touchmove",
                    "touchleave",
                    "touchend",
                    "touchcancel",
                ].forEach(function (e) {
                    h.Element.prototype[e] = function (t) {
                        return h.on(this.node, e, t), this;
                    };
                }),
                (h.listeners = []),
                (h.handlerMap = []),
                (h.listenerId = 0),
                (h.on = function (t, e, i, a, s) {
                    var a = i.bind(a || t.instance || t),
                        o =
                            (h.handlerMap.indexOf(t) + 1 ||
                                h.handlerMap.push(t)) - 1,
                        r = e.split(".")[0],
                        e = e.split(".")[1] || "*";
                    (h.listeners[o] = h.listeners[o] || {}),
                        (h.listeners[o][r] = h.listeners[o][r] || {}),
                        (h.listeners[o][r][e] = h.listeners[o][r][e] || {}),
                        i._svgjsListenerId ||
                            (i._svgjsListenerId = ++h.listenerId),
                        (h.listeners[o][r][e][i._svgjsListenerId] = a),
                        t.addEventListener(r, a, s || { passive: !1 });
                }),
                (h.off = function (t, e, i) {
                    var a = h.handlerMap.indexOf(t),
                        s = e && e.split(".")[0],
                        o = e && e.split(".")[1],
                        r = "";
                    if (-1 != a)
                        if (i)
                            !(i =
                                "function" == typeof i
                                    ? i._svgjsListenerId
                                    : i) ||
                                (h.listeners[a][s] &&
                                    h.listeners[a][s][o || "*"] &&
                                    (t.removeEventListener(
                                        s,
                                        h.listeners[a][s][o || "*"][i],
                                        !1
                                    ),
                                    delete h.listeners[a][s][o || "*"][i]));
                        else if (o && s) {
                            if (h.listeners[a][s] && h.listeners[a][s][o]) {
                                for (var n in h.listeners[a][s][o])
                                    h.off(t, [s, o].join("."), n);
                                delete h.listeners[a][s][o];
                            }
                        } else if (o)
                            for (var l in h.listeners[a])
                                for (var r in h.listeners[a][l])
                                    o === r && h.off(t, [l, o].join("."));
                        else if (s) {
                            if (h.listeners[a][s]) {
                                for (var r in h.listeners[a][s])
                                    h.off(t, [s, r].join("."));
                                delete h.listeners[a][s];
                            }
                        } else {
                            for (var l in h.listeners[a]) h.off(t, l);
                            delete h.listeners[a], delete h.handlerMap[a];
                        }
                }),
                h.extend(h.Element, {
                    on: function (t, e, i, a) {
                        return h.on(this.node, t, e, i, a), this;
                    },
                    off: function (t, e) {
                        return h.off(this.node, t, e), this;
                    },
                    fire: function (t, e) {
                        return (
                            t instanceof s.Event
                                ? this.node.dispatchEvent(t)
                                : this.node.dispatchEvent(
                                      (t = new h.CustomEvent(t, {
                                          detail: e,
                                          cancelable: !0,
                                      }))
                                  ),
                            (this._event = t),
                            this
                        );
                    },
                    event: function () {
                        return this._event;
                    },
                }),
                (h.Defs = h.invent({ create: "defs", inherit: h.Container })),
                (h.G = h.invent({
                    create: "g",
                    inherit: h.Container,
                    extend: {
                        x: function (t) {
                            return null == t
                                ? this.transform("x")
                                : this.transform({ x: t - this.x() }, !0);
                        },
                    },
                    construct: {
                        group: function () {
                            return this.put(new h.G());
                        },
                    },
                })),
                (h.Doc = h.invent({
                    create: function (t) {
                        t &&
                            ("svg" ==
                            (t = "string" == typeof t ? o.getElementById(t) : t)
                                .nodeName
                                ? this.constructor.call(this, t)
                                : (this.constructor.call(this, h.create("svg")),
                                  t.appendChild(this.node),
                                  this.size("100%", "100%")),
                            this.namespace().defs());
                    },
                    inherit: h.Container,
                    extend: {
                        namespace: function () {
                            return this.attr({ xmlns: h.ns, version: "1.1" })
                                .attr("xmlns:xlink", h.xlink, h.xmlns)
                                .attr("xmlns:svgjs", h.svgjs, h.xmlns);
                        },
                        defs: function () {
                            var t;
                            return (
                                this._defs ||
                                    ((t =
                                        this.node.getElementsByTagName(
                                            "defs"
                                        )[0])
                                        ? (this._defs = h.adopt(t))
                                        : (this._defs = new h.Defs()),
                                    this.node.appendChild(this._defs.node)),
                                this._defs
                            );
                        },
                        parent: function () {
                            return this.node.parentNode &&
                                "#document" != this.node.parentNode.nodeName
                                ? this.node.parentNode
                                : null;
                        },
                        remove: function () {
                            return (
                                this.parent() &&
                                    this.parent().removeChild(this.node),
                                this
                            );
                        },
                        clear: function () {
                            for (; this.node.hasChildNodes(); )
                                this.node.removeChild(this.node.lastChild);
                            return (
                                delete this._defs,
                                h.parser.draw &&
                                    !h.parser.draw.parentNode &&
                                    this.node.appendChild(h.parser.draw),
                                this
                            );
                        },
                        clone: function (t) {
                            this.writeDataToDom();
                            var e = this.node,
                                i = f(e.cloneNode(!0));
                            return (
                                t
                                    ? (t.node || t).appendChild(i.node)
                                    : e.parentNode.insertBefore(
                                          i.node,
                                          e.nextSibling
                                      ),
                                i
                            );
                        },
                    },
                })),
                h.extend(h.Element, {}),
                (h.Gradient = h.invent({
                    create: function (t) {
                        this.constructor.call(this, h.create(t + "Gradient")),
                            (this.type = t);
                    },
                    inherit: h.Container,
                    extend: {
                        at: function (t, e, i) {
                            return this.put(new h.Stop()).update(t, e, i);
                        },
                        update: function (t) {
                            return (
                                this.clear(),
                                "function" == typeof t && t.call(this, this),
                                this
                            );
                        },
                        fill: function () {
                            return "url(#" + this.id() + ")";
                        },
                        toString: function () {
                            return this.fill();
                        },
                        attr: function (t, e, i) {
                            return h.Container.prototype.attr.call(
                                this,
                                (t =
                                    "transform" == t ? "gradientTransform" : t),
                                e,
                                i
                            );
                        },
                    },
                    construct: {
                        gradient: function (t, e) {
                            return this.defs().gradient(t, e);
                        },
                    },
                })),
                h.extend(h.Gradient, h.FX, {
                    from: function (t, e) {
                        return "radial" == (this._target || this).type
                            ? this.attr({
                                  fx: new h.Number(t),
                                  fy: new h.Number(e),
                              })
                            : this.attr({
                                  x1: new h.Number(t),
                                  y1: new h.Number(e),
                              });
                    },
                    to: function (t, e) {
                        return "radial" == (this._target || this).type
                            ? this.attr({
                                  cx: new h.Number(t),
                                  cy: new h.Number(e),
                              })
                            : this.attr({
                                  x2: new h.Number(t),
                                  y2: new h.Number(e),
                              });
                    },
                }),
                h.extend(h.Defs, {
                    gradient: function (t, e) {
                        return this.put(new h.Gradient(t)).update(e);
                    },
                }),
                (h.Stop = h.invent({
                    create: "stop",
                    inherit: h.Element,
                    extend: {
                        update: function (t) {
                            return (
                                null !=
                                    (t =
                                        "number" == typeof t ||
                                        t instanceof h.Number
                                            ? {
                                                  offset: arguments[0],
                                                  color: arguments[1],
                                                  opacity: arguments[2],
                                              }
                                            : t).opacity &&
                                    this.attr("stop-opacity", t.opacity),
                                null != t.color &&
                                    this.attr("stop-color", t.color),
                                null != t.offset &&
                                    this.attr("offset", new h.Number(t.offset)),
                                this
                            );
                        },
                    },
                })),
                (h.Pattern = h.invent({
                    create: "pattern",
                    inherit: h.Container,
                    extend: {
                        fill: function () {
                            return "url(#" + this.id() + ")";
                        },
                        update: function (t) {
                            return (
                                this.clear(),
                                "function" == typeof t && t.call(this, this),
                                this
                            );
                        },
                        toString: function () {
                            return this.fill();
                        },
                        attr: function (t, e, i) {
                            return h.Container.prototype.attr.call(
                                this,
                                (t = "transform" == t ? "patternTransform" : t),
                                e,
                                i
                            );
                        },
                    },
                    construct: {
                        pattern: function (t, e, i) {
                            return this.defs().pattern(t, e, i);
                        },
                    },
                })),
                h.extend(h.Defs, {
                    pattern: function (t, e, i) {
                        return this.put(new h.Pattern())
                            .update(i)
                            .attr({
                                x: 0,
                                y: 0,
                                width: t,
                                height: e,
                                patternUnits: "userSpaceOnUse",
                            });
                    },
                }),
                (h.Shape = h.invent({
                    create: function (t) {
                        this.constructor.call(this, t);
                    },
                    inherit: h.Element,
                })),
                (h.Symbol = h.invent({
                    create: "symbol",
                    inherit: h.Container,
                    construct: {
                        symbol: function () {
                            return this.put(new h.Symbol());
                        },
                    },
                })),
                (h.Use = h.invent({
                    create: "use",
                    inherit: h.Shape,
                    extend: {
                        element: function (t, e) {
                            return this.attr(
                                "href",
                                (e || "") + "#" + t,
                                h.xlink
                            );
                        },
                    },
                    construct: {
                        use: function (t, e) {
                            return this.put(new h.Use()).element(t, e);
                        },
                    },
                })),
                (h.Rect = h.invent({
                    create: "rect",
                    inherit: h.Shape,
                    construct: {
                        rect: function (t, e) {
                            return this.put(new h.Rect()).size(t, e);
                        },
                    },
                })),
                (h.Circle = h.invent({
                    create: "circle",
                    inherit: h.Shape,
                    construct: {
                        circle: function (t) {
                            return this.put(new h.Circle())
                                .rx(new h.Number(t).divide(2))
                                .move(0, 0);
                        },
                    },
                })),
                h.extend(h.Circle, h.FX, {
                    rx: function (t) {
                        return this.attr("r", t);
                    },
                    ry: function (t) {
                        return this.rx(t);
                    },
                }),
                (h.Ellipse = h.invent({
                    create: "ellipse",
                    inherit: h.Shape,
                    construct: {
                        ellipse: function (t, e) {
                            return this.put(new h.Ellipse())
                                .size(t, e)
                                .move(0, 0);
                        },
                    },
                })),
                h.extend(h.Ellipse, h.Rect, h.FX, {
                    rx: function (t) {
                        return this.attr("rx", t);
                    },
                    ry: function (t) {
                        return this.attr("ry", t);
                    },
                }),
                h.extend(h.Circle, h.Ellipse, {
                    x: function (t) {
                        return null == t
                            ? this.cx() - this.rx()
                            : this.cx(t + this.rx());
                    },
                    y: function (t) {
                        return null == t
                            ? this.cy() - this.ry()
                            : this.cy(t + this.ry());
                    },
                    cx: function (t) {
                        return null == t ? this.attr("cx") : this.attr("cx", t);
                    },
                    cy: function (t) {
                        return null == t ? this.attr("cy") : this.attr("cy", t);
                    },
                    width: function (t) {
                        return null == t
                            ? 2 * this.rx()
                            : this.rx(new h.Number(t).divide(2));
                    },
                    height: function (t) {
                        return null == t
                            ? 2 * this.ry()
                            : this.ry(new h.Number(t).divide(2));
                    },
                    size: function (t, e) {
                        t = g(this, t, e);
                        return this.rx(new h.Number(t.width).divide(2)).ry(
                            new h.Number(t.height).divide(2)
                        );
                    },
                }),
                (h.Line = h.invent({
                    create: "line",
                    inherit: h.Shape,
                    extend: {
                        array: function () {
                            return new h.PointArray([
                                [this.attr("x1"), this.attr("y1")],
                                [this.attr("x2"), this.attr("y2")],
                            ]);
                        },
                        plot: function (t, e, i, a) {
                            return null == t
                                ? this.array()
                                : ((t =
                                      void 0 !== e
                                          ? { x1: t, y1: e, x2: i, y2: a }
                                          : new h.PointArray(t).toLine()),
                                  this.attr(t));
                        },
                        move: function (t, e) {
                            return this.attr(this.array().move(t, e).toLine());
                        },
                        size: function (t, e) {
                            t = g(this, t, e);
                            return this.attr(
                                this.array().size(t.width, t.height).toLine()
                            );
                        },
                    },
                    construct: {
                        line: function (t, e, i, a) {
                            return h.Line.prototype.plot.apply(
                                this.put(new h.Line()),
                                null != t ? [t, e, i, a] : [0, 0, 0, 0]
                            );
                        },
                    },
                })),
                (h.Polyline = h.invent({
                    create: "polyline",
                    inherit: h.Shape,
                    construct: {
                        polyline: function (t) {
                            return this.put(new h.Polyline()).plot(
                                t || new h.PointArray()
                            );
                        },
                    },
                })),
                (h.Polygon = h.invent({
                    create: "polygon",
                    inherit: h.Shape,
                    construct: {
                        polygon: function (t) {
                            return this.put(new h.Polygon()).plot(
                                t || new h.PointArray()
                            );
                        },
                    },
                })),
                h.extend(h.Polyline, h.Polygon, {
                    array: function () {
                        return (
                            this._array ||
                            (this._array = new h.PointArray(
                                this.attr("points")
                            ))
                        );
                    },
                    plot: function (t) {
                        return null == t
                            ? this.array()
                            : this.clear().attr(
                                  "points",
                                  "string" == typeof t
                                      ? t
                                      : (this._array = new h.PointArray(t))
                              );
                    },
                    clear: function () {
                        return delete this._array, this;
                    },
                    move: function (t, e) {
                        return this.attr("points", this.array().move(t, e));
                    },
                    size: function (t, e) {
                        t = g(this, t, e);
                        return this.attr(
                            "points",
                            this.array().size(t.width, t.height)
                        );
                    },
                }),
                h.extend(h.Line, h.Polyline, h.Polygon, {
                    morphArray: h.PointArray,
                    x: function (t) {
                        return null == t
                            ? this.bbox().x
                            : this.move(t, this.bbox().y);
                    },
                    y: function (t) {
                        return null == t
                            ? this.bbox().y
                            : this.move(this.bbox().x, t);
                    },
                    width: function (t) {
                        var e = this.bbox();
                        return null == t ? e.width : this.size(t, e.height);
                    },
                    height: function (t) {
                        var e = this.bbox();
                        return null == t ? e.height : this.size(e.width, t);
                    },
                }),
                (h.Path = h.invent({
                    create: "path",
                    inherit: h.Shape,
                    extend: {
                        morphArray: h.PathArray,
                        array: function () {
                            return (
                                this._array ||
                                (this._array = new h.PathArray(this.attr("d")))
                            );
                        },
                        plot: function (t) {
                            return null == t
                                ? this.array()
                                : this.clear().attr(
                                      "d",
                                      "string" == typeof t
                                          ? t
                                          : (this._array = new h.PathArray(t))
                                  );
                        },
                        clear: function () {
                            return delete this._array, this;
                        },
                    },
                    construct: {
                        path: function (t) {
                            return this.put(new h.Path()).plot(
                                t || new h.PathArray()
                            );
                        },
                    },
                })),
                (h.Image = h.invent({
                    create: "image",
                    inherit: h.Shape,
                    extend: {
                        load: function (e) {
                            var i, a;
                            return e
                                ? ((i = this),
                                  (a = new s.Image()),
                                  h.on(a, "load", function () {
                                      h.off(a);
                                      var t = i.parent(h.Pattern);
                                      null !== t &&
                                          (0 == i.width() &&
                                              0 == i.height() &&
                                              i.size(a.width, a.height),
                                          t &&
                                              0 == t.width() &&
                                              0 == t.height() &&
                                              t.size(i.width(), i.height()),
                                          "function" == typeof i._loaded) &&
                                          i._loaded.call(i, {
                                              width: a.width,
                                              height: a.height,
                                              ratio: a.width / a.height,
                                              url: e,
                                          });
                                  }),
                                  h.on(a, "error", function (t) {
                                      h.off(a),
                                          "function" == typeof i._error &&
                                              i._error.call(i, t);
                                  }),
                                  this.attr(
                                      "href",
                                      (a.src = this.src = e),
                                      h.xlink
                                  ))
                                : this;
                        },
                        loaded: function (t) {
                            return (this._loaded = t), this;
                        },
                        error: function (t) {
                            return (this._error = t), this;
                        },
                    },
                    construct: {
                        image: function (t, e, i) {
                            return this.put(new h.Image())
                                .load(t)
                                .size(e || 0, i || e || 0);
                        },
                    },
                })),
                (h.Text = h.invent({
                    create: function () {
                        this.constructor.call(this, h.create("text")),
                            (this.dom.leading = new h.Number(1.3)),
                            (this._rebuild = !0),
                            (this._build = !1),
                            this.attr(
                                "font-family",
                                h.defaults.attrs["font-family"]
                            );
                    },
                    inherit: h.Shape,
                    extend: {
                        x: function (t) {
                            return null == t
                                ? this.attr("x")
                                : this.attr("x", t);
                        },
                        text: function (t) {
                            if (void 0 === t) {
                                t = "";
                                for (
                                    var e = this.node.childNodes,
                                        i = 0,
                                        a = e.length;
                                    i < a;
                                    ++i
                                )
                                    0 != i &&
                                        3 != e[i].nodeType &&
                                        1 == h.adopt(e[i]).dom.newLined &&
                                        (t += "\n"),
                                        (t += e[i].textContent);
                                return t;
                            }
                            if (
                                (this.clear().build(!0), "function" == typeof t)
                            )
                                t.call(this, this);
                            else
                                for (
                                    var i = 0, s = (t = t.split("\n")).length;
                                    i < s;
                                    i++
                                )
                                    this.tspan(t[i]).newLine();
                            return this.build(!1).rebuild();
                        },
                        size: function (t) {
                            return this.attr("font-size", t).rebuild();
                        },
                        leading: function (t) {
                            return null == t
                                ? this.dom.leading
                                : ((this.dom.leading = new h.Number(t)),
                                  this.rebuild());
                        },
                        lines: function () {
                            var t = ((this.textPath && this.textPath()) || this)
                                