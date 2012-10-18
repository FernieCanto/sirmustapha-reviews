    <div class="comment">
      <p class="commentHeader">
      <?php
      if(!is_null($comment->commentatorEMail) and $comment->publiciseEMail == 1): ?>
        <a href="mailto:<?=$comment->commentatorEMail?>"><?=htmlentities($comment->commentatorName)?></a>
      <?php
      else:
        echo $comment->commentatorName;
      endif; ?>
      (<?=$comment->commentDate?>):</p>
      <p class="commentBody">
        <?=nl2br(htmlentities($comment->comment))?>
      </p>
      <?php
      if(!is_null($comment->reply)): ?>
      <p class="replyHeader">Editor's reply:</p>
      <div class="replyBody"><?=TextAdjust::adjustTags($comment->reply)?></div>
      <?php
      endif; ?>
    </div>