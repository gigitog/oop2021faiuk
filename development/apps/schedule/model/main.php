<?php
/**
 * User Controller
 *
 * @author Fayuk  Kostyantyn
 * @global object $CORE->model
 * @package Model\Main
 */
namespace Model;
class Main
{
	use \Library\Shared;

	public function formsubmitAmbassador(array $data):?array {
		$key = 'my_key'; // Ключ API телеграм
		if (empty($key)) throw new Exception("NullKey", 1);
		
		$result = null;
		$chat = 349870574;
		$text = 
			"Нова заявка в *Цифрові Амбасадори*:\n" 
			. $data['firstname'] . ' '
			. $data['secondname']. " 👤\n"
			. $data['position'] . " 🪑\n\n*Зв'язок*: " 
			. $data['phone'] . ' 📞, ' 
			. $data['email'] . ' 📧';
		$text = urlencode($text);
		$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chat&text=$text");
		$answer = json_decode($answer, true);
		$result = ['message' => $answer['result']];
		return $result;
	}

	public function __construct() {

	}
}