<?php
/**
 * @property-read boolean reviewed
 * 
 * @property-read Artist $artist
 * @property-read Disc[] $discs
 * @property-read Rating $rating
 * @property-read Comment[] $comments
 * 
 * @method Artist artist()
 * @method Disc[] discs()
 * @method Rating rating()
 * @method Comment[] comments()
 * 
 * @method Album reviewed()
 * @method Album available()
 */
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
    $alias = $this->getTableAlias();
    return array(
      "reviewed"  => array(
          "condition" => "$alias.rating is not null",
      ),
      "available" => array(
          "condition" => "$alias.available = 1",
      ),
    );
  }
  
  public function defaultScope() {
    return array(
        "with"    => "rating",
    );
  }
  
  public function getReviewed() {
    return $this->rating !== null;
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