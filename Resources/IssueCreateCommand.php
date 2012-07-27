<?php

namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Shell;

class IssueCreateCommand extends Command {

	protected function configure() {
		$this->setName('issue:create')
			 ->setDescription('Create issue in redmine project')
			 ->addArgument('project_id', InputArgument::REQUIRED, 'Which project do you want add new issue?');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		
		$project_id = $input->getArgument('project_id');		
		$text = "";
		
		$dialog = $this->getHelperSet()->get('dialog');

		$tracker = $dialog->ask($output, '<question>(REQUIRED) Issue type (bug, feature, support, tasks) : </question> ');
		while (!$tracker || !in_array(strtolower($tracker), array('bug', 'feature', 'support', 'tasks'))) {
			$output->writeln("<question>Your input is not valid, !</question>");
			$tracker = $dialog->ask($output, '<question>(REQUIRED) Issue type (bug, feature, support, tasks) : </question> ');
		}
		
		$subject = $dialog->ask($output, '<question>(REQUIRED) Issue title : </question> ');
		while (!$subject) {
			$subject = $dialog->ask($output, '<question>(REQUIRED) Issue title : </question> ');
		}

		$description = $dialog->ask($output, '<question>(REQUIRED) Issue description : </question> ');
		while (!$description) {
			$description = $dialog->ask($output, '<question>(REQUIRED) Issue description : </question> ');
		}
		
		$status = $dialog->ask($output, '<question>(REQUIRED) Issue status (new, in-progress, resolved, feedback, close, rejected) : </question> ');
		while (!$status) {
			$status = $dialog->ask($output, '<question>(REQUIRED) Issue status (new, in-progress, resolved, feedback, close, rejected) : </question> ');
		}
		
		$assigned_to = $dialog->ask($output, '<question>(OPTIONAL) Issue assigned to (USER ID) : </question> ');
		while ($assigned_to && !is_numeric($assigned_to)) {
			$output->writeln("<question>Your input is not integer!</question>");
			$assigned_to = $dialog->ask($output, '<question>(OPTIONAL) Issue assigned to (USER ID) : </question> ');
		}	

		$statuses = array('undefined', 'new', 'in-progress', 'resolved', 'feedback', 'close', 'rejected');
		$trackers = array('bug', 'feature', 'support', 'tasks');
		$issue = new \Issue(array(
			'tracker_id' => array_search($tracker, $trackers),
			'subject' => $subject,
			'description' => $description,
			'project_id' => $project_id,
			'status_id' => array_search($status, $statuses),
			'assigned_to_id' => $assigned_to
		));
		
		if ($issue->save()) {
			$output->writeln('Issue has been created.');
		}
		
		$output->writeln($text);
	}
}

