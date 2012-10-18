<?php
class Rating extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'ratings';
  }
  
  public function relations() {
    return array(
        'albums'  => array(self::HAS_MANY, 'Album', 'rating', 'with' => array('artist'), 'order' => 'albums.title'),
    );
  }
  
  public function scopes() {
    return array(
      'descending'  => array(
          'order' => 't.id desc',
      ),
    );
  }
}