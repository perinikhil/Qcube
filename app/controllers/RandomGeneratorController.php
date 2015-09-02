<?php

class RandomGeneratorController extends \BaseController {

	private static $allPickedQuestions;
	private static $allPickedQuestionIds;
	private static $i;

	public function generate($departmentId, $subjectId)
	{
		$paperRequirement = Input::get('paper_data');
		$pattern = Input::get('pattern');
		$noSections = $pattern['no_sections'];
		$noQuestionsPerSection = $pattern['marks_mains'];
		$noQuestionsPerSection = explode('|', $noQuestionsPerSection);
		foreach($noQuestionsPerSection as &$marks)
		{
			$marks = explode(',', $marks);
			$marks = count($marks);
		}
		unset($marks);
		$paper = [];
		$flag=false;						//flag sets to false if there are insufficient questions
		$m=0;
		while($flag==false && $m<100)
		{
			self::$i = 0;
			self::$allPickedQuestions = [];
			self::$allPickedQuestionIds = [];
			$flag=true;
			$paper = [];
			$k=0;
			for($i=0; $i<$noSections; $i++)
			{
				for($j=0; $j<$noQuestionsPerSection[$i]; $j++)
				{
					if(!($paper[$i][$j] = self::randomMain($subjectId, $paperRequirement[$k]['units'],
						$paperRequirement[$k]['marks'])))
						{
							$flag=false;
						}
					$k++;
				}
			}
			$m++;
		}
		if($flag)
			return Response::json($paper);
		else
			return Response::json(['alert' => 'Insufficient questions'], 404);
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
