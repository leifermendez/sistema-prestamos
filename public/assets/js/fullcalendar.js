+function($){ "use strict";
	$('.external-event').each(function(){
		$(this).data('event', {
			title: $.trim($(this).text()),
			className: [$(this).data('class')]
		});
	});

	$('.external-event').draggable({
		revert: true,
		revertDuration: 0
	});

	var cal = $('#fullcalendar').fullCalendar({
		theme: true,
		editable: true,
		droppable: true,
		defaultDate: '2016-05-15',
		header: {
			left: 'prev, today, next',
			center: 'title',
			right: 'month, agendaWeek, agendaDay'
		},
		buttonText: {
			prev: '',
			next: ''
		},
		events: [
			{
				"category": "warning",
				"title": "My First Event",
				"start": "2016-05-05",
				"end": "2016-05-8",
				"className": ["warning"]
			},
			{
				"category": "success",
				"title": "Three Days Event",
				"start": "2016-05-11",
				"className": ["success"]
			},
			{
				"category": "warning",
				"title": "Imporatnt Event",
				"start": "2016-05-13",
				"end": "2016-05-15",
				"className": ["danger"]
			},
			{
				"category": "primary",
				"title": "Four Days Event",
				"start": "2016-05-22",
				"end": "2016-05-25",
				"className": ["primary"]
			}
		],
		drop: function(date) {
			if ($('#drop-remove').is(':checked')) {
				$(this).remove();
			}
		},
		dayClick: function(date, jsEvent, view) {
			var modal = $('#new_event_modal');
			modal.modal('show');
			modal.find('#event_start').val(date.format());
		}
	});

	$.fn.windowCheck = function() {
		var ww = $(window).width();
		if(ww > 768) {
			cal.fullCalendar('changeView', 'month');
		} else if(ww < 768 && ww > 540) {
			cal.fullCalendar('changeView', 'basicWeek');
		} else {
			cal.fullCalendar('changeView', 'basicDay');
		}
	};

	$(window).on('resize', function(e){
		$().windowCheck();
	});

	$('.fc-prev-button').append('<i class="fa fa-chevron-left"><i>');
	$('.fc-next-button').append('<i class="fa fa-chevron-right"><i>');

	// add new event category
	$('#new_event_cat_form').on('submit', function(e){
		e.preventDefault();

		var name = $(this).find('#category_name').val();
		var color = $(this).find('#category_color').val();
		var category = $('<div class="external-event"></div>');

		category.text(name);
		category.addClass(color);
		category.data('event', {
			title: name,
			className: [color]
		});

		category.draggable({
			revert: true,
			revertDuration: 0
		});

		$('#external-events').append(category);

 		$('#new_event_cat_modal').modal('hide');
	});

	// add new event
	$('#new_event_form').on('submit', function(e){
		e.preventDefault();

		var title = $(this).find('#event_title').val();
		var category = $(this).find('#event_category').val();
		var start = $(this).find('#event_start').val();

		cal.fullCalendar('addEventSource', [
			{
				title: title,
				start: start,
				className: [category]
			}
		])
		$('#new_event_modal').modal('hide');
	});
}(jQuery);