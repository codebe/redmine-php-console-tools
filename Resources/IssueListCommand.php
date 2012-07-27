<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class IssueListCommand extends Command {

	protected function configure() {
		$this->setName('issue:list')
			 ->setDescription('Querying issues in redmine')
			 ->addOption('project_id', null, InputOption::VALUE_REQUIRED, 
			 		'Project id filtering issues by project (e.g : project_id=2)')
			 ->addOption('status', null, InputOption::VALUE_REQUIRED,
			 		'Status of issue (new, in-progress, resolved, feedback, close, rejected)')
			 ->addOption('assigned_to_id', null, InputOption::VALUE_REQUIRED,
			 		'Filtered issue by assigned user id');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
						
		$green = new OutputFormatterStyle('green', 'black', array('bold', 'blink'));
		$red = new OutputFormatterStyle('white', 'red', array('bold', 'blink'));
		$blue = new OutputFormatterStyle('white', 'blue', array('bold', 'blink'));
		$yellow = new OutputFormatterStyle('black', 'yellow', array('bold', 'blink'));
		
		$output->getFormatter()->setStyle('green', $green);
		$output->getFormatter()->setStyle('red', $red);
		$output->getFormatter()->setStyle('blue', $blue);
		$output->getFormatter()->setStyle('yellow', $yellow);
		
		$text = "\n<green>\n";			
		$issues = new \Issue(array('subject' => 'XML REST API'));
		
		if (count($input->getOptions()) > 7) {
			$query_string = "";			
			foreach ($input->getOptions() as $key => $value) {
				if ($value) {
					$status = array('undefined', 'new', 'in-progress', 
							'resolved', 'feedback', 'close', 'rejected');
					if ($key == 'status') {
						$value = array_search($value, $status);
						$key = 'status_id';
					}
					$query_string .= $key . '=' . $value . '&';					  
				}
			}								
			$list = $issues->query($query_string);				
		} else {			
			$list = $issues->find('all');
		}		
				
		foreach ($list as $issue) {						
			$issue->assignVariables();
			$text .= "ID : " . $issue->id . ", ";
			$text .= "SUBJECT : " . $issue->subject . ", ";
			$text .= "PROJECT : " . "[{$issue->project->id}] " .  $issue->project->name . "\n";
			$text .= "DESCRIPTION : <yellow> " . $issue->description . " </yellow>\n";
			$text .= "STATUS : <red> " . $issue->status->name . " </red>, ";
			if (@$issue->assigned_to) {
				$text .= "ASSIGNED TO : <blue> " . "[{$issue->assigned_to->attributes()->id}] " . $issue->assigned_to->attributes()->name . " </blue>\n";
			} else {
				$text .= "<blue> NOT ASSIGNED YET </blue>\n";
			}
			$text .= "------------------------------------------------------------------\n";
		}
						
		$text .= "</green>\n";		
		$output->writeln($text);
	}
}
