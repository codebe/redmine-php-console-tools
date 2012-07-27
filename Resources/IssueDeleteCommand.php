<?php
namespace Redmine\Resources;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class IssueDeleteCommand extends Command {

	protected function configure() {
		$this->setName('issue:delete')
			->setDescription('Show list of users')
			->addArgument('id', InputArgument::REQUIRED, 'Which issue do you want delete?');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$id = $input->getArgument('id');
		$issue = new \Issue(array('subject' => 'XML Rest API'));
		$issue->find($id);
		if ($issue->destroy()) {
			$output->writeln('Issue successfully deleted');
		}
	}
}