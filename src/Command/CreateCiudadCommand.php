<?php

namespace App\Command;

use App\Entity\Provincia;
use App\Repository\CiudadRepository;
use App\Repository\ProvinciaRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-ciudad')]
class CreateCiudadCommand extends Command
{
    public function __construct(
        private CiudadRepository $ciudadRepository,
        private ProvinciaRepository $provinciaRepository
    )
    {
        parent::__construct();
    }
    protected function configure(): void
{
    $this
        ->addArgument('ciudad', InputArgument::REQUIRED, 'Nombre de la ciudad')
        ->addArgument('provincia', InputArgument::REQUIRED, 'Nombre de la provincia')
    ;
}
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $provincia = $this->provinciaRepository->findOneBy(['descripcion' => $input->getArgument('provincia')]);
        if (!$provincia) {
            $output->writeln('Provincia no encontrada');
            return Command::FAILURE;
        }
        $this->ciudadRepository->guardar($input->getArgument('ciudad'), $provincia);
        
        $output->writeln('ciudad: '.$input->getArgument('ciudad'));
        $output->writeln('provincia: '.$input->getArgument('provincia'));

        $output->writeln('Ciudad agregada con exito!');
        return Command::SUCCESS;

        
    }
}