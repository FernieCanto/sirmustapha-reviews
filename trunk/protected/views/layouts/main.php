<!DOCTYPE HTML>

<html>

<head>
    <title><?=Yii::app()->name?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="Fernando H. Canto" />
    <link rel="stylesheet" title="Classic Blue" href="<?=Yii::app()->request->baseUrl;?>/css/classic1.css" />
    <link rel="alternate stylesheet" title="Plainish" href="<?=Yii::app()->request->baseUrl;?>/css/plain.css" />
    <link rel="alternate" type="application/rss+xml" title="Sir Mustapha's RSS Feed" href="code/feed.rss" />
</head>

<body>
  <div id="siteHeader">
    <h1>Sir Mustapha's Album Reviews</h1>
    <div id="subtitle">Music reviews for newcomers and veterans alike</div>
  </div>

<?=$content?>

</body>
</html>