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
					var li = $('<li><a data-pjax href="chapter/' + rsdata[x].cn + '" class="pic"><img data-original="' + rsdata[x].cv + '" alt="' + rsdata[x].ti + '"></a><p class="cover"><a data-pjax href="chapter/' + rsdata[x].cn + '" class="pic2"><span>' + rsdata[x].ti + '</span></a></p></li>');
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
		layui.use('layer', function(){
		var layer = layui.layer;
			$.ajax({
				url:"/load_chapter",
				async:true,
				cache:false,
				type:'POST',
				dataType:"json",
				data:{qy:$name},
				success:function(rsdata) {
					//上次观看记录弹窗
					if (rsdata.hasOwnProperty('popStatus')) {
						layer.open({
							content: '需要跳转到上次观看地方吗',
							btn: ['需要', '不需要'],
							yes: function(){
								window.open('/page/' + rsdata.popData['cover'] + '/' + rsdata.popData['chapter']);
							}
						});
					}
					//加载章节
					for (var x=0; x<rsdata.chapterData.length; x++) {
						var li = $("<li><a href = /page/" + rsdata.chapterData[x].id + "/" + rsdata.chapterData[x].pagenum + " target=_blank>" + rsdata.chapterData[x].pn + "</a></li>");
						$("#add_chapter").children("ul").append(li);
					}
				}
			});
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
					var li = $('<li style="width:1000px;height:1200px;"><img width="1000" height="1200" data-original="' + rsdata[x].ad + '"><span class="comic-sp">' + (x+1)+ "/" + rsdata.length + '</span></li>');
					
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
					var li = $('<li class="vdcvli"><a data-pjax="" href="' + rsdata[x].src +'" title="' + rsdata[x].ti + '" target="_self" class="vdcvimg"><img class="vdcvloading" data-original="' + rsdata[x].cv + '" alt="' + rsdata[x].ti + '" style="display: inline;"><span class="vdcvmask"><i class="glyphicon glyphicon-play-circle glyphiconL"></i></span></a><div class="vdcvinfo"><a data-pjax="" href="' + rsdata[x].src + '">' + rsdata[x].ti + '</a><p><span class="vdcvf1">更新至' + rsdata[x].cotdir + '集</span></p></div></li>');
					li.hover(function(){
							$(this).find(".vdcvmask").css("opacity","1");
						},function(){
					    	$(this).find(".vdcvmask").css("opacity","0");
						});
					$("#vdcv").append(li);
				}
				$("img[data-original]").lazyload({effect: "fadeIn"});
				$(document).pjax('a[data-pjax]', 'body',{timeout:5000,fragment:'body'});
			}
		});
	}

	function Ld_Vdir(associated){
		layui.use('layer', function(){
		var layer = layui.layer;
			$.ajax({
				url:"/load_Vdor/"+associated,
				async:true,
				cache:false,
				type:'GET',
				dataType:"json",
				success:function(rsdata){
					//上次观看记录弹窗
					if (rsdata.hasOwnProperty('popStatus')) {
						layer.open({
							content: '需要跳转到上次观看地方吗',
							btn: ['需要', '不需要'],
							yes: function(){
								window.open('/animation/' + rsdata.popData['cover'] + '/' + rsdata.popData['chapter']);
							}
						});
					}
						//加载章节
					for(var x=0; x<rsdata.chapterData.length; x++){
						var a = $("<a target=_blank href=/animation/"+rsdata.chapterData[x].cvid+"/"+rsdata.chapterData[x].dirid+" title="+rsdata.chapterData[x].dirname+">"+rsdata.chapterData[x].dirname+"</a>");
						$("#player_list").append(a);
					}
				}
			});
		});	
	}
