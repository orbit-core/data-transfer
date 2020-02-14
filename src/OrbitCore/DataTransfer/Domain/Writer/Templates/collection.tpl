    /**
     * @param {% propertyTypeDocPrefix %}{% propertyTypeDoc %}{% propertyTypeDocSuffix %} $value
     *
     * @return self
     */
    public function add{% propertySingleName %}({% propertyTypeDocPrefix %}{% propertyTypeDoc %} $value): self
    {
        $this->setModified('{% propertyName %}');
        $this->{% propertyName %}[] = $value;

        return $this;
    }
