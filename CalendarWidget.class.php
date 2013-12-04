<?php
class CalendarWidget {

	function __construct()
	{
		$this->url_template = '/events/day/:day';
		$this->max_ym = date('Y-m');
		$this->dates = array();
	}

	//in case you want to process this before rendering
	public function getDatesArray()
	{
		return $this->dates;
	}

	public function render()
	{
		$months = $this->getMonthsToRender();
		foreach($months as $month){
			$this->generateMonthTable($month);
		}
	}

	public function setDate($datetime, $class)
	{
		$datetime = new DateTime($datetime);
		$this->generateMaxYearMonth($datetime);
		
		$ymd = $datetime->format('Y-m-d');
		if(!isset($this->dates[$ymd])){
			$this->dates[$ymd] = array(
				'classes' => array($class)
			);
		}else{
			$this->dates[$ymd]['classes'][] = $class;
		}
	}

	//in case you want to process this before rendering
	public function setDatesArray($dates)
	{
		$this->dates = $dates;
	}

	//if want to override url template in constructor
	public function setUrlTemplate($url_template)
	{
		$this->url_template = $url_template;
	}

	private function generateMaxYearMonth($datetime)
	{
		$ym = $datetime->format('Y-m');
		if($ym > $this->max_ym){
			$this->max_ym = $ym;
		}
	}

	private function generateMonthTable($month)
	{
		$tds = $this->generateTds($month);
		echo '<table class="calendar-widget-table" style="display:none" data-month="' . $month->format('F') . '" data-year="' . $month->format('Y') . '">';
		$i = 1;
		foreach($tds as $td){
			if($i == 1){
				echo '<tr>';
			}
			echo $td;
			if($i == 7){
				echo '</tr>';
				$i = 1;
			}else{
				$i++;
			}
		}
		echo '</table>';
	}

	private function generateTdContents($day, $month)
	{
		$ymd = $month->format('Y-m') . '-' . str_pad($day,2,'0',STR_PAD_LEFT);
		if(isset($this->dates[$ymd])){
			$classes = implode(' ', $this->dates[$ymd]['classes']);
			return '<a class="' . $classes . '" href="' . $this->getUrl($ymd) . '">' . $day . '</a>';
		}else{
			return $day;
		}
	}

	private function generateTds($month)
	{
		$first_day = (int)$month->format('w');
		$num_days_in_month = (int)$month->format('t');
		$total_days = $first_day + $num_days_in_month;
		if($total_days <= 28){
			$num_of_iterations = 28;
		}elseif($total_days <= 35){
			$num_of_iterations = 35;
		}else{
			$num_of_iterations = 42;
		}

		$i = 0;
		$day_of_the_month = 1;
		$tds = array();
		while($i < $num_of_iterations){
			if($i >= $first_day && $i < $total_days){
				$tds[] = '<td>'. $this->generateTdContents($day_of_the_month, $month)  .'</td>';
				$day_of_the_month++;
			}else{
				$tds[] = '<td></td>';
			}
			$i++;
		}
		return $tds;
	}

	private function getMonthsToRender()
	{
		$year_month_array = explode('-', $this->max_ym);
		$max_year = (int)$year_month_array[0];
		$max_month = (int)$year_month_array[1];
		$current_year = (int)date('Y');
		$current_month = (int)date('m');

		$months_to_render = array();
		$i = 0; //a little safety
		while($max_year >= $current_year && $max_month >= $current_month){
			if($i > 24){ //two years, should be enough
				break;
			}

			$months_to_render[] = new Datetime($current_year . '-' . $current_month);

			if($current_month == 12){
				$current_month = 1;
				$current_year++;
			}else{
				$current_month++;
			}
			$i++;
		}
		return $months_to_render;
	}

	private function getUrl($date)
	{
		return str_replace(':day', $date, $this->url_template);
	}

}