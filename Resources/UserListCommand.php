<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class UserListCommand extends Command {
	
	protected function configure() {
		$this->setName('user:list')
		->setDescription('Show list of users');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$green = new OutputFormatterStyle('green', 'black', array('bold', 'blink'));
		$output->getFormatter()->setStyle('green', $green);
		$text = "\n<green>\n";

		$users = new \User(array('subject' => 'XML REST API'));
		$list = $users->find('all');

		foreach ($list as $user) {
			var_dump($user);die;
			$text .= "ID : " . $user->_data['id'] . ", ";
			$text .= "NAME : " . $user->_data['name'] . "\n";
			$text .= "------------------------------------------------------------------\n";
		}

		$text .= "</green>\n";
		$output->writeln($text);
	}
}