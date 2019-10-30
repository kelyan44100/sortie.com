<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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

    public function findBySite($site){
        return $this->createQueryBuilder('s')
            ->andWhere('s.site = :val')
            ->setParameter('val', $site)
            ->orderBy('s.dateDebut', 'DECS')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNom(String $nomContient){
        return $this->createQueryBuilder('s')
            ->where('s.nom LIKE :search')
            ->setParameter('search', '%'.$nomContient.'%')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByEntresDates($dateEntre, $dateEt){
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut BETWEEN :dateEntre and :dateEt')
            ->setParameter('dateEntre', $dateEntre)
            ->setParameter('dateEt', $dateEt)
            //->orderBy('s.dateDebut', 'DECS')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByOrganisateur($org){
        return $this->createQueryBuilder('s')
            ->andWhere('s.organisateur = :org')
            ->setParameter('org', $org)
            ->orderBy('s.dateDebut', 'DECS')
            ->getQuery()
            ->getResult()
            ;
    }


    public function getDateDuJour()
    {
        return (new \DateTime('now'))->setTime(0, 0, 0);
    }

    public function findSortieByCriteria($site, $nomContient, $dateEntre, $dateEt, $organisateur, $mesInscriptions, $userEnCours, $pasInscrit, $sortiesPassees)
    {
        $queryBuilder = $this->createQueryBuilder('sortie');
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

        $queryBuilder = $queryBuilder->orderBy('sortie.dateDebut', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $queryBuilder;
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
