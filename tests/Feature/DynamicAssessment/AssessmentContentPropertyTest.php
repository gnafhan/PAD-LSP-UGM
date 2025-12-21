<?php

namespace Tests\Feature\DynamicAssessment;

use App\Models\AssessmentContent;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for AssessmentContent
 * 
 * **Feature: dynamic-assessment-flow, Property 5: Content-Scheme Association**
 * **Validates: Requirements 4.1, 4.2, 4.3**
 * 
 * Property: For any assessment content created for a scheme, the content SHALL be 
 * associated with that specific scheme and retrievable only when querying that scheme.
 */
class AssessmentContentPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 5: Content-Scheme Association
     * 
     * For any assessment content created for a scheme, the content SHALL be 
     * associated with that specific scheme and retrievable only when querying that scheme.
     * 
     * **Feature: dynamic-assessment-flow, Property 5: Content-Scheme Association**
     * **Validates: Requirements 4.1, 4.2, 4.3**
     * 
     * @test
     */
    public function content_is_associated_with_specific_scheme_and_retrievable_only_for_that_scheme(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create two different schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();
            $user = User::factory()->create();

            // Generate random content data
            $assessmentType = fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES);
            $contentType = fake()->randomElement(AssessmentContent::CONTENT_TYPES);
            $contentData = [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'unique_id' => fake()->uuid(),
            ];

            // Create content for scheme1
            $content = AssessmentContent::create([
                'id_skema' => $scheme1->id_skema,
                'assessment_type' => $assessmentType,
                'content_type' => $contentType,
                'content_data' => $contentData,
                'created_by' => $user->id_user,
                'display_order' => fake()->numberBetween(0, 100),
            ]);

            // Assert 1: Content is associated with scheme1
            $this->assertEquals(
                $scheme1->id_skema,
                $content->id_skema,
                "Content should be associated with scheme1"
            );

            // Assert 2: Content is retrievable when querying scheme1
            $scheme1Content = AssessmentContent::forSkema($scheme1->id_skema)->get();
            $this->assertTrue(
                $scheme1Content->contains('id', $content->id),
                "Content should be retrievable when querying scheme1"
            );

            // Assert 3: Content is NOT retrievable when querying scheme2
            $scheme2Content = AssessmentContent::forSkema($scheme2->id_skema)->get();
            $this->assertFalse(
                $scheme2Content->contains('id', $content->id),
                "Content should NOT be retrievable when querying scheme2"
            );

            // Assert 4: Content is retrievable by scheme and assessment type
            $contentByType = AssessmentContent::bySchemeAndType($scheme1->id_skema, $assessmentType)->get();
            $this->assertTrue(
                $contentByType->contains('id', $content->id),
                "Content should be retrievable by scheme and assessment type"
            );

            // Assert 5: Content is NOT retrievable for different assessment type
            $differentType = fake()->randomElement(
                array_diff(AssessmentContent::CONTENT_ASSESSMENT_TYPES, [$assessmentType])
            );
            $contentDifferentType = AssessmentContent::bySchemeAndType($scheme1->id_skema, $differentType)->get();
            $this->assertFalse(
                $contentDifferentType->contains('id', $content->id),
                "Content should NOT be retrievable for different assessment type"
            );

            // Clean up
            $content->delete();
            $scheme1->delete();
            $scheme2->delete();
            $user->delete();
        }
    }

    /**
     * Property: Multiple content items for same scheme are all retrievable
     * 
     * @test
     */
    public function multiple_content_items_for_same_scheme_are_all_retrievable(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $scheme = Skema::factory()->create();
            $user = User::factory()->create();
            
            // Create random number of content items (2-5)
            $numItems = fake()->numberBetween(2, 5);
            $createdIds = [];
            
            for ($j = 0; $j < $numItems; $j++) {
                $content = AssessmentContent::create([
                    'id_skema' => $scheme->id_skema,
                    'assessment_type' => fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                    'content_type' => fake()->randomElement(AssessmentContent::CONTENT_TYPES),
                    'content_data' => ['item' => $j, 'data' => fake()->sentence()],
                    'created_by' => $user->id_user,
                    'display_order' => $j,
                ]);
                $createdIds[] = $content->id;
            }

            // Retrieve all content for scheme
            $schemeContent = AssessmentContent::forSkema($scheme->id_skema)->get();

            // Assert all created content is retrievable
            $this->assertCount(
                $numItems,
                $schemeContent,
                "All {$numItems} content items should be retrievable for scheme"
            );

            foreach ($createdIds as $id) {
                $this->assertTrue(
                    $schemeContent->contains('id', $id),
                    "Content with id {$id} should be in scheme's content"
                );
            }

            // Clean up
            AssessmentContent::whereIn('id', $createdIds)->delete();
            $scheme->delete();
            $user->delete();
        }
    }

    /**
     * Property: Content data persists correctly as JSON
     * 
     * @test
     */
    public function content_data_persists_correctly_as_json(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $scheme = Skema::factory()->create();
            $user = User::factory()->create();

            // Generate complex random content data
            $originalData = [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'nested' => [
                    'level1' => fake()->word(),
                    'level2' => [
                        'value' => fake()->numberBetween(1, 1000),
                        'text' => fake()->sentence(),
                    ],
                ],
                'array_data' => fake()->words(5),
                'boolean_value' => fake()->boolean(),
                'numeric_value' => fake()->randomFloat(2, 0, 100),
            ];

            $content = AssessmentContent::create([
                'id_skema' => $scheme->id_skema,
                'assessment_type' => fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                'content_type' => fake()->randomElement(AssessmentContent::CONTENT_TYPES),
                'content_data' => $originalData,
                'created_by' => $user->id_user,
                'display_order' => 0,
            ]);

            // Refresh from database
            $content->refresh();

            // Assert content_data is correctly persisted and retrieved
            $this->assertEquals(
                $originalData,
                $content->content_data,
                "Content data should persist correctly as JSON"
            );

            // Clean up
            $content->delete();
            $scheme->delete();
            $user->delete();
        }
    }

    /**
     * Property: Scheme relationship is correctly established
     * 
     * @test
     */
    public function scheme_relationship_is_correctly_established(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $scheme = Skema::factory()->create();
            $user = User::factory()->create();

            $content = AssessmentContent::create([
                'id_skema' => $scheme->id_skema,
                'assessment_type' => fake()->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                'content_type' => fake()->randomElement(AssessmentContent::CONTENT_TYPES),
                'content_data' => ['test' => fake()->word()],
                'created_by' => $user->id_user,
                'display_order' => 0,
            ]);

            // Assert relationship works
            $this->assertNotNull($content->skema);
            $this->assertEquals(
                $scheme->id_skema,
                $content->skema->id_skema,
                "Content's skema relationship should return the correct scheme"
            );
            $this->assertEquals(
                $scheme->nama_skema,
                $content->skema->nama_skema,
                "Content's skema relationship should have correct scheme data"
            );

            // Clean up
            $content->delete();
            $scheme->delete();
            $user->delete();
        }
    }
}
