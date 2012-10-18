<?php
return array(
  'name'        => 'Sir Mustapha\'s Reviews Page',
  'import'      => array('application.models.*',
                         'application.components.widgets.*',
                         'application.components.behavior.*',
                        ),
  'components'  => array(
    'urlManager'  => array(
      'urlFormat'   => 'path',
      'rules'       => array(
                        'reviews/<artist:[\d\w]+>' => 'site/reviews',
                        'comments/<artist:[\d\w]+>' => 'site/comments',
                        'comments/<artist:[\d\w]+>/<album:[\d\w]+>' => 'site/comments',
                       ),
    ),
    'db'          => array(
                      'class'             => 'CDbConnection',
                      'connectionString'  => 'mysql:host=localhost;dbname=reviews;',
                      'username'          => 'reviews',
                      'password'          => 'kraftwerk',
                      'emulatePrepare'    => true,
                     ),
                   ),
);