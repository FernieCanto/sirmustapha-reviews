<h2>The rating system</h2>

<p>When I started the website, I had a rather traditional rating system: it 
   ranged from 0 to 10, in steps of 0.5. It sounded fair enough to me; after all, 
   10 is a nice, round number, and the half steps gave me a good number of 
   possible ratings to keep my "ranking" of albums very clear and accurate. I 
   even reserved a special rating of 11 to albums I considered extraodinarily 
   great (two of them, to be exact). But the problem was... I ended up not 
   understanding my own rating system. I don't know what happened, but it did. 
   The range from 0 to 10 looked unbalanced, somehow, and the overall "ranking" 
   didn't look quite the way I once imagined. Something had happened.</p>

<p>After talking to some people, I was convinced that the 0-10 rating system is 
   flawed &mdash; not the numeric system per se, but the way it's perceived by 
   most of us. And then I came up with this new rating system. The basic idea is 
   that ratings range from 0 to 15, in steps of 1. But the main idea was not 
   simply to reduce the number of possible ratings, but to give a different 
   presentation of them. The 16 ratings are arranged in groups of four; that is, 
   you have 4 groups of 4 ratings each. I didn't do that for mathematical rigour 
   or for sheer geekiness, even though I was partly inspired by the writings of 
   a theoretical base 16 system by one Robin Debreuil. The choice was, actually, 
   more aesthetic than mathematical: it looks pleasant and fair to have such a 
   harmonic division, and the creation of four "quadrants" of ratings makes a 
   clearer view of how my ranking works. So, you have the fourth quadrant, 
   consisting of the "essential" albums (12 to 15); the third quadrant, which is 
   the "good but not essential" zone (8-11); the second quadrant, representing 
   the "not worth much" records (4-7); and the first quadrant, which is the 
   "real bad" region (0-3). Within each quadrant, you have four ratings, which 
   looks quite clean, uncluttered and clear to rationalise and organise. Also, 
   the lack of half-steps looks far more pleasant and easier to handle, in my 
   opinion.</p>

<p>I have completely abolished the idea of a "special" rating reserved to one or 
   two albums; to me, it looks way too much as if my opinions are absolutely 
   sacred and unmutable. It's just plain 0-15 to all albums of all artists. I 
   still have the self-imposed limitation of having one album per artist that is 
   rated higher than all others, though it doesn't necessarily have to be a 15. 
   Anyway, for me it's quite a nice and intuitive system and doesn't need all 
   that longwinded explanation I just gave. On with the list!</p>

<?
foreach($ratings as $rating): ?>
<div class="rating" id="<?=$rating->id?>">
  <p class="image"><?=CHtml::image(Yii::app()->request->baseUrl.'/assets/images/'.$rating->id.'.png', $rating->description)?></p>
  <p class="rating"><?=$rating->title?></p>
  <p class="explanation"><?=$rating->description?></p>
  <ol class="albumList">
    <?
    foreach($rating->albums() as $album): 
      $artist = $album->artist(); ?>
    <li>
      <?=CHtml::link($album->title, array('reviews/'.$artist->reference."#".$album->reference))?>, <?=$artist->name?>
    </li>
    <?
    endforeach; ?>
  </ol>
</div>
<?
endforeach;

echo CHtml::link('Back', $_SERVER['HTTP_REFERER']);