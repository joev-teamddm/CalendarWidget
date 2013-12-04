var CalendarWidget = function () {
	var current_table = 0;
	var tables = $('.calendar-widget').find('table');
	var num_of_tables = tables.length;

	var generate_header = function(){
		if(current_table == 0){
			$('.calendar-widget .previous-month').hide();
		}else{
			$('.calendar-widget .previous-month').show();
		}

		var month = $(tables[current_table]).data('month');
		var year = $(tables[current_table]).data('year');
		$('.calendar-widget .current-month').text(month + ' ' + year);

		if(current_table == (num_of_tables - 1)){
			$('.calendar-widget .next-month').hide();
		}else{
			$('.calendar-widget .next-month').show();
		}
	}

	$('.calendar-widget .next-month').on('click', function(){
		$(tables[current_table]).hide();
		$(tables[current_table]).next().show();
		current_table = current_table + 1;
		generate_header();
	});

	$('.calendar-widget .previous-month').on('click', function(){
		$(tables[current_table]).hide();
		$(tables[current_table]).prev().show();
		current_table = current_table - 1;
		generate_header();
	});

	$(tables[current_table]).show();
	generate_header();
}

$(document).ready(function(){
	calendar = CalendarWidget();
});