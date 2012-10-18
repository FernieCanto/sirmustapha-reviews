<header id="commentPageHeader">
  <h1>Send your comments</h1>
  
  <p>Thank you for your interest! Through this link, you can send me comments
     for any artist and album I review here, on this site. Select the artist and
     the album on the combo boxes before, fill up the form, and once you submit,
     your comment will be immediately visible on the website for everyone to read.
     Simple, eh? Fast, eh? Easy, eh? Of course, that doesn't mean you can use
     this form to write up any nonsense you think up, use the website as some
     kind of forum, or send me personal messages unrelated to the music. Read
     the <?=CHtml::link("guidelines", array("site/guidelines"))?> for further
     detailed info. Be aware that any comments that don't meed the guidelines 
     will be DELETED without warning, so consider yourself warned. If you wish
     to speak and/or ask something directly to me, feel free to mail me through
     cfern(dot)canto[ANTISPAM-at]gmail(dot)com! And without further ado, THE FORM!</p>
</header>

<?php
$form = $this->beginWidget("CActiveForm", array(
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
));

echo $form->errorSummary($comment);

echo $form->labelEx($comment, 'album').': ';
echo $form->dropDownList($comment, 'album', $artist->getAlbumsForForm());
echo '<br />';

echo $form->labelEx($comment, 'commentatorName').': ';
echo $form->textField($comment, 'commentatorName');
echo '<br />';

echo $form->labelEx($comment, 'commentatorEMail').': ';
echo $form->textField($comment, 'commentatorEMail');
echo $form->labelEx($comment, 'publiciseEMail');
echo $form->checkBox($comment, 'publiciseEMail');
echo '<br />';

echo $form->labelEx($comment, 'comment').':<br />';
echo $form->textArea($comment, 'comment', array('cols' => 40, 'rows' => 6));
echo '<br />';

echo CHtml::submitButton('Send!');
$this->endWidget();