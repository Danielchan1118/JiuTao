var DataCount={
	  //曲线图
	Statistical:function(data){
		$(function () {	
			$('#container').highcharts({
				chart: {
					type: 'line'
				},
				title: {
					text: data.titles
				},
				xAxis: {
					categories: data.categories
				},
				yAxis: {
					title: {
						text: data.data_titles
					}
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						},
						enableMouseTracking: false
					}
				},
				series: [ {
					data: data.downarray
				}]
			});
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
			$("#hChartTitle").html(title);

			$.ajax({
				type: 'POST',
				url: Url.downUrl,
				data:{downtype:nav_id},
				dataType:'json',
				success:function(data){
					DataCount.Statistical(data);
				}
			}); 
		})
	},
	
	init:function(){
	    DataCount.Statistical(data);
		DataCount.NavClick();
	}
};

DataCount.init();