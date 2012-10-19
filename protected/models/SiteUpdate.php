<?php
class SiteUpdate extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'siteupdates';
  }
  
  public function relations() {
    return array(
      'updatedItems'  => array(self::HAS_MANY, 'UpdatedItem', 'siteUpdate'),
    );
  }
  
  public function scopes() {
    return array(
      'recent'  => array(
                    'limit' => 2,
                    'order' => 'id desc',
      ),
      'unpublished' => array(
                    'condition' => 'available = 0',
      ),
    );
  }
  
  public function publish() {
    Artist::model()->updateAll( array('available' => 1),
                                ' id in (select artist from updateditems where siteUpdate = :update and album = 0) ',
                                array(':update' => $this->id));
    Album::model()->updateAll( array('available' => 1),
                               ' id in (select album from updateditems where siteUpdate = :update and album <> 0) ',
                               array(':update' => $this->id));
    $this->available = 1;
    $this->save();
  }
}