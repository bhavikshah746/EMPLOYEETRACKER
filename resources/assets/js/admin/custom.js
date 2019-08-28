;/*
|------------------------------------------------------------
| GLOBAL VARIABLES
|------------------------------------------------------------
*/

/*
|------------------------------------------------------------
| DOCUMENT READY
|------------------------------------------------------------
*/

$(document).ready(function() {

	//POPUP INIT
	popup.init();

	//DATE PICKER
	$( ".datedropper" ).dateDropper({
		animate:false,
		dropShadow:'none',
		dropBorderRadius:'0',
		dropBorder:'1px solid #dadada',
		dropPrimaryColor:'#8BC34A',
	});

	//TAKEAWAY TOGGLE ORDER
	$(document).on('click','.ta_view_orders',function(){
		$(this).parents('td').find('.ta_orders').slideToggle(200);
	});

});


/*
|------------------------------------------------------------
| ITEMS POPUP
|------------------------------------------------------------
*/
function timer(element,startWith){
	if(!startWith){
		startWith=0;
	}
	element.html('<span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>');
	var timerInterval = setInterval(function(){
	    element.find(".seconds").text(pad(++startWith%60));
	    element.find(".minutes").text(pad(parseInt((startWith/60)%60,10)));
	    element.find(".hours").text(pad(parseInt((startWith/60)/60,10)));
			if(startWith>5){
				element.addClass('ss_danger');
			}
	},1000);
	function pad(val){
		return val>9 ? val:"0"+val;
	}
};

/*
|------------------------------------------------------------
| ITEMS POPUP
|------------------------------------------------------------
*/
$(function(){

	$(document).on('click','.ia_extra_toggle',function(){
		$(this).parents('.item_addons').find('.ia_extra').toggle();
	});

  $(document).on('click','.count_box button',function(){
    var box = $(this).parent();
    var boxText = box.find('.cb_count');
    if(!boxText.val()){
      boxText.val('0');
    }
    if($(this).hasClass('cb_plus')){
      boxText.val(parseInt(boxText.val())+1);
    }
    else if($(this).hasClass('cb_minus') && boxText.val()>1){
      boxText.val(parseInt(boxText.val())-1);
    }
  });

	var countKeys=[8,38,40,9,107,109,189,46];
	$(document).keydown(function(e){
		if($('.cb_count').is(":focus")){

				if((e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 48 && e.keyCode <= 57)	|| countKeys.indexOf(e.keyCode)>-1){
					var boxText = $('.cb_count:focus');
					if(e.keyCode==38 || e.keyCode==107){
						e.preventDefault();
						boxText.val(parseInt(boxText.val())+1);
					}
					if(e.keyCode==40 || e.keyCode==109){
						e.preventDefault();
						if(boxText.val()>1){
							boxText.val(parseInt(boxText.val())-1);
						}
					}
				}
				else{
					e.preventDefault();
					return false;
			}
		}
	});
});

/*
|------------------------------------------------------------
| SIDEBAR
|------------------------------------------------------------
*/
$(function(){
  $(document).on('click','.s_nav_list li.has_sub_nav',function(){
      $(this).siblings().removeClass('open').find('.s_sub_nav_list').slideUp('fast');
      $(this).toggleClass('open').find('.s_sub_nav_list').slideToggle('fast');
  });
});


/*
|------------------------------------------------------------
| BUTTON LOADER
|------------------------------------------------------------
*/
var buttonLoader = {
  el:{
    loaderElement:'button_loader',
  },
  data:{
    loaderText:''
  },
  init:function(){
    buttonLoader.bindUIActions();
  },
  bindUIActions:function(){
  },
  on:function(settings){
    settings.button.addClass('on');
    settings.button.prop('disabled',true);
		buttonLoader.data.loaderText = settings.button.text();
    //BUTTON TEXT
    if(settings.text){
      settings.button.text(settings.text);
    }
  },
  off:function(settings){
    settings.button.removeClass('on');

    //BUTTON TEXT
    if(settings.text){
      settings.button.text(settings.text);
    }
    else{
      settings.button.text(buttonLoader.data.loaderText);
    }
    //IF DISABLE AFTER FIRST SUBMIT
    if(settings.disable){
      settings.button.prop('disabled',true);
    }
    else{
      settings.button.prop('disabled',false);
    }
  }
}

/*
|------------------------------------------------------------
| NOTIFICATION
|------------------------------------------------------------
*/
$(function(){
  notification.init();
});

var notification = {
	el:{
  },
  data:{
  },
  init:function(){
    this.bindUIActions();
  },
  bindUIActions:function(){
    var _this = this;
    $(document).on('click','.ss_notification .ssn_close',function(){
      _this.destroy();
    });
  },
  create:function(settings){
    var _this = this;

    //REMOVE PREV NOTIFICATION
    $('.ss_notification').remove();

    //NOTIFICATION TYPE
    var type='ss_info';
    if(settings.type){
      type='ss_'+settings.type;
    }

    //WIDTH
    var width='';
    if(settings.width){
      width = 'width:'+settings.width;
    }


    //CREATE
    html ='<div class="ss_notification '+type+'" style="'+width+'">';
    if(!(settings.icon || settings.icon==false)){
      html+=  '<div class="ssn_icon_wrap">';
      html+=    '<span class="ssn_icon"></span>';
      html+=  '</div>';
    }
    html+=  '<div class="ssn_text_wrap">';
    html+=    '<p class="ssn_text">';
    html+=      settings.text;
    html+=    '</p>';
    html+=  '</div>';
    html+=  '<div class="ssn_close_wrap">';
    html+=    '<button class="ssn_close">×</button>';
    html+=  '</div>';
    html+='</div>';


    //APPEND
    $('body').append(html);


    //ANIMATE
    setTimeout(function(){
      $('.ss_notification').addClass('open');
    },10);

    //AUTO HIDE
    if(settings.timeout){
      setTimeout(function(){
        _this.destroy();
      },settings.timeout);
    }

  },
  destroy:function(){
    $('.ss_notification').removeClass('open');
  }
};


/*
|------------------------------------------------------------
| LOADER
|------------------------------------------------------------
*/
var loader = {
  el:{
    loaderElement:'ss_loader',
    loaderText:'ss_loader_text',
  },
  data:{
    loaderText:'Please Wait'
  },
  init:function(){
    loader.bindUIActions();
  },
  bindUIActions:function(){
  },
  on:function(settings){
    $('.'+loader.el.loaderElement).addClass('open');
    if(settings){
      if(settings.text){
        $('.'+loader.el.loaderText).text(settings.text);
      }
    }
    else{
      $('.'+loader.el.loaderText).text(loader.data.loaderText);
    }
  },
  off:function(){
    $('.'+loader.el.loaderElement).removeClass('open');
  }
}

/*
|------------------------------------------------------------
| ACTION BOX
|------------------------------------------------------------
*/
var actionBox = {
	el:{
  },
  data:{
  },
  init:function(){
    actionBox.bindUIActions();
  },
  bindUIActions:function(){

  },
  create:function(settings){
    actionBox.destroy();
    var html='';
    html += '<div class="ss_action_box_overlay">';
    html +=   '<div class="ss_action_box">';
    html +=     '<div class="ss_ab_header">';
    html +=       settings.title;
    html +=     '</div>';
    html +=     '<div class="ss_ab_content">';
    html +=       settings.content;
    html +=     '</div>';
    html +=     '<div class="ss_ab_footer">';
                  for(var i=0; i<settings.buttons.length; i++){
                    var actionScript = settings.buttons[i].action;
                    html +=       '<button class="button" id="ssabb'+i+'">';
                    html +=         settings.buttons[i].name;
                    html +=       '</button>';
                    if(actionScript){
                      html +=       '<script type="text/javascript">';
                      html +=       '$(document).on("click","#ssabb'+i+'",';
                      html +=       actionScript;
                      html +=       ')';
                      html +=       '</script>';
                    }
                  }
    html +=     '</div>';
    html +=   '</div>';
    html += '</div>';
    $('body').append(html);
  },
  destroy:function(){
    $('.ss_action_box_overlay button').each(function(){
        $(document).off('click','#'+$(this).attr('id'));
    });
    $('.ss_action_box_overlay').remove();
  }
};

/*
|------------------------------------------------------------
| POPUP
|------------------------------------------------------------
*/
var popup = {
	el:{
  },
  data:{
		currentPopup:''
  },
  init:function(){
    popup.bindUIActions();
  },
  bindUIActions:function(){
    $(document).on("click",'.popup_open',function(){
			popup.open($(this).data('popup'));
		});
    $(document).on("click",'.popup_close',function(){
			popup.close($(this).parents('.popup').attr('id'));
		});
		$(document).mouseup(function(e){
		    var container = $('.popup_overlay');
		    if (container.is(e.target)){
		        popup.close(popup.data.currentPopup);
		    }
		});
		$(document).keyup(function(e){
		    if(e.keyCode==27){
					popup.close(popup.data.currentPopup);
				}
		});
  },
	open:function(popupID){
		popup.close(popup.data.currentPopup);
		popup.data.currentPopup=popupID;
		$('body').addClass('oh');
		$('#'+popupID).parents('.popup_overlay').addClass('open');
		$('#'+popupID).addClass('open');
		$('#'+popupID).find('.popup_focus').focus();
	},
	close:function(popupID){
		popup.data.currentPopup='';
		$('#'+popupID).parents('.popup_overlay').removeClass('open');
		$('#'+popupID).removeClass('open');
		$('body').removeClass('oh').focus();
	},
};

/*
|------------------------------------------------------------
| PAGE LOADED
|------------------------------------------------------------
*/

$(window).bind("load", function() {

});


/*
|------------------------------------------------------------
| DOCUMENT MOUSE UP
|------------------------------------------------------------
*/
$(document).mouseup(function(e){

    var container = $('.auto_close');
    var opener = $('.opener.auto_close');
    if (!container.is(e.target) && container.has(e.target).length === 0
       && !opener.is(e.target) && opener.has(e.target).length === 0
       ){
        container.removeClass('open');
        opener.removeClass('active');
        $('.overlay').removeClass('open');
    }
});


/*
|------------------------------------------------------------
| OPENER
|------------------------------------------------------------
*/

$(document).on('click','.opener',function(){
    $this = $(this);
    $this.toggleClass('active');
    $('.opener').not($this).removeClass('active');
    var toOpen = $('.'+$this.data('open'));
    toOpen.toggleClass('open').find('.open_focus').focus();
    $('.auto_close').not(toOpen).removeClass('open');
    if($this.data('overlay')){
      $('.overlay').toggleClass('open');
    }
});

/*
|------------------------------------------------------------
| LOG
|------------------------------------------------------------
*/
function log(input){
    console.log(input);
}

/*
|------------------------------------------------------------
| SS AJAX SEARCH
|------------------------------------------------------------
*/

var demoData = [
	{
		name:'Mango',
		id:'mango',
		cat:'Icecream'
	},
	{
		name:'Chocolate',
		id:'chocolate',
		cat:'Icecream'
	},
	{
		name:'Chikoo',
		id:'chikoo',
		cat:'Icecream'
	},
	{
		name:'Banana',
		id:'canana',
		cat:'Shakes'
	},
	{
		name:'Chocolate',
		id:'chocolate',
		cat:'Shakes'
	},
	{
		name:'Coffee',
		id:'coffee',
		cat:'Shakes'
	},
];

function ajaxSearch(ele,data){
	var ajaxSearchJson  = {
		el:{
			noResult:'',
			resultList:'',
			searchBox:'',
			searchWrap : '',
		},
		data:{
			isTyping:false,
			navKeys:[40,38,23,27],
			currentFocus:-1,
			matchingResults:0,
		},

		bindUIActions:function(){
			var _this=this;

			$(document).on('mouseup',function(e){
				if(!_this.el.searchBox.is(':focus') && !_this.el.resultList.find('li a:focus').length > 0){
					_this.reset(_this.el.searchWrap);
				}
			});
			$(document).on('keyup',function(e){
				if(_this.el.searchBox.is(':focus') || _this.el.resultList.find('li a:focus').length > 0){
					_this.typing(e);
				}
			});
			$(document).on('keydown',function(e){
				if(_this.el.searchBox.is(':focus') || _this.el.resultList.find('li a:focus').length > 0){
					_this.navigating(e);
				}
			});
		},

		init:function(ele,data){
			this.el.searchWrap = ele;
			this.el.searchBox = ele.find('.ss_as_text');
			this.create(data);
			this.bindUIActions();
		},

		create:function(data){
			var results='<ul class="ss_as_result">';
			for(var i=0; i<data.length; i++){
				results+='<li>\
					<a href="#nogo" data-id="'+data[i].id+'">\
						<p class="i_item_name">'+data[i].name+'</p>\
						<p class="i_item_cat">'+data[i].cat+'</p>\
					</a>\
				</li>';
			}
			results+='<li class="ss_as_no_result"><a href="#nogo" data-id="0">No Results Found !</a></li>';
			results+='</ul>';
			this.el.searchWrap.append(results);
			this.el.resultList = this.el.searchWrap.find('.ss_as_result');
			this.el.noResult = this.el.searchWrap.find('.ss_as_no_result');
		},

		navigating:function(e){
			var _this = this;
			switch(e.keyCode){

				//DOWN KEY
				case 40:
					if(_this.data.currentFocus == _this.data.matchingResults){
						_this.data.currentFocus=0;
					}
					else{
						_this.data.currentFocus++;
					}
					_this.el.resultList.find('li:visible').eq(_this.data.currentFocus).find('a').focus();
					break;

				//UP KEY
				case 38:
					if(_this.data.currentFocus == 0){
						_this.data.currentFocus = _this.data.matchingResults;
					}
					else{
						_this.data.currentFocus--;
					}
					_this.el.resultList.find('li:visible').eq(_this.data.currentFocus).find('a').focus();
					break;

				//ENTER KEY
				case 13:
					_this.action(_this.el.resultList.find('li:visible').eq(_this.data.currentFocus));
					break;

				//ESC KEY
				case 27:
					_this.reset(_this.el.searchWrap);
					break;
				default:
					_this.el.searchBox.focus();
					break;
			}
		},

		typing:function(e){
			var _this = this;
			if(_this.data.navKeys.indexOf(e.keyCode)>-1){
				return false;
			}
			_this.data.matchingResults=0;
			_this.data.currentFocus=-1;
			var searchValue = _this.el.searchBox.val(); //GET THE VALUE
			var dropDown = _this.el.searchWrap.find('.ss_as_result li:not(.ss_as_no_result)');

			//IF SEARCHBOX TEXT
			if(searchValue!=''){
				_this.el.resultList.addClass('open');
				//LOOP THROUGH ARRAY
				$.each(dropDown,function(index,value){
						if($(value).text().toLowerCase().indexOf(searchValue.toLowerCase()) >= 0){
							$(value).show();
							_this.data.matchingResults++;
						}
						else{
							$(value).hide();
						}
				});
				//IF RESULTS ARE THERE
				if(_this.data.matchingResults==0){
					_this.el.noResult.show();
				}
				else{
					_this.el.noResult.hide();
				}
			}
			//IF TEXTBOX EMPTY
			else{
				_this.el.resultList.removeClass('open');
			}
		},

		reset:function(ele){
			ele.find('.ss_as_text').val('').blur();
			ele.find('.ss_as_result').removeClass('open');
		},

		action:function(selected){
			alert(selected.text());
			this.reset(this.el.searchWrap)
		}
	}

	//CALLING
	ajaxSearchJson.init(ele,data);
}

$(function(){
	ajaxSearch($('#searchItemsList'),demoData);
	ajaxSearch($('#searchItemsList2'),demoData);
});

/*
|------------------------------------------------------------
| FULL SCREEN
|------------------------------------------------------------
*/
function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    }
  }
}

/*
|------------------------------------------------------------
| SMOOTH SCROLL
|------------------------------------------------------------
*/
$(function(){
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 500);
                return false;
            }
        }
    });
});
