
function isInArray(arr,item){
  for(var i=0;i<arr.length;i++){
    if(arr[i]==item)return true;
  }
  return false;
}
function loadmenu(menulevel1){
	var i,j,html;
	html = "<ul>";
	if(menulevel1==undefined)menulevel1="";
	var classes = menulevel1.split(',');	
	for(i=0;i<data.titles.length;i++){
		if(menulevel1!="" && classes.length>0 && !isInArray(classes,data.titles[i].text))
		  continue;
		html += '<li class="menutitle"><span class="pl40px">'+data.titles[i].text+'</span></li>';
		if('undefined'!=typeof(data.titles[i].items))
			for(j=0;j<data.titles[i].items.length;j++){
			  html += '<li href="' + data.titles[i].items[j].href +'" ><span class="pl40px">'+ data.titles[i].items[j].text +"</span></li>";
			}
	}
	html += "</ul>";
	$("#divmenu").html(html);
	//$('#divnav > div > ul > li:first').attr('class','curnav');
	$('#divmenu li').each(function(i,e){
		$(this).click(function(){
			if($(this).attr("href")!=null && $(this).attr("href")!=undefined){
				window.open($(this).attr("href"),"menu_lists");

				$('#divmenu > ul > .menucursel').attr('class',""); 
				$(this).attr('class',"menucursel"); 
			}
		});
	});
	//$('#divnav > div > ul > li[href]:first').attr('href');
	var url = $('#divmenu > ul > li[href]:first').attr('href');
	$('#divmenu > ul > li[href]:first').attr('class',"menucursel"); 
	if( 'undefined'!=typeof(url) ){
		window.open(url,"menu_lists");
  	}

}


$(function(){
  loadmenu("");
});

