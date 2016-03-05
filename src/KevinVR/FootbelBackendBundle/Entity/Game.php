<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="KevinVR\FootbelBackendBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="division", type="string", length=25)
     */
    private $division;

    /**
     * @var int
     *
     * @ORM\Column(name="matchday", type="integer")
     */
    private $matchday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="home_name", type="string", length=255)
     */
    private $homeName;

    /**
     * @var string
     *
     * @ORM\Column(name="home_regnr", type="string", length=255)
     */
    private $homeRegnr;

    /**
     * @var string
     *
     * @ORM\Column(name="away_name", type="string", length=255)
     */
    private $awayName;

    /**
     * @var string
     *
     * @ORM\Column(name="away_regnr", type="string", length=255)
     */
    private $awayRegnr;

    /**
     * @var int
     *
     * @ORM\Column(name="score_home", type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @var int
     *
     * @ORM\Column(name="score_away", type="integer", nullable=true)
     */
    private $scoreAway;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=true)
     */
    private $status;

    /**
     * Game constructor.
     * @param $season
     * @param $level
     * @param $province
     * @param $division
     * @param $matchday
     * @param $datetime
     * @param $homename
     * @param $awayname
     * @param $homeregnr
     * @param $awayregnr
     * @param $homescore
     * @param $awayscore
     * @param $status
     */
    public function __construct(
        $season,
        $level,
        $province,
        $division,
        $matchday,
        $datetime,
        $homename,
        $awayname,
        $homeregnr,
        $awayregnr,
        $homescore,
        $awayscore,
        $status
    ) {
        $this->setSeason($season);
        $this->setLevel($level);
        $this->setProvince($province);
        $this->setDivision($division);
        $this->setMatchday($matchday);
        $this->setDatetime($datetime);
        $this->setHomeName($homename);
        $this->setAwayName($awayname);
        $this->setHomeRegnr($homeregnr);
        $this->setAwayRegnr($awayregnr);
        $this->setScoreHome($homescore);
        $this->setScoreAway($awayscore);
        $this->setStatus($status);
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
     * Set season
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     *
     * @return Game
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
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
     * Set level
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     *
     * @return Game
     */
    public function setLevel($level)
    {
        $this->level = $level;

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
     * Set province
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     *
     * @return Game
     */
    public function setProvince($province)
    {
        $this->province = $province;

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
     * Set division
     *
     * @param string $division
     *
     * @return Game
     */
    public function setDivision($division)
    {
        $this->division = $division;

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
     * Set matchday
     *
     * @param integer $matchday
     *
     * @return Game
     */
    public function setMatchday($matchday)
    {
        $this->matchday = $matchday;

        return $this;
    }

    /**
     * Get matchday
     *
     * @return int
     */
    public function getMatchday()
    {
        return $this->matchday;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Game
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Get datetime in a formatted way
     *
     * @param string $format
     *
     * @return string
     */
    public function getDatetimeFormatted($format)
    {
        return $this->datetime->format($format);
    }

    /**
     * Set homeName
     *
     * @param string $homeName
     *
     * @return Game
     */
    public function setHomeName($homeName)
    {
        $this->homeName = $homeName;

        return $this;
    }

    /**
     * Get homeName
     *
     * @return string
     */
    public function getHomeName()
    {
        return $this->homeName;
    }

    /**
     * Set homeRegnr
     *
     * @param string $homeRegnr
     *
     * @return Game
     */
    public function setHomeRegnr($homeRegnr)
    {
        $this->homeRegnr = $homeRegnr;

        return $this;
    }

    /**
     * Get homeRegnr
     *
     * @return string
     */
    public function getHomeRegnr()
    {
        return $this->homeRegnr;
    }

    /**
     * Set awayName
     *
     * @param string $awayName
     *
     * @return Game
     */
    public function setAwayName($awayName)
    {
        $this->awayName = $awayName;

        return $this;
    }

    /**
     * Get wayName
     *
     * @return string
     */
    public function getAwayName()
    {
        return $this->awayName;
    }

    /**
     * Set awayRegnr
     *
     * @param string $awayRegnr
     *
     * @return Game
     */
    public function setAwayRegnr($awayRegnr)
    {
        $this->awayRegnr = $awayRegnr;

        return $this;
    }

    /**
     * Get awayRegnr
     *
     * @return string
     */
    public function getAwayRegnr()
    {
        return $this->awayRegnr;
    }

    /**
     * Set scoreHome
     *
     * @param integer $scoreHome
     *
     * @return Game
     */
    public function setScoreHome($scoreHome)
    {
        $this->scoreHome = is_int($scoreHome) ? $scoreHome : null;

        return $this;
    }

    /**
     * Get scoreHome
     *
     * @return int
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * Set scoreAway
     *
     * @param integer $scoreAway
     *
     * @return Game
     */
    public function setScoreAway($scoreAway)
    {
        $this->scoreAway = is_int($scoreAway) ? $scoreAway : null;

        return $this;
    }

    /**
     * Get scoreAway
     *
     * @return int
     */
    public function getScoreAway()
    {
        return $this->scoreAway;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

}

