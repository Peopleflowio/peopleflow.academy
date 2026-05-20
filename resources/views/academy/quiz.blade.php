<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz — {{ $package->title }}</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F4F0; min-height: 100vh; padding: 40px 20px; }
    .wrap { max-width: 900px; margin: 0 auto; }
    .back { display: inline-flex; align-items: center; gap: 6px; color: #2563EB; text-decoration: none; font-size: 13px; font-weight: 500; margin-bottom: 24px; }
    .header { background: #fff; border: 1px solid #e8e6e1; border-radius: 14px; padding: 28px 32px; margin-bottom: 24px; }
    .header h1 { font-family: 'DM Serif Display', serif; font-size: 26px; color: #1a1a2e; margin-bottom: 6px; }
    .header p { font-size: 14px; color: #9090a8; }
    .header-meta { display: flex; gap: 20px; margin-top: 16px; }
    .meta-item { font-size: 13px; color: #4a4a6a; }
    .meta-item strong { color: #1a1a2e; }
    .last-attempt { background: #EEF2FF; border: 1px solid #c7d2fe; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; color: #1a1a2e; }
    .question-card { background: #fff; border: 1px solid #e8e6e1; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
    .q-num { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #9090a8; margin-bottom: 8px; }
    .q-text { font-size: 15px; font-weight: 600; color: #1a1a2e; margin-bottom: 16px; line-height: 1.5; }
    .options { display: flex; flex-direction: column; gap: 8px; }
    .option { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1.5px solid #e8e6e1; border-radius: 8px; cursor: pointer; transition: all 0.15s; }
    .option:hover { border-color: #2563EB; background: #EEF2FF; }
    .option input[type=radio] { accent-color: #2563EB; width: 16px; height: 16px; flex-shrink: 0; }
    .option label { font-size: 14px; color: #1a1a2e; cursor: pointer; flex: 1; }
    .submit-btn { width: 100%; padding: 14px; background: #2563EB; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; font-family: inherit; margin-top: 8px; transition: background 0.2s; }
    .submit-btn:hover { background: #1d4ed8; }
  </style>
</head>
<body>
  <div class="wrap">
    <a href="{{ route('academy.package', $package->slug) }}" class="back">← Back to course</a>

    <div class="header">
      <h1>{{ $quiz->title }}</h1>
      <p>{{ $quiz->description ?? 'Test your knowledge of ' . $package->title }}</p>
      <div class="header-meta">
        <div class="meta-item"><strong>{{ $quiz->questions->count() }}</strong> Questions</div>
        <div class="meta-item">Pass mark: <strong>{{ $quiz->pass_percent }}%</strong></div>
      </div>
    </div>

    @if($lastAttempt)
      <div class="last-attempt">
        Your last attempt: <strong>{{ $lastAttempt->percent }}%</strong> ({{ $lastAttempt->passed ? '✅ Passed' : '❌ Failed' }}) — {{ $lastAttempt->created_at->format('d M Y') }}
      </div>
    @endif

    <form method="POST" action="{{ route('academy.quiz.submit', $package->slug) }}">
      @csrf
      @foreach($quiz->questions as $i => $question)
        <div class="question-card">
          <div class="q-num">Question {{ $i + 1 }} of {{ $quiz->questions->count() }}</div>
          <div class="q-text">{{ $question->question }}</div>
          <div class="options">
            @foreach(['a'=>$question->option_a,'b'=>$question->option_b,'c'=>$question->option_c,'d'=>$question->option_d] as $key=>$option)
              @if($option)
                <div class="option">
                  <input type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}_{{ $key }}" value="{{ $key }}">
                  <label for="q{{ $question->id }}_{{ $key }}">{{ strtoupper($key) }}. {{ $option }}</label>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      @endforeach

      <button type="submit" class="submit-btn">Submit Quiz →</button>
    </form>
  </div>
</body>
</html>
