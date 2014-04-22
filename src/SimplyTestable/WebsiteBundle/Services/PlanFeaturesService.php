<?php

namespace SimplyTestable\WebsiteBundle\Services;

class PlanFeaturesService {

    /**
     *
     * @var array
     */
    private $planData;

    public function __construct($planData) {
        $this->planData = $planData;
    }

    public function getPlanFeatures() {
        $planClassOptions = array();

        foreach ($planClassesParameters = $this->planData['plan_keys'] as $planKey) {
            $planClassOptions[$planKey] = $this->getFeaturesForPlan($planKey);
        }

        foreach ($this->planData['pseudo_plans'] as $planKey => $existingPlanKeys) {
            $planClassOptions[$planKey] = $this->getFeaturesForPlan($planKey);           
        }

        return $planClassOptions;
    }

    private function getFeaturesForPlan($planKey) {
        $optionsForPlanClass = array();

        foreach ($this->planData['feature_categories'] as $categoryKey => $categoryName) {
            $optionsForPlanClass[$categoryKey] = array_merge(array('name' => $categoryName), $this->getFeaturesForPlanClassAndFeatureCategory($planKey, $categoryKey));
        }

        return $optionsForPlanClass;
    }

    private function getFeaturesForPlanClassAndFeatureCategory($planKey, $categoryKey) {
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

    private function getFeatureProperty($featureKey, $propertyName) {
        $properties = $this->getFeatureProperties($featureKey);
        if (!array_key_exists($propertyName, $properties)) {
            throw new \RuntimeException('Feature "' . $featureKey . '" has no "' . $propertyName . '" property defined', 4);
        }

        return $properties[$propertyName];
    }

    private function getFeatureProperties($featureKey) {
        if (!array_key_exists($featureKey, $this->planData['feature_properties'])) {
            throw new \RuntimeException('Feature "' . $featureKey . '" has no properties defined', 3);
        }

        return $this->planData['feature_properties'][$featureKey];
    }

    private function getPlanFeatureValue($planKey, $featureKey) {
        return $this->getPlanFeatureParameterValue($planKey, $featureKey);
    }

    private function getPlanFeatureParameterValue($planKey, $featureKey) {
        if (isset($this->planData['features'][$planKey][$featureKey])) {
            return $this->planData['features'][$planKey][$featureKey];
        }

        if ($this->isPseudoPlan($planKey)) {
            return $this->getPseudoPlanFeatureParameterValue($planKey, $featureKey);
        }


        if (!$this->isAllowedToDefault($featureKey)) {
            throw new \RuntimeException('Feature "' . $featureKey . '" for plan class "' . $planKey . '" is not set and is not allowed to take a default value', 1);
        }

        return $this->getDefaultFeatureValue($featureKey);
    }

    private function getPseudoPlanFeatureParameterValue($pseudoPlanKey, $featureKey) {
        $planValues = array();

        foreach ($this->planData['pseudo_plans'][$pseudoPlanKey] as $planKey) {
            $planValues[] = $this->getPlanFeatureParameterValue($planKey, $featureKey);
        }

        if ($this->arePlanValuesIdentical($planValues)) {
            return $planValues[0];
        }

        return $this->getSmallestAndLargestPlanValuesAsString($planValues);
    }

    private function getSmallestAndLargestPlanValuesAsString($planValues) {
        return number_format(min($planValues)) . ' - ' . number_format(max($planValues));
    }

    /**
     * 
     * @param array $planValues
     * @return boolean
     */
    private function arePlanValuesIdentical($planValues) {
        for ($index = 1; $index < count($planValues); $index++) {
            if ($planValues[$index] != $planValues[$index - 1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * 
     * @param string $planKey
     * @return boolean
     */
    private function isPseudoPlan($planKey) {
        return array_key_exists($planKey, $this->planData['pseudo_plans']);
    }

    /**
     * 
     * @param string $featureKey
     * @return boolean
     */
    private function isAllowedToDefault($featureKey) {
        return in_array($featureKey, $this->planData['features']['allowed_to_default']);
    }

    private function getDefaultFeatureValue($featureKey) {
        if (!array_key_exists($featureKey, $this->planData['features']['defaults'])) {
            throw new \RuntimeException('Default value for defaultable feature "' . $featureKey . '" not set', 1);
        }

        return $this->planData['features']['defaults'][$featureKey];
    }

}
