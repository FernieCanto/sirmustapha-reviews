<?php
class Track extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'tracks';
  }
  
  public function primaryKey() {
    return array('album', 'disc', 'number');
  }
  
  public function relations() {
    return array(
      'disc'  => array(self::BELONGS_TO, 'disc', 'album, disc'),
    );
  }
}