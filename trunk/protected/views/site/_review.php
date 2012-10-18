<div class="albumReview">
  <div class="albumReviewHeader">
    <h2 id="<?=$album->reference?>" <?=($maxAlbumRating == $album->rating ? 'class="best"' : null)?> >
      <?=$album->title?> (<?=$album->year?>)
    </h2>
    <p class="highPoints">High points: <?=TextAdjust::adjustTags($album->highPoints)?></p>
    <p class="trackList">Track list:</p>
    <?
    foreach($album->discs as $disc) {
      if(!is_null($disc->title))
        echo '<p class="discTitle">'.$disc->title.'</p>';
      
      echo '<ol>';
      $level = 1;
      foreach($disc->tracks as $track) {
        if($track->level != $level) {
          if($track->level > $level)
            echo '<ol>';
          else
            echo str_repeat('</ol>', $level - $track->level);
          $level = $track->level;
        }
        $title = CHtml::encode($track->title);
        switch($track->grade) {
          case 1: echo '<li class="bad">'.$title.' &times;&times;</li>'; break;
          case 2: echo '<li>'.$title.' <span class="bad">&times;</span></li>'; break;
          case 3: echo '<li>'.$title.'</li>'; break;
          case 4: echo '<li>'.$title.' <span class="good">+</span></li>'; break;
          case 5: echo '<li class="good">'.$title.' ++</li>'; break;
        }
      }
      echo str_repeat('</ol>', $level);
    }
    ?>
  </div>
  <div class="albumReviewBody">
    <?=TextAdjust::adjustTags($album->review)?>
  </div>
  
  <p class="rating">
    Rating: <?=CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/assets/images/'.$album->rating.'.png', $album->rating()->title, array('title' => $album->rating()->description)), array('site/ratings#'.$album->rating))?>
  </p>
  
  <?php
  $comments = $album->comments;
  if(!empty($comments)): ?>
  <div class="albumComments">
    <p class="albumCommentsHeader">
      Reader comments:
    </p>
    <?php
    foreach($comments as $comment):  
      $this->renderPartial('_comment', array('comment' => $comment));
    endforeach; ?>
  </div>  
    <?php
  endif;
  ?>
  
  <p>
    <?=TextAdjust::sendCommentsMessage($album->commentPhrase, $this->createUrl('comments/'.$artist->reference.'/'.$album->reference))?>
  </p>
</div>