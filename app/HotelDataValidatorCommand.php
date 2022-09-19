<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Yaml\Yaml;
use App\FileReader\CsvFileReader;
use App\Validator\HotelDataValidator;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class HotelDataValidatorCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('generate:validdata')
            ->setDescription('This command will generate validated hotel data into specified format')
            ->addArgument(
                'output_type',
                InputArgument::REQUIRED,
                'Specify an output format type (yaml|xml)!'
            )
            ->addArgument(
                'file_name',
                InputArgument::OPTIONAL,
                'Specify an output file name!'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputType = $input->getArgument('output_type');
        $outputFile = $input->getArgument('file_name');

        $config = Yaml::parse(file_get_contents(__DIR__ . '/../config.yml'));

        $fullLogPath = __DIR__ . '/../log/';

        if (!isset($config['settings']['writer'][$outputType])) {
            $output->writeln(sprintf('<error>Defined output type %s currently not implemented in system. Please try xml/yaml type</error>', $outputType));
        } else {
            $output->writeln('Hotel data validation process initiated.');
            $output->writeln('========================================');

            $output->writeln('Reading data from given CSV file.');

            $logger = new Logger($config['settings']['monolog']['name']);
            $logger->pushHandler(new StreamHandler($fullLogPath  . $config['settings']['monolog']['path'], Logger::WARNING));

            $csvFileReader = new CsvFileReader();
            $hotelsData = $csvFileReader->getFileContent(__DIR__ . '/../' . $config['settings']['file_name'], $config);

            $hotelDataValidator = new HotelDataValidator($config, $logger);

            $fileWriter = new $config['settings']['writer'][$outputType]['class']();

            $output->writeln('Data validation and processing started.');

            $allHotelData = array();
            foreach ($hotelsData as $hotel)
            {
                if ($hotelDataValidator->validateHotelData($hotel))
                {
                    $allHotelData[] = $hotel;
                    $fileWriter->appendData($hotel);
                }
            }

            $totalHotelCount = count($allHotelData);

            $output->writeln(sprintf('<info>Total %s valid data found from CSV.</info>', $totalHotelCount));
            $output->writeln('Data validation and processing finished. Now writing to file.');

            if($outputFile && $outputFile != "")
            {
                $fileWriter->saveDataToFile(__DIR__ . "/../" . $outputFile . $config['settings']['writer'][$outputType]['ext']);
                $output->writeln('Data successfully written to the file ' . $outputFile . $config['settings']['writer'][$outputType]['ext']);
            }
            else
            {
                $fileWriter->saveDataToFile(__DIR__ . "/../" . $config['settings']['writer'][$outputType]['save_file']);
                $output->writeln('Data successfully written to the file ' . $config['settings']['writer'][$outputType]['save_file']);
            }

            $output->writeln(sprintf('<info>Please check log file /log/hotel_data_log.log for more details information.</info>'));
            $output->writeln('Hotel data validation process finished successfully.');
            $output->writeln('====================================================');

        }
    }
}