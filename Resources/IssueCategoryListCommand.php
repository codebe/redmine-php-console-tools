<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IssueCategoryListCommand extends Command {
	
	protected function configure() {
		$this->setName('issue:category:list')
		->setDescription('Querying issues categories in redmine')
		->addArgument('project_id', InputArgument::REQUIRED, 'Which project do you want searching?');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
	
		//@TODO : Implement issue:category:list command
		$output->writeln($text);
	}

}