<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\FormExtensionsBundle\Behat\Context\Page\Element;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class Form extends Element
{
    protected $selector = ['css' => 'form'];

    public function movePhoto(int $photoNumber, int $newPosition): void
    {
        $this->getDriver()->executeScript(sprintf("
var photo = document.getElementById('gallery_photos_%s');
var parent = photo.parentNode;
photo.remove();
var insertBefore = document.getElementById('gallery_photos_%s');
parent.insertBefore(photo, insertBefore)",
            $photoNumber - 1, $newPosition - 1));
    }

    public function getGoogleMapWrapper(string $label): ?NodeElement
    {
        return $this->find(
            'xpath',
            sprintf(
                '//label[text()="%s"]/parent::*/descendant::*[contains(concat(" ", normalize-space(@class), " "), " map-location ")]',
                $label
            )
        );
    }

    public function isGoogleMap(string $fieldSelector): bool
    {
        if (!$this->getDriver() instanceof Selenium2Driver) {
            throw new UnexpectedPageException("isGoogleMap method requires Selenium2 Driver");
        }

        $wrapper = $this->getGoogleMapWrapper($fieldSelector);
        expect($wrapper)->notToBe(null);

        return $wrapper->has('css', '.gm-style');
    }
}
