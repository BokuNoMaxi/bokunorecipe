<?php

declare(strict_types=1);

namespace BokuNoRecipe\Bokunorecipe\Domain\Model;


/**
 * This file is part of the "BokuNoRecipe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 Markus Ketterer <ketterer.markus@gmx.at>
 */

/**
 * Ingredients
 */
class Ingredients extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject
{

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * unit
     *
     * @var string
     */
    protected $unit = '';

    /**
     * gluten
     *
     * @var bool
     */
    protected $gluten = false;

    /**
     * lactose
     *
     * @var bool
     */
    protected $lactose = false;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns the unit
     *
     * @return string $unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Sets the unit
     *
     * @param string $unit
     * @return void
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
    }

    /**
     * Returns the gluten
     *
     * @return bool gluten
     */
    public function getGluten()
    {
        return $this->gluten;
    }

    /**
     * Sets the gluten
     *
     * @param bool $gluten
     * @return void
     */
    public function setGluten(bool $gluten)
    {
        $this->gluten = $gluten;
    }

    /**
     * Returns the boolean state of gluten
     *
     * @return bool gluten
     */
    public function isGluten()
    {
        return $this->gluten;
    }

    /**
     * Returns the lactose
     *
     * @return bool lactose
     */
    public function getLactose()
    {
        return $this->lactose;
    }

    /**
     * Sets the lactose
     *
     * @param bool $lactose
     * @return void
     */
    public function setLactose(bool $lactose)
    {
        $this->lactose = $lactose;
    }

    /**
     * Returns the boolean state of lactose
     *
     * @return bool lactose
     */
    public function isLactose()
    {
        return $this->lactose;
    }
}
