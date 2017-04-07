<?php

namespace RoyallTheFourth\QuickList\Layout\Optin;

use RoyallTheFourth\HtmlDocument\Element\Button;
use RoyallTheFourth\HtmlDocument\Element\Form;
use RoyallTheFourth\HtmlDocument\Element\Input;
use RoyallTheFourth\HtmlDocument\Element\Text;
use RoyallTheFourth\HtmlDocument\Set\ElementSet;
use RoyallTheFourth\QuickList\Layout\Base\LoggedOut;
use RoyallTheFourth\QuickList\Layout\LayoutInterface;

final class Landing implements LayoutInterface
{
    private $csrf;
    private $hash;
    private $listName;
    private $prefix;

    public function __construct(string $listName, string $hash, string $csrf, string $prefix)
    {
        $this->listName = $listName;
        $this->hash = $hash;
        $this->csrf = $csrf;
        $this->prefix = $prefix;
    }

    public function render(): string
    {
        return (new LoggedOut(
            "Subscribe to {$this->listName}",
            (new ElementSet())
                ->add(
                    (new Form())
                        ->withMethod('POST')
                        ->withAction("{$this->prefix}/optin")
                        ->withChild(new Text("Confirm your subscription to receive messages from {$this->listName}:"))
                        ->withChild(
                            (new Input())
                                ->withType('hidden')
                                ->withName('hash')
                                ->withValue($this->hash)
                        )
                        ->withChild(
                            (new Input())
                                ->withType('hidden')
                                ->withName('csrf')
                                ->withValue($this->csrf)
                        )
                        ->withChild(
                            (new Button())
                                ->withChild(new Text('Yes, sign me up!'))
                        )
                )
        )
        )->render();
    }
}
