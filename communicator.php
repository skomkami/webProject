<?php
	session_write_close();
	ignore_user_abort(false);


	if(isset($_REQUEST['getnow']) && $_REQUEST['getnow'] == 'true') {

		echo getMessages();

	} else { 
		$filename = 'messages.json';
		$last_update = filemtime($filename);
		if ($last_update === false) {
			throw new Exception('Could not read last modification time');
		}

		while(true) {
			usleep(100000);
			clearstatcache();
			if(filemtime($filename) > $last_update) {
				break;
			}
		}

		echo getMessages();
	}

	function getMessages() {

		if(file_exists('messages.json')) {
			$semaphore = sem_get(12345, 1, 0666, 1);
			sem_acquire($semaphore);

			$messages = file_get_contents('messages.json');
			$messagesArray = json_decode($messages, true);

			$messagesText = "";
			foreach($messagesArray as $message) {
				$messagesText.=$message['user'].": ".$message['message']."\n";
			}

			sem_release($semaphore);

			return $messagesText;
		}

		return "Nie można odczytać wiadomości";
	}

?>
