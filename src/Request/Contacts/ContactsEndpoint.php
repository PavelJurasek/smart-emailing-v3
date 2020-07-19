<?php declare(strict_types=1);

namespace SmartEmailing\v3\Request\Contacts;

use SmartEmailing\v3\Api;

class ContactsEndpoint
{

    /** @var Api */
    private $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function all(?int $page = null, ?int $limit = null): Contacts
    {
        return new Contacts($this->api, $page, $limit);
    }

    public function get(int $listId, ?int $page = null, ?int $limit = null): ContactsInList
    {
        return new ContactsInList($this->api, $listId, $page, $limit);
    }

}
