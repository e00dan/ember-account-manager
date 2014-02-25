<style>
.wykres {
	margin-top: 20px;
	font: 10px sans-serif;
	text-align: right;
	padding: 3px;
	margin: 1px;
	color: white;
}

.pasek {
	fill: white;
}
</style>

<div id="statsContainer">
	<h1>Characters created on Memsoria.pl</h1>
	<div class="liner"></div>
	<br />
	<div style="font-weight: bold; position: absolute; margin-left: 32px; margin-top: -20px;">Day</div>
	<div style="font-weight: bold; position: absolute; margin-left: 330px; margin-top: -20px;">Ammount of new players</div>
</div>
<div class="alert alert-info">
This chart contains information on the number of players who signed up within the last thirty days.
</div>
<ul class="pager">
  <li class="previous">
    <a href="#/v/statistics">&larr; step back</a>
  </li>
</ul>

<script src="http://memsoria.pl/m/js/libs/d3.js" charset="utf-8"></script>

<script>
var config = {
	odlegloscOdGory: 10,
	odlegloscOdLewejProstokatow: 70,
	odlegloscTextuOdProstokatow: 10,
	kolorProstokatow: 'rgb(0, 175, 161)',
	wysokoscProstokatow: 20,
	maksymalnaSzerokoscProstokata: 690,
	klasaWykresu: 'wykres',
	szerokoscWykresu: 760
	
};

var max = 0;

var skaluj = function (wartosc) {
	return config.maksymalnaSzerokoscProstokata * wartosc / max;
}

d3.json('http://memsoria.pl/m/engine/ajax/characters.php', function (blad, json) {
	if (blad) {
		return console.warn(blad);
	}
	
	function count(obj) {
	  var i = 0;
	  for (var x in obj)
		if (obj.hasOwnProperty(x))
		  i++;
	  return i;
	}

	$.each(json, function (key, value) {
			if (max == 0 || value > max) {
				max = value;
			}
		});
		
	var wykres = d3.select('#statsContainer')
			.append('svg')
			.attr('class', config.klasaWykresu)
			.attr('width', config.szerokoscWykresu)
			.attr('height', count(json) * 40 + 40);
	
	wykres.selectAll('rect')
		.data(d3.keys(json))
		.enter()
		.append('rect')
		.attr('x', config.odlegloscOdLewejProstokatow)
		.attr('y', function (d, i) {
			return i * 40 + config.odlegloscOdGory;
		})
		.attr('width', 50)
		.attr('height', config.wysokoscProstokatow)
		.attr('fill', config.kolorProstokatow)
		.attr('stroke', 'white');
		
	wykres.selectAll('rect')
		.data(d3.keys(json))
		.transition()
		.duration(3000)
		.attr('x', config.odlegloscOdLewejProstokatow)
		.attr('y', function (d, i) {
			return i * 40 + config.odlegloscOdGory;
		})
		.attr('width', function (d, i) {
			return skaluj(json[d]);
		})
		.attr('height', config.wysokoscProstokatow)
		.attr('fill', config.kolorProstokatow)
		.attr('stroke', 'white');
		
	wykres.selectAll('text')
		.data(d3.keys(json))
		.enter()
		.append('text')
		.attr("x", config.odlegloscOdLewejProstokatow - config.odlegloscTextuOdProstokatow)
		.attr("y", function (d, i) {
			return i * 40 + config.odlegloscOdGory + 10;
		})
		.attr("dx", -3) // padding-right
		.attr("dy", ".35em") // vertical-align: middle
		.attr("text-anchor", "end") // text-align: right
		.attr('class', 'label')
		.text(String);
		
	wykres.selectAll('circle')
		.data(d3.keys(json))
		.enter()
		.append('text')
		.attr('class', 'pasek')
		.attr("x", function (d, i) {
			return skaluj(json[d]) + config.odlegloscOdLewejProstokatow;
		})
		.attr("y", function (d, i) {
			return i * 40 + config.odlegloscOdGory + 10;
		})
		.attr("dx", -3) // padding-right
		.attr("dy", ".35em") // vertical-align: middle
		.attr("text-anchor", "end") // text-align: right
		.text(function (d, i) {
			return json[d];
		});
		
});
</script>