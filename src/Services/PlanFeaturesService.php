<?php

namespace App\Services;

class PlanFeaturesService
{
    /**
     * @var array
     */
    private $planData;

    /**
     * @param array $planData
     */
    public function __construct($planData)
    {
        $this->planData = $planData;
    }

    /**
     * @return array
     */
    public function getPlanFeatures()
    {
        $planClassOptions = array();

        foreach ($planClassesParameters = $this->planData['plan_keys'] as $planKey) {
            $planClassOptions[$planKey] = $this->getFeaturesForPlan($planKey);
        }

        foreach ($this->planData['pseudo_plans'] as $planKey => $existingPlanKeys) {
            $planClassOptions[$planKey] = $this->getFeaturesForPlan($planKey);
        }

        return $planClassOptions;
    }

    /**
     * @param string $planKey
     *
     * @return array
     */
    private function getFeaturesForPlan($planKey)
    {
        $optionsForPlanClass = array();

        foreach ($this->planData['feature_categories'] as $categoryKey => $categoryName) {
            $optionsForPlanClass[$categoryKey] = array_merge(
                array('name' => $categoryName),
                $this->getFeaturesForPlanClassAndFeatureCategory($planKey, $categoryKey)
            );
        }

        return $optionsForPlanClass;
    }

    /**
     * @param string $planKey
     * @param string $categoryKey
     *
     * @return array
     */
    private function getFeaturesForPlanClassAndFeatureCategory($planKey, $categoryKey)
    {
        $options = array();

        foreach ($this->planData['category_to_key_map'][$categoryKey] as $featureKey) {
            $value = $this->getPlanFeatureValue($planKey, $featureKey);

            $options[$featureKey] = array(
                'name' => $this->getFeatureProperty($featureKey, 'name'),
                'value' => $value,
                'icon' => $this->getFeatureProperty($featureKey, 'icon'),
                'type' => gettype($value)
            );
        }

        return $options;
    }

    /**
     * @param string $featureKey
     * @param string $propertyName
     *
     * @return mixed
     */
    private function getFeatureProperty($featureKey, $propertyName)
    {
        $properties = $this->getFeatureProperties($featureKey);
        if (!array_key_exists($propertyName, $properties)) {
            throw new \RuntimeException(
                'Feature "' . $featureKey . '" has no "' . $propertyName . '" property defined',
                4
            );
        }

        return $properties[$propertyName];
    }

    /**
     * @param string $featureKey
     *
     * @return mixed
     */
    private function getFeatureProperties($featureKey)
    {
        if (!array_key_exists($featureKey, $this->planData['feature_properties'])) {
            throw new \RuntimeException('Feature "' . $featureKey . '" has no properties defined', 3);
        }

        return $this->planData['feature_properties'][$featureKey];
    }

    /**
     * @param string $planKey
     * @param string $featureKey
     *
     * @return mixed|string
     */
    private function getPlanFeatureValue($planKey, $featureKey)
    {
        return $this->getPlanFeatureParameterValue($planKey, $featureKey);
    }

    /**
     * @param string $planKey
     * @param string $featureKey
     *
     * @return mixed|string
     */
    private function getPlanFeatureParameterValue($planKey, $featureKey)
    {
        if (isset($this->planData['features'][$planKey][$featureKey])) {
            return $this->planData['features'][$planKey][$featureKey];
        }

        if ($this->isPseudoPlan($planKey)) {
            return $this->getPseudoPlanFeatureParameterValue($planKey, $featureKey);
        }


        if (!$this->isAllowedToDefault($featureKey)) {
            throw new \RuntimeException(
                'Feature "'
                . $featureKey
                . '" for plan class "'
                . $planKey
                . '" is not set and is not allowed to take a default value',
                1
            );
        }

        return $this->getDefaultFeatureValue($featureKey);
    }

    /**
     * @param string $pseudoPlanKey
     * @param string $featureKey
     *
     * @return mixed|string
     */
    private function getPseudoPlanFeatureParameterValue($pseudoPlanKey, $featureKey)
    {
        $planValues = array();

        foreach ($this->planData['pseudo_plans'][$pseudoPlanKey] as $planKey) {
            $planValues[] = $this->getPlanFeatureParameterValue($planKey, $featureKey);
        }

        if ($this->arePlanValuesIdentical($planValues)) {
            return $planValues[0];
        }

        return $this->getSmallestAndLargestPlanValuesAsString($planValues);
    }

    /**
     * @param array $planValues
     *
     * @return string
     */
    private function getSmallestAndLargestPlanValuesAsString($planValues)
    {
        return number_format(min($planValues)) . ' - ' . number_format(max($planValues));
    }

    /**
     * @param array $planValues
     *
     * @return boolean
     */
    private function arePlanValuesIdentical($planValues)
    {
        for ($index = 1; $index < count($planValues); $index++) {
            if ($planValues[$index] != $planValues[$index - 1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $planKey
     * @return boolean
     */
    private function isPseudoPlan($planKey)
    {
        return array_key_exists($planKey, $this->planData['pseudo_plans']);
    }

    /**
     * @param string $featureKey
     *
     * @return boolean
     */
    private function isAllowedToDefault($featureKey)
    {
        return in_array($featureKey, $this->planData['features']['allowed_to_default']);
    }

    /**
     * @param string $featureKey
     *
     * @return mixed
     */
    private function getDefaultFeatureValue($featureKey)
    {
        if (!array_key_exists($featureKey, $this->planData['features']['defaults'])) {
            throw new \RuntimeException('Default value for defaultable feature "' . $featureKey . '" not set', 1);
        }

        return $this->planData['features']['defaults'][$featureKey];
    }
}
