<header id="commentPageHeader">
  <h1>Your comment was sent successfully!</h1>
</header>
  
<p>Thank you for your contribution.</p>

<p><?=CHtml::link('Go back to the main page', array('reviews/'.$artist->reference.(is_null($album) ? null : '#'.$album->reference)))?></p>