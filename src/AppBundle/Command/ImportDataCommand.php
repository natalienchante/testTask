<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ImportDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import-data')
            ->setDescription('Import data to database.')
            ->setHelp('This command allows you to import data, validate it and insert to database')
            ->addArgument('filename', InputArgument::REQUIRED, 'Enter the filename')
            ->addOption(
                'test',
                null,
                InputOption::VALUE_NONE,
                'Test mode',
                null
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $workflowOrganizer = $this->getContainer()->get('workflow.organizer');
        $result = $workflowOrganizer->processCSVFile(new \SplFileObject($filename), $test=$input->getOption('test'));
        $output->writeln('Всего ошибок: '.$result['result']->getErrorCount());
        $output->writeln('Успешно: '.$result['result']->getSuccessCount());
        $output->writeln('Всего обработано: '.$result['result']->getTotalProcessedCount());
        $output->writeln('Не прошли проверку данные с кодом: ');
        foreach ($result['failedItems'] as $item) {
            $output->writeln($item['Product Code']);
        }
    }
}