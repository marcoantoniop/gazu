/**
- Ajax.InPlaceDateTimeSelect.js -
  Creates several <select> controls in place of the html element with the id
  specified.  It functions similar to "Ajax.InPlaceSelect" but instead
  it creates several <select> boxes with year,month,day,hour,minute for 
  choosing date and time.
  
  Based on "Ajax.InPlaceSelect"
  Created by: Andreas Norman (http://www.subzane.com)
			  Date: 2006-11-07
     Version: 0.91
   
- Syntax -
  new Ajax.InPlaceDateTimeSelect('id', 'url', { options });

- Example -
	new Ajax.InPlaceDateTimeSelect('name-of-div', 'update.php', 
	{showTime: false,	callback: function(year, month, day, hour, minute) { 
		return 'year='+year+'&month='+month+'&day='+day+'&hour='+hour+'&minute='+minute+'&extraParam=1'; 
	}});

- Options('default value') -
  - startYear(current year-5): The start year in the select box
  - endYear(current year+5): The end year in the select box
  - showTime(false): If you wish to use hours and minutes as well
  - monthNames: The name of the months. Translate if needed.
  - hoverClassName(null): class added when mouse hovers over the control
  - hightlightcolor("#FFFF99"): initial color (mouseover)
  - hightlightendcolor("#FFFFFF"): final color (mouseover)
  - parameters(null): additional parameters to send with the request
      (in addition to the data sent by default)
      
-	Todo -

- Modifications below -

- Modified Nov 08, 2006 by Andreas Norman
  - It now reads from innerHTML instead of given params
  - Removed the params year,month,day,hour,minute
  - It now selects correct year
  - Fixed the slow loading issue
*/
Ajax.InPlaceDateTimeSelect = Class.create();
Ajax.InPlaceDateTimeSelect.prototype = {
  initialize:function(element,url,options) {
    this.element = $(element);
    this.url = url;
    this.options = Object.extend({
      okText: "ok",
      startYear: new Date().getFullYear()-5,
      endYear: new Date().getFullYear()+5,
      showTime: false,
      monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      cancelText: "cancel",
      highlightcolor: "#FFFF99",
      highlightendcolor: "#FFFFFF",
      onComplete: function(transport, element) {
        Effect.Highlight(element, {startcolor: this.options.highlightcolor});
      },
      onFailure: function(transport) {
        alert("Error communicating with the server: " + transport.responseText.stripTags());
      },
       callback: function(value, text) {
        return 'newval='+value+'&newtxt='+text;
      },
      savingText: "Saving...",
      savingClassName: 'inplaceeditor-saving',
      clickToEditText: "Click to edit"
    }, options || {} );

    this.originalBackground = Element.getStyle(this.element, 'background-color');
    if (!this.originalBackground) {
      this.originalBackground = "transparent";
    }

    this.element.title = this.options.clickToEditText;

    this.ondblclickListener = this.enterEditMode.bindAsEventListener(this);
    this.mouseoverListener = this.enterHover.bindAsEventListener(this);
    this.mouseoutListener = this.leaveHover.bindAsEventListener(this);

    Event.observe(this.element, 'click', this.ondblclickListener);
    Event.observe(this.element, 'mouseover', this.mouseoverListener);
    Event.observe(this.element, 'mouseout', this.mouseoutListener);
  },
  enterEditMode: function(evt) {
    if (this.saving) {
      return;
    }
    if (this.editing) {
      return;
    }
    this.editing = true;
    Element.hide(this.element);
    this.createControls();
    this.element.parentNode.insertBefore(this.yearmenu, this.element);
    this.element.parentNode.insertBefore(this.monthmenu, this.element);
    this.element.parentNode.insertBefore(this.daymenu, this.element);
    if (this.options.showTime) {
    	this.element.parentNode.insertBefore(this.hourmenu, this.element);
    	this.element.parentNode.insertBefore(this.minutemenu, this.element);
    }
    this.element.parentNode.insertBefore(this.submitButton, this.element);
	  this.element.parentNode.insertBefore(this.cancelButton, this.element);
    return false;
  },
  createControls: function() {
    // Date format: 2006-11-27 18:45 (YYYY-MM-DD HH:mm)
    var fulldate = this.element.innerHTML;
    var sel_year = fulldate.substring(0,4);
    var sel_month = fulldate.substring(5,7);
    var sel_day = fulldate.substring(8,10);
    var sel_hour = fulldate.substring(11,13);
    var sel_minute = fulldate.substring(14,16);

    var year_options = [];
    var years = [];
    var month_options = [];
    var day_options = [];
    var range = this.options.endYear - this.options.startYear+1;
    var i = 0;
    
		for (i=0;i<range;i++) {
			year_options[i] = Builder.node('option', {value:this.options.startYear+i}, this.options.startYear+i);
      years[i] = this.options.startYear+i;
		}
		this.yearmenu = Builder.node('select', year_options);

    for (i=0;i<years.length;i++) {
      if (years[i]==sel_year) {
        this.yearmenu.selectedIndex=i;
        break;
      }
    }

		for (i=1;i<13;i++) {
      month = (i < 10) ? "0"+i : i;
			month_options[i] = Builder.node('option', {value:month}, this.options.monthNames[i-1]);
		}
		this.monthmenu = Builder.node('select', month_options);
		this.monthmenu.selectedIndex=sel_month-1;
		
		for (i=1;i<32;i++) {
      day = (i < 10) ? "0"+i : i;
			day_options[i] = Builder.node('option', {value:day}, day);
		}
		this.daymenu = Builder.node('select', day_options);
	  this.daymenu.selectedIndex=sel_day-1;
	  
	  if (this.options.showTime) {
		  var hour_options = [];
			for (i=1;i<24;i++) {
        hour = (i < 10) ? "0"+i : i;
				hour_options[i] = Builder.node('option', {value:hour}, hour);
			}
			this.hourmenu = Builder.node('select', hour_options);
			this.hourmenu.selectedIndex=sel_hour-1;

		  var minute_options = [];
			for (i=1;i<60;i++) {
        minute = (i < 10) ? "0"+i : i;
				minute_options[i] = Builder.node('option', {value:minute}, minute);
			}
			this.minutemenu = Builder.node('select', minute_options);
			this.minutemenu.selectedIndex=sel_minute-1;
	  
	  }

    this.submitButton = Builder.node('button', this.options.okText);
    this.submitButton.onclick = this.onSubmit.bind(this);
    this.submitButton.className = 'editor_ok_button';
    
    this.cancelButton = Builder.node('a', this.options.cancelText);
    this.cancelButton.onclick = this.onCancel.bind(this);
    this.cancelButton.className = 'editor_cancel';
  },
  onCancel: function() {
    this.onComplete();
    this.leaveEditMode();
    return false;
  },
  onSubmit: function() {
    var year = this.yearmenu.options[this.yearmenu.selectedIndex].value;
    var month = this.monthmenu.options[this.monthmenu.selectedIndex].value;
    var day = this.daymenu.options[this.daymenu.selectedIndex].value;
	  if (this.options.showTime) {
		  hour = this.hourmenu.options[this.hourmenu.selectedIndex].value;
		  minute = this.minutemenu.options[this.minutemenu.selectedIndex].value;
		} else {
		  hour = 0;
		  minute = 0;
		}
    this.onLoading();
    new Ajax.Updater(
    	{
    		success:this.element
    	}, 
    	this.url, 
      Object.extend({
        parameters: this.options.callback(year, month, day, hour, minute),
        onComplete: this.onComplete.bind(this),
        onFailure: this.onFailure.bind(this)
      }, this.options.ajaxOptions)
    );
  },
  onLoading: function() {
    this.saving = true;
    this.removeControls();
    this.leaveHover();
    this.showSaving();
  },
  removeControls:function() {
    if(this.yearmenu) {
      if (this.yearmenu.parentNode) {Element.remove(this.yearmenu);}
      this.yearmenu = null;
    }
    if(this.monthmenu) {
      if (this.monthmenu.parentNode) {Element.remove(this.monthmenu);}
      this.monthmenu = null;
    }
    if(this.daymenu) {
      if (this.daymenu.parentNode) {Element.remove(this.daymenu);}
      this.daymenu = null;
    }
    if(this.hourmenu) {
      if (this.hourmenu.parentNode) {Element.remove(this.hourmenu);}
      this.hourmenu = null;
    }
    if(this.minutemenu) {
      if (this.minutemenu.parentNode) {Element.remove(this.minutemenu);}
      this.minutemenu = null;
    }

    if (this.cancelButton) {
      if (this.cancelButton.parentNode) {Element.remove(this.cancelButton);}
      this.cancelButton = null;
    }
    if (this.submitButton) {
      if (this.submitButton.parentNode) {Element.remove(this.submitButton);}
      this.submitButton = null;
    }
  },
  showSaving:function() {
    this.oldInnerHTML = this.element.innerHTML;
    this.element.innerHTML = this.options.savingText;
    Element.addClassName(this.element, this.options.savingClassName);
    this.element.style.backgroundColor = this.originalBackground;
    Element.show(this.element);
  },
  onComplete: function() {
    this.leaveEditMode();
    //this.options.onComplete.bind(this)(transport, this.element);
  },
  onFailure: function(transport) {
    this.options.onFailure(transport);
    if (this.oldInnerHTML) {
      this.element.innerHTML = this.oldInnerHTML;
      this.oldInnerHTML = null;
    }
    return false;
  },
  enterHover: function() {
    if (this.saving) {return;}
    this.element.style.backgroundColor = this.options.highlightcolor;
    if (this.effect) { this.effect.cancel(); }
    Element.addClassName(this.element, this.options.hoverClassName);
  },
  leaveHover: function() {
    if (this.options.backgroundColor) {
      this.element.style.backgroundColor = this.oldBackground;
    }
    Element.removeClassName(this.element, this.options.hoverClassName);
    if (this.saving) {return;}
    this.effect = new Effect.Highlight(this.element, {
      startcolor: this.options.highlightcolor,
      endcolor: this.options.highlightendcolor,
      restorecolor: this.originalBackground
    });
  },
  leaveEditMode:function(transport) {
    Element.removeClassName(this.element, this.options.savingClassName);
    this.removeControls();
    this.leaveHover();
    this.element.style.backgroundColor = this.originalBackground;
    Element.show(this.element);
    this.editing = false;
    this.saving = false;
    this.oldInnerHTML = null;
  }
};