function load_comic(){
	$("#ccover").empty();
	$.ajax({
		url:"/load_comic",
		async:true,
		cache:false,
		type:'GET',
		dataType:"json",
		success:function(rsdata){
			for(var x=0; x<rsdata.length; x++){
				var li = $("<li></li>");
				var p = $("<p"+" class=cover"+"></p>")			
				var a1 = $("<a data-pjax href = chapter/" + rsdata[x].cn + " class=pic></a>");
				var a2 = $("<a data-pjax href = chapter/" + rsdata[x].cn + " class=pic2></a>");
				var img = $("<img data-original=" + '"'+ rsdata[x].cv +'"'+ " alt= " + rsdata[x].ti +">");
				var span = $("<span>" + rsdata[x].ti +"</span>");
				li.append(a1);
				a1.append(img);
				li.append(p);
				p.append(a2);
				a2.append(span);
				$("#ccover").append(li);
			}
			//懒加载
			$("img[data-original]").lazyload({effect: "fadeIn"});
			//PJAX绑定
			$(document).pjax('a[data-pjax]', 'body',{timeout:5000,fragment:'body'})
		}
	});
}

function load_chapter($name){
	$.ajax({
		url:"/load_chapter",
		async:true,
		cache:false,
		type:'POST',
		dataType:"json",
		data:{qy:$name},
		success:function(rsdata){
			for(var x=0; x<rsdata.length; x++){
				var cp_na = rsdata[x].pn;
				var a = $("<a href = /page/" + rsdata[x].id +"/"+ rsdata[x].pagenum + " target=_blank>"+ cp_na +"</a>");
				var li = $("<li></li>")
				li.append(a);
				$("#add_chapter").children("ul").append(li);
			}
		}
	});
}

function load_page($comicid ,$pagenum){
	//算出下一章的地址
	var pgum = (window.location.toString().split('//')[1]).split('/')[3];
	var chnum = (window.location.toString().split('//')[1]).split('/')[2];
	var nexturl = '/page/' + chnum +'/'+(parseInt(pgum)+1);
	$("#mexta").attr("href",nexturl);

	$.ajax({
		url:"/load_page",
		async:true,
		cache:false,
		type:'POST',
		dataType:"json",
		data:{qy1:$comicid ,qy2:$pagenum},
		success:function(rsdata){
			if(rsdata==""){
				alert("没有下一章拉");
			}
			for(var x=0; x<rsdata.length; x++){
				var img = $("<img width=1000 height=1200 data-original="+ '"' +rsdata[x].ad+ '"' + ">");
				var li  = $("<li style=width:1000px;height:1200px;></li>");
				var span = $("<span class=comic-sp>"+(x+1)+"/"+rsdata.length+"</span>");
				li.append(img);
				li.append(span);
				$("#page_main").children("ul").append(li);
			}
			$("img[data-original]").lazyload({threshold:200});
		}
	});
}

function Load_Animations_Cover(){
	$("#vdcv").empty();
	$.ajax({
		url:"/Load_Animations_Cover",
		async:true,
		cache:false,
		type:'GET',
		dataType:"json",
		success:function(rsdata){
			for(var x=0; x<rsdata.length; x++){
				var li = $("<li class=vdcvli></li>");
				var a1 = $("<a data-pjax id=\"" + rsdata[x].id + "\" href=\"" + rsdata[x].src + "\" title="+'"'+rsdata[x].ti+'"'+" target=_self class=vdcvimg></a>");
				var img = $("<img class=vdcvloading data-original="+rsdata[x].cv+" alt="+'"'+rsdata[x].ti+'"'+" style=display:inline;>");
				var div = $("<div class=vdcvinfo></div>");
				var a2 = $("<a data-pjax href="+rsdata[x].src+">"+rsdata[x].ti+"</a>");
				var p = $("<p></p>");
				var span = $("<span class=vdcvf1>更新至"+ rsdata[x].cotdir +"集</span>");
				var str = "\"glyphicon glyphicon-play-circle glyphiconL\"";
				var span2 = $("<span class=vdcvmask><i class="+str+"></i></span>");
				a1.append(img);
				a1.append(span2);
				div.append(a2);
				p.append(span);
				div.append(p);
				li.append(a1);
				li.append(div);
				$("#vdcv").append(li);
				VdBind(a1);
			}
			$("img[data-original]").lazyload({effect: "fadeIn"});
			$(document).pjax('a[data-pjax]', 'body',{timeout:5000,fragment:'body'});
		}
	});
}

function VdBind(obj){
	obj.hover(function(){
		$(this).children(".vdcvmask").css("opacity","1");
	},function(){
    	$(this).children(".vdcvmask").css("opacity","0");
	}); 
}

function Ld_Vdir(associated){
	$.ajax({
		url:"/load_Vdor/"+associated,
		async:true,
		cache:false,
		type:'GET',
		dataType:"json",
		success:function(rsdata){
			for(var x=0; x<rsdata.length; x++){
				var a = $("<a target=_blank href=/animation/"+rsdata[x].cvid+"/"+rsdata[x].dirid+" title="+rsdata[x].dirname+">"+rsdata[x].dirname+"</a>");
				$("#player_list").append(a);
			}
		}
	});
}	