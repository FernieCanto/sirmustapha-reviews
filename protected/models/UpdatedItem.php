<?php
class UpdatedItem extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'updateditems';
  }
  
  public function relations() {
    return array(
      'siteUpdate'  => array(self::BELONGS_TO, 'SiteUpdate', 'siteUpdate'),
    );
  }
}