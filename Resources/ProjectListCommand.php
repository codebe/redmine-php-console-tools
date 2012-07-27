<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ProjectListCommand extends Command {
	
	protected function configure() {
		$this->setName('project:list')
		->setDescription('Show list of projects');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
	
		$green = new OutputFormatterStyle('green', 'black', array('bold', 'blink'));	
		$output->getFormatter()->setStyle('green', $green);
		$text = "\n<green>\n";
	
		$projects = new \Project(array('subject' => 'XML REST API'));
		$list = $projects->find('all');
	
		foreach ($list as $project) {
			$text .= "ID : " . $project->_data['id'] . ", ";
			$text .= "NAME : " . $project->_data['name'] . "\n";
			$text .= "------------------------------------------------------------------\n";
		}
	
		
		$text .= "</green>\n";
		$output->writeln($text);
	}
}