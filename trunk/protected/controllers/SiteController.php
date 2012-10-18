<?php
class SiteController extends CController {
  public function actionIndex() {
    $recentUpdates = SiteUpdate::model()->recent()->findAll();
    $updatedItems = array();
    
    foreach($recentUpdates[0]->updatedItems as $item) {
      if(is_null($item['album']))
        $updatedItems[$item['artist']][0] = true;
      else
        $updatedItems[$item['artist']][$item['album']] = true;
    }
    
    $artists = Artist::model()
      ->available()
      ->unrelated()
      ->with(array(
          "albums"  => array(
              "scopes"  => "available",
          ),
          "relatedArtists"  => array(
              "scopes"  => "available",
              "with"    => array(
                  "albums"  => array(
                      "alias"   => "r_albums",
                      "scopes"  => "avaliable",
                  ),
              ),
          ),
    ))->findAll();
    
    $this->render("index", array('recentUpdates'  => $recentUpdates,
                                 'updatedItems'   => $updatedItems,
                                 'artists'        => $artists));
  }
  
  public function actionMe() {
    $this->render("me");
  }
  
  public function actionPrinciples() {
    $this->render("principles");
  }
  
  public function actionRatings() {
    $ratings = Rating::model()->with('albums')->descending()->findAll();
    
    $this->render('ratings', array('ratings' => $ratings));
  }
  
  public function actionReviews() {
    $artist = Artist::model()
      ->with(array(
          "maxAlbumRating",
          "albums"          => array(
              "scopes"          => array("available", "reviewed"),
          ),
          "relatedArtists"  => array(
              "scopes"          => "available",
              "with"            => array(
                  "albums"          => array(
                      "alias"           => "r_albums",
                      "scopes"          => array("available", "reviewed"),
                  ),
              ),
          ),
    ))->byReference($_GET['artist'])
      ->find();
    
    if(!is_null($artist))
      $this->render("reviews", array('artist' => $artist));
    else
      $this->render("notFound");
  }
  
  public function actionComments() {
    if(!isset($_GET['artist']) or is_null($artist = Artist::model()->byReference($_GET['artist'])->find())) {
      $this->render("invalid"); return;
    }

    $comment = new Comment;
    if(Yii::app()->request->getIsPostRequest()) {
      $comment->artist = $artist->id;
      $comment->attributes = $_POST['Comment'];
      if($comment->validate()) {
        $album = null;
        if(trim($_POST['Comment']['album']) != '' and is_null($album = $artist->findAlbumByReference($_GET['album']))) {
          $comment->addError('album', 'Invalid album choice!');
        }
        else {
          $comment->commentDate = new CDbExpression('now()');
          $comment->commentatorIP = $_SERVER['REMOTE_ADDR'];
          $comment->reply = null;
          $comment->save();

          $this->render("commentOk", array('artist' => $artist, 'album' => $album));
          return;
        }
      }
    }
    else {
      if(isset($_GET['artist'])) {
        $artist = Artist::model()->byReference($_GET['artist'])->find();
        if(!is_null($artist)) {
          $comment->artist = $artist->id;

          if(!isset($_GET['album']) or !is_null($album = $artist->findAlbumByReference($_GET['album']))) {
            if(isset($album))
              $comment->album = $album->id;
            else
              $comment->album = null;
          }
          else {
            $comment->addError('album', 'The selected album is invalid');
            $comment->album = null;
          }
        }
        else
          $comment->addError("artist", 'The selected artist is invalid');
      }
      else
        $comment->addError('artist', 'No artist was selected');
    }
    $this->render("comment", array('comment' => $comment, 'artist' => $artist));
  }
}