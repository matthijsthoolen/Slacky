<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use MatthijsThoolen\Slacky\Model\SlackyIterable;

class MessageIterable extends SlackyIterable
{

    /**
     * @return Message
     */
    public function current()
    {
        $message = new Message();
        $message->loadData(parent::current());

        return $message;
    }

}
