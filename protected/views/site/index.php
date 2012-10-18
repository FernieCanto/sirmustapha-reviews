<h2>Welcome!</h2>

<div id="update-old">
  <p class="update">Updated <span class="date"><?=$recentUpdates[1]['date']?></span>: <span class="title"><?=CHtml::encode($recentUpdates[1]['title'])?></span></p>
  <p><?=CHtml::encode($recentUpdates[1]['text'])?></p>
</div>

<div id="update-new">
  <p class="update">Updated <span class="date"><?=$recentUpdates[0]['date']?></span>: <span class="title"><?=CHtml::encode($recentUpdates[0]['title'])?></span></p>
  <p><?=CHtml::encode($recentUpdates[0]['text'])?></p>
</div>

<div id="welcome">
  <p class="p1">Howdy! Fernie Canto speakin'. It's been several years, in fact,
                that I haven't been speakin' around these parts. Due to a server
                incident, my reviews site was taken off the air, and I never
                managed to get it back up online. So, I closed my reviewing
                operations and moved to other projects. But you know what?
                I miss writing about music. I really do! So, I decided to make
                a new stab, and here I am.</p>
  <p class="p1">Even though I had quite a bunch of reviews here, I don't really
                think many of them were very good. So, this site is being slowly
                repopulated with fresh new reviews, and the older ones will
                certainly show up, probably revised or rewritten. But for now,
                enjoy as this site grows back to shape and form!
  <p class="p1">If you care, you can subscribe to my RSS feed, and you'll
                quickly know when my site receives its next updates. And if
                you bump into any broken links around here, worry not! They'll
                be fixed shortly.</p>
  <p class="p1">I'm glad to be back!</p>
</div>

<div id="links">
  <h2 class="page-item"><span>The Links:</span></h2>
  <ul>
    <li><?=CHtml::link('About me', array('site/me'))?> - A short page about
        this site's author.</li>
    <li><?=CHtml::link('About the ratings', array('site/ratings'))?> -
        An explanation on the ratings system, as well as a list of all
        albums reviewed, sorted by rating.</li>
    <li><?=CHtml::link('About the comments', array('site/guidelines'))?> -
        The guidelines for the reader comments; read this before you post!</li>
    <li><?=CHtml::link('The pals', array('site/links'))?> -
        More websites for you to check out, related and non-related to music.</li>
    <li><?=CHtml::link('My music', 'http://ferniecanto.imdanet.com', array('title' => 'Fernie Canto\'s Hall of Music'))?> -
        If you're one of those who thinks that "those who can do it, do it; those
        who can't do it, teach it; those who can't teach it, review it," well,
        check my music website to change your mind, then! All my music is available
        under the Creative Commons for free download, so check it out if you wish!</li>
  </ul>
</div>

<div id="reviews">
  <h2 class="page-item"><span>The Reviews:</span></h2>
  <? foreach($artists as $artist): //var_dump($artist->albums); exit; ?>
    <div class="artist-link <?=(isset($updatedItems[$artist->id]) ? 'new' : null)?>">
      <?=CHtml::link($artist->nameToUpper(), array('reviews/'.$artist->reference), array('class' => 'artist'))?>
      <?=(isset($updatedItems[$artist->id])
           ? (isset($updatedItems[$artist->id][0]) ? 'CREATED ' : 'UPDATED ').$recentUpdates[0]->date
           : null)?>
    </div>
    <div class="albums">
     (<?
        $first = true;
        foreach($artist->albums('albums:available') as $album):
          ($first ? $first = false : print('; '));
          if(is_null($album->rating))
            echo $album->title;
          else
            echo CHtml::link($album->title,
                             array('reviews/'.$artist->reference.'#'.$album->reference),
                             (isset($updatedItems[$artist->id][$album->id]) ? array('class' => 'new') : null));
        endforeach;
        
        foreach($artist->relatedArtists('relatedArtists:available') as $relatedArtist):
          echo " &mdash; ".$relatedArtist->nameToUpper().": ";
          $first = true;

          foreach($relatedArtist->albums('albums:available') as $album):
            ($first ? $first = false : print('; '));
            if(is_null($album->rating))
              echo $album->title;
            else
              echo CHtml::link($album->title,
                               array('reviews/'.$artist->reference.'#'.$album->reference),
                               (isset($updatedItems[$artist->id][$album->id]) ? array('class' => 'new') : null));
          endforeach;
        endforeach;
      ?>)
    </div>

  <? endforeach; ?>
</div>