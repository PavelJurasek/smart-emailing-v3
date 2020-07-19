<?php declare(strict_types=1);

namespace SmartEmailing\v3\Request\Contacts;

use SmartEmailing\v3\Api;
use SmartEmailing\v3\Exceptions\InvalidFormatException;
use SmartEmailing\v3\Request\AbstractRequest;

class Contacts extends AbstractRequest
{

    private const ALL_FIELDS = [
        'id',
        'language',
        'blacklisted',
        'emailaddress',
        'name',
        'surname',
        'titlesbefore',
        'titlesafter',
        'birthday',
        'nameday',
        'salution',
        'gender',
        'company',
        'street',
        'town',
        'country',
        'postalcode',
        'notes',
        'phone',
        'cellphone',
        'realname',
    ];

    /** @var string[] */
    private $select = self::ALL_FIELDS;

    /** @var string[]|null */
    private $sort;

    /** @var int */
    public $page = 1;

    /** @var int */
    public $limit = 100;

    public function __construct(Api $api, ?int $page = null, ?int $limit = null)
    {
        parent::__construct($api);
        $this->page = $page ?? $this->page;
        $this->limit = $limit ?? $this->limit;
    }

    public function select(array $select): self
    {
        InvalidFormatException::checkAllowedValues($select, self::ALL_FIELDS);

        $this->select = $select;
        return $this;
    }

    public function sortBy(array $sort): self
    {
        $fields = array_map(function(string $field): string {
            return ltrim($field, '-');
        }, $sort);

        InvalidFormatException::checkAllowedValues($fields, self::ALL_FIELDS);

        $this->sort = $sort;

        return $this;
    }

    protected function endpoint(): string
    {
        return 'contacts';
    }

    protected function options(): array
    {
        return [
            'query' => $this->query()
        ];
    }

    private function toArray(): array
    {
        $query = [
            'limit' => $this->limit,
            'offset' => $this->offset(),
        ];

        $this->setIfNotNull($query, 'select', $this->select ? implode(',', $this->select) : null)
            ->setIfNotNull($query, 'sort', $this->sort);

        return $query;
    }

    public function query(): array
    {
        return $this->toArray();
    }

    public function offset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    protected function setIfNotNull(array &$array, string $key, $value): self
    {
        if (is_null($value)) {
            return $this;
        }

        $array[$key] = $value;
        return $this;
    }

}
