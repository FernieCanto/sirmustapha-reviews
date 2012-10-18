<?php
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
      'comments'        => array(self::HAS_MANY, 'Comment', 'artist', 'condition' => 'comments.album is null'),
      'maxAlbumRating'  => array(self::STAT, 'Album', 'artist', 'select' => 'max(rating)'),
    );
  }
  
  public function scopes() {
    return array(
      'unrelated' => array(
                      'condition' => 'not exists (select * from relatedartists where artist = art.id)'),
                      'alias'     => 'art',
      'available' => array(
                      'condition' => 'art.available = 1',
                      'order'     => 'art.name',
                      'alias'     => 'art'),
    );
  }
  
  public static function getArtistsForForm() {
    $array = array();
    foreach(self::model()->available()->findAll() as $artist)
      $array[$artist->id] = $artist->name;
    
    return $array;
  }
  
  public function getAlbumsForForm() {
    $array = array(null => ' -- NO ALBUM SELECTED -- ');
    foreach($this->albums('albums:available') as $album)
      $array[$album->id] = $album->title;
    
    return $array;
  }
  
  public function byReference($ref) {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => 'reference = :ref',
        'params'    => array('ref' => $ref),
    ));
    return $this;
  }
  
  public function findAlbumByReference($ref) {
    return Album::model()->findByAttributes(array('artist' => $this->id, 'reference' => $ref));
  }
  
  public function nameToUpper() {
    return $this->name;
  }
}