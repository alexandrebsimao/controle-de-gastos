$(document).ready(function(){
	$('.date').mask('00/00/0000');
	$('.money').mask('000.000.000.000.000,00', {reverse: true});

	$('.date').datepicker();

	setTimeout(function() {
		$('.alert').slideUp('slow')
	}, 4000);
	
	var mes = [];

	$.ajax({
      url: 'home/graph1',
      dataType: 'json',
      success:function(data){
      	mes = data['meses'];
      	dados = data['dados'];

      	console.log(mes);
      	console.log(dados);

		var lineChartData = {
	      labels : mes,
	      datasets : [
	        {
	          label: "My Second dataset",
	          fillColor : "rgba(151,187,205,0.2)",
	          strokeColor : "rgba(151,187,205,1)",
	          pointColor : "rgba(151,187,205,1)",
	          pointStrokeColor : "#fff",
	          pointHighlightFill : "#fff",
	          pointHighlightStroke : "rgba(151,187,205,1)",
	          data : dados
	        }
	      ]

	    }

	    // window.onload = function(){
		    var ctx = document.getElementById("graph1").getContext("2d");
		    window.myLine = new Chart(ctx).Line(lineChartData, {
		      responsive: true
		    });
		  // }
      }
    });


    $.ajax({
      url: 'home/graph2',
      dataType: 'json',
      success:function(data){
      	mes = data['meses'];
      	dados = data['dados'];

      	console.log(mes);
      	console.log(dados);

		var lineChartData = {
	      labels : mes,
	      datasets : [
	        {
	          label: "My Second dataset",
	          fillColor : "rgba(151,187,205,0.2)",
	          strokeColor : "rgba(151,187,205,1)",
	          pointColor : "rgba(151,187,205,1)",
	          pointStrokeColor : "#fff",
	          pointHighlightFill : "#fff",
	          pointHighlightStroke : "rgba(151,187,205,1)",
	          data : dados
	        }
	      ]

	    }

	    // window.onload = function(){
		    var ctx = document.getElementById("graph2").getContext("2d");
		    window.myLine = new Chart(ctx).Line(lineChartData, {
		      responsive: true
		    });
		  // }
      }
    });

});