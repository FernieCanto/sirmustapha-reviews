<?php
/**
 * @property-read Album[] $albums
 * @property-read Artist[] $relatedArtists
 * @property-read Comment[] $comments
 * @property-read int $maxAlbumRating
 * 
 * @method Album[] albums()
 * @method Artist[] relatedArtists()
 * @method Comment[] comments()
 * @method int maxAlbumRating()
 * 
 * @method Artist unrelated()
 * @method Artist available()
 */
class Artist extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'artists';
  }
  
  public function relations() {
    return array(
        'albums'          => array(self::HAS_MANY, 'Album', 'artist', 'with' => array('rating')),
        'relatedArtists'  => array(self::MANY_MANY, 'Artist', 'relatedartists(relatedTo, artist)'),
        'comments'        => array(self::HAS_MANY, 'Comment', 'artist', 'on' => 'comments.album is null'),
        'maxAlbumRating'  => array(self::STAT, 'Album', 'artist', 'select' => 'max(rating)'),
    );
  }
  
  public function scopes() {
    $alias = $this->getTableAlias();
    return array(
        "unrelated" => array(
            "condition" => "not exists (select * from relatedartists where artist = $alias.id)",
        ),
        "available" => array(
            "condition" => "$alias.available = 1",
            "order"     => "$alias.name",
        ),
    );
  }
  
  public static function getArtistsForForm() {
    $array = array();
    foreach(self::model()->available()->findAll() as $artist)
      $array[$artist->id] = $artist->name;
    
    return $array;
  }
  
  /**
   * Named scope
   * @param string $ref
   * @return Artist 
   */
  public function byReference($ref) {
    $this->getDbCriteria()->addColumnCondition(array(
        'reference' => $ref
    ));
    return $this;
  }
  
  /**
   *
   * @param string $ref
   * @return Album
   */
  public function findAlbumByReference($ref) {
    return Album::model()->findByAttributes(array(
        'artist' => $this->id,
        'reference' => $ref
    ));
  }
  
  public function nameToUpper() {
    return $this->name;
  }
}