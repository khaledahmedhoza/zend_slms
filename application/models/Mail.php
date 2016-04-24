<?php
  require_once 'Zend/Mail.php';
  class Application_Model_Mail
  {
      public function sendActivationEmail($username, $email, $token)
      {

      	$config = array(
            'ssl'      => 'tls',
            'port'     => '587',
            'auth'     => 'login',
            'username' => 'eng.ahmed9393@gmail.com',
            'password' => '01143439044ahmed'
        );

		$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        
        $mail = new Zend_Mail();
        $mail->setBodyText('Please click the following link to activate your account '. 'www.et3lm.com/users/activate/token/' . $token . '/email/'.$email);
          // $email)->setFrom('admin@et3lm.com', 'Website Name Admin'->addTo($email, $username)->setSubject('Registration Success at Website Name')->send();
        // $mail->setBodyText("Welcome to Our Website..");
        $mail->setFrom('eng.ahmed9393@gmail.com');
		$mail->addTo($email, $username);
		$mail->setSubject('TestSubject');
		$mail->send($transport);
      }
  }