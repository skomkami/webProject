<?php

	echo addMessage();

	function addMessage() {


		if(file_exists('messages.json')) {
			$semaphore = sem_get(12345, 1, 0666, 1);
			sem_acquire($semaphore);

			$messages = file_get_contents('messages.json');
			$messagesArray = json_decode($messages, true);

			if(isset($_REQUEST["user"]) && isset($_REQUEST["message"]) 
				&& !empty($_REQUEST["user"]) && !empty($_REQUEST["message"])) {
				$user = $_REQUEST["user"];
				$message = $_REQUEST["message"];
			
				$new_message = array(
					'user' => $user,
					'message' => $message
				);

				$messagesArray[] = $new_message;

				if(count($messagesArray) >= 5)
					array_shift($messagesArray);

				$messages_encoded = json_encode($messagesArray);

				if(!file_put_contents('messages.json', $messages_encoded)) {
					sem_release($semaphore);
					return "failure";
				}
				
				sem_release($semaphore);
				return "success";

			} else {
				sem_release($semaphore);
				return "failure";
			}
		} else
			return "failure";
	}

?>
