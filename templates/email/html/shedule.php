<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Etalonnage</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0; padding: 20px;
      color: #000;
    }
    .email-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      max-width: 600px;
      margin: 0 auto;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .email-header {
      text-align: center;
      font-size: 24px;
    }
    .email-body {
      margin-top: 20px;
      font-size: 16px;
      line-height: 1.6;
      color: #000;
    }
    .button {
      display: inline-block;
      background-color: #0d837c;
      color: #000;
      text-decoration: none;
      padding: 12px 20px;
      margin-top: 20px;
    }
    .footer {
      font-size: 12px;
      color: #777;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <h1 style="color: #0d837c;">Setal</h1>
    <div class="email-body">
          <p> Cher client, <?= h($startupName) ?> l'étalonnage de votre appareil:  <?= h($device) ?> expire le : <?= h($startupName) ?>. Bien vouloir penser à  le renouveler.<strong style="color: #3c7d9e;"></strong> </p>
    </div>
    <div class="footer">
      <p>&copy; <?= date('Y') ?> Setal - Tous droits réservés</p>
      <p>Setal · BP 12345 · Yaoundé, Cameroun</p>
    </div>
  </div>
</body>
</html>
