<?php
class TextAdjust {
  public static function adjustTags($text) {
    return
      str_replace('[a]', '<span class="album">',
        str_replace('[/a]', '</span>', 
          str_replace('[s]', '<span class="song">',
            str_replace('[/s]', '</span>', $text))));
  }

  public static function sendCommentsMessage($message, $url) {
    return self::adjustTags(
      str_replace('[l]', '<a href="'.$url.'">',
        str_replace('[/l]', '</a>', $message)));
  }
}
?>
