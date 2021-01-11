<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\CampaignRepository;
use App\Utils\WriterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportXlsCommand extends Command
{
    protected static $defaultName = 'app:export-xls';

    private CampaignRepository $campaignRepository;
    private WriterInterface $xlsWriter;

    public function __construct(CampaignRepository $campaignRepository, WriterInterface $xlsWriter)
    {
        $this->campaignRepository = $campaignRepository;
        $this->xlsWriter = $xlsWriter;

        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates an export in .xls format.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->campaignRepository->findActiveCampaigns() as $campaign) {
            $io->success(sprintf('Wrote file: %s', $this->xlsWriter->write($campaign)));
        }

        return 0;
    }
}
