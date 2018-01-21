<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CountSubposts extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:count-subposts')
            ->setDescription('Counts sub posts')
            ->setHelp('This command allows you to count')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        #$name = $input->getArgument('name');
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        $i = 0;

        $query = $em->createQueryBuilder()
            ->select('p.id')
            ->from('AppBundle\Entity\Post', 'p')
            ->where('p.type = \'main\'')
            ->getQuery()
            ->iterate();

        foreach ($query as $row) {
            $query2 = $em->createQueryBuilder()
                ->select('count(p.id)')
                ->from('AppBundle\Entity\Post', 'p')
                ->where('p.parent = ' . $row[$i]['id'])
                ->getQuery()
                ->getSingleScalarResult();

            $product = $em->getRepository(Post::class)->find($row[$i]['id']);

            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$row[$i]['id']
                );
            }

            $product->setCountSubPosts($query2);

            $output->write($row[$i]['id'] . ' - ' . $query2 . "\n");
            $em->flush();
            $i++;
        }

        $output->write("Done");
        $output->write("\n");
    }
}