<?php

class RandomGeneratorController extends \BaseController {

	public function randomQuestions($subjectId)
	{
		// $subjectId = Input::get('subject_id');
		$unit = Input::get('unit');
		$totalMarks = Input::get('marks');
		// if(Input::has('numberOfQuestions'))
		$numberOfQuestions = Input::get('numberOfQuestions');
		// else
		// 	return Redirect::to('random-main')
		// 				->with(Input::all());

		$countDistinctMarks = [];
		$i = 0;

		$allMarks = Question::select('marks')->get();
		$length = sizeof($allMarks)/sizeof($allMarks[0]);

		$answer = self::randomQuestionsSumOfSubsets($allMarks, $length, $totalMarks, $numberOfQuestions);
		// print_r($answer);

		if($answer == true)
		{
			$questions = self::pickRandomQuestions($subjectId, $unit, $totalMarks, $numberOfQuestions);
			return Response::json($questions);
		}
		else
		{
			return Response::json(['success' => 'failed',
									'alert' => 'Warning! Cannot find any subset of questions for given marks']);
		}
	}

	private function randomQuestionsSumOfSubsets($set, $n, $sum, $numberOfQuestions)
	{

		if($sum == 0 && $numberOfQuestions == 0)
			return true;
		else if($sum == 0 && $numberOfQuestions != 0)
			return false;
		else if($n == 0 && $sum > 0)
			return false;
		else if($set[$n-1]->marks > $sum)
			return self::randomQuestionsSumOfSubsets($set, $n-1, $sum, $numberOfQuestions);
		else
			return (self::randomQuestionsSumOfSubsets($set, $n-1, $sum - $set[$n-1]->marks, $numberOfQuestions-1) || self::randomQuestionsSumOfSubsets($set, $n-1, $sum, $numberOfQuestions));

	}

	private function pickRandomQuestions($subjectId, $unit, $totalMarks, $numberOfQuestions)
	{
		$pickedQuestions = [];

		do
		{
			$remainingMarks = $totalMarks;
		
			$i = 0;
			$pickedQuestions = [];
			$pickedQuestionIds = [];

			while($remainingMarks > 0 && sizeof($pickedQuestionIds) < $numberOfQuestions)
			{
				if(sizeof($pickedQuestions) == 0)
				{
					$question = Question::where('subject_id', $subjectId)->where('marks', '<=', $remainingMarks)->get()->random(1);
				}
				else
				{
					$question = Question::where('subject_id', $subjectId)->where('marks', '<=', $remainingMarks)->whereNotIn('id', $pickedQuestionIds)->get()->random(1);
				}

				$pickedQuestions[$i] = $question;
				$pickedQuestionIds[$i] = $question['id'];
				$remainingMarks -= $question['marks'];
				$i++;
			}
		}while(!($remainingMarks == 0 && sizeof($pickedQuestionIds) == $numberOfQuestions));

		return $pickedQuestions;
	}

	public function randomMain($subjectId)
	{
		// $subjectId = Input::get('subject_id');
		$unit = Input::get('unit');
		$totalMarks = Input::get('marks');

		$countDistinctMarks = [];
		$i = 0;

		$allMarks = Question::select('marks')->get();
		$length = sizeof($allMarks)/sizeof($allMarks[0]);

		$answer = self::randomMainSumOfSubsets($allMarks, $length, $totalMarks);
		// print_r($answer);

		if($answer == true)
		{
			$questions = self::pickRandomMain($subjectId, $unit, $totalMarks);
			return Response::json($questions);
		}
		else
		{
			return Response::json(['success' => 'failed',
									'alert' => 'Warning! Cannot find any subset of questions for given marks']);
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

	private function pickRandomMain($subjectId, $unit, $totalMarks)
	{
		$pickedQuestions = [];

		do
		{
			$remainingMarks = $totalMarks;
		
			$i = 0;
			$pickedQuestions = [];
			$pickedQuestionIds = [];

			while($remainingMarks > 0)
			{
				if(sizeof($pickedQuestions) == 0)
				{
					$question = Question::where('subject_id', $subjectId)->where('unit', $unit)->where('marks', '<=', $remainingMarks)->get()->random(1);
				}
				else
				{
					$question = Question::where('subject_id', $subjectId)->where('unit', $unit)->where('marks', '<=', $remainingMarks)->whereNotIn('id', $pickedQuestionIds)->get()->random(1);
				}

				$pickedQuestions[$i] = $question;
				$pickedQuestionIds[$i] = $question['id'];
				$remainingMarks -= $question['marks'];
				$i++;
			}
		}while(!($remainingMarks == 0));

		return $pickedQuestions;
	}
}