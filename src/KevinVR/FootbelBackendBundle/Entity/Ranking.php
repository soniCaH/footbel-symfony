<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ranking
 *
 * @ORM\Table(name="ranking")
 * @ORM\Entity(repositoryClass="KevinVR\FootbelBackendBundle\Repository\RankingRepository")
 */
class Ranking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="games")
     * @ORM\JoinColumn(name="season", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbelBackendBundle\Entity\Season")
     * @Assert\Valid()
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="resources")
     * @ORM\JoinColumn(name="level", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbelBackendBundle\Entity\Level")
     * @Assert\Valid()
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="resources")
     * @ORM\JoinColumn(name="province", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbelBackendBundle\Entity\Province")
     * @Assert\Valid()
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="division", type="string", length=255)
     */
    private $division;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="team", type="string", length=255)
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(name="matches", type="integer")
     */
    private $matches;

    /**
     * @var int
     *
     * @ORM\Column(name="wins", type="integer")
     */
    private $wins;

    /**
     * @var int
     *
     * @ORM\Column(name="draws", type="string", length=255)
     */
    private $draws;

    /**
     * @var int
     *
     * @ORM\Column(name="losses", type="integer")
     */
    private $losses;

    /**
     * @var int
     *
     * @ORM\Column(name="goals_pro", type="integer")
     */
    private $goalsPro;

    /**
     * @var int
     *
     * @ORM\Column(name="goals_against", type="integer")
     */
    private $goalsAgainst;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(name="period", type="integer")
     */
    private $period;


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
     * Get season
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set season
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     *
     * @return Ranking
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get level
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     *
     * @return Ranking
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get province
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     *
     * @return Ranking
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set division
     *
     * @param string $division
     *
     * @return Ranking
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Ranking
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get team
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set team
     *
     * @param string $team
     *
     * @return Ranking
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get matches
     *
     * @return int
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Set matches
     *
     * @param integer $matches
     *
     * @return Ranking
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;

        return $this;
    }

    /**
     * Get wins
     *
     * @return int
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set wins
     *
     * @param integer $wins
     *
     * @return Ranking
     */
    public function setWins($wins)
    {
        $this->wins = $wins;

        return $this;
    }

    /**
     * Get draws
     *
     * @return string
     */
    public function getDraws()
    {
        return $this->draws;
    }

    /**
     * Set draws
     *
     * @param string $draws
     *
     * @return Ranking
     */
    public function setDraws($draws)
    {
        $this->draws = $draws;

        return $this;
    }

    /**
     * Get losses
     *
     * @return int
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * Set losses
     *
     * @param integer $losses
     *
     * @return Ranking
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;

        return $this;
    }

    /**
     * Get goalsPro
     *
     * @return int
     */
    public function getGoalsPro()
    {
        return (int) $this->goalsPro;
    }

    /**
     * Set goalsPro
     *
     * @param integer $goalsPro
     *
     * @return Ranking
     */
    public function setGoalsPro($goalsPro)
    {
        $this->goalsPro = $goalsPro;

        return $this;
    }

    /**
     * Get goalsAgainst
     *
     * @return int
     */
    public function getGoalsAgainst()
    {
        return (int) $this->goalsAgainst;
    }

    /**
     * Set goalsAgainst
     *
     * @param integer $goalsAgainst
     *
     * @return Ranking
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;

        return $this;
    }

    /**
     * Get goalsDifference
     *
     * @return int
     */
    public function getGoalsDifference()
    {
        return (int) $this->getGoalsPro() - $this->getGoalsAgainst();
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Ranking
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get period
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return Ranking
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }
}

