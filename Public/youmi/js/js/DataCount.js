var DataCount={
	//条形图
	BarChart:function(data){
		$('#container').highcharts({
			chart: {
				type: 'bar'
			},
			title: {
				text: data.titles
			},
			subtitle: {
				text: data.frist_name
			},
			xAxis: {
				categories: data.categories,
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Population (millions)',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' millions'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 100,
				floating: true,
				borderWidth: 1,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [{
				name: "  ",
				data: data.downarray
			}]
		});
	},

	NavClick:function(){
		$("#evt_tabs a").click(function(){
			var nav_id = $(this).attr("id");
			var title = $(this).html();
			$("#evt_tabs a").each(function() {    
				$(this).removeClass();  
			});
			$("#"+nav_id).addClass("current");
			$("#hChartTitle").html("TOP10 新增用户（含重复安装）"+title);

			var datatimes = $("#reservation").val();

			$.ajax({
				type: 'POST',
				url: Url.downUrl,
				data:{reservation:datatimes,downtype:nav_id},
				dataType:'json',
				success:function(data){
					DataCount.BarChart(data);
				}
			}); 
		})
	},

	init:function(){
		DataCount.BarChart(data);
		DataCount.NavClick();
	}

};
DataCount.init();