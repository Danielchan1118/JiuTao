var DataCount={
  //曲线图
	Statistical:function(){
     BUI.use('bui/chart',function (Chart) {
        var chart = new Chart.Chart({     
          render : '#canvas',
          width : 1175,
          height : 376,
          plotCfg : {
            margin : [50,50,80] //画板的边距
          },
          title : {
            text : '今日下载量'
          },
          xAxis : {
            categories : data.categories
          },
         series : [{
                name: data.frist_name,
                data: data.downarray
            }]
        });
 
        chart.render();
        DataCount.chart = chart;
    });
	},

  //日期控件
  DateFunction:function(){
      BUI.use('bui/calendar',function(Calendar){
        var calendar = new Calendar.Calendar({
          render:'#calendar',
          width:'394px',
          height:'253px'
        });
        calendar.render();
        calendar.on('selectedchange',function (ev) {
          alert(ev.date);
        });
    });
  },

	init:function(){
	    DataCount.Statistical();
	    DataCount.DateFunction();
	  }
};

DataCount.init();