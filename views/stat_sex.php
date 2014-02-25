<style>
.arc path {
  stroke: #fff;
}

#statsContainer text {
	fill: white;
	font-size: 22px;
}

.infobar {
	-moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;
	border-radius: 5px;
	background-color: white;
	padding: 20px;
}

@media screen and (min-width: 980px) {
	.infobar {
		position: absolute;
		width: 235px;
		height: 120px;
		margin: -498px 0px 0px 493px;
	}
}
</style>

<div id="statsContainer">
	<h1>Sex</h1>
	<div class="liner"></div>
	<br />
</div>

<div class="infobar span2 offset5">
	<h4>more detailed stats</h4>

</div>

<ul class="pager">
  <li class="previous">
    <a href="#/v/statistics">&larr; step back</a>
  </li>
</ul>

<script src="http://memsoria.pl/m/js/libs/d3.js" charset="utf-8"></script>

<script>
	var width = Math.min(500, screen.width - 50),
		height = 500,
		radius = Math.min(width, height) / 2;
	
	var color = d3.scale.ordinal()
		.range(['#00AFA1', '#263DB3']);

	var arc = d3.svg.arc()
		.outerRadius(radius - 10)
		.innerRadius(0);
		
	var pie = d3.layout.pie()
		.sort(null)
		.value(function (d) {
			return d.count;
		});
		
	var chart = d3.select("#statsContainer").append("svg")
		.attr("width", width)
		.attr("height", height)
		.append("g")
		.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
		
d3.json('http://memsoria.pl/m/engine/ajax/sex.php', function (blad, json) {

	var g = chart.selectAll(".arc")
		.data(pie(json))
		.enter().append("g")
		.attr("class", "arc");

	g.append("path")
		.attr('d', arc)
		.attr('i', function (d) {
			return d.data.name
		})
		.transition()
		.ease('elastic')
		.duration(2000)
		.style("fill", function(d) {
			return color(d.data.count);
		});

	g.append("text")
		.attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
		.attr("dy", ".35em")
		.style("text-anchor", "middle")
		.text(function(d) { return d.data.name; });

	var i =	d3.select('.infobar').selectAll('p')
		.data(json)
		.enter()
		.append('p')
		.text(function (d) { return d.name + ': ' + d.procent + '% of server, exact: ' + d.count; })
		.style('opacity', 0)
		.transition()
		.duration(1000)
		.style('opacity', 1);
		
	$('g .arc').mouseover(function () {
		if (d3.select(this).select('text').text() == 'male') {
			d3.select('path[i="female"]').transition().duration(500).style('fill', 'rgb(128, 128, 128)');
		} else {
			d3.select('path[i="male"]').transition().duration(500).style('fill', 'rgb(128, 128, 128)');
		}
	});
	
	$('g .arc').mouseleave(function () {
		d3.select('path[i="male"]')
			.transition()
			.duration(500)
			.style('fill', '#00afa1');

		d3.select('path[i="female"]')
			.transition()
			.duration(500)
			.style('fill', '#263db3');
	});
});

</script>