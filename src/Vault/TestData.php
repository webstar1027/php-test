<?php

Interface TestData {
	public function getData($data);	
}

/**
 *  Revserse Array class
 */
class ReverseArray implements TestData {	

   /**
	*  	Reverse Input Array.
	*
	*	@param string array
	*
	*	@return sorted array
	*/
	public function getData($data)
	{
		$array = explode(' ', $data);
		krsort($array);
		return $array;
	}
}

/**
 *  Order Array Class
 */
class OrderArray implements TestData
{
   /**
	*  	Order Input Array.
	*
	*	@param string array
	*
	*	@return sorted array
	*/
	public function getData($data)
	{
		sort($data);
		return $data;
	}
}

/**
 * 	Get Diff Array Class.
 */
class GetDiffArray implements TestData
{
   /**
	*  	Calculate difference between two arrays.
	*
	*	@param array
	*
	*	@return diff array
	*/
	public function getData($data)
	{
		$array = array_diff($data[0], $data[1]);
		return $array;
	}
}


/**
 * Get Distance Class.
 */
class GetDistance implements TestData
{
	/**
	*  	Calculate distance between two geo ponits.
	*
	*	@param point array
	*
	*	@return distance
	*/
	public function getData($data)
	{
		$latFrom = deg2rad($data[0]['lat']);
		$lonFrom = deg2rad($data[0]['lon']);
		$latTo = deg2rad($data[1]['lat']);
		$lonTo = deg2rad($data[1]['lon']);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		// calculate earth radius as mile.

		$earthRadius = 6371000 * 0.6213711922 / 1000;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		$distance = round($angle * $earthRadius, 2);

		return $distance;
	}
}


/**
 * 	Get Diff Time Class
 */
class GetHumanTimeDiff implements TestData
{
   /**
	*  	Calculate difference between two dates.
	*
	*	@param time array
	*
	*	@return difference text
	*/	
	public function getData($data)
	{
		$datetime1 = new DateTime($data[0]);
		$datetime2 = new DateTime($data[1]);
		
		$diff = date_diff($datetime1, $datetime2);
		$text = $this->getDisplayText($diff);

		return $text;
	}	


   /**
	*  	Get display text from date diff object.
	*
	*	@param diff object
	*
	*	@return string display text
	*/
	public function getDisplayText($diff)
	{		
		$displayText = array(
			'y' => 'years', 
			'm' => 'months',
			'd' => 'days',
			'h' => 'hours',
			'i' => 'minutes',
			's' => 'seconds'
		);

		$text = '';

		foreach($diff as $key=>$value) {
			if ($value != 0 && $value > 0) {
				$text .= $value.' '. $displayText[$key]. ' ago';
			}
			if ($value != 0 && $value < 0) {
				$text .= $value.' '. $displayText[$key]. ' later';
			}
		}

		return $text;
	}
}




