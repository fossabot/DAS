<?php

namespace CourseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="CourseBundle\Repository\GradeRepository")
 */
class Grade
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="grade", type="integer", unique=true)
     */
    private $grade;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CourseBundle\Entity\GradeClass", mappedBy="grade")
     */
    private $sections;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\CourseContent", mappedBy="grades")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $courses;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CourseBundle\Entity\Lesson", inversedBy="grades")
     * @ORM\JoinColumn(name="lessoné_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $lessons;

    /**
     * Grade constructor.
     */
    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get grade
     *
     * @return int
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return GradeClass
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param GradeClass $class
     *
     * @return Grade
     */
    public function addSection(GradeClass $class)
    {
        $this->sections->add($class);
        return $this;
    }

    /**
     * @param GradeClass $class
     *
     * @return Grade
     */
    public function removeSection(GradeClass $class)
    {
        $this->sections->removeElement($class);
        return $this;
    }

    /**
     * @return CourseContent
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param CourseContent $class
     *
     * @return Grade
     */
    public function addCourse(CourseContent $class)
    {
        $this->sections->add($class);
        return $this;
    }

    /**
     * @param CourseContent $class
     *
     * @return Grade
     */
    public function removeCourse(CourseContent $class)
    {
        $this->sections->removeElement($class);
        return $this;
    }
}

