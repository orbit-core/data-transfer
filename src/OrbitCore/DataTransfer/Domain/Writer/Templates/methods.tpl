    /**
     * @return {% propertyTypeDocPrefix %}{% propertyTypeDoc %}{% propertyTypeDocSuffix %}
     */
    public function get{% propertyName %}(): {% propertyTypePrefix %}{% propertyType %}
    {
        return $this->{% propertyName %};
    }

    /**
     * @param {% propertyTypeDocPrefix %}{% propertyTypeDoc %}{% propertyTypeDocSuffix %} $value
     *
     * @return self
     */
    public function set{% propertyName %}({% propertyTypePrefix %}{% propertyType %} $value): self
    {
        if ($this->{% propertyName %} !== $value) {
            $this->setModified('{% propertyName %}');
        }

        $this->{% propertyName %} = $value;

        return $this;
    }

    public function require{% propertyName %}(): void
    {
        if ($this->{% propertyName %} === null) {
            throw new RequiredPropertyNotDefinedException('Required property {% propertyName %} is not defined');
        }
    }
