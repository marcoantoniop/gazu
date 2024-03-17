// Calendar: a Javascript class for Mootools that adds accessible and unobtrusive date pickers to your form elements <http://electricprism.com/aeron/calendar>
// Calendar RC2, Copyright (c) 2007 Aeron Glemann <http://electricprism.com/aeron>, MIT Style License.

var Calendar=new Class({initialize:function(obj,props){this.props=Object.extend({blocked:[],classes:['calendar','prev','next','month','year','invalid','valid','inactive','active','hover'],days:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],direction:0,draggable:true,months:['January','February','March','April','May','June','July','August','September','October','November','December'],navigation:1,offset:0,pad:1},props||{});if(obj==null||obj.length==0){return false;}
this.props.offset%=7;this.calendar=new Element('div',{'styles':{left:'-1000px',opacity:0,position:'absolute',top:'-1000px',zIndex:1000}}).addClass(this.props.classes[0]).injectInside(document.body);this.calendar.coord=this.calendar.getCoordinates();this.fx=this.calendar.effect('opacity',{onStart:function(){if(this.element.getStyle('opacity')==0){this.element.setStyle('display','block');}},onComplete:function(){if(this.element.getStyle('opacity')==0){this.element.setStyle('display','none');}}});if(window.Drag&&this.props.draggable){new Drag.Move(this.calendar);}
this.calendars=[];var id=0;var d=new Date();d.setDate(d.getDate()+this.props.direction.toInt());for(var i in obj){var cal={button:new Element('button',{'type':'button'}),el:$(i),els:[],id:id++,month:d.getMonth(),visible:false,year:d.getFullYear()};this.element(i,obj[i],cal);cal.el.addClass(this.props.classes[0]);cal.button.addClass(this.props.classes[0]).addEvent('click',function(cal){this.toggle(cal);}.pass(cal,this)).injectAfter(cal.el);cal.val=this.evaluate(cal);cal.bounds=this.bounds(cal);this.options(cal);this.calendars.push(cal);}},blocked:function(cal){var blocked=[];var offset=new Date(cal.year,cal.month,1).getDay();var last=new Date(cal.year,cal.month+1,0).getDate();this.props.blocked.each(function(date){var values=date.split(' ');for(var i=0;i<3;i++){if(!values[i]){values[i]='*';}
values[i]=values[i].contains(',')?values[i].split(','):new Array(values[i]);}
if(values[2].contains(cal.year+'')||values[2].contains('*')){if(values[1].contains(cal.month+1+'')||values[1].contains('*')){values[0].each(function(val){if(val>0){blocked.push(val.toInt());}});if(values[3]){values[3]=values[3].contains(',')?values[3].split(','):new Array(values[3]);for(var i=0;i<last;i++){var day=(i+offset)%7;if(values[3].contains(day+'')){blocked.push(i+1);}}}}}},this);return blocked;},bounds:function(cal){var start=new Date(1000,0,1);var end=new Date(2999,11,31);var date=new Date().getDate()+this.props.direction.toInt();if(this.props.direction>0){start=new Date();start.setDate(date+this.props.pad*cal.id);}
if(this.props.direction<0){end=new Date();end.setDate(date-this.props.pad*(this.calendars.length-cal.id-1));}
var years,months,days;cal.els.each(function(el){if(el.getTag()=='select'){if(el.format.test('(y|Y)')){years=[];el.getChildren().each(function(option){var values=this.unformat(option.value,el.format);if(!years.contains(values[0])){years.push(values[0]);}},this);years.sort(this.sort);if(years[0]>start.getFullYear()){d=new Date(years[0],start.getMonth()+1,0);if(start.getDate()>d.getDate()){start.setDate(d.getDate());}
start.setYear(years[0]);}
if(years.getLast()<end.getFullYear()){d=new Date(years.getLast(),end.getMonth()+1,0);if(end.getDate()>d.getDate()){end.setDate(d.getDate());}
end.setYear(years.getLast());}}
if(el.format.test('(F|m|M|n)')){months=[];el.getChildren().each(function(option){var values=this.unformat(option.value,el.format);if($type(values[0])!='number'||values[0]==cal.year){if(!months.contains(values[1])){months.push(values[1]);}}},this);months.sort(this.sort);if(start.getFullYear()==cal.year&&months[0]>start.getMonth()){d=new Date(start.getFullYear(),months[0]+1,0);if(start.getDate()>d.getDate()){start.setDate(d.getDate());}
start.setMonth(months[0]);}
if(end.getFullYear()==cal.year&&months.getLast()<end.getMonth()){d=new Date(start.getFullYear(),months.getLast()+1,0);if(end.getDate()>d.getDate()){end.setDate(d.getDate());}
end.setMonth(months.getLast());}}
if(el.format.test('(d|j)')&&!el.format.test('^(d|j)$')){days=[];el.getChildren().each(function(option){var values=this.unformat(option.value,el.format);if(values[0]==cal.year&&values[1]==cal.month){if(!days.contains(values[2])){days.push(values[2]);}}},this);}}},this);var first=1;var last=new Date(cal.year,cal.month+1,0).getDate();var prev={'month':true,'year':true};var next={'month':true,'year':true};if(cal.year==start.getFullYear()){prev.year=false;}
if(cal.year==end.getFullYear()){next.year=false;}
if(cal.year==start.getFullYear()&&cal.month==start.getMonth()){if(this.props.navigation==1){prev.month=false;}
first=start.getDate();}
if(cal.year==end.getFullYear()&&cal.month==end.getMonth()){if(this.props.navigation==1){next.month=false;}
last=end.getDate();}
var blocked=this.blocked(cal);if($type(days)=='array'){days=days.filter(function(day){if(day>=first&&day<=last&&!blocked.contains(day)){return day;}});}
else{days=[];for(var i=first;i<=last;i++){if(!blocked.contains(i)){days.push(i);}}}
days.sort(this.sort);return{'days':days,'months':months,'years':years,'prev':prev,'next':next,'start':start,'end':end};},caption:function(cal){var caption=new Element('caption');var prev=new Element('a').addClass(this.props.classes[1]).appendText('\x3c');var next=new Element('a').addClass(this.props.classes[2]).appendText('\x3e');if(this.props.navigation==2){var month=new Element('span').addClass(this.props.classes[3]).injectInside(caption);if(cal.bounds.prev.month){prev.clone().addEvent('click',function(cal){this.navigate(cal,'m',-1);}.pass(cal,this)).injectInside(month);}
month.adopt(new Element('span').appendText(this.props.months[cal.month]));if(cal.bounds.next.month){next.clone().addEvent('click',function(cal){this.navigate(cal,'m',1);}.pass(cal,this)).injectInside(month);}
var year=new Element('span').addClass(this.props.classes[4]).injectInside(caption);if(cal.bounds.prev.year){prev.clone().addEvent('click',function(cal){this.navigate(cal,'y',-1);}.pass(cal,this)).injectInside(year);}
year.adopt(new Element('span').appendText(cal.year));if(cal.bounds.next.year){next.clone().addEvent('click',function(cal){this.navigate(cal,'y',1);}.pass(cal,this)).injectInside(year);}}
else{if(cal.bounds.prev.month&&this.props.navigation){prev.clone().addEvent('click',function(cal){this.navigate(cal,'m',-1);}.pass(cal,this)).injectInside(caption);}
caption.adopt(new Element('span').addClass(this.props.classes[3]).appendText(this.props.months[cal.month]));caption.adopt(new Element('span').addClass(this.props.classes[4]).appendText(cal.year));if(cal.bounds.next.month&&this.props.navigation){next.clone().addEvent('click',function(cal){this.navigate(cal,'m',1);}.pass(cal,this)).injectInside(caption);}}
return caption;},changed:function(cal){cal.val=this.evaluate(cal);cal.bounds=this.bounds(cal);this.options(cal);if(cal.val){if(cal.val.getDate()<cal.bounds.days[0]){cal.val.setDate(cal.bounds.days[0]);}
if(cal.val.getDate()>cal.bounds.days.getLast()){cal.val.setDate(cal.bounds.days.getLast());}
cal.els.each(function(el){el.value=this.format(cal.val,el.format);},this);}
if(!cal.val){return;}
this.check(cal);if(cal.visible){this.display(cal);}},clicked:function(cal){this.options(cal);cal.els.each(function(el){el.value=this.format(cal.val,el.format);},this);},check:function(cal){if(!cal.val){return;}
this.calendars.each(function(kal,i){if(kal.val){var change=false;if(i<cal.id){var bound=new Date(Date.parse(cal.val));bound.setDate(bound.getDate()-(this.props.pad*(cal.id-i)));if(bound<kal.val){change=true;}}
if(i>cal.id){var bound=new Date(Date.parse(cal.val));bound.setDate(bound.getDate()+(this.props.pad*(i-cal.id)));if(bound>kal.val){change=true;}}
if(change){if(kal.bounds.start>bound){bound=kal.bounds.start;}
if(kal.bounds.end<bound){bound=kal.bounds.end;}
kal.val=bound;kal.month=bound.getMonth();kal.year=bound.getFullYear();kal.bounds=this.bounds(kal);this.clicked(kal);if(kal.visible){this.display(kal);}}}},this);},display:function(cal){this.calendar.empty();this.calendar.className=this.props.classes[0]+' '+this.props.months[cal.month].toLowerCase();var div=new Element('div').injectInside(this.calendar);var table=new Element('table').injectInside(div).adopt(this.caption(cal));var thead=new Element('thead').injectInside(table);var tr=new Element('tr').injectInside(thead);for(var i=0;i<=6;i++){var th=this.props.days[(i+this.props.offset)%7];tr.adopt(new Element('th',{'title':th}).appendText(th.substr(0,1)));}
var tbody=new Element('tbody').injectInside(table);var tr=new Element('tr').injectInside(tbody);var offset=new Date(cal.year,cal.month,1).getDay()-this.props.offset;var last=new Date(cal.year,cal.month+1,0).getDate();var prev_last=new Date(cal.year,cal.month,0).getDate();var active=this.value(cal);var inactive=[];this.calendars.each(function(kal){if(kal!=cal&&kal.val){if(cal.year==kal.val.getFullYear()&&cal.month==kal.val.getMonth()){inactive.push(kal.val.getDate());}}},this);var valid=cal.bounds.days;for(var i=1;i<43;i++){if((i-1)%7==0){tr=new Element('tr').injectInside(tbody);}
var td=new Element('td').injectInside(tr);var day=i-offset;var cls='';if(day===active){cls=this.props.classes[8];}
else if(inactive.contains(day)){cls=this.props.classes[7];}
else if(valid.contains(day)){cls=this.props.classes[6];}
else if(day>=1&&day<=last){cls=this.props.classes[5];}
td.addClass(cls);if(valid.contains(day)){td.setProperty('title',this.format(new Date(cal.year,cal.month,day),'D M jS Y'));td.addEvents({'click':function(td,day,cal){cal.val=(this.value(cal)==day)?null:new Date(cal.year,cal.month,day);this.clicked(cal);if(!cal.val){cal.val=this.evaluate(cal);}
if(cal.val){this.check(cal);this.toggle(cal);}
else{td.addClass(this.props.classes[6]);td.removeClass(this.props.classes[8]);}}.pass([td,day,cal],this),'mouseover':function(td,cls){td.addClass(cls);}.pass([td,this.props.classes[9]]),'mouseout':function(td,cls){td.removeClass(cls);}.pass([td,this.props.classes[9]])});}
if(day<1){day=prev_last+day;}
else if(day>last){day=day-last;}
td.appendText(day);}},element:function(el,f,cal){if($type(f)=='object'){for(var i in f){this.element(i,f[i],cal);}
return;}
el=$(el);el.format=f;if(el.getTag()=='select'){el.addEvent('change',function(cal){this.changed(cal);}.pass(cal,this));}
else{el.readOnly=true;el.addEvent('focus',function(cal){this.toggle(cal);}.pass(cal,this));}
cal.els.push(el);},evaluate:function(cal){var arr=[null,null,null];cal.els.each(function(el){var values=this.unformat(el.value,el.format);values.each(function(val,i){if($type(val)=='number'){arr[i]=val;}});},this);if($type(arr[0])=='number'){cal.year=arr[0];}
if($type(arr[1])=='number'){cal.month=arr[1];}
var val=null;if(arr.every(function(i){return $type(i)=='number';})){var last=new Date(arr[0],arr[1]+1,0).getDate();if(arr[2]>last){arr[2]=last;}
val=new Date(arr[0],arr[1],arr[2]);}
return(cal.val==val)?null:val;},format:function(date,f){var g='';if(date){var d=date.getDate();var day=this.props.days[date.getDay()];var m=date.getMonth()+1;var month=this.props.months[date.getMonth()];var y=date.getFullYear()+'';for(var i=0;i<f.length;i++){var c=f.charAt(i);switch(c){case'y':y=y.substr(2);case'Y':g+=y;break;case'm':if(m<10){m='0'+m;}
case'n':g+=m;break;case'M':month=month.substr(0,3);case'F':g+=month;break;case'd':if(d<10){d='0'+d;}
case'j':g+=d;break;case'D':day=day.substr(0,3);case'l':g+=day;break;case'S':if(d%10==1&&d!='11'){g+='st';}
else if(d%10==2&&d!='12'){g+='nd';}
else if(d%10==3&&d!='13'){g+='rd';}
else{g+='th';}
break;default:g+=c;}}}
return g;},navigate:function(cal,type,n){switch(type){case'm':if($type(cal.bounds.months)=='array'){var i=cal.bounds.months.indexOf(cal.month)+n;if(i<0||i==cal.bounds.months.length){if(this.props.navigation==1){this.navigate(cal,'y',n);}
i=(i<0)?cal.bounds.months.length-1:0;}
cal.month=cal.bounds.months[i];}
else{var i=cal.month+n;if(i<0||i==12){if(this.props.navigation==1){this.navigate(cal,'y',n);}
i=(i<0)?11:0;}
cal.month=i;}
break;case'y':if($type(cal.bounds.years)=='array'){var i=cal.bounds.years.indexOf(cal.year)+n;cal.year=cal.bounds.years[i];}
else{cal.year+=n;}
break;}
cal.bounds=this.bounds(cal);if($type(cal.bounds.months)=='array'){var i=cal.bounds.months.indexOf(cal.month);if(i<0){cal.month=cal.bounds.months[0];}}
this.display(cal);},options:function(cal){cal.els.each(function(el){if(el.getTag()=='select'&&el.format.test('^(d|j)$')){var d=this.value(cal);if(!d){d=el.value.toInt();}
el.empty();cal.bounds.days.each(function(day){var option=new Element('option',{'selected':(d==day),'value':((el.format=='d'&&day<10)?'0'+day:day)}).appendText(day).injectInside(el);},this);}},this);},sort:function(a,b){return a-b;},toggle:function(cal){document.removeEvent('mousedown',this.fn);if(cal.visible){cal.visible=false;cal.button.removeClass(this.props.classes[8]);this.fx.start(1,0);}
else{this.fn=function(e,cal){var e=new Event(e);var el=e.target;var stop=false;while(el!=document.body&&el.nodeType==1){if(el==this.calendar){stop=true;}
this.calendars.each(function(kal){if(kal.button==el||kal.els.contains(el)){stop=true;}});if(stop){e.stop();return false;}
else{el=el.parentNode;}}
this.toggle(cal);}.create({'arguments':cal,'bind':this,'event':true});document.addEvent('mousedown',this.fn);this.calendars.each(function(kal){if(kal==cal){kal.visible=true;kal.button.addClass(this.props.classes[8]);}
else{kal.visible=false;kal.button.removeClass(this.props.classes[8]);}},this);var coord=cal.button.getCoordinates();var size=window.getSize().size;if(coord.right+this.calendar.coord.width>size.x){coord.right-=(coord.right+this.calendar.coord.width-size.x);}
if(coord.top+this.calendar.coord.height>size.y){coord.top-=(coord.top+this.calendar.coord.height-size.y);}
this.calendar.setStyles({left:coord.right+'px',top:coord.top+'px'});this.display(cal);this.fx.start(0,1);}},unformat:function(val,f){f=f.escapeRegExp();var re={d:'([0-9]{2})',j:'([0-9]{1,2})',D:'('+this.props.days.map(function(day){return day.substr(0,3);}).join('|')+')',l:'('+this.props.days.join('|')+')',S:'(st|nd|rd|th)',F:'('+this.props.months.join('|')+')',m:'([0-9]{2})',M:'('+this.props.months.map(function(month){return month.substr(0,3);}).join('|')+')',n:'([0-9]{1,2})',Y:'([0-9]{4})',y:'([0-9]{2})'}
var arr=[];var g='';for(var i=0;i<f.length;i++){var c=f.charAt(i);if(re[c]){arr.push(c);g+=re[c];}
else{g+=c;}}
var matches=val.match('^'+g+'$');var dates=new Array(3);if(matches){matches=matches.slice(1);arr.each(function(c,i){i=matches[i];switch(c){case'y':i='19'+i;case'Y':dates[0]=i.toInt();break;case'F':i=i.substr(0,3);case'M':i=this.props.months.map(function(month){return month.substr(0,3);}).indexOf(i)+1;case'm':case'n':dates[1]=i.toInt()-1;break;case'd':case'j':dates[2]=i.toInt();break;}},this);}
return dates;},value:function(cal){var day=null;if(cal.val){if(cal.year==cal.val.getFullYear()&&cal.month==cal.val.getMonth()){day=cal.val.getDate();}}
return day;}});