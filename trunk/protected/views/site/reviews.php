<?php
/* @var $artist Artist */
?>
<div id="reviewPageHeader">
  <h1 class="reviewTitle"><?=$artist->nameToUpper()?></h1>
</div>

<ul class="albumList">
  <?
  foreach($artist->albums as $album) { ?>
  <li><?=CHtml::link($album->title, '#'.$album->reference)?></li>
  <?
  }
  
  foreach($artist->relatedArtists as $relatedArtist) { ?>
  <li class="relatedArtist"><?=CHtml::link($relatedArtist->nameToUpper().":", '#'.$relatedArtist->reference)?></li>
  <ul>
    <?
    foreach($relatedArtist->albums as $album) { ?>
    <li><?=CHtml::link($album->title, '#'.$album->reference)?></li>
    <? 
    } ?>
  </ul>
  <? 
  } ?>
</ul>

<div class="reviewIntro">
  <?=TextAdjust::adjustTags($artist->introduction)?>

  <?
  $comments = $artist->comments;
  if(!empty($comments)) { ?>
  <div class="albumComments">
    <p class="albumCommentsHeader">
      Reader comments:
    </p>
    <?php
    foreach($comments as $comment) {
      $this->renderPartial('_comment', array('comment' => $comment));
    } ?>
  </div>  
    <?php
  };
  ?>

  <p class="comment"><?=CHtml::link('Send me your comments!', array('comments/'.$artist->reference))?></p>
</div>

<?
foreach($artist->albums as $album) {
  $this->renderPartial('_review', array('artist' => $artist, 'album' => $album, 'maxAlbumRating' => $artist->maxAlbumRating));
}

foreach($artist->relatedArtists as $relatedArtist) { ?>
  <div class="relatedArtistHeader" id="<?=$relatedArtist->reference?>"><?=$relatedArtist->name?></div>
  <?
  foreach($relatedArtist->albums as $album) {
    $this->renderPartial('_review', array('artist' => $relatedArtist, 'album' => $album, 'maxAlbumRating' => null));
  }
} ?>

<div id="footer">
  <p class="backMessage"><?=CHtml::link("Back to the Reviews Page index", array('site/index'))?></p>
</div>