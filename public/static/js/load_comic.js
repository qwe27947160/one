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
				$("img[data-original]").lazyload();
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
					var a1 = $("<a data-pjax href=\"" + rsdata[x].src + "\" title="+'"'+rsdata[x].ti+'"'+" target=_self class=vdcvimg></a>").hover(function(){
						$(this).children(".vdcvmask").css("opacity","1");
					},function(){
				    	$(this).children(".vdcvmask").css("opacity","0");
					}); ;
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
				}
				$("img[data-original]").lazyload({effect: "fadeIn"});
				$(document).pjax('a[data-pjax]', 'body',{timeout:5000,fragment:'body'});
			}
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
