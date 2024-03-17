// Calendar: a Javascript class for Mootools that adds accessible and unobtrusive date pickers to your form elements <http://electricprism.com/aeron/calendar>
// Calendar RC2, Copyright (c) 2007 Aeron Glemann <http://electricprism.com/aeron>, MIT Style License.

var Calendar = new Class({	
	initialize: function(obj, props) {
		this.props = Object.extend({
			blocked: [], // blocked dates 
			classes: ['calendar', 'prev', 'next', 'month', 'year', 'invalid', 'valid', 'inactive', 'active', 'hover'],
			days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // days of the week starting at sunday
			direction: 0, // -1 past, 0 past + future, 1 future
			draggable: true,
			months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			navigation: 1, // 0 = no nav; 1 = single nav for month; 2 = dual nav for month and year
			offset: 0, // first day of the week: 0 = sunday, 1 = monday, etc..
			pad: 1 // padding between calendars
		}, props || {});		

		// basic error checking
		if (obj == null || obj.length == 0) { return false; }

		// make sure the offset is within 0 - 6
		this.props.offset %= 7;

		// create cal element with css styles required for proper cal functioning
		this.calendar = new Element('div', { 
			'styles': { left: '-1000px', opacity: 0, position: 'absolute', top: '-1000px', zIndex: 1000 }
		}).addClass(this.props.classes[0]).injectInside(document.body);

		this.calendar.coord = this.calendar.getCoordinates();

		// initialize fade method
		this.fx = this.calendar.effect('opacity', { 
			onStart: function() { if (this.element.getStyle('opacity') == 0) { this.element.setStyle('display', 'block'); }},
			onComplete: function() { if (this.element.getStyle('opacity') == 0) { this.element.setStyle('display', 'none'); }}
		});
		
		// initialize drag method
		if (window.Drag && this.props.draggable) { new Drag.Move(this.calendar); }

		// create calendars array
		this.calendars = [];

		var id = 0;
		var d = new Date(); // today

		d.setDate(d.getDate() + this.props.direction.toInt()); // correct today for directional offset

		for (var i in obj) {
			var cal = { 
				button: new Element('button', { 'type': 'button' }),
				el: $(i),
				els: [],
				id: id++,
				month: d.getMonth(),
				visible: false,
				year: d.getFullYear()
			};

			this.element(i, obj[i], cal);
			
			cal.el.addClass(this.props.classes[0]);

			// create cal button
			cal.button.addClass(this.props.classes[0]).addEvent('click', function(cal) { this.toggle(cal); }.pass(cal, this)).injectAfter(cal.el);

			// read in default value
			cal.val = this.evaluate(cal);

			cal.bounds = this.bounds(cal); // cache bounds so we can speed things up

			this.options(cal);

			this.calendars.push(cal); // add to cals array		
		}	
	},


	// blocked: returns an array of blocked days for the month / year
	// @param cal (obj)
	// @returns blocked days (array)

	blocked: function(cal) {
		var blocked = [];
		var offset = new Date(cal.year, cal.month, 1).getDay(); // day of the week (offset)
		var last = new Date(cal.year, cal.month + 1, 0).getDate(); // last day of this month
		
		this.props.blocked.each(function(date) {
			var values = date.split(' ');

			for (var i = 0; i < 3; i++) { 
				if (!values[i]) { values[i] = '*'; } // make sure blocked date contains values for at least d, m and y
				values[i] = values[i].contains(',') ? values[i].split(',') : new Array(values[i]); // split multiple values
			}

			if (values[2].contains(cal.year + '') || values[2].contains('*')) {
				if (values[1].contains(cal.month + 1 + '') || values[1].contains('*')) {
					values[0].each(function(val) { // if blocked value indicates this month / year
						if (val > 0) { blocked.push(val.toInt()); } // add date to blocked array
					});

					if (values[3]) { // optional value for day of week
						values[3] = values[3].contains(',') ? values[3].split(',') : new Array(values[3]);

						for (var i = 0; i < last; i++) {
								var day = (i + offset) % 7;
	
								if (values[3].contains(day + '')) { 
									blocked.push(i + 1); // add every date that corresponds to the blocked day of the week to the blocked array
								}
						}
					}
				}
			}
		}, this);

		return blocked;
	},
	

	// bounds: returns an object with the clickable days in a month based on a calendars month and year values
	// @param cal (obj)
	// @returns obj	

	bounds: function(cal) {
		// 1. first we need to get our bounds - thats the absolute start + end dates that our cal will accept

		// by default the calendar will accept a millennium in either direction
		var start = new Date(1000, 0, 1); // jan 1, 1000
		var end = new Date(2999, 11, 31); // dec 31, 2999

		// if calendar is one directional adjust cal accordingly
		var date = new Date().getDate() + this.props.direction.toInt();

		if (this.props.direction > 0) {
			start = new Date();
			start.setDate(date + this.props.pad * cal.id);
		}
		
		if (this.props.direction < 0) {
			end = new Date();
			end.setDate(date - this.props.pad * (this.calendars.length - cal.id - 1));
		}

		var years, months, days;

		cal.els.each(function(el) {	
			if (el.getTag() == 'select') {		
				if (el.format.test('(y|Y)')) { // search for a year select
					years = [];

					el.getChildren().each(function(option) { // get options
						var values = this.unformat(option.value, el.format);
	
						if (!years.contains(values[0])) { years.push(values[0]); } // add to years array
					}, this);
	
					years.sort(this.sort);
			
					if (years[0] > start.getFullYear()) { 
						d = new Date(years[0], start.getMonth() + 1, 0); // last day of new month
					
						if (start.getDate() > d.getDate()) { start.setDate(d.getDate()); }
	
						start.setYear(years[0]); 
					}
					
					if (years.getLast() < end.getFullYear()) { 
						d = new Date(years.getLast(), end.getMonth() + 1, 0); // last day of new month
					
						if (end.getDate() > d.getDate()) { end.setDate(d.getDate()); }
	
						end.setYear(years.getLast());
					}		
				}
	
				if (el.format.test('(F|m|M|n)')) { // search for a month select
					months = [];

					el.getChildren().each(function(option) { // get options
						var values = this.unformat(option.value, el.format);
	
						if ($type(values[0]) != 'number' || values[0] == cal.year) { // if it's a year / month combo for curr year, or simply a month select
							if (!months.contains(values[1])) { months.push(values[1]); } // add to months array
						}
					}, this);
	
					months.sort(this.sort);
					
					if (start.getFullYear() == cal.year && months[0] > start.getMonth()) { 
						d = new Date(start.getFullYear(), months[0] + 1, 0); // last day of new month
					
						if (start.getDate() > d.getDate()) { start.setDate(d.getDate()); }
	
						start.setMonth(months[0]); 
					}
					
					if (end.getFullYear() == cal.year && months.getLast() < end.getMonth()) { 
						d = new Date(start.getFullYear(), months.getLast() + 1, 0); // last day of new month
					
						if (end.getDate() > d.getDate()) { end.setDate(d.getDate()); }
	
						end.setMonth(months.getLast());
					}		
				}
				
				if (el.format.test('(d|j)') && !el.format.test('^(d|j)$')) { // search for a day select, but NOT a days only select
					days = [];
					
					el.getChildren().each(function(option) { // get options
						var values = this.unformat(option.value, el.format);

						// in the special case of days we dont want the value if its a days only select
						// otherwise that will screw up the options rebuilding
						// we will take the values if they are exact dates though
						if (values[0] == cal.year && values[1] == cal.month) {
							if (!days.contains(values[2])) { days.push(values[2]); } // add to months array
						}
					}, this);
				}
			}
		}, this);
		
		// 2. now we can figure out the range of valid days for the current month

		// we start with what would be the first and last days were there no restrictions
		var first = 1;
		var last = new Date(cal.year, cal.month + 1, 0).getDate(); // last day of the month
		var prev = { 'month': true, 'year': true }; // we also assume navigation is allowed
		var next = { 'month': true, 'year': true };
		
		// if we're in an out of bounds year
		if (cal.year == start.getFullYear()) { prev.year = false; }		
		if (cal.year == end.getFullYear()) { next.year = false; }

		// if we're in an out of bounds month
		if (cal.year == start.getFullYear() && cal.month == start.getMonth()) { 
			if (this.props.navigation == 1) { prev.month = false; }
			first = start.getDate(); // first day equals day of bound
		}		
		if (cal.year == end.getFullYear() && cal.month == end.getMonth()) { 
			if (this.props.navigation == 1) { next.month = false; }
			last = end.getDate(); // last day equals day of bound
		}

		// finally we can prepare all the valid days in a neat little array
		var blocked = this.blocked(cal);

		if ($type(days) == 'array') { // somewhere there was a days select
			days = days.filter(function(day) {
				if (day >= first && day <= last && !blocked.contains(day)) { return day; }
			});
		}
		else { // no days select we'll need to construct a valid days array
			days = [];
			
			for (var i = first; i <= last; i++) { 
				if (!blocked.contains(i)) { days.push(i); }
			}
		}		

		days.sort(this.sort); // sorting our days will give us first and last of month

		return { 'days': days, 'months': months, 'years': years, 'prev': prev, 'next': next, 'start':start, 'end': end };
	},


	// caption: returns the caption element with header and navigation
	// @param cal (obj)
	// @returns caption (element)

	caption: function(cal) {
		var caption = new Element('caption');

		var prev = new Element('a').addClass(this.props.classes[1]).appendText('\x3c'); // <		
		var next = new Element('a').addClass(this.props.classes[2]).appendText('\x3e'); // >

		if (this.props.navigation == 2) {
			var month = new Element('span').addClass(this.props.classes[3]).injectInside(caption);
			
			if (cal.bounds.prev.month) { prev.clone().addEvent('click', function(cal) { this.navigate(cal, 'm', -1); }.pass(cal, this)).injectInside(month); }
			
			month.adopt(new Element('span').appendText(this.props.months[cal.month]));

			if (cal.bounds.next.month) { next.clone().addEvent('click', function(cal) { this.navigate(cal, 'm', 1); }.pass(cal, this)).injectInside(month); }

			var year = new Element('span').addClass(this.props.classes[4]).injectInside(caption);

			if (cal.bounds.prev.year) { prev.clone().addEvent('click', function(cal) { this.navigate(cal, 'y', -1); }.pass(cal, this)).injectInside(year); }
			
			year.adopt(new Element('span').appendText(cal.year));

			if (cal.bounds.next.year) { next.clone().addEvent('click', function(cal) { this.navigate(cal, 'y', 1); }.pass(cal, this)).injectInside(year); }
		}
		else { // 1 or 0
			if (cal.bounds.prev.month && this.props.navigation) { prev.clone().addEvent('click', function(cal) { this.navigate(cal, 'm', -1); }.pass(cal, this)).injectInside(caption); }

			caption.adopt(new Element('span').addClass(this.props.classes[3]).appendText(this.props.months[cal.month]));
			
			caption.adopt(new Element('span').addClass(this.props.classes[4]).appendText(cal.year));
			
			if (cal.bounds.next.month && this.props.navigation) { next.clone().addEvent('click', function(cal) { this.navigate(cal, 'm', 1); }.pass(cal, this)).injectInside(caption); }

		}

		return caption;
	},


	// changed: run when a select value is changed
	// @param cal (obj)

	changed: function(cal) {
		cal.val = this.evaluate(cal); // update calendar val from inputs	

		cal.bounds = this.bounds(cal); // update bounds

		this.options(cal); 

		if (cal.val) {
			if (cal.val.getDate() < cal.bounds.days[0]) { cal.val.setDate(cal.bounds.days[0]); }
			if (cal.val.getDate() > cal.bounds.days.getLast()) { cal.val.setDate(cal.bounds.days.getLast()); }
			
			cal.els.each(function(el) {	// then we can set the value to the field
				el.value = this.format(cal.val, el.format); 		
			}, this);
		}

		if (!cal.val) { return; } // in case the same date was clicked the cal has no set date we should exit		
		
		this.check(cal); // checks other cals

		if (cal.visible) { this.display(cal); } // update cal graphic if visible
	},


	// clicked: run when a valid day is clicked in the calendar
	// @param cal (obj)

	clicked: function(cal) {
		this.options(cal);	 // in the case of options, we'll need to make sure we have the correct number of days available
		
		cal.els.each(function(el) {	// then we can set the value to the field
			el.value = this.format(cal.val, el.format); 		
		}, this);
	},
	

	// check: checks other calendars to make sure no overlapping values
	// @param cal (obj)

	check: function(cal) {
		if (!cal.val) { return; }
		
		this.calendars.each(function(kal, i) {
			if (kal.val) { // if calendar has value set
				var change = false;
			
				if (i < cal.id) { // preceding calendar
					var bound = new Date(Date.parse(cal.val));
					
					bound.setDate(bound.getDate() - (this.props.pad * (cal.id - i)));

					if (bound < kal.val) { change = true; }
				}
				if (i > cal.id) { // following calendar
					var bound = new Date(Date.parse(cal.val));
					
					bound.setDate(bound.getDate() + (this.props.pad * (i - cal.id)));
					
					if (bound > kal.val) { change = true; }
				}

				if (change) {
					if (kal.bounds.start > bound) { bound = kal.bounds.start; }
					if (kal.bounds.end < bound) { bound = kal.bounds.end; }

					kal.val = bound;
					kal.month = bound.getMonth();
					kal.year = bound.getFullYear();
					
					kal.bounds = this.bounds(kal); // update bounds

					this.clicked(kal);

					if (kal.visible) { this.display(kal); } // update cal graphic if visible
				}
			}
		}, this);
	},
	

	// display: create calendar element
	// @param cal (obj)

	display: function(cal) {
		// 1. header and navigation
		this.calendar.empty(); // init div

		this.calendar.className = this.props.classes[0] + ' ' + this.props.months[cal.month].toLowerCase();

		var div = new Element('div').injectInside(this.calendar); // a wrapper div to help correct browser css problems with the caption element

		var table = new Element('table').injectInside(div).adopt(this.caption(cal));
				
		// 2. day names		
		var thead = new Element('thead').injectInside(table);

		var tr = new Element('tr').injectInside(thead);
		
		for (var i = 0; i <= 6; i++) {
			var th = this.props.days[(i + this.props.offset) % 7];
			
			tr.adopt(new Element('th', { 'title': th }).appendText(th.substr(0, 1)));
		}

		// 3. day numbers
		var tbody = new Element('tbody').injectInside(table);
		var tr = new Element('tr').injectInside(tbody);

		var offset = new Date(cal.year, cal.month, 1).getDay() - this.props.offset; // day of the week (offset)
		var last = new Date(cal.year, cal.month + 1, 0).getDate(); // last day of this month
		var prev_last = new Date(cal.year, cal.month, 0).getDate(); // last day of previous month
		var active = this.value(cal);
		var inactive = [];
		this.calendars.each(function(kal) {
			if (kal != cal && kal.val) {
				if (cal.year == kal.val.getFullYear() && cal.month == kal.val.getMonth()) { inactive.push(kal.val.getDate()); }
			}
		}, this);
		var valid = cal.bounds.days;

		for (var i = 1; i < 43; i++) {
			if ((i - 1) % 7 == 0) { tr = new Element('tr').injectInside(tbody); } // 6 weeks

			var td = new Element('td').injectInside(tr);
						
			var day = i - offset;
			
			var cls = '';
			
			if (day === active) { cls = this.props.classes[8]; } // active
			else if (inactive.contains(day)) { cls = this.props.classes[7]; } // inactive
			else if (valid.contains(day)) { cls = this.props.classes[6]; } // valid
			else if (day >= 1 && day <= last) { cls = this.props.classes[5]; } // invalid

			td.addClass(cls);

			if (valid.contains(day)) {
				td.setProperty('title', this.format(new Date(cal.year, cal.month, day), 'D M jS Y'));
				
				td.addEvents({
					'click': function(td, day, cal) { 
						cal.val = (this.value(cal) == day) ? null : new Date(cal.year, cal.month, day); // set new value - if same then disable

						this.clicked(cal); 

						// ok - in the special case that it's all selects and there's always a date no matter what (at least as far as the form is concerned)
						// we can't let the calendar undo a date selection - it's just not possible!!
						if (!cal.val) { cal.val = this.evaluate(cal); }

						if (cal.val) {
							this.check(cal); // checks other cals						
							this.toggle(cal); // hide cal
						} 
						else { // remove active class and replace with valid
							td.addClass(this.props.classes[6]);
							td.removeClass(this.props.classes[8]);
						}
					}.pass([td, day, cal], this),
					'mouseover': function(td, cls) { 
						td.addClass(cls); 
					}.pass([td, this.props.classes[9]]),
					'mouseout': function(td, cls) { 
						td.removeClass(cls); 
					}.pass([td, this.props.classes[9]])
				});
			}

			// pad calendar with last days of prev month and first days of next month
			if (day < 1) { day = prev_last + day; }
			else if (day > last) { day = day - last; }

			td.appendText(day);
		}
	},


	// element: helper function
	// @param el (string) element id
	// @param f (string) format string
	// @param cal (obj)

	element: function(el, f, cal) {
		if ($type(f) == 'object') { // in the case of multiple inputs per calendar
			for (var i in f) { this.element(i, f[i], cal); }
			return;
		}

		el = $(el);
		
		el.format = f;
		
		if (el.getTag() == 'select') { // select elements allow the user to manually set the date via select option
			el.addEvent('change', function(cal) { this.changed(cal); }.pass(cal, this));
		}
		else { // input (type text) elements restrict the user to only setting the date via the calendar
			el.readOnly = true;
			el.addEvent('focus', function(cal) { this.toggle(cal); }.pass(cal, this));
		}

		cal.els.push(el);
	},


	// evaluate: compiles cal value based on array of inputs passed in
	// @param cal (obj)
	// @returns date (obj) or (null)

	evaluate: function(cal) {
		var arr = [null, null, null];

		cal.els.each(function(el) {
			// returns an array which may contain empty values
			var values = this.unformat(el.value, el.format);
			
			values.each(function(val, i) { 
				if ($type(val) == 'number') { arr[i] = val; }
			}); 
		}, this);

		// we can update the cals month and year values
		if ($type(arr[0]) == 'number') { cal.year = arr[0]; }
		if ($type(arr[1]) == 'number') { cal.month = arr[1]; }

		var val = null;

		if (arr.every(function(i) { return $type(i) == 'number'; })) { // if valid date
			var last = new Date(arr[0], arr[1] + 1, 0).getDate(); // last day of month

			if (arr[2] > last) { arr[2] = last; } // make sure we stay within the month (ex in case default day of select is 31 and month is feb)
			
			val = new Date(arr[0], arr[1], arr[2]);
		}

		return (cal.val == val) ? null : val; // if new date matches old return null (same date clicked twice = disable)
	},

	
	// format: formats a date object according to passed in instructions
	// @param date (obj)
	// @param f (string) any combination of punctuation / separators and d, j, D, l, S, m, n, F, M, y, Y
	// @returns string

	format: function(date, f) {
		var g = '';
		
		if (date) {
			var d = date.getDate(); // 1 - 31
			var day = this.props.days[date.getDay()]; // Sunday - Saturday
			var m = date.getMonth() + 1; // 1 - 12
			var month = this.props.months[date.getMonth()]; // January - December
			var y = date.getFullYear() + ''; // 19xx - 20xx
			
			for (var i = 0; i < f.length; i++) {
				var c = f.charAt(i); // format char
				
				switch(c) {
					// year cases
					case 'y': // xx - xx
						y = y.substr(2);
					case 'Y': // 19xx - 20xx
						g += y;
						break;
	
					// month cases
					case 'm': // 01 - 12
						if (m < 10) { m = '0' + m; }
					case 'n': // 1 - 12
						g += m;
						break;
	
					case 'M': // Jan - Dec
						month = month.substr(0, 3);
					case 'F': // January - December
						g += month;
						break;
	
					// day cases
					case 'd': // 01 - 31
						if (d < 10) { d = '0' + d; }
					case 'j': // 1 - 31
						g += d;
						break;
	
					case 'D': // Sun - Sat
						day = day.substr(0, 3);
					case 'l': // Sunday - Saturday
						g += day;
						break;
	
					case 'S': // st, nd, rd or th (works well with j)
						if (d % 10 == 1 && d != '11') { g += 'st'; }
						else if (d % 10 == 2 && d != '12') { g += 'nd'; }
						else if (d % 10 == 3 && d != '13') { g += 'rd'; }
						else { g += 'th'; }
						break;
	
					default:
						g += c;
				}
			}
		}

	  return g; //  return format with values replaced
	},


	// navigate: calendar navigation
	// @param cal (obj)
	// @param type (str) m or y for month or year
	// @param n (int) + or - for next or prev

	navigate: function(cal, type, n) {
		switch (type) {
			case 'm': // month
					if ($type(cal.bounds.months) == 'array') {
						var i = cal.bounds.months.indexOf(cal.month) + n; // index of current month
						
						if (i < 0 || i == cal.bounds.months.length) { // out of range
							if (this.props.navigation == 1) { // if type 1 nav we'll need to increment the year
								this.navigate(cal, 'y', n);		
							}
		
							i = (i < 0) ? cal.bounds.months.length - 1 : 0;
						}

						cal.month = cal.bounds.months[i];
					}
					else { 
						var i = cal.month + n;
		
						if (i < 0 || i == 12) {
							if (this.props.navigation == 1) {
								this.navigate(cal, 'y', n);	
							}
		
							i = (i < 0) ? 11 : 0;
						}
						
						cal.month = i;
					}		
					break;

				case 'y': // year
					if ($type(cal.bounds.years) == 'array') {
						var i = cal.bounds.years.indexOf(cal.year) + n;

						cal.year = cal.bounds.years[i]; 
					}
					else { 
						cal.year += n;
					}						
					break;		
		}

		cal.bounds = this.bounds(cal);

		if ($type(cal.bounds.months) == 'array') { // if the calendar has a months select
			var i = cal.bounds.months.indexOf(cal.month); // and make sure the curr months exists for the new year

			if (i < 0) { cal.month = cal.bounds.months[0]; } // otherwise we'll reset the month
		}


		this.display(cal);
	},


	// options: in the special case that a cal implements a day select, rebuilds the select upon cal change
	// @param cal (obj)

	options: function(cal) {
		cal.els.each(function(el) {			
			if (el.getTag() == 'select' && el.format.test('^(d|j)$')) { // special case for days select
				var d = this.value(cal);

				if (!d) { d = el.value.toInt(); } // if the calendar doesn't have a set value, try to use value from select

				el.empty(); // initialize select

				cal.bounds.days.each(function(day) {
					// create an option element
					var option = new Element('option', {
						'selected': (d == day),
						'value': ((el.format == 'd' && day < 10) ? '0' + day : day)
					}).appendText(day).injectInside(el);
				}, this);
			}
		}, this); 
	},


	// sort: helper function for numerical sorting

	sort: function(a, b) {
		return a - b;
	},


	// toggle: show / hide calendar 
	// @param cal (obj)

	toggle: function(cal) {
		document.removeEvent('mousedown', this.fn); // always remove the current mousedown script first
			
		if (cal.visible) { // simply hide curr cal						
			cal.visible = false;
			cal.button.removeClass(this.props.classes[8]); // active
			
			this.fx.start(1, 0);
		}
		else { // otherwise show (may have to hide others)
			// hide cal on out-of-bounds click
			this.fn = function(e, cal) { 
				var e = new Event(e);
			
				var el = e.target;

				var stop = false;
				
				while (el != document.body && el.nodeType == 1) {
					if (el == this.calendar) { stop = true; }
					this.calendars.each(function(kal) {
						if (kal.button == el || kal.els.contains(el)) { stop = true; }
					});

					if (stop) { 
						e.stop();
						return false;
					}
					else { el = el.parentNode; }
				}
				
				this.toggle(cal);
			}.create({ 'arguments': cal, 'bind': this, 'event': true });				

			document.addEvent('mousedown', this.fn);

			this.calendars.each(function(kal) {
				if (kal == cal) {
					kal.visible = true;
					kal.button.addClass(this.props.classes[8]); // css c-icon-active
				}
				else {
					kal.visible = false;
					kal.button.removeClass(this.props.classes[8]); // css c-icon-active
				}
			}, this);
			
			var coord = cal.button.getCoordinates();
			var size = window.getSize().size;

			// make sure the calendar doesn't open off screen (does't work in safari!?)
			if (coord.right + this.calendar.coord.width > size.x) { coord.right -= (coord.right + this.calendar.coord.width - size.x); }
			if (coord.top + this.calendar.coord.height > size.y) { coord.top -= (coord.top + this.calendar.coord.height - size.y); }
			
			this.calendar.setStyles({ left: coord.right + 'px', top: coord.top + 'px' });

			this.display(cal);
			
			this.fx.start(0, 1);
		}
	},


	// unformat: takes a value from an input and parses the d, m and y elements
	// @param val (string)
	// @param f (string) any combination of punctuation / separators and d, j, D, l, S, m, n, F, M, y, Y
	// @returns array
	
	unformat: function(val, f) {
		f = f.escapeRegExp();
		
		var re = {
			d: '([0-9]{2})',
			j: '([0-9]{1,2})',
			D: '(' + this.props.days.map(function(day) { return day.substr(0, 3); }).join('|') + ')',					
			l: '(' + this.props.days.join('|') + ')',
			S: '(st|nd|rd|th)',
			F: '(' + this.props.months.join('|') + ')',
			m: '([0-9]{2})',
			M: '(' + this.props.months.map(function(month) { return month.substr(0, 3); }).join('|') + ')',					
			n: '([0-9]{1,2})',
			Y: '([0-9]{4})',
			y: '([0-9]{2})'
		}

		var arr = []; // array of indexes

		var g = '';

		// convert our format string to regexp
		for (var i = 0; i < f.length; i++) {
			var c = f.charAt(i);
			
			if (re[c]) {
				arr.push(c);

				g += re[c];
			}
			else {
				g += c;
			}
		}

		// match against date
		var matches = val.match('^' + g + '$');
		
		var dates = new Array(3);

		if (matches) {
			matches = matches.slice(1); // remove first match which is the date

			arr.each(function(c, i) {
				i = matches[i];
				
				switch(c) {
					// year cases
					case 'y':
						i = '19' + i; // 2 digit year assumes 19th century (same as JS)
					case 'Y':
						dates[0] = i.toInt();
						break;

					// month cases
					case 'F':
						i = i.substr(0, 3);
					case 'M':
						i = this.props.months.map(function(month) { return month.substr(0, 3); }).indexOf(i) + 1;
					case 'm':
					case 'n':
						dates[1] = i.toInt() - 1;
						break;

					// day cases
					case 'd':
					case 'j':
						dates[2] = i.toInt();
						break;
				}
			}, this);
		}

		return dates;
	},


	// value: returns day value of calendar if set
	// @param cal (obj)
	// @returns day (int) or null

	value: function(cal) {
		var day = null;

		if (cal.val) {
			if (cal.year == cal.val.getFullYear() && cal.month == cal.val.getMonth()) { day = cal.val.getDate(); }
		}

		return day;
	}
});