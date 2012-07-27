<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class IssueUpdateCommand extends Command {

	protected function configure() {
		$this->setName('issue:update')
			 ->setDescription('Updating issue, specify issue id')
			 ->addArgument('id', InputArgument::REQUIRED, 'Which issue do you want update?')
			 ->addOption('status', null, InputOption::VALUE_REQUIRED,
			 		'Update the status of issue (new, in-progress, resolved, feedback, close, rejected)')
			 ->addOption('assigned_to_id', null, InputOption::VALUE_REQUIRED,
			 		'Update assigned user id');;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$green = new OutputFormatterStyle('green', 'black', array('bold', 'blink'));		
		
		$output->getFormatter()->setStyle('green', $green);
		
		$issue = new \Issue(array('subject' => 'XML REST API'));
		$issue = $issue->find($input->getArgument('id'));
		
		foreach ($input->getOptions() as $key => $value) {
			if ($value) {
				switch ($key) {
					case 'status' :
						$status = array('undefined', 'new', 'in-progress',
								'resolved', 'feedback', 'close', 'rejected');
						$issue->set('status_id', array_search($value, $status));
						break;
					case 'assigned_to_id' :
						$issue->set('assigned_to_id', $value);
						break;
				}
			}
		}

		if ($issue->save()) {			
			$text = "\n<green>Issue successfully to update. </green>\n";
		} else {
			$text = "\n<green>Issue failed to update, maybe you can't access the issue. </green>\n";
		}
		
		$output->writeln($text);
	}
}
