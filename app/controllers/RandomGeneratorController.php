<?php

class RandomGeneratorController extends \BaseController {

	private static $pickedQuestionIds = [];
	private static $isFirstMain = true;
  private static $subjectId;

	public function generate($departmentId, $subjectId)
	{
		$paperData = Input::get('paper_data');
		$pattern = Input::get('pattern');
    self::$subjectId = $subjectId;
    $generatedPaper = [];

    self::applyIndices($paperData);
    usort($paperData, self::buildSorter('marks'));

    forEach($paperData as &$main)
      if(!self::buildMain($main))
        return Response::json(['alert' => 'Insufficient questions'], 404);

    usort($paperData, self::buildSorter('index'));

    self::buildGeneratedPaper($generatedPaper, $paperData, $pattern);

		return Response::json($generatedPaper);
	}

  function applyIndices(&$paperData) {
    $index = 0;
    foreach($paperData as &$main) {
      $main['index'] = $index++;
    }
  }

  function buildSorter($key) {
    return function ($a, $b) use ($key) {
      return ($a[$key] - $b[$key]);
    };
  }

  function buildGeneratedPaper(&$generatedPaper, $paperData, $pattern) {
		$noSections = $pattern['no_sections'];
		$sections = explode('|', $pattern['marks_mains']);
    $noMainsPerSection = [];
		foreach($sections as $section)
			array_push($noMainsPerSection, count(explode(',', $section)));

    for($i = 0, $k = 0; $i < $noSections; $i++)
      for($j = 0; $j < $noMainsPerSection[$i]; $j++)
        $generatedPaper[$i][$j] = $paperData[$k++];
  }

	function buildMain(&$main)
	{
    $querySetOfMarks = self::buildQuery($main);

		if(self::$isFirstMain)
    {
      $setOfMarks = $querySetOfMarks->lists('marks');
      self::$isFirstMain = false;
    }
		else
			$setOfMarks = $querySetOfMarks->whereNotIn('id', self::$pickedQuestionIds)->lists('marks');

		$setOfMarksLength = count($setOfMarks);
    if($setOfMarksLength == 0)
      return false;

		$canBuildMain = self::sumOfSubsets($setOfMarks, $setOfMarksLength, $main['marks']);

		if($canBuildMain)
		{
			self::buildQuestionsForMain($main);
			return true;
		}
		else
			return false;
	}

  function buildQuery($main) {
    $units = $main['units'];
    $courseOutcomes = $main['course_outcomes'];
		$query = Question::where('subject_id', self::$subjectId)->whereIn('unit', $units);
		$query->where(function($q) use ($courseOutcomes) {
			foreach($courseOutcomes as $courseOutcome)
			{
				$q->orWhere('course_outcome', 'like', '%'.$courseOutcome.'%');
			}
		});
    return $query;
  }

	function sumOfSubsets($set, $n, $sum)
	{

		if($sum == 0)
			return true;
		else if($n == 0 && $sum > 0)
			return false;
		else if($set[$n-1] > $sum)
			return self::sumOfSubsets($set, $n-1, $sum);
		else
			return (self::sumOfSubsets($set, $n-1, $sum - $set[$n-1]) || self::sumOfSubsets($set, $n-1, $sum));

	}

	function buildQuestionsForMain(&$main)
	{
    $originallyPickedQuestionIds = self::$pickedQuestionIds;
		$pickedQuestions = [];

		do
		{
      self::$pickedQuestionIds = $originallyPickedQuestionIds;
			$remainingMarks = $main['marks'];
      $pickedQuestions = [];

			while($remainingMarks > 0)
			{
        $queryQuestions = self::buildQuery($main);
				if(count(self::$pickedQuestionIds) == 0)
				{
					$question = $queryQuestions->where('marks', '<=', $remainingMarks)->get()->random(1);
					if($question)
						$question['attachments'] = $question->attachments;
          else
            break;
				}
				else
				{
					$question = $queryQuestions->where('marks', '<=', $remainingMarks)->whereNotIn('id', self::$pickedQuestionIds)->get()->random(1);
					if($question)
						$question['attachments'] = $question->attachments;
          else
            break;
				}
        array_push(self::$pickedQuestionIds, $question['id']);
        array_push($pickedQuestions, $question);
				$remainingMarks -= $question['marks'];
			}
		}while($remainingMarks != 0);

		$main['questions'] = $pickedQuestions;
	}
}
