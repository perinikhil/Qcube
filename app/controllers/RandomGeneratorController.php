<?php

class RandomGeneratorController extends \BaseController {

	private static $allPickedQuestions;
	private static $allPickedQuestionIds;
	private static $i;

	public function generate($departmentId, $subjectId)
	{
		self::$i = 0;
		self::$allPickedQuestions = [];
		self::$allPickedQuestionIds = [];

		$paperRequirement = Input::get('paper_data');
		$noSections = Input::get('pattern')['no_sections'];
		$noQuestionsPerMain = Input::get('pattern')['marks_mains'];
		$noQuestionsPerMain = explode('|', $noQuestionsPerMain);
		foreach($noQuestionsPerMain as &$marks)
		{
			$marks = explode(',', $marks);
			$marks = count($marks);
		}
		unset($marks);
		// return Response::json($noQuestionsPerMain);
		$paper = [];
		for($i=0; $i<$noSections; $i++)
		{
			for($j=0; $j<$noQuestionsPerMain[$i]; $j++)
			{
				if(!($paper[$i][$j] = self::randomMain($subjectId, $paperRequirement[$i*$noSections+$j]['units'],
					$paperRequirement[$i*$noSections+$j]['marks'])))
						return Response::json(['alert' => 'Insufficient questions'], 404);
			}
		}
		// foreach($paperRequirement as &$requirement)
		// {
		// 	$requirement = (object)$requirement;
		// 	// $requirement->question = [];
		// 	if(!($requirement->questions = self::randomMain($subjectId, $requirement->units, $requirement->marks)))
		// }
		// unset($requirement);
		return Response::json($paper);
	}

	public function randomMain($subjectId, $units, $totalMarks)
	{
		// $countDistinctMarks = [];

		if(self::$i == 0)
			$allMarks = Question::select('marks')->where('subject_id', $subjectId)->whereIn('unit', $units)->get();
		else
			$allMarks = Question::select('marks')->where('subject_id', $subjectId)->whereIn('unit', $units)->whereNotIn('id', self::$allPickedQuestionIds)->get();

		if(count($allMarks) == 0)	return false;
		$length = sizeof($allMarks)/sizeof($allMarks[0]);

		$answer = self::randomMainSumOfSubsets($allMarks, $length, $totalMarks);
		// return $answer;

		if($answer == true)
		{
			$questions = self::pickRandomMain($subjectId, $units, $totalMarks);
			return $questions;
		}
		else
		{
			return false;
		}
	}

	private function randomMainSumOfSubsets($set, $n, $sum)
	{

		if($sum == 0)
			return true;
		else if($n == 0 && $sum > 0)
			return false;
		else if($set[$n-1]->marks > $sum)
			return self::randomMainSumOfSubsets($set, $n-1, $sum);
		else
			return (self::randomMainSumOfSubsets($set, $n-1, $sum - $set[$n-1]->marks) || self::randomMainSumOfSubsets($set, $n-1, $sum));

	}

	private function pickRandomMain($subjectId, $units, $totalMarks)
	{
		$curPickedQuestions = [];
		$j=0;
		do
		{
			$remainingMarks = $totalMarks;

			while($remainingMarks > 0)
			{
				if(sizeof(self::$allPickedQuestions) == 0)
				{
					$question = Question::where('subject_id', $subjectId)->whereIn('unit', $units)
						->where('marks', '<=', $remainingMarks)->get()->random(1);
					if($question)
						$question->attachments = $question->attachments;
				}
				else
				{
					$question = Question::where('subject_id', $subjectId)->whereIn('unit', $units)
						->where('marks', '<=', $remainingMarks)->whereNotIn('id', self::$allPickedQuestionIds)->get()->random(1);
					if($question)
						$question->attachments = $question->attachments;
				}

				self::$allPickedQuestions[self::$i] = $question;
				self::$allPickedQuestionIds[self::$i] = $question['id'];
				$curPickedQuestions[$j++] = $question;
				$remainingMarks -= $question['marks'];
				self::$i+=1;
			}
		}while(!($remainingMarks == 0));

		return $curPickedQuestions;
	}
}
