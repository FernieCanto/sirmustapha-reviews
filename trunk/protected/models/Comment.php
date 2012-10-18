<?php
class Comment extends CActiveRecord {
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }
  
  public function tableName() {
    return 'comments';
  }
  
  public function rules() {
    return array(
        array('artist, commentatorName, comment', 'required'),
        array('artist, album', 'numerical'),
        array('commentatorName', 'length', 'min' => 1, 'max' => 90),
        array('commentatorEMail', 'email'),
        array('publiciseEMail', 'in', 'range' => array(0, 1)),
        array('album, commentatorEMail', 'default', 'setOnEmpty' => true, 'value' => null),
    );
  }
  
  public function attributeLabels() {
    return array(
        'commentatorName'   => 'Your name',
        'commentatorEMail'  => 'E-mail (optional)',
        'comment'           => 'Comment',
    );
  }
}