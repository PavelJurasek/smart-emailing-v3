<?php declare(strict_types=1);

namespace SmartEmailing\v3\Request\Contacts;

use SmartEmailing\v3\Api;
use SmartEmailing\v3\Exceptions\InvalidFormatException;

class ContactsInList extends Contacts
{

    private const STATUS_FILTER_ALL = '';
    private const STATUS_FILTER_CONFIRMED = '/confirmed';
    private const STATUS_FILTER_UNSUBSCRIBED = '/unsubscribed';

    private $statusFilter = self::STATUS_FILTER_ALL;

    /** @var int */
    private $listId;

    public function __construct(Api $api, int $listId, ?int $page = null, ?int $limit = null)
    {
        parent::__construct($api, $page, $limit);

        $this->listId = $listId;
    }

    public function all(): self
    {
        $this->statusFilter = self::STATUS_FILTER_ALL;
        return $this;
    }

    public function confirmed(): self
    {
        $this->statusFilter = self::STATUS_FILTER_CONFIRMED;
        return $this;
    }

    public function unsubscribed(): self
    {
        $this->statusFilter = self::STATUS_FILTER_UNSUBSCRIBED;
        return $this;
    }

    protected function endpoint(): string
    {
        return sprintf('contactlists/%d/contacts%s', $this->listId, $this->statusFilter);
    }

}
