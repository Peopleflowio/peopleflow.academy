<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Result — {{ $package->title }}</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F4F0; min-height: 100vh; padding: 40px 20px; }
    .wrap { max-width: 900px; margin: 0 auto; }
    .back { display: inline-flex; align-items: center; gap: 6px; color: #2563EB; text-decoration: none; font-size: 13px; font-weight: 500; margin-bottom: 24px; }
    .result-card { background: #fff; border: 1px solid #e8e6e1; border-radius: 14px; padding: 40px; text-align: center; margin-bottom: 24px; }
    .result-icon { font-size: 56px; margin-bottom: 16px; }
    .result-score { font-family: 'DM Serif Display', serif; font-size: 56px; color: #2563EB; line-height: 1; }
    .result-label { font-size: 14px; color: #9090a8; margin-top: 4px; margin-bottom: 20px; }
    .result-status { display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; border-radius: 100px; font-size: 14px; font-weight: 600; margin-bottom: 24px; }
    .passed { background: #dcfce7; color: #16a34a; }
    .failed { background: #fee2e2; color: #dc2626; }
    .result-meta { display: flex; justify-content: center; gap: 32px; padding-top: 20px; border-top: 1px solid #e8e6e1; }
    .meta-item { text-align: center; }
    .meta-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #9090a8; margin-bottom: 4px; }
    .meta-value { font-size: 18px; font-weight: 700; color: #1a1a2e; }
    .actions { display: flex; gap: 12px; justify-content: center; margin-top: 24px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; font-family: inherit; cursor: pointer; border: none; }
    .btn-primary { background: #2563EB; color: #fff; }
    .btn-secondary { background: #fff; color: #1a1a2e; border: 1px solid #e8e6e1; }
    .review { margin-top: 24px; }
    .review h2 { font-family: 'DM Serif Display', serif; font-size: 20px; color: #1a1a2e; margin-bottom: 16px; }
    .question-card { background: #fff; border: 1px solid #e8e6e1; border-radius: 12px; padding: 20px; margin-bottom: 12px; }
    .q-text { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 12px; }
    .answer-row { display: flex; align-items: center; gap: 8px; font-size: 13px; padding: 6px 10px; border-radius: 6px; margin-bottom: 4px; }
    .correct-ans { background: #dcfce7; color: #16a34a; }
    .wrong-ans { background: #fee2e2; color: #dc2626; }
    .explanation { font-size: 12px; color: #9090a8; margin-top: 8px; font-style: italic; }
  </style>
</head>
<body>
  <div class="wrap">
    <a href="{{ route('academy.package', $package->slug) }}" class="back">← Back to course</a>

    <div class="result-card">
      <div class="result-icon">{{ $attempt->passed ? '🎉' : '📚' }}</div>
      <div class="result-score">{{ $attempt->percent }}%</div>
      <div class="result-label">{{ $attempt->score }} out of {{ $attempt->total }} correct</div>
      <div class="result-status {{ $attempt->passed ? 'passed' : 'failed' }}">
        {{ $attempt->passed ? '✅ Passed' : '❌ Not quite — keep studying!' }}
      </div>
      <div class="result-meta">
        <div class="meta-item">
          <div class="meta-label">Score</div>
          <div class="meta-value">{{ $attempt->score }}/{{ $attempt->total }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Pass Mark</div>
          <div class="meta-value">{{ $quiz->pass_percent }}%</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Result</div>
          <div class="meta-value">{{ $attempt->passed ? 'Pass' : 'Fail' }}</div>
        </div>
      </div>
      <div class="actions">
        @if($attempt->passed)
          <a href="{{ route('academy.certificate', $package->slug) }}" class="btn btn-primary">🎓 Get Certificate</a>
        @endif
        <a href="{{ route('academy.quiz', $package->slug) }}" class="btn btn-secondary">🔄 Retake Quiz</a>
        <a href="{{ route('academy.package', $package->slug) }}" class="btn btn-secondary">← Back to Course</a>
      </div>
    </div>

    <div class="review">
      <h2>Review Your Answers</h2>
      @foreach($quiz->questions as $question)
        @php $r = $results[$question->id] ?? []; @endphp
        <div class="question-card">
          <div class="q-text">{{ $question->question }}</div>
          @if(($r['given'] ?? null) === $r['correct'] ?? null)
            <div class="answer-row correct-ans">✅ Your answer: {{ strtoupper($r['given'] ?? '?') }}. {{ $question->{'option_'.$r['given']} ?? '' }}</div>
          @else
            <div class="answer-row wrong-ans">❌ Your answer: {{ $r['given'] ? strtoupper($r['given']).'. '.$question->{'option_'.$r['given']} : 'Not answered' }}</div>
            <div class="answer-row correct-ans">✅ Correct: {{ strtoupper($r['correct']) }}. {{ $question->{'option_'.$r['correct']} }}</div>
          @endif
          @if($question->explanation)
            <div class="explanation">💡 {{ $question->explanation }}</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</body>
</html>
