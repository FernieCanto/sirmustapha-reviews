<form action="" method="POST">
<? foreach($updates as $update): ?>
  <input type="radio" name="siteUpdate" value="<?=$update->id?>" /> <?=$update->title?><br />
<? endforeach; ?>
<input type="submit" />
</form>