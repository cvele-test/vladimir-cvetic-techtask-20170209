<?php

namespace App\Entity;

/**
 * ingredient entity.
 */
class Ingredient
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $useBy;

    /**
     * @var \DateTime
     */
    protected $bestBefore;

    /**
     * Get the value of Title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title.
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Use By.
     *
     * @return \DateTime
     */
    public function getUseBy()
    {
        return $this->useBy;
    }

    /**
     * Set the value of Use By.
     *
     * @param \DateTime $useBy
     *
     * @return self
     */
    public function setUseBy(\DateTime $useBy)
    {
        $this->useBy = $useBy;

        return $this;
    }

    /**
     * Get the value of Best Before.
     *
     * @return \DateTime
     */
    public function getBestBefore()
    {
        return $this->bestBefore;
    }

    /**
     * Set the value of Best Before.
     *
     * @param \DateTime $bestBefore
     *
     * @return self
     */
    public function setBestBefore(\DateTime $bestBefore)
    {
        $this->bestBefore = $bestBefore;

        return $this;
    }

    /**
     * Convers object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}
