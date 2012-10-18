<? if(isset($error)): ?>
  <div id="error"><?=$error?></div>
<? endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
  File: <input type="file" name="import" /><br />
  <input type="submit" />
</form>