<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\UserLabels;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
Use App\Service\ServiceAdherents;
use App\Service\ServiceJsonCustom;

class ImportCommand extends ContainerAwareCommand
{
    //declaration des services qui vont être utilisés
    private $serviceAdherents;
    private $serviceJsonCustom;
    public function __construct(ServiceAdherents $serviceAdherents, ServiceJsonCustom $serviceJsonCustom)
    {
        $this->serviceAdherents = $serviceAdherents;
        $this->serviceJsonCustom = $serviceJsonCustom;
        //$this->mailer = $mailer;
        parent::__construct();
    }
    // fin de déclaration des services

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('import:csv')
            ->setDescription('Import users from CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' </comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('');
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' </comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);
        $usersLabels = $data[1];
        $adherents = $data[0];

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);


        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($adherents);
        $batchSize = 20;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        dump($usersLabels);
        // Updating columns names for traductions at every import
        $userLablesToPersist = new UserLabels();
        $userLablesToPersist->setIdCsv($usersLabels->getIdCsv());
        $userLablesToPersist->setLastName($usersLabels->getLastName());
        $userLablesToPersist->setFirstName($usersLabels->getFirstName());
        $userLablesToPersist->setPhoneNumber($usersLabels->getPhoneNumber());
        $em->persist($userLablesToPersist);
        $em->flush();

        // Processing on each row of data
        foreach($adherents as $row) {
            $output->writeln('');
            echo $row['id'];echo " ";
            echo $row['lastName'];echo " ";
            echo $row['firstName'];echo " ";
            echo $row['phoneNumber'];echo " ";


            $user = $em->getRepository('App:User')->findOneByLastName($row['lastName']);

            // If the user doest not exist we create one
            if(!is_object($user)){
                $user = new User();
            }

            // Updating info
            $user->setIdCsv($row['id']);
            $user->setLastName($row['lastName']);
            $user->setFirstName($row['firstName']);
            $user->setPhoneNumber($row['phoneNumber']);

            // Persisting the current user
            $em->persist($user);

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of users imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $output->writeln('');
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        //$fileName = 'csv/donnees.csv';

        $adherents = $this->serviceAdherents->getAdherentsEntities();
        // Using service for converting CSV to PHP Array
        //$converter = $this->getContainer()->get('import.csvtoarray');
        //$data = $converter->convert($fileName, ';');

        return $adherents;
    }

}