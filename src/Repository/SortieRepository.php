<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findAllByPage(int $page = 1, int $nbMaxParPage = 3){
        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }
        $qb = $this->createQueryBuilder('s')
            ->addSelect('s')
            ->orderBy('s.dateDebut','DESC');

        $premierResultat = ($page - 1) * $nbMaxParPage;
        $qb->setFirstResult($premierResultat)->setMaxResults($nbMaxParPage);
        $paginator = new Paginator($qb);

        return $paginator;
    }

    public function findSortieByCriteriaByPage($site, $nomContient, $dateEntre, $dateEt, $organisateur, $mesInscriptions, $userEnCours, $pasInscrit, $sortiesPassees, int $page = 1, int $nbMaxParPage = 3)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        $queryBuilder = $this->createQueryBuilder('sortie')
                        ->addSelect('sortie');
        //site
        if($site != null){
            $queryBuilder = $queryBuilder->andWhere('sortie.site = :val')
            ->setParameter('val', $site);
        }
        //nomContient
        if ($nomContient != null) {
            $queryBuilder = $queryBuilder->andWhere('sortie.nom LIKE :valContient')
                ->setParameter('valContient', '%'.$nomContient.'%');
        }
        //dates
        if ($dateEntre != null && $dateEt != null) {
            $queryBuilder = $queryBuilder->andWhere('sortie.dateDebut between :valDateDebut AND :valDateFin')
                ->setParameter('valDateDebut', $dateEntre)
                ->setParameter('valDateFin', $dateEt);
        }

        //dont je suis l'organisateur/trice
        if ($organisateur != null) {
            $queryBuilder->andWhere('sortie.organisateur = :valOrganisateur')
                ->setParameter('valOrganisateur', $userEnCours);
        }
        //auxquelles je suis inscrit/e
        if ($mesInscriptions != null) {
            $queryBuilder->innerJoin('sortie.inscriptions', 'inscriptions', 'WITH', 'inscriptions.participant = :valParticipant')
                ->setParameter('valParticipant', $userEnCours);
        }
        //auxquelles je ne suis pas inscrit/e
        if ($pasInscrit != null) {
            // Toutes les sorties de l'utilisateur
            $queryBuilder2 = $this->createQueryBuilder('sortie2')
            ->select('sortie2.id')
            ->innerJoin('sortie2.inscriptions', 'inscriptions2', 'WITH', 'inscriptions2.participant = :valParticipant2');
            $queryBuilder->andWhere($queryBuilder->expr()->notIn('sortie.id', $queryBuilder2->getDQL()))
            ->setParameter('valParticipant2', $userEnCours);
            /*$queryBuilder
                ->andWhere(':valParticipant NOT MEMBER OF sortie.inscriptions')
                ->setParameter('valParticipant', $userEnCours);*/
        }
        //Sorties passées
        if ($sortiesPassees != null) {
            $queryBuilder ->innerjoin('sortie.etat', 'etat', 'WITH', 'etat.libelle = :valLibelle')
                ->setParameter('valLibelle', "Passée");
        }

        $queryBuilder->orderBy('sortie.dateDebut', 'DESC');

        $premierResultat = ($page - 1) * $nbMaxParPage;
        $queryBuilder->setFirstResult($premierResultat)->setMaxResults($nbMaxParPage);
        $paginator = new Paginator($queryBuilder);
        return $paginator;
    }


    public function findByDateArchive(){
        $oneMonthAgo = ((new \DateTime('now -1 month'))->setTime(0,0,0));
        $qb = $this->createQueryBuilder('s')
            ->where('s.dateDebut <= :oneMonthAgo')
            ->setParameter('oneMonthAgo', $oneMonthAgo)
            ->getQuery()
            ->getResult();
        return $qb;
    }
}
