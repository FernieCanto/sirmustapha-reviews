<?php
class Disc extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'discs';
  }
  
  public function primaryKey() {
    return array('album', 'number');
  }
  
  public function relations() {
    return array(
      'album'   => array(self::BELONGS_TO, 'Album', 'album'),
      'tracks'  => array(self::HAS_MANY, 'Track', 'album, disc'),
    );
  }
  
  public function tracksForReview() {
    $tracks = $this->tracks;
  }
}