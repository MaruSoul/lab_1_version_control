<?php

$today     = new DateTimeImmutable('now', new DateTimeZone('Europe/Kyiv'));
$month     = (int)$today->format('n');   // 1–12
$day       = (int)$today->format('j');   // 1–31

// Season detection
$season = match(true) {
    in_array($month, [12, 1, 2]) => 'winter',
    in_array($month, [3, 4, 5])  => 'spring',
    in_array($month, [6, 7, 8])  => 'summer',
    default                      => 'autumn',
};

// ── Affirmations
$affirmations = require_once(__DIR__ . '/affirmations.php');
$phrases      = $affirmations[$month];
$affirmation  = $phrases[($day - 1) % count($phrases)];

// ── Ukrainian weekday & month names
$weekdays = ['Неділя', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П\'ятниця', 'Субота'];
$months   = [
    1=>'січня', 2=>'лютого', 3=>'березня', 4=>'квітня', 5=>'травня', 6=>'червня',
    7=>'липня', 8=>'серпня', 9=>'вересня', 10=>'жовтня', 11=>'листопада', 12=>'грудня'
];

$dateString = $weekdays[(int)$today->format('w')] . ', ' . $day . ' ' . $months[$month] . ' ' . $today->format('Y');

// ── Season label (UA)
$seasonLabel = match($season) {
    'winter' => 'зима',
    'spring' => 'весна',
    'summer' => 'літо',
    'autumn' => 'осінь',
};
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Твій день</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Inter:wght@300;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="<?= $season ?>">
  <main class="wrapper">
    <p class="season"><?= htmlspecialchars($seasonLabel) ?></p>

    <div class="dots">
      <span></span><span></span><span></span>
    </div>

    <time class="date" datetime="<?= $today->format('Y-m-d') ?>">
      <?= htmlspecialchars($dateString) ?>
    </time>

    <blockquote class="affirmation">
      <?= htmlspecialchars($affirmation) ?>
    </blockquote>

    <div class="line"></div>

    <p class="footer">твій день · <?= $today->format('Y') ?></p>
  </main>
</body>
</html>
