<?php
class ManagementController extends CController {
  public function actionPublish() {
    if(isset($_POST['siteUpdate'])) {
      $siteUpdate = SiteUpdate::model()->findByPk($_POST['siteUpdate']);
      $siteUpdate->publish();
    }
    
    $this->render("publish", array('updates' => SiteUpdate::model()->unpublished()->findAll()));
  }

  public function actionImport() {
    if(isset($_FILES['import'])) {
      $ImportXML = new ImportXML;
      try {
        $ImportXML->loadXML($_FILES['import']['tmp_name']);
        $ImportXML->import();
        $this->render("import_ok");
      }
      catch(XMLImportException $e) {
        $this->render("import", array("error" => $e->getMessage()));
      }
    }
    else {
      $this->render("import");
    }
  }
}