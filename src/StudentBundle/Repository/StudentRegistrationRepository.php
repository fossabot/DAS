<?php

namespace StudentBundle\Repository;

use Carbon\Carbon;
use CoreBundle\Repository\AbstractRepository;
use CourseBundle\Entity\Lesson;
use Doctrine\ORM\QueryBuilder;
use UserBundle\Entity\Student;

/**
 * StudentRegistrationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRegistrationRepository extends AbstractRepository
{
    protected $alias = "sr";

    /**
     * @param Lesson $lesson
     *
     * @return array
     */
    public function findByLesson(Lesson $lesson)
    {
        return $this->createQueryBuilder($this->alias)
            ->where('sr.lesson = :lesson')
            ->setParameter('lesson', $lesson)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Student $student
     * @param Lesson  $lesson
     *
     * @return array
     */
    public function findByStudentAndLesson(Student $student, Lesson $lesson)
    {
        return $this->getByStudentAndLessonQuery($student, $lesson)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Student $student
     * @param Lesson  $lesson
     *
     * @return QueryBuilder
     */
    private function getByStudentAndLessonQuery(Student $student, Lesson $lesson)
    {
        return $this->createQueryBuilder($this->alias)
            ->where('sr.lesson = :lesson')
            ->andWhere('sr.student = :student')
            ->setParameter('lesson', $lesson)
            ->setParameter('student', $student);
    }


    /**
     * @param Student $student
     * @param Lesson  $lesson
     *
     * @return mixed
     */
    public function countByStudentAndLesson(Student $student, Lesson $lesson)
    {
        return $this->getByStudentAndLessonQuery($student, $lesson)
            ->select('count(sr.student)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param $student
     * @param $lesson
     *
     * @return mixed
     */
    public function deleteForStudentAndLesson($student, $lesson)
    {
        return $this->createQueryBuilder('sr')
            ->update()
            ->set('sr.deletedAt', ':now')
            ->where('sr.student = :student')
            ->andWhere('sr.lesson = :lesson')
            ->setParameter('now', Carbon::now())
            ->setParameter('student', $student)
            ->setParameter('lesson', $lesson)
            ->getQuery()
            ->execute();
    }
}
