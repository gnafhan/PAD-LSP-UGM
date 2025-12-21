<?php

namespace Database\Factories;

use App\Enums\AssessmentType;
use App\Models\AssessmentConfigTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssessmentConfigTemplate>
 */
class AssessmentConfigTemplateFactory extends Factory
{
    protected $model = AssessmentConfigTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate random config with all types
        $config = [];
        
        // Mandatory types always enabled
        foreach (AssessmentType::getMandatoryTypes() as $type) {
            $config[$type] = true;
        }
        
        // Configurable types randomly enabled/disabled
        foreach (AssessmentType::getConfigurableTypes() as $type) {
            $config[$type] = $this->faker->boolean();
        }

        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(),
            'config_data' => $config,
            'is_default' => false,
        ];
    }

    /**
     * Indicate that the template is the default template.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }

    /**
     * Create a template with all assessments enabled.
     */
    public function allEnabled(): static
    {
        $config = [];
        foreach (AssessmentType::getAllTypes() as $type) {
            $config[$type] = true;
        }

        return $this->state(fn (array $attributes) => [
            'config_data' => $config,
        ]);
    }

    /**
     * Create a template with only mandatory assessments enabled.
     */
    public function minimalConfig(): static
    {
        $config = [];
        
        // Only mandatory types enabled
        foreach (AssessmentType::getMandatoryTypes() as $type) {
            $config[$type] = true;
        }
        
        // All configurable types disabled
        foreach (AssessmentType::getConfigurableTypes() as $type) {
            $config[$type] = false;
        }

        return $this->state(fn (array $attributes) => [
            'config_data' => $config,
        ]);
    }
}
