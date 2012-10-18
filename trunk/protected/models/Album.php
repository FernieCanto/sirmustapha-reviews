<?php
class Album extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'albums';
  }
  
  public function relations() {
    return array(
      'artist'    => array(self::BELONGS_TO, 'Artist', 'artist'),
      'discs'     => array(self::HAS_MANY, 'Disc', 'album'),
      'rating'    => array(self::BELONGS_TO, 'Rating', 'rating'),
      'comments'  => array(self::HAS_MANY, 'Comment', 'album'),
    );
  }
  
  public function scopes() {
    return array(
      'reviewed'  => array(
                      'condition' => 'alb.rating is not null',
                      'alias'     => 'alb'),
      'available' => array(
                      'condition' => 'alb.available = 1',
                      'alias'     => 'alb'),
    );
  }
  
  public function discsForReview() {
    return $this->discs();
  }
  
  public function highPoints() {
    return TextAdjust::adjustTags($this->highPoints);
  }
  
  public function review() {
    return TextAdjust::adjustTags($this->review);
  }
  
  public function commentPhrase() {
    return TextAdjust::sendCommentsMessage($this->commentPhrase, $this->artist, $this->id);
  }
  

  static function adjustTags($text) {
    return
      str_replace('[a]', '<span class="album">',
        str_replace('[/a]', '</span>', 
          str_replace('[s]', '<span class="song">',
            str_replace('[/s]', '</span>', $text))));
  }

  static function sendCommentsMessage($message, $artist, $album) {
    return adjustTags(
      str_replace('[l]', '<a href="comments.php?a='.$artist.'&amp;alb='.$album.'">',
        str_replace('[/l]', '</a>', $message)));
  }
}