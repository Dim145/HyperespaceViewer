<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function query($alias, $options = [], $joins = [], $groupBy = null, $select = null): Query {
        $query = $this->createQueryBuilder($alias);
        if($select != null) {
            $query->select($select);
        }
        elseif($groupBy) {
            $query->select("$groupBy, COUNT($alias) as count");
        }
        $aliases = [$alias];
        foreach($joins as $key=>$al) {
            $query->leftJoin($key,$al);
            $aliases[] = $al;
        }
        $queryCopy = clone $query;
        $queryCopy->setMaxResults(1);
        $resultCopy = $queryCopy->getQuery()->getArrayResult();

        foreach($options as $name=>$value) {
            $nameExplode = explode('.',$name,2);

            if(!in_array($nameExplode[0],$aliases)) continue;

            if(is_null($value)) {
                $query->andWhere($name.' is null');
            }
            elseif(is_array($value)) {
                $type = 'text';
                $mode = 'exact';
                if(isset($value['type'])) $type = $value['type'];
                if(isset($value['mode'])) $mode = $value['mode'];
                if(isset($value['value'])) {
                    switch($type) {
                        case 'text':
                            switch($mode){
                                case '%like%':
                                    $query->andWhere($name.' LIKE :'.$nameExplode[1])->setParameter($nameExplode[1],'%'.$value['value'].'%');
                                    break;
                                case 'like%':
                                    $query->andWhere($name.' LIKE :'.$nameExplode[1])->setParameter($nameExplode[1],$value['value'].'%');
                                    break;
                                case '%like':
                                    $query->andWhere($name.' LIKE :'.$nameExplode[1])->setParameter($nameExplode[1],'%'.$value['value']);
                                    break;
                                case 'different':
                                    $query->andWhere($name.' != :'.$nameExplode[1])->setParameter($nameExplode[1],$value['value']);
                                    break;
                                case '>=':
                                    $query->andWhere($name. ' >= :'.$nameExplode[1])->setParameter($nameExplode[1], $value['value']);
                                    break;
                                case '>':
                                    $query->andWhere($name. ' > :'.$nameExplode[1])->setParameter($nameExplode[1], $value['value']);
                                    break;
                                case '<=':
                                    $query->andWhere($name. ' <= :'.$nameExplode[1])->setParameter($nameExplode[1], $value['value']);
                                    break;
                                case '<':
                                    $query->andWhere($name. ' < :'.$nameExplode[1])->setParameter($nameExplode[1], $value['value']);
                                    break;
                                default:
                                    $query->andWhere($name.' = :'.$nameExplode[1])->setParameter($nameExplode[1],$value['value']);
                            }
                            break;
                        default:
                            $query->andWhere($name.' = :'.$nameExplode[1])->setParameter($nameExplode[1],$value['value']);
                    }
                }
                elseif(isset($value['values'])) {

                }
            }
            else {
                $query->andWhere($name.' = :'.$nameExplode[1])->setParameter($nameExplode[1],$value);
            }
        }
        if($groupBy != null ) {
            $groupByExp = explode(',',$groupBy);
            foreach($groupByExp as $grp) {
                if($grp === $groupByExp[0]) $query->groupBy(trim($grp));
                else $query->addGroupBy(trim($grp));
            }
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
