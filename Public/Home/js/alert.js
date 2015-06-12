
/**
 * 手机端通用js文件
 * @param {Object} txt
 */

function alertMsg(txt){
	var ele = $("#alertMsg-mobile");
	if(ele.length == 0){		
		$alert = $('<div style="z-index:100000000;" class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="alertMsg-mobile"><div class="am-modal-dialog"><div class="am-modal-bd"></div></div></div>');
		$("body").append($alert);
		ele = $("#alertMsg-mobile");
	}
	
	if(txt){
		$(".am-modal-bd",ele).html(txt);
	}else{
		return ;
	}
	
	ele.show();
	$(".am-dimmer").addClass("active");
	
	setTimeout(function(){
		$(".am-dimmer").removeClass("active");
		ele.hide();
	},2500);
	
}

function loadingMsg(txt){
	var ele = $("#loading-mobile");
	if(ele.length == 0){
		
		$alert = $('<div style="z-index:100000000;" class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="loading-mobile"><div class="am-modal-dialog"><div class="am-modal-bd"><span class="am-icon-spinner am-icon-spin"></span></div></div></div>');
		$("body").append($alert);
		ele = $("#loading-mobile");
	}
	
//	if(txt){
//		$(".am-modal-hd",ele).text(txt);
//	}else{
//		return ;
//		$(".am-modal-bd",ele).text(txt);
//	}
	
	var dimmer = $(".am-dimmer").addClass("active");
	ele.show();
	
	return new function(){
		var  _this = ele;
		var _dimmer = dimmer;
		this.hide = function(){
			_this.hide();
			_dimmer.removeClass("active");
		}
	};
//	setTimeout(function(){
//	},2500);
	
}
