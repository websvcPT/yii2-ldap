<?php

namespace chrmorandi\ldap\Models;

use chrmorandi\ldap\interfaces\SchemaInterface;
use chrmorandi\ldap\Query\QueryBuilder;

class Factory
{
    /**
     * @var QueryBuilder
     */
    protected $query;

    /**
     * @var SchemaInterface
     */
    protected $schema;

    /**
     * Constructor.
     *
     * @param QueryBuilder         $builder
     * @param SchemaInterface $schema
     */
    public function __construct(QueryBuilder $builder, SchemaInterface $schema)
    {
        $this->setQuery($builder);
        $this->setSchema($schema);
    }

    /**
     * Sets the current query builder.
     *
     * @param QueryBuilder $builder
     */
    public function setQuery(QueryBuilder $builder)
    {
        $this->query = $builder;
    }

    /**
     * Sets the current schema.
     *
     * @param SchemaInterface $schema
     */
    public function setSchema(SchemaInterface $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Creates a new user instance.
     *
     * @param array $attributes
     *
     * @return User
     */
    public function user(array $attributes = [])
    {
        return (new User($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), [
                $this->schema->top(),
                $this->schema->person(),
                $this->schema->organizationalPerson(),
                $this->schema->user(),
            ]);
    }

    /**
     * Creates a new organizational unit instance.
     *
     * @param array $attributes
     *
     * @return OrganizationalUnit
     */
    public function ou(array $attributes = [])
    {
        return (new OrganizationalUnit($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), [
                $this->schema->top(),
                $this->schema->organizationalUnit(),
            ]);
    }

    /**
     * Creates a new group instance.
     *
     * @param array $attributes
     *
     * @return Group
     */
    public function group(array $attributes = [])
    {
        return (new Group($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), [
                $this->schema->top(),
                $this->schema->objectCategoryGroup(),
            ]);
    }

    /**
     * Creates a new organizational unit instance.
     *
     * @param array $attributes
     *
     * @return Container
     */
    public function container(array $attributes = [])
    {
        return (new Container($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), $this->schema->organizationalUnit());
    }

    /**
     * Creates a new user instance as a contact.
     *
     * @param array $attributes
     *
     * @return User
     */
    public function contact(array $attributes = [])
    {
        return (new User($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), [
                $this->schema->top(),
                $this->schema->person(),
                $this->schema->organizationalPerson(),
                $this->schema->contact(),
            ]);
    }

    /**
     * Creates a new computer instance.
     *
     * @param array $attributes
     *
     * @return Computer
     */
    public function computer(array $attributes = [])
    {
        return (new Computer($attributes, $this->query))
            ->setAttribute($this->schema->objectClass(), [
                $this->schema->top(),
                $this->schema->person(),
                $this->schema->organizationalPerson(),
                $this->schema->user(),
                $this->schema->computer(),
            ]);
    }
}