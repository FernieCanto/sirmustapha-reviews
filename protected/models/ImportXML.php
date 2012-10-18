<?php
class ImportXML {
  private $filename = null;

  public function loadXML($filename) {
    $reader = new XMLReader();
    if(!$reader->xml(file_get_contents($_FILES['import']['tmp_name']))) {
      throw new ImportXMLException("Invalid XML file", 0);
    }
    if(!$reader->setRelaxNGSchema('schema.rng')) {
      throw new ImportXMLException("Invalid import file", 1);
    }
    $this->filename = $filename;
  }
  
  public function import() {
    if(is_null($this->filename))
      throw new ImportXMLException("File not loaded", 2);

    $xmlUpdate = simplexml_load_file($this->filename);
    
    $update = new SiteUpdate;
    $update->title = $xmlUpdate->updateTitle;
    $update->link = $xmlUpdate->updateLink;
    $update->text = $xmlUpdate->updateText;
    $update->save();
    
    foreach($xmlUpdate->artist as $xmlArtist) {
      if(isset($xmlArtist->name)) {
        $artist = new Artist;
        $artist->name = $xmlArtist->name;
        $artist->reference = (string)$xmlArtist['ref'];
        $artist->introduction = $xmlArtist->text;
        $artist->save();
        
        $updatedItem = new UpdatedItem;
        $updatedItem->siteUpdate = $update->id;
        $updatedItem->artist = $artist->id;
        $updatedItem->save();
        
        if(isset($xmlArtist->comment)) {
          foreach($xmlArtist->comment as $xmlComment) {
            $comment = new Comment;
            $comment->artist = $artist->id;
            $comment->commentatorName = $xmlComment->name;
            $comment->commentatorEMail = $xmlComment->email;
            $comment->commentDate = $xmlComment->date;
            $comment->comment = $xmlComment->text;
            $comment->publiciseEMail = 0;
            if(isset($xmlComment->reply))
              $comment->reply = $xmlComment->reply;
            $comment->save();
          }
        }
      }
      else {
        $artist = Artist::findByReference((string)$xmlArtist['ref']);
      }
      
      foreach($xmlArtist->album as $xmlAlbum) {
        $album = $artist->findAlbumByReference((string)$xmlAlbum['ref']);
        if(is_null($album)) {
          $album = new Album;
          $album->artist = $artist->id;
          $album->reference = (string)$xmlAlbum['ref'];
          $album->title = $xmlAlbum->title;
          $album->year = $xmlAlbum->year;
        }
        if(isset($xmlAlbum->review)) {
          $album->highPoints = $xmlAlbum->highPoints;
          $album->review = $xmlAlbum->review;
          $album->rating = $xmlAlbum->rating;
          $album->commentPhrase = $xmlAlbum->commentPhrase;
          $album->save();
          
          foreach($xmlAlbum->disc as $xmlDisc) {
            $disc = new Disc;
            $disc->album = $album->id;
            if(isset($xmlDisc['title']))
              $disc->title = (string)$xmlDisc['title'];
            $disc->save();
            
            foreach($xmlDisc->track as $xmlTrack) {
              $track = new Track;
              $track->album = $album->id;
              $track->disc = $disc->disc;
              $track->title = $xmlTrack->title;
              $track->grade = $xmlTrack->grade;
              $track->save();
            }
          }
          $updatedItem = new UpdatedItem;
          $updatedItem->siteUpdate = $update->id;
          $updatedItem->artist = $artist->id;
          $updatedItem->album = $album->id;
          $updatedItem->save();
        }
        else {
          $album->save();
        }
        
        if(isset($album->comment)) {
          foreach($album->comment as $xmlComment) {
            $comment = new Comment;
            $comment->artist = $artist->id;
            $comment->album = $album->id;
            $comment->commentatorName = $xmlComment->name;
            $comment->commentatorEMail = $xmlComment->email;
            $comment->commentDate = $xmlComment->date;
            $comment->comment = $xmlComment->text;
            $comment->publiciseEMail = 0;
            if(isset($xmlComment->reply))
              $comment->reply = $xmlComment->reply;
            $comment->save();
          }
        }
      }
      
      if(isset($xmlArtist->relatedArtist)) {
        foreach($xmlArtist->relatedArtist as $xmlRelatedArtist) {
          if(isset($xmlRelatedArtist->name)) {
            $relatedArtist = new Artist;
            $relatedArtist->name = $xmlRelatedArtist->name;
            $relatedArtist->reference = (string)$xmlRelatedArtist['ref'];
            $relatedArtist->introduction = $xmlRelatedArtist->text;
            $relatedArtist->save();
            
            $updatedItem = new UpdatedItem;
            $updatedItem->siteUpdate = $update->id;
            $updatedItem->artist = $relatedArtist->id;
            $updatedItem->save();
            
            if(isset($xmlRelatedArtist->comment)) {
              foreach($xmlRelatedArtist->comment as $xmlComment) {
                $comment = new Comment;
                $comment->artist = $relatedArtist->id;
                $comment->commentatorName = $xmlComment->name;
                $comment->commentatorEMail = $xmlComment->email;
                $comment->commentDate = $xmlComment->date;
                $comment->comment = $xmlComment->text;
                $comment->publiciseEMail = 0;
                if(isset($xmlComment->reply))
                  $comment->reply = $xmlComment->reply;
                $comment->save();
              }
            }
            
            $related = new RelatedArtist;
            $related->artist = $relatedArtist->id;
            $related->relatedTo = $artist->id;
            $related->save();
          }
          else {
            $relatedArtist = Artist::findByReference((string)$xmlRelatedArtist['ref']);
            
            $related = RelatedArtist::model()->findByPk(array($relatedArtist->id, $artist->id));
            if(is_null($related)) {
              $related = new RelatedArtist;
              $related->artist = $relatedArtist->id;
              $related->relatedTo = $artist->id;
              $related->save();
            }
          }
          
          foreach($xmlRelatedArtist->album as $xmlAlbum) {
            $album = $relatedArtist->findAlbumByReference((string)$xmlAlbum['ref']);
            if(is_null($album)) {
              $album = new Album;
              $album->artist = $relatedArtist->id;
              $album->reference = (string)$xmlAlbum['ref'];
              $album->title = $xmlAlbum->title;
              $album->year = $xmlAlbum->year;
            }
            if(isset($xmlAlbum->review)) {
              $album->highPoints = $xmlAlbum->highPoints;
              $album->review = $xmlAlbum->review;
              $album->rating = $xmlAlbum->rating;
              $album->commentPhrase = $xmlAlbum->commentPhrase;
              $album->save();
              
              foreach($xmlAlbum->disc as $xmlDisc) {
                $disc = new Disc;
                $disc->album = $album->id;
                if(isset($xmlDisc['title']))
                  $disc->title = (string)$xmlDisc['title'];
                $disc->save();
                
                foreach($xmlDisc->track as $xmlTrack) {
                  $track = new Track;
                  $track->album = $album->id;
                  $track->disc = $disc->disc;
                  $track->title = $xmlTrack->title;
                  $track->grade = $xmlTrack->grade;
                  $track->save();
                }
              }
              $updatedItem = new UpdatedItem;
              $updatedItem->siteUpdate = $update->id;
              $updatedItem->artist = $artist->id;
              $updatedItem->album = $album->id;
              $updatedItem->save();
            }
            else {
              $album->save();
            }
            
            if(isset($album->comment)) {
              foreach($album->comment as $xmlComment) {
                $comment = new Comment;
                $comment->artist = $artist->id;
                $comment->album = $album->id;
                $comment->commentatorName = $xmlComment->name;
                $comment->commentatorEMail = $xmlComment->email;
                $comment->commentDate = $xmlComment->date;
                $comment->comment = $xmlComment->text;
                $comment->publiciseEMail = 0;
                if(isset($xmlComment->reply))
                  $comment->reply = $xmlComment->reply;
                $comment->save();
              }
            }
          }
        }
      }
    }
  }
}